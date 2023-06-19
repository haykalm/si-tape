<?php

namespace App\Http\Controllers\Penduduk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    KategoriPR,
    P_Rentan,
    Yayasan,
    Pendataan,
    PendataanHistory,
    NotaDinas,
    Event,
    EventImages,
};
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Exports\PendudukExport;
use App\Imports\PendudukImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use File;
// use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PendudukController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');

        $this->monthyear = Carbon::now()->format('mY');
        $this->month = Carbon::now()->format('m');
        $this->year = Carbon::now()->format('Y');
        $this->Ymd_His = Carbon::now()->format('Y-m-d H:i:s');

        //**order_number formating**//
        $pendataan = Pendataan::select('kode_pendataan')
            ->whereMonth('created_at', $this->month)
            ->max("kode_pendataan");

        $kode_pendataan = [];
        if ($pendataan == null) {
            $this->kode_pendataan = 'JB' . '-' . $this->monthyear . '-' . '00001';
            
        } else {
            $kode_pendataan = (int) substr($pendataan, 11, 16);
            $kode_pendataan++;
            $this->kode_pendataan = 'JB' . '-' . $this->monthyear . '-' . sprintf('%05s', $kode_pendataan);
        }
    }

    public function index()
    {
        $disabilitas = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 3)
                ->get();
        // return $disabilitas;
        $kategori_pr = KategoriPR::all();
        $yayasan = yayasan::all();

        return view('pr.disabilitas.index',['disabilitas'=>$disabilitas,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        // $validator = $request->validated();

        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:100'],
            'nik' => 'required|unique:p_Rentan|size:16',
            'ttl' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'kategori_pr_id' => 'required',
            'lampiran' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'file' => 'required|mimes:pdf,docx|max:2048',
        ]);

        if ($validator->fails()) {
            $out = [
                "message" => $validator->messages()->all(),
            ];
            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back();
            }
        }

        if ($request->hasfile('lampiran')) {

            $imageName = time().'_'.$request->lampiran->getClientOriginalName();  
            $request->lampiran->move(public_path('files/lampiran'), $imageName);
        }

        // insert data
        $save_pr = New P_Rentan;
        $save_pr->yayasan_id   = $request->yayasan_id ?? NULL;
        $save_pr->kategori_pr_id   = $request->kategori_pr_id;
        $save_pr->nik   = $request->nik;
        $save_pr->name   = $request->name;
        $save_pr->gender   = $request->gender ?? NULL;
        $save_pr->ttl   = $request->ttl ?? NULL;
        $save_pr->address   = $request->address ?? NULL;
        $save_pr->lampiran   = $imageName ?? NULL;
        $save_pr->save();

        $pendataan = new Pendataan;
        $pendataan->p_rentan_id = $save_pr->id;
        $pendataan->kode_pendataan = $this->kode_pendataan;
        $pendataan->save();

        $pendataan_h = new PendataanHistory;
        $pendataan_h->pendataan_id = $pendataan->id;
        $pendataan_h->pendataan_date = $this->Ymd_His;
        $pendataan_h->save();

        if ($request->hasfile('file')) {
            $Name = time().'_'.$request->file->getClientOriginalName();  
            $request->file->move(public_path('files/nota_dinas'), $Name);

            $notadinas = new NotaDinas;
            $notadinas->yayasan_id = $request->yayasan_id ?? NULL;
            $notadinas->p_rentan_id = $save_pr->id;
            $notadinas->file = $Name;
            $notadinas->save();
        }

        if ($save_pr) {

            Alert::success('Success', 'Data berhasil ditambahkan!');
            return back();

        } else {

            Alert::error('Failed', 'Data gagal ditambahkan!');
            return back();
        }
    }

    public function show($id)
    {
        $data = P_Rentan::find($id);
        $kategori_pr = KategoriPR::all();
        $old_kategori_pr = KategoriPR::where('id',$data->kategori_pr_id)->first();
        $yayasan = Yayasan::all();
        $old_yayasan = Yayasan::where('id',$data->yayasan_id)->first();

        return view('pr.disabilitas.edit', ['data' => $data,'kategori_pr' => $kategori_pr,'old_kategori_pr' => $old_kategori_pr,'yayasan' => $yayasan,'old_yayasan' => $old_yayasan]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','min:3','max:100'],
            'nik' => 'required|size:16',
            'ttl' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'kategori_pr_id' => 'required',
            'lampiran' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'file' => 'mimes:pdf,docx|max:2048',
        ]);
        
        if ($validator->fails()) {
            $out = [
            "message" => $validator->messages()->all(),
            ];

            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back();
            }
        }

        $penduduk = P_Rentan::where('id', $id)->first();
        $notadinas = NotaDinas::where('p_rentan_id', $id)->first();

        if ($request->hasfile('lampiran')) {

            File::delete(public_path().'/files/lampiran/'. $penduduk->lampiran);

            $imageName = time().'_'.$request->lampiran->getClientOriginalName();  
            $request->lampiran->move(public_path('files/lampiran'), $imageName);
        }

        if ($request->hasfile('file')) {

            File::delete(public_path().'/files/nota_dinas/'. $notadinas->file);

            $Name = time().'_'.$request->file->getClientOriginalName();  
            $request->file->move(public_path('files/nota_dinas'), $Name);
        }

        $penduduk->yayasan_id = $request->yayasan_id ?? NULL;
        $penduduk->kategori_pr_id = $request->kategori_pr_id ?? $penduduk->kategori_pr_id;
        $penduduk->nik = $request->nik ?? $penduduk->nik;
        $penduduk->name = $request->name ?? $penduduk->name;
        $penduduk->gender = $request->gender ?? $penduduk->gender;
        $penduduk->ttl = $request->ttl ?? $penduduk->ttl;
        $penduduk->address = $request->address ?? $penduduk->address;
        $penduduk->lampiran = $imageName ?? $penduduk->lampiran;
        $penduduk->save();

        $notadinas->yayasan_id = $request->yayasan_id ?? $penduduk->kategori_pr_id ?? NULL;
        $notadinas->p_rentan_id = $penduduk->id ?? $notadinas->p_rentan_id;
        $notadinas->file = $Name ?? $notadinas->file;
        $notadinas->save();

        if ($penduduk) {

            Alert::success('Success', 'Data berhasil diupdate!');
            return back();
        } else {

            Alert::error('Failed', 'Data gagal diupdate!');
            return back();
        }
    }

    public function destroy($id)
    {
        $id = base64_decode($id);
        
        $data = P_Rentan::find($id);
        $notadinas = NotaDinas::where('p_rentan_id', $id)->first();
        $pendataan = Pendataan::where('p_rentan_id', $id)->first();
        $pendataan_h = PendataanHistory::where('pendataan_id', $pendataan->id)->first();

        $event = Event::where('p_rentan_id', $id)->first();

        if ($event) {
            $event_image = EventImages::where('events_id', $event->id)->get();
            if ($event_image) {
                foreach ($event_image as $key => $value) {
                    $value->delete();
                }
            }
            $event->delete();
        }

        if ($notadinas) {
            File::delete(public_path().'/files/nota_dinas/'. $notadinas->file);
            $notadinas->delete();
        }

        if ($data->lampiran != NULL || $data->lampiran != null) {
            File::delete(public_path().'/files/lampiran/'. $data->lampiran);
        }


        if ($data) {

            $data->delete();
            $pendataan->delete();
            $pendataan_h->delete();

            Alert::success('Success', 'Data berhasil dihapus!');
            return back();
            
        } else {

            Alert::error('Failed', 'Data gagal dihapus!');
            return back();
        }
    }

    public function list_napi()
    {
        
        $napi = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 4)
                ->get();
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.napi.index',['napi'=>$napi,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function list_transgender()
    {

        $transgender = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 5)
                ->get(); 
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.transgender.index',['transgender'=>$transgender,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

     public function list_odgj()
    {
        
        $odgj = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 1)
                ->get(); 
        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.odgj.index',['odgj'=>$odgj,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function list_panti_asuhan()
    {

        $panti_asuhan = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 2)
                ->get();

        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.panti_asuhan.index',['panti_asuhan'=>$panti_asuhan,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }

    public function all_pr()
    {

        $all_pr = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->get();

        $kategori_pr = KategoriPR::all();
        $yayasan = Yayasan::all();

        return view('pr.all_pr.index',['all_pr'=>$all_pr,'kategori_pr'=>$kategori_pr,'yayasan'=>$yayasan]);
    }
}
