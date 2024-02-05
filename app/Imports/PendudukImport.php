<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\{
    P_Rentan,
    Yayasan,
    KategoriPR,
    Pendataan,
    PendataanHistory,
};
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Carbon\Carbon;

class PendudukImport implements
    ToCollection,
    WithValidation,
    WithStartRow,
    SkipsOnError,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public $data;
    private $kode_pendataan;
    private $monthyear;
    private $month;
    private $year;
    private $Ymd_His;

    public function startRow(): int
    {
        return 2; // start from row 2 (excluding header row)
    }

    public function collection(Collection $collection)
    {
        $this->data = $collection;
        $data = $this->data;

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


        foreach ($data as $key => $value) {
            // $this->request_kategori = $value[6];

            if ($value[5] != NULL && $value[6] != NULL) {
                // $replace = str_replace("", "", $angkaa);
                $y_name = $value[5];
                $k_name = $value[6];
                $yayasan = Yayasan::where('name', $y_name)->first();
                $kategori = KategoriPR::where('name', $k_name)->first();
                // $this->data = $kategori;
                if (!empty($yayasan)) {
                    $save_pr = New P_Rentan;
                    $save_pr->yayasan_id = $yayasan->id;
                    $save_pr->kategori_pr_id = $kategori->id;
                    $save_pr->nik = intval($value[0]);
                    $save_pr->name = $value[1];
                    $save_pr->ttl = $value[2];
                    $save_pr->address = $value[3];
                    $save_pr->gender = $value[4];
                    $save_pr->save();

                    $pendataan = new Pendataan;
                    $pendataan->p_rentan_id = $save_pr->id;
                    $pendataan->kode_pendataan = $this->kode_pendataan ++;
                    $pendataan->save();

                    $pendataan_h = new PendataanHistory;
                    $pendataan_h->pendataan_id = $pendataan->id;
                    $pendataan_h->pendataan_date = $this->Ymd_His;
                    $pendataan_h->save();
                } else {
                    $save_yayasan = New Yayasan;
                    $save_yayasan->kategori_pr_id = $kategori->id;
                    $save_yayasan->name = $y_name;
                    $save_yayasan->save();

                    $save_pr = New P_Rentan;
                    $save_pr->kategori_pr_id = $save_yayasan->kategori_pr_id;
                    $save_pr->nik = intval($value[0]);
                    $save_pr->name = $value[1];
                    $save_pr->yayasan_id = $save_yayasan->id;
                    $save_pr->ttl = $value[2];
                    $save_pr->address = $value[3];
                    $save_pr->gender = $value[4];
                    $save_pr->save();

                    $pendataan = new Pendataan;
                    $pendataan->p_rentan_id = $save_pr->id;
                    $pendataan->kode_pendataan = $this->kode_pendataan ++;
                    $pendataan->save();

                    $pendataan_h = new PendataanHistory;
                    $pendataan_h->pendataan_id = $pendataan->id;
                    $pendataan_h->pendataan_date = $this->Ymd_His;
                    $pendataan_h->save();
                }
            } else {
                // $y_name = $value[5];
                $k_name = $value[6];
                // $yayasan = Yayasan::where('name', $y_name)->first();
                $kategori = KategoriPR::where('name', $k_name)->first();
                if ($value[5] == NULL && $value[6] != NULL) {
                    $save_pr = New P_Rentan;
                    $save_pr->yayasan_id = NULL;
                    $save_pr->kategori_pr_id = $kategori->id;
                    $save_pr->nik = intval($value[0]);
                    $save_pr->name = $value[1];
                    $save_pr->ttl = $value[2];
                    $save_pr->address = $value[3];
                    $save_pr->gender = $value[4];
                    $save_pr->save();

                    $pendataan = new Pendataan;
                    $pendataan->p_rentan_id = $save_pr->id;
                    $pendataan->kode_pendataan = $this->kode_pendataan ++;
                    $pendataan->save();

                    $pendataan_h = new PendataanHistory;
                    $pendataan_h->pendataan_id = $pendataan->id;
                    $pendataan_h->pendataan_date = $this->Ymd_His;
                    $pendataan_h->save();
                }else{

                }
            }
        }

    }

    public function rules(): array
    {
        // $names_kategori = KategoriPR::pluck('name');
        return [
            '0' => 'required|unique:p_Rentan,nik|size:16',
            '1' => 'required|string',
            '2' => 'required',
            '3' => 'required',
            '4' => 'required|in:male,female',
            '6' => 'required|in:odgj,panti asuhan,disabilitas,napi,transgender'
        ];
    }
    // public function onFailure(Failure ...$failure)
    // {
    //         // to show data the validations in return or dd() to controller
    // }
}
