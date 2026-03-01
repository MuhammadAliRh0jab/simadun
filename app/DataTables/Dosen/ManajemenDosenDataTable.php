<?php

namespace App\DataTables\Dosen;

use App\Helpers\DataTableHelper;
use App\Helpers\UserHelper;
use App\Models\Dosen as ManajemenDosen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ManajemenDosenDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('nama', function ($data) {
                $nama = $data->nama;
                $no_induk = $data->no_induk;
                $url = UserHelper::getDosenPicture($no_induk);
                return DataTableHelper::dosenNamaPlaceholder($nama, $no_induk, $url);
            })
            ->editColumn('role', function ($data) {
                return $data->role_label;
            })
            ->editColumn(
                'aksi',
                function ($row) {
                    $edit_route = route('dosen.manajemen.dosen.edit', $row->id);
                    $delete_route = route('dosen.manajemen.dosen.destroy', $row->id);
                    $show_route = route('dosen.manajemen.dosen.show', $row->id);
                    $csrf = csrf_field();
                    return DataTableHelper::actionButton($show_route, $edit_route, $delete_route, $csrf);
                }
            )
            ->rawColumns(['role', 'nama', 'aksi']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ManajemenDosen $model): QueryBuilder
    {
        return $model->newQuery();
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
            Column::make('nama')->width('40%'),
            Column::make('no_induk')->visible(false)->searchable(true),   // no induk hidden for search only
            Column::make('email')->width('20%'),
            Column::make('pangkat_gol')->width('20%'),
            Column::make('role')->width('10%'),
            Column::computed('aksi')->width('10%')
        ];
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ManajemenDosen_' . date('YmdHis');
    }
}
