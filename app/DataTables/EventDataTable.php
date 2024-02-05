<?php

namespace App\DataTables;

use App\Models\Event;
use App\Models\P_Rentan;
use App\Models\Yayasan;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Route;

class EventDataTable extends DataTable
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
            ->editColumn('p_rentan_id', function ($row) {
                return P_Rentan::find($row->p_rentan_id)->nik ?? '-';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y ') ?? '-';
            })
            ->editColumn('date', function ($row) {
                return $row->date ?? '-';
            })
            ->editColumn('event_location', function ($row) {
                return $row->event_location ?? '-';
            })
            ->addColumn('alamat_warga', function ($row) {
                return P_Rentan::find($row->p_rentan_id)->address ?? '-';
            })
            ->addColumn('nama_warga', function ($row) {
                return P_Rentan::find($row->p_rentan_id)->name ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                $btnAksi = '-';
                $routeDelete = route('event.destroy',base64_encode($row->id_event),);
                $routeEdit = route('edit_event.internal',base64_encode($row->id),);
                if(Route::currentRouteName() == 'event.index') $routeEdit = route('event.edit',base64_encode($row->id),);

                $btnAksi = '<div style="display: flex;justify-content:center;vertical-align: middle;text-decoration: none;">';

                $btnAksi .= '<a class="btn btn-success btn-xs show_confirm" onClick="show('.$row->id.')" data-nama="#" data-toggle="tooltip" title="show images" style="margin-right: 3px">
                                <li type="submit" class="fa fa-eye" ></li>
                            </a>
                            <a href="'.route('event.pdf', base64_encode($row->id),).'" class="btn btn-primary btn-xs show_confirm" title="Download Event" style="margin-right: 3px" target="_blank">
                                <li type="button" class="fa fa-cloud-download" ></li>
                            </a>
                            <a href="'.$routeEdit.'" class="btn btn-info btn-xs" title="Edit" style="margin-right: 3px">
                                <li type="button" class="fa fa-pencil" ></li>
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
     * @param \App\Models\Event $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Event $model)
    {
        $r = Route::currentRouteName();
        $model = $model->newQuery();
        if($r == 'event.internal')$model = $model->whereNull('yayasan_id');
        elseif($r == 'event.index')$model = $model->whereNotNull('yayasan_id');
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
            ->setTableId('event-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom("<'row'<'col-sm-2'f><'col-sm-10'>>" . "<'row'<'col-sm-12'tr>>" . "<'row'<'col-sm-1 mt-1'l><'col-sm-4 mt-3'i><'col-sm-7'p>>")
            ->buttons([''])
            ->scrollX(true)
            ->scrollY('300px')
            ->fixedColumns(['left' => 3, 'right' => 3])
            ->language(['processing' => '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>'])
            ->orderBy(1, 'asc')
            ->parameters([
                "lengthMenu" => [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100],
                'buttons' => [
                    'copy', 'csv', 'excel', 'pdf', 'print', // Semua tombol yang tersedia
                ],
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
        $column = [
            Column::make('DT_RowIndex')->title('No.')->searchable(false)->orderable(false)->addClass('text-center'),
            Column::make('p_rentan_id')->title('Nik'),
            Column::make('nama_warga')->title('Nama Warga'),
            Column::make('alamat_warga')->title('Alamat Warga'),
            Column::make('event_name')->title('Nama Kegiatan'),
            Column::make('event_location')->title('Tempat Kegiatan'),
            Column::make('date')->title('Tanggal Kegiatan'),
        ];
        if(Route::currentRouteName() == 'event.index') $column[] = Column::make('yayasan_id')->title('Yayasan');
        $column[] = Column::computed('aksi')->title('Aksi')
            ->searchable(false)
            ->orderable(false)
            ->exportable(false)
            ->printable(false)
            ->width(100)
            ->addClass('text-center min-w-100px');

        return $column;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Event_' . date('YmdHis');
    }
}
