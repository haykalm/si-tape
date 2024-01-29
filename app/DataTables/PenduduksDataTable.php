<?php

namespace App\DataTables;

use App\Models\P_Rentan;
use App\Models\Yayasan;
use App\Models\KategoriPR;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class PenduduksDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query->FilterMonthYear(request(['month_year'])))
            ->addIndexColumn()
            ->editColumn('yayasan_id', function ($row) {
                return Yayasan::find($row->yayasan_id)->name ?? '-';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y ') ?? '-';
            })
            ->editColumn('kategori_pr_id', function ($row) {
                return KategoriPR::find($row->kategori_pr_id)->name ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                $btnAksi = '-';
                $routeDelete = route('penduduk.destroy',base64_encode($row->id),);

                $btnAksi = '<div style="display: flex;justify-content:center;vertical-align: middle;text-decoration: none;">';

                $btnAksi .= '<a href="'.route('download.lampiran', base64_encode($row->id),).'" class="btn btn-primary btn-xs show_confirm" title="Download Lampiran" style="margin-right: 2px">
                                <li type="button" class="fa fa-cloud-download" ></li>
                            </a>
                            <a href="'.route('download.nota_lampiran', base64_encode($row->id),).'" class="btn bg-purple btn-xs show_confirm" title="download nota dinas" style="margin-right: 2px">
                                <li type="button" class="fa fa-download" ></li>
                            </a>
                            <a href="'.route('detail_pr.pdf', base64_encode($row->id),).'" class="btn bg-orange btn-xs show_confirm" target="_blank" title="download detail" style="margin-right: 2px">
                                <li type="button" class="glyphicon glyphicon-download"></li>
                            </a>
                            <a class="btn btn-info btn-xs show_confirm" onClick="show('. $row->id.')" data-nama="#" data-toggle="tooltip" title="Edit" style="margin-right: 2px">
                                <li type="submit" class="fa fa-pencil" ></li>
                            </a>';

                $btnDelete = '<form data-form="delete" action="'.$routeDelete.'" method="POST">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button class="btn btn-danger btn-xs" onclick="return confirm("Are you sure want to delete '.$row->name .'?")" title="Hapus" style="text-decoration: none;">
                            <li class="fa fa-trash" ></li>
                        </button>
                        </form>';

                $btnAksi .= $btnDelete.'</div>';
                return $btnAksi;
            })
            ->with(['width' => '100%'])
            ->rawColumns(['aksi']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Penduduk $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(P_Rentan $model)
    {
        $r = Route::currentRouteName();
        $model = $model->newQuery();
        if($r == 'list_napi')$model = $model->where('kategori_pr_id', 4);
        elseif($r == 'list_odgj')$model = $model->where('kategori_pr_id', 1);
        elseif($r == 'list_panti_asuhan')$model = $model->where('kategori_pr_id', 2);
        elseif($r == 'list_transgender')$model = $model->where('kategori_pr_id', 5);
        elseif($r == 'penduduk.index')$model = $model->where('kategori_pr_id', 3);
        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('penduduk-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom("<'row'<'col-sm-2'f><'col-sm-10'>>" . "<'row'<'col-sm-12'tr>>" . "<'row'<'col-sm-1 mt-1'l><'col-sm-4 mt-3'i><'col-sm-7'p>>")
            ->buttons([''])
            ->scrollX(true)
            ->scrollY(true)
            ->fixedColumns(['left' => 3, 'right' => 3])
            ->language(['processing' => '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'])
            ->orderBy(1, 'asc')
            ->parameters([
                "lengthMenu" => [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ]
            ])
            ->addTableClass('table align-middle table-rounded table-striped table-row-gray-300 fs-6 gy-5');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')->title('No.')->searchable(false)->orderable(false)->addClass('text-center'),
            Column::make('nik')->title('Nik'),
            Column::make('name')->title('Nama'),
            Column::make('ttl')->title('TTL'),
            Column::make('address')->title('Alamat'),
            Column::make('gender')->title('Jenis Kelamin'),
            Column::make('yayasan_id')->title('Yayasan'),
            Column::make('kategori_pr_id')->title('Kategori'),
            Column::make('created_at')->title('Dibuat'),
            Column::computed('aksi')->title('Aksi')
                ->searchable(false)
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center min-w-100px'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Penduduks_' . date('YmdHis');
    }
}
