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

class PantiAsuhanExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = P_Rentan::FilterMonthYear(request(['month_year']))
            ->FilterKategori(request(['kategori_pr_id']))
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
            ->where('p_rentan.kategori_pr_id', 2)
            ->orderBy('p_rentan.id', 'DESC')
            ->get();
        return $data;
    }

    public function map($model): array
    {
        return [
            "'".$model->nik,
            $model->name,
            $model->ttl,
            $model->address,
            $model->gender,
            $model->yayasan_name,
            $model->kategori_name
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
