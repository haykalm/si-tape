<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Event,
    EventImages,
    Yayasan,
    Pendataan,
    PendataanHistory,
    P_Rentan,
    NotaDinas
};
use RealRashid\SweetAlert\Facades\Alert;
// use DB;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use File;
use Exception;
use Maatwebsite\Excel\Validators\ValidationException;
use Throwable;
use App\DataTables\EventDataTable;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->monthyear = Carbon::now()->format('mY');
        $this->month = Carbon::now()->format('m');
        $this->year = Carbon::now()->format('Y');
        $this->Ymd_His = Carbon::now()->format('Y-m-d H:i:s');

        $pendataan = Pendataan::select('kode_pendataan')
            ->whereMonth('created_at', $this->month)
            ->max("kode_pendataan");

        $kode_pendataan = [];
        if ($pendataan == null) {
            $this->kode_pendataan = 'JB' . '-' . $this->monthyear . '-' . '00001';
        } else {

            $kode_pendataan = (int) substr($pendataan, 10, 15);
            $kode_pendataan++;
            $this->kode_pendataan = 'JB' . '-' . $this->monthyear . '-' . sprintf('%05s', $kode_pendataan);
        }
    }

    public function index(EventDataTable $dataTable)
    {
        // $event = DB::table('events as e')
        //         ->leftJoin('yayasan as y', 'y.id', '=', 'e.yayasan_id')
        //         ->leftJoin('p_rentan as pr', 'pr.id', '=', 'e.p_rentan_id')
        //         ->select('e.id as id_event','e.event_name','e.event_location','e.date','pr.nik','y.name as yayasan_name')
        //         ->orderBy('e.id', 'DESC')
        //         ->WhereNotNull('e.yayasan_id')
        //         ->get();

        $yayasan = Yayasan::all();

        // return view('event.yayasan.index',['event'=>$event,'yayasan'=>$yayasan]);
        return $dataTable->render('event.yayasan.index', compact('yayasan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $yayasan = Yayasan::all();
        return view('event.yayasan.create',['yayasan'=>$yayasan]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string',
            'event_location' => 'required',
            'date' => 'required|date',
            'name' => 'required|string',
            'address' => 'required',
            'nik' => 'required|unique:p_rentan|size:16',
            'name_file.*' => ['mimes:jpeg,png,jpg,max:2048'],
            'lampiran' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'file' => 'required|mimes:pdf,docx|max:2048',
        ]);

        if ($validator->fails()) {
            $out = [
                "message" => $validator->messages()->all(),
            ];

            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back()->withInput()->withErrors('Terjadi kesalahan validasi.');
            }
        }

        if ($request->hasfile('lampiran')) {

            $imageName = time().'_'.$request->lampiran->getClientOriginalName();
            $request->lampiran->move(public_path('files/lampiran'), $imageName);
        }

        $save_pr = New P_Rentan;
        $save_pr->yayasan_id   = $request->yayasan_id ?? NULL;
        $save_pr->kategori_pr_id   = 3;
        $save_pr->nik   = $request->nik;
        $save_pr->name   = $request->name;
        $save_pr->gender   = $request->gender ?? NULL;
        $save_pr->ttl   = $request->ttl ?? NULL;
        $save_pr->address   = $request->address ?? NULL;
        $save_pr->lampiran   = $imageName ?? NULL;
        $save_pr->save();

        $new_event = new Event;
        $new_event->p_rentan_id = $save_pr->id;
        $new_event->yayasan_id = $request->yayasan_id ?? NULL;
        $new_event->event_name = $request->event_name;
        $new_event->event_location = $request->event_location;
        $new_event->date = Carbon::parse($request->date)->format('Y-m-d');
        $new_event->save();

        $pendataan = new Pendataan;
        $pendataan->p_rentan_id = $save_pr->id;
        $pendataan->kode_pendataan = $this->kode_pendataan;
        $pendataan->save();

        $pendataan_h = new PendataanHistory;
        $pendataan_h->pendataan_id = $pendataan->id;
        $pendataan_h->pendataan_date = $this->Ymd_His;
        $pendataan_h->save();

        if ($request->hasfile('name_file')) {
            foreach ($request->file('name_file') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/files/event/', $name);
                $data[] = $name;
            }

            foreach ($data as $key => $value) {
                $event_image = new EventImages;
                $event_image->events_id    = $new_event->id;
                $event_image->name_file      = $value;
                $event_image->save();
            }
        }

        if ($request->hasfile('file')) {
            $Name = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('files/nota_dinas'), $Name);

            $notadinas = new NotaDinas;
            $notadinas->yayasan_id = $request->yayasan_id ?? NULL;
            $notadinas->p_rentan_id = $save_pr->id;
            $notadinas->file = $Name;
            $notadinas->save();
        }

        return redirect()->route('event.index')->with('success', 'Successfully Add Data.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = EventImages::where('events_id', $id)->get();

        return view('event.yayasan.show', ['image' => $image]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = base64_decode($id);
        $event = Event::find($id);

        $oldyayasan = Event::join('yayasan', 'yayasan.id', '=', 'events.yayasan_id')
                            ->where('yayasan.id',$event->yayasan_id)
                            ->select('yayasan.id as id_yayasan','yayasan.name as name_yayasan')
                            ->first();

        $yayasan = Yayasan::select('*')->orderBy('id','DESC')->get();
        $date = Carbon::parse($event->date)->format('m/d/Y');
        return view('event.yayasan.edit',['event' => $event,'yayasan' => $yayasan,'oldyayasan' => $oldyayasan,'date' => $date]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string',
            'event_location' => 'required',
            'date' => 'required',
            'name_file.*' => ['mimes:jpeg,png,jpg,max:2048'],
        ]);
        if ($validator->fails()) {

            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back();
            }
        }

        $event = Event::where('id', $id)->first();

        $event->yayasan_id = $request->yayasan_id ?? NULL;
        $event->event_name = $request->event_name;
        $event->event_location = $request->event_location;
        $event->date = Carbon::parse($request->date)->format('Y-m-d');
        $event->save();

        if ($request->hasfile('name_file')) {
            $EventImages = EventImages::where('events_id', $id)->get();
            if ($EventImages) {
                foreach ($EventImages as $key => $value) {
                   File::delete(public_path().'/files/event/'. $value->name_file);
                   $value->delete();
                }
            }

            foreach ($request->file('name_file') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/files/event/', $name);
                $data[] = $name;
            }

            foreach ($data as $key => $value) {
                $event_image = new EventImages;
                $event_image->events_id    = $event->id;
                $event_image->name_file      = $value;
                $event_image->save();
            }
        }

        return redirect()->route('event.index')->with('success', 'Successfully Updated Data.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);

        $nameimages = EventImages::where('events_id', $id)->get();
        // return $nameimages;
        if ($nameimages) {
            foreach ($nameimages as $key => $value) {
               File::delete(public_path().'/files/event/'. $value->name_file);
            }
        }

        $data = Event::find($id);
        if ($data) {

            $data->delete();

            Alert::success('Success', 'Data berhasil dihapus!');
            return back();
        } else {

            Alert::error('Failed', 'Data gagal dihapus!');
            return back();
        }
    }

    public function event_internal(EventDataTable $dataTable)
    {

        // $event = DB::table('events as e')
        //         ->leftJoin('p_rentan as pr', 'pr.id', '=', 'e.p_rentan_id')
        //         ->select('e.id as id_event','e.event_name','e.event_location','e.date','pr.nik')
        //         ->orderBy('e.id', 'DESC')
        //         ->WhereNull('e.yayasan_id')
        //         ->get();

        // return view('event.internal.index',['event'=>$event]);
        return $dataTable->render('event.internal.index');
    }

    public function create_event_internal()
    {
        return view('event.internal.create');
    }

    public function store_event_internal(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string',
            'event_location' => 'required',
            'date' => 'required',
            'name' => 'required|string',
            'address' => 'required',
            'nik' => 'required|unique:p_rentan|size:16',
            'name_file.*' => ['mimes:jpeg,png,jpg,max:2048'],
            'lampiran' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'file' => 'required|mimes:pdf,docx|max:2048',
        ]);

        if ($validator->fails()) {
            $out = [
                "message" => $validator->messages()->all(),
            ];
            foreach ($out as $key => $value) {
                Alert::error('Failed!', $value);
                return back()->withInput()->withErrors('Terjadi kesalahan validasi.');
            }
        }

        if ($request->hasfile('lampiran')) {

            $imageName = time().'_'.$request->lampiran->getClientOriginalName();
            $request->lampiran->move(public_path('files/lampiran'), $imageName);
        }

        $save_pr = New P_Rentan;
        $save_pr->yayasan_id   = $request->yayasan_id ?? NULL;
        $save_pr->kategori_pr_id   = 3;
        $save_pr->nik   = $request->nik;
        $save_pr->name   = $request->name;
        $save_pr->gender   = $request->gender ?? NULL;
        $save_pr->ttl   = $request->ttl ?? NULL;
        $save_pr->address   = $request->address ?? NULL;
        $save_pr->lampiran   = $imageName ?? NULL;
        $save_pr->save();

        $new_event = new Event;
        $new_event->p_rentan_id = $save_pr->id;
        $new_event->yayasan_id = $request->yayasan_id ?? NULL;
        $new_event->event_name = $request->event_name;
        $new_event->event_location = $request->event_location;
        $new_event->date = Carbon::parse($request->date)->format('Y-m-d');
        $new_event->save();

        $pendataan = new Pendataan;
        $pendataan->p_rentan_id = $save_pr->id;
        $pendataan->kode_pendataan = $this->kode_pendataan;
        $pendataan->save();

        $pendataan_h = new PendataanHistory;
        $pendataan_h->pendataan_id = $pendataan->id;
        $pendataan_h->pendataan_date = $this->Ymd_His;
        $pendataan_h->save();

        if ($request->hasfile('name_file')) {
            foreach ($request->file('name_file') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/files/event/', $name);
                $data[] = $name;
            }

            foreach ($data as $key => $value) {
                $event_image = new EventImages;
                $event_image->events_id    = $new_event->id;
                $event_image->name_file      = $value;
                $event_image->save();
            }
        }

        if ($request->hasfile('file')) {
            $Name = time().'_'.$request->file->getClientOriginalName();
            $request->file->move(public_path('files/nota_dinas'), $Name);

            $notadinas = new NotaDinas;
            $notadinas->yayasan_id = $request->yayasan_id ?? NULL;
            $notadinas->p_rentan_id = $save_pr->id;
            $notadinas->file = $Name;
            $notadinas->save();
        }

        return redirect()->route('event.internal')->with('success', 'Successfully Add Data.');
    }

    public function edit_event_internal($id)
    {
        $id = base64_decode($id);
        $event = Event::find($id);
        $yayasan = Yayasan::select('*')->orderBy('id','DESC')->get();
        $date = Carbon::parse($event->date)->format('m/d/Y');
        return view('event.internal.edit',['event' => $event,'date' => $date,'yayasan' => $yayasan]);
    }

    public function update_event_internal(Request $request, $id)
    {

        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string',
            'event_location' => 'required',
            'date' => 'required',
            'name_file.*' => ['mimes:jpeg,png,jpg,max:2048'],
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

        $event = Event::where('id', $id)->first();

        $event->yayasan_id = $request->yayasan_id ?? NULL;
        $event->event_name = $request->event_name;
        $event->event_location = $request->event_location;
        $event->date = Carbon::parse($request->date)->format('Y-m-d');
        $event->save();

        if ($request->hasfile('name_file')) {
            $EventImages = EventImages::where('events_id', $id)->get();
            if ($EventImages) {
                foreach ($EventImages as $key => $value) {
                   File::delete(public_path().'/files/event/'. $value->name_file);
                   $value->delete();
                }
            }

            foreach ($request->file('name_file') as $file) {
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path() . '/files/event/', $name);
                $data[] = $name;
            }

            foreach ($data as $key => $value) {
                $event_image = new EventImages;
                $event_image->events_id    = $event->id;
                $event_image->name_file      = $value;
                $event_image->save();
            }
        }

        return redirect()->route('event.internal')->with('success', 'Successfully Updated Data.');
    }
}
