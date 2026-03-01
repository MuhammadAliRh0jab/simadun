<?php

namespace App\DataTables\Dosen;

use App\Helpers\DataTableHelper;
use App\Helpers\UserHelper;
use App\Models\Dosen;
use App\Models\Mahasiswa as BimbinganMahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BimbinganMahasiswaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('progress', function ($data) {
                $progress = [
                    0 => '<span class="badge bg-label-primary">Belum Diajukan</span>',
                    1 => '<span class="badge bg-label-primary">Ujian Proposal</span>',
                    2 => '<span class="badge bg-label-primary">Ujian Semhas</span>',
                    3 => '<span class="badge bg-label-primary">Ujian Publikasi</span>',
                    4 => '<span class="badge bg-label-primary">Ujian Disertasi</span>',
                    5 => '<span class="badge bg-label-primary">Ujian Tertutup</span>',
                    6 => '<span class="badge bg-label-success">Ujian Selesai</span>',
                ];

                return $progress[$data->progress];
            })
            ->editColumn('nama', function ($data) {
                $nama = $data->nama;
                $nim = $data->nim;
                $url = UserHelper::getMahasiswaPicture($nim);
                return DataTableHelper::namaPlaceholder($nama, $nim, $url);
            })
            ->editColumn('promotor', function ($data) {
                $promotor_ids = [$data->promotor_id, $data->co_promotor1_id, $data->co_promotor2_id];
                $promotor_ids = array_filter($promotor_ids);
                $promotors = [];


                foreach ($promotor_ids as $id) {
                    $promotor = new \stdClass();
                    $dosen = Dosen::select('nama', 'no_induk')->where('id', $id)->first();
                    $promotor->nama = $dosen->nama;
                    $promotor->url = UserHelper::getDosenPicture($dosen->no_induk);
                    $promotors[] = $promotor;
                }

                return DataTableHelper::promotors($promotors);
            })
            ->editColumn(
                'aksi',
                function ($row) {
                    $edit_route = null;
                    $delete_route = null;
                    $show_route = route('dosen.bimbingan.show', $row->id);
                    $csrf = csrf_field();
                    return DataTableHelper::actionButton($show_route, $edit_route, $delete_route, $csrf);
                }
            )
            ->rawColumns(['progress', 'nama', 'promotor', 'aksi']);

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BimbinganMahasiswa $model): QueryBuilder
    {
        $uid = auth()->guard('dosen')->user()->id;
        return $model->where('promotor_id', $uid)->orWhere('co_promotor1_id', $uid)->orWhere('co_promotor2_id', $uid)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return DataTableHelper::builder($this, 'datatable')
        ->orderBy(1, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('progress')->width('10%'),
            Column::make('nama')->width('30%'),
            Column::make('judul')->width('30%'),
            Column::computed('promotor')->width('20%'),
            Column::computed('aksi')->width('10%')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BimbinganMahasiswa_' . date('YmdHis');
    }
}
