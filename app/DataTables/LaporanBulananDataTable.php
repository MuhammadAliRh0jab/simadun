<?php

namespace App\DataTables;

use App\Helpers\DataTableHelper;
use App\Models\LaporanBulanan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Livewire\Attributes\Computed;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LaporanBulananDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('updated_at', fn ($data) => $data->updated_at->format('d-m-Y'))
            ->editColumn('status', function ($data) {
                $status = [
                0 => '<span class="badge bg-label-secondary">Dalam Proses</span>',
                1 => '<span class="badge bg-label-info">Dalam Proses</span>',
                2 => '<span class="badge bg-label-success">Selesai</span>',
                ];

                return $status[$data->status];
            })

            ->addColumn(
                'action',
                function ($row) {
                    $edit_route = null;
                    $delete_route = null;
                    $show_route = route('laporan-bulanan.show', $row->id);
                    $csrf = csrf_field();
                    return DataTableHelper::actionButton($show_route, $edit_route, $delete_route, $csrf);
                }
            )
            ->rawColumns(['status', 'action']);

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(LaporanBulanan $model): QueryBuilder
    {
        $nim = auth()->user()->nim;
        $query = $model->newQuery()->where('nim', $nim);
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return DataTableHelper::builder($this, 'datatable')
        ->orderBy(0, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('updated_at')->title('Tanggal'),
            Column::make('judul')->title('Judul'),
            Column::computed('status')->title('Status'),
            Column::computed('action')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'LaporanBulanan_' . date('YmdHis');
    }
}
