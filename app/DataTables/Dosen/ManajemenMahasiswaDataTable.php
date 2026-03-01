<?php

namespace App\DataTables\Dosen;

use App\Helpers\DataTableHelper;
use App\Helpers\UserHelper;
use App\Models\Dosen;
use App\Models\Mahasiswa as ManajemenMahasiswa;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ManajemenMahasiswaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query)) // Add this line to add DT_RowIndex
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
                    if ($dosen) {
                        $promotor->nama = $dosen->nama;
                        $promotor->url = UserHelper::getDosenPicture($dosen->no_induk);
                        $promotors[] = $promotor;
                    }
                }

                return DataTableHelper::promotors($promotors);
            })
            ->editColumn('progress', function ($data) {
                $progress = [
                    0 => '<span class="badge bg-label-primary">Ujian Proposal</span>',
                    1 => '<span class="badge bg-label-primary">Ujian Semhas</span>',
                    2 => '<span class="badge bg-label-primary">Ujian Kelayakan</span>',
                    3 => '<span class="badge bg-label-primary">Ujian Kelayakan</span>',
                    4 => '<span class="badge bg-label-primary">Ujian Tertutup</span>',
                ];

                return $progress[$data->progress] ?? '<span class="badge bg-label-secondary">Unknown</span>';
            })
            ->addColumn('aksi', function ($row) {
                $edit_route = route('dosen.manajemen.mahasiswa.edit', $row->id);
                $delete_route = route('dosen.manajemen.mahasiswa.destroy', $row->id);
                $show_route = route('dosen.manajemen.mahasiswa.show', $row->id);
                $csrf = csrf_field();
                return DataTableHelper::actionButton($show_route, $edit_route, $delete_route, $csrf);
            })
            ->rawColumns(['progress', 'nama', 'promotor', 'aksi']);
            // ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ManajemenMahasiswa $model): QueryBuilder
    {
        // return $model->newQuery()->select([
        //     'id', 'nama', 'nim', 'judul', 'promotor_id', 
        //     'co_promotor1_id', 'co_promotor2_id', 'progress'
        // ]);
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
            Column::make('nama')->title('Nama')->width('30%'),
            Column::make('judul')->title('Judul')->width('30%'),
            Column::computed('promotor')->title('Promotor')->width('20%'),
            Column::computed('progress')->title('Progress')->width('10%'),
            Column::computed('aksi')->title('Aksi')->width('10%')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ManajemenMahasiswa_' . date('YmdHis');
    }
}