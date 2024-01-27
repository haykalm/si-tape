<?php

namespace App\DataTables;

use App\Models\Napi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NapiDataTable extends DataTable
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
            ->eloquent($query->FilterParent(request(['parent_id'])))
            ->addIndexColumn()
            ->editColumn('status_data', function ($row) {
                $row = $row->status_data;
                $status = $row == True ? 'Aktif' : 'Tidak Aktif';
                $class = $row == True ? 'primary' : 'danger';
                $html = '<span class="badge badge-light-'.$class.'">'.$status.'</span>';
                return $html;
            })
            ->addColumn('aksi', function ($row) {
                $btnAksi = '-';
                // $routeEdit = route('jakelola.daily.edit', enkrip($row->id));
                // $routeDelete = route('jakelola.daily.destroy', enkrip($row->id));

                // $btnAksi = '<div class="d-flex justify-content-center">';

                //     $btnAksi .= '<a href="' . $routeEdit . '" class="btn btn-primary btn-sm me-2">Ubah</a>';

                //     $btnDelete = '<form data-form="delete" action="'.$routeDelete.'" method="POST">

                // '.csrf_field().'
                // '.method_field('DELETE').'
                // <button type="button" class="btn btn-danger btn-sm me-1 delete-btn" data-nama="' . $row->nama . '">Hapus</button>
                // </form>';

                // $btnAksi .= $btnDelete.'</div>';
                return $btnAksi;
            })
            ->rawColumns(['aksi','status_data']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Napi $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Napi $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('maste-daily-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-sm-2'f><'col-sm-10'>>" . "<'row'<'col-sm-12'tr>>" . "<'row'<'col-sm-1 mt-1'l><'col-sm-4 mt-3'i><'col-sm-7'p>>")
            ->buttons([''])
            ->scrollX(true)
            ->scrollY('500px')
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
            Column::make('nama')->title('Nama'),
            Column::make('jenis')->title('Jenis'),
            Column::make('parent_id')->title('Parent'),
            Column::make('order')->title('Order'),
            Column::make('status_data')->title('Status Data'),
            Column::make('tanggal_mulai')->title('Tanggal Mulai'),
            Column::make('tanggal_selesai')->title('Tanggal Selesai'),
            Column::computed('aksi')
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
        return 'Napi_' . date('YmdHis');
    }
}
