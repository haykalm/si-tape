<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\P_Rentan;
use App\Models\Yayasan;
use App\Models\KategoriPR;
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


class PendudukImport implements 
    ToCollection, 
    WithValidation, 
    WithStartRow,
    SkipsOnError,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public $data;
    // public $request_kategori;

    public function startRow(): int
    {
        return 2; // start from row 2 (excluding header row)
    }

    public function collection(Collection $collection)
    {
        $this->data = $collection;
        $data = $this->data;


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
                    $save = $save_pr->save();
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
                    $save = $save_pr->save();
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
                    $save = $save_pr->save();
                }else{
                    $save_pr = New P_Rentan;        
                    $save_pr->yayasan_id = $value[5] ?? NULL;
                    $save_pr->kategori_pr_id = $value[6] ?? NULL;
                    $save_pr->nik = intval($value[0] ?? NULL);
                    $save_pr->name = $value[1] ?? NULL;
                    $save_pr->ttl = $value[2] ?? NULL;
                    $save_pr->address = $value[3] ?? NULL;
                    $save_pr->gender = $value[4] ?? NULL;
                    $save = $save_pr->save();
                }
            }
        }
        
    }

    public function rules(): array
    {
        // $names_kategori = KategoriPR::pluck('name');
        return [
            '0' => 'required|unique:p_Rentan,nik|max:16',
            '1' => 'required',
            '6' => 'required', //kategori name
            // '6' => 'required'.$names_kategori, //kategori name
            // '*.0' => ['0','unique:p_Rentan,nik'],
        ];
    }
    // public function onFailure(Failure ...$failure)
    // {
    //         // to show data the validations in return or dd() to controller
    // }
}
