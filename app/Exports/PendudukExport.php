<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\P_Rentan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;
// use Maatwebsite\Excel\Concerns\WithColumnWidths;
class PendudukExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // export all penduduk rentan
    // public function columnWidths(): array
    // {
    //     return [
    //         'A1' => 45,
    //         'B1' => 45,
    //         'C1' => 45,
    //         'D1' => 45,
    //         'E1' => 45,
    //         'F1' => 45,
    //     ];
    // }

    // protected $request;
    // public function __construct(Request $request)
    // {
    //     $this->request = $request;
    // }

    public function collection()
    {
        // dd(request(['kategori_pr_id']));
        $data = P_Rentan::FilterMonthYearJoin(request(['month_year']))
            ->FilterKategoriJoin(request(['kategori_pr_id']))
            ->leftJoin('yayasan as y', 'y.id', '=', 'p_rentan.yayasan_id')
            ->leftJoin('kategori_pr as k', 'k.id', '=', 'p_rentan.kategori_pr_id')
            ->select(
                'p_rentan.id',
                'p_rentan.name',
                'p_rentan.nik',
                'p_rentan.ttl',
                'p_rentan.address',
                'p_rentan.gender',
                'k.name as kategori_name',
                'y.name as yayasan_name',
                DB::raw('COALESCE(p_rentan.yayasan_id, 0) as yayasan_id')
            )
            ->orderBy('p_rentan.id', 'DESC')
            ->get();
            // dd($data);
        return $data;
    }

    public function map($model): array
    {
        return [
            // $model->nik = number_format($model->nik, 0, '', ''),
            // (string)$model->nik,
            // strval($model->nik),
            // $nik,
            // $model->nik = str_replace(".", "", $model->nik),
            "'".$model->nik,
            $model->name,
            $model->ttl,
            $model->address,
            $model->gender,
            $model->yayasan_name,
            $model->kategori_name
            // $model->stock->qty_float ? $model->stock->qty_float : 'Terjual Habis',

        ];
    }

    public function headings(): array
    {
        return [
            'NIK',
            'NAMA',
            'TTL',
            'ALAMAT',
            'GENDER',
            'YAYASAN',
            'STATUS',
        ];
    }
}
