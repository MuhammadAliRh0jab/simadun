<?php

namespace App\DataTables\Dosen;

use App\Helpers\DataTableHelper;
use App\Helpers\UserHelper;
use App\Models\Dosen;
use App\Models\LaporanBulanan as LaporanProgress;
use App\Models\Mahasiswa;
use App\Models\LaporanBulanan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LaporanProgressDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($data) {
                // query laporan bulanan search for all laporan bulanan with the same nim that has status 0 or 1
                $status = [
                    0 => '<span class="badge bg-label-info">tidak ada</span>',
                    1 => '<span class="badge bg-label-secondary">Laporan Baru</span>',
                    2 => '<span class="badge bg-label-success">Laporan Selesai</span>',
                ];

                return $status[$data->status];
            })
            ->editColumn('nama', function ($data) {
                $nama = $data->nama;
                $nim = $data->nim;
                $url = UserHelper::getMahasiswaPicture($nim);
                return DataTableHelper::namaPlaceholder($nama, $nim, $url);
            })
            ->editColumn('laporan', function ($data) {
                return $data->judul;
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
                    $show_route = route('dosen.laporan.show', $row->id);
                    $csrf = csrf_field();
                    return DataTableHelper::actionButton($show_route, $edit_route, $delete_route, $csrf);
                }
            )
            ->rawColumns(['status', 'nama', 'laporan', 'promotor', 'aksi']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(LaporanProgress $model): QueryBuilder
    {
        $uid = auth()->guard('dosen')->user()->id;
        $mahasiswaNims = Mahasiswa::where('promotor_id', $uid)
            ->orWhere('co_promotor1_id', $uid)
            ->orWhere('co_promotor2_id', $uid)
            ->pluck('nim');

        return $model->newQuery()
            ->whereIn('laporan_bulanans.nim', $mahasiswaNims)
            ->join('mahasiswas', 'mahasiswas.nim', '=', 'laporan_bulanans.nim')
            ->select('laporan_bulanans.*', 'mahasiswas.nama', 'mahasiswas.nim as nim_mahasiswa');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return DataTableHelper::builder($this, 'datatable')
        ->orderBy(2, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('status')->width('25%'),
            Column::computed('nama')->width('30%')->searchable('false'),
            Column::make('judul')->title('laporan')->width('35%'),
            Column::computed('aksi')->width('10%')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'LaporanProgress_' . date('YmdHis');
    }
}
