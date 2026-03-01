<?php

namespace App\DataTables;

use App\Models\PublikasiJurnal;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\DataTableHelper;


class PublikasiMahasiswaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'publikasimahasiswa.action')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PublikasiJurnal $model): QueryBuilder
    {
        // ambil data berdasarakn nim
        $model = $model->where('nim', auth()->user()->nim);
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return DataTableHelper::builder($this, 'datatable')
        ->orderBy(0, 'asc')
        ->minifiedAjax(route('tabelJurnal'));
    }
    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('judul'),
            Column::make('nim'),
            Column::make('nama'),
            Column::make('volume'),
            Column::make('nomort'),
            Column::make('tanggal terbit'),
            Column::make('link'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PublikasiMahasiswa_' . date('YmdHis');
    }
}