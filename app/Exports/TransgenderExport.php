<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
// use App\Models\P_Rentan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransgenderExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('p_rentan as p')
                ->leftJoin('yayasan as y', 'y.id', '=', 'p.yayasan_id')
                ->leftJoin('kategori_pr as k', 'k.id', '=', 'p.kategori_pr_id')
                ->select('p.id','p.name','p.nik','p.ttl','p.address','p.gender','k.name as kategori_name','y.name as yayasan_name', DB::raw('COALESCE(p.yayasan_id, 0) as yayasan_id'))
                ->orderBy('p.id', 'DESC')
                ->where('p.kategori_pr_id', 5)
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
