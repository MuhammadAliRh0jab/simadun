<?php

namespace App\DataTables\Dosen;

use App\Models\Mahasiswa as Proposal;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\DataTableHelper;
use App\Helpers\UserHelper;

class ProposalDataTable extends DataTable
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
                $status = [
                    2 => '<span class="badge bg-label-secondary">Diajukan</span>',
                    3 => '<span class="badge bg-label-success">Terjadwal</span>',
                    4 => '<span class="badge bg-label-warning">Revisi</span>',
                    5 => '<span class="badge bg-label-secondary">Revisi Diajukan</span>',
                    6 => '<span class="badge bg-label-success">Selesai</span>',
                ];

                return $status[$data->status];
            })
            ->editColumn('penilaian', function ($data) {
                if ($data->nilai_penguji1 != null && $data->nilai_penguji2 != null && $data->nilai_promotor != null && $data->nilai_co_promotor1 != null && ($data->co_promotor2_id == null || $data->nilai_co_promotor2 != null) && $data->nilai_kaprodi != null) {
                    $data->penilaian = 2;
                } elseif ($data->nilai_penguji1 != null || $data->nilai_penguji2 != null || $data->nilai_promotor != null || $data->nilai_co_promotor1 != null || $data->nilai_co_promotor2 != null || $data->nilai_kaprodi != null) {
                    $data->penilaian = 1;
                } else {
                    $data->penilaian = 0;
                }
                $penilaian = [
                    0 => '<span class="badge bg-label-secondary">Belum Dinilai</span>',
                    1 => '<span class="badge bg-label-primary">Sedang Dinilai</span>',
                    2 => '<span class="badge bg-label-success">Sudah Dinilai</span>',
                ];

                return $penilaian[$data->penilaian];
            })
            ->editColumn('judul', function ($data) {
                return DataTableHelper::limitText($data->judul, 65);
            })
            ->editColumn('nama', function ($data) {
                $nama = $data->nama;
                $nim = $data->nim;
                $url = UserHelper::getMahasiswaPicture($nim);

                return DataTableHelper::namaPlaceholder($nama, $nim, $url);
            })
            ->editColumn(
                'aksi',
                function ($row) {
                    $edit_route = null;
                    $delete_route = null;
                    $show_route = route('dosen.ujian.proposal.show', $row->pendaftaran_id);
                    $csrf = csrf_field();
                    return DataTableHelper::actionButton($show_route, $edit_route, $delete_route, $csrf);
                }
            )
            ->rawColumns(['status', 'penilaian', 'nama', 'aksi']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Proposal $model): QueryBuilder
    {
        $test = $model->join('pendaftaran_ujians', 'pendaftaran_ujians.nim', '=', 'mahasiswas.nim')->where('pendaftaran_ujians.jenis_ujian', 'proposal')->where('pendaftaran_ujians.status', '<=', 6)->select('mahasiswas.*', 'pendaftaran_ujians.id as pendaftaran_id', 'status', 'nilai_penguji1', 'nilai_penguji2', 'nilai_promotor', 'nilai_co_promotor1', 'nilai_co_promotor2', 'nilai_kaprodi')->newQuery();
        return $test;
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
            Column::computed('status')->width('10%'),
            Column::computed('penilaian')->width('10%'),
            Column::make('nama')->width('30%'),
            Column::make('judul')->width('40%'),
            // Column::make('promotor'),
            Column::computed('aksi')->width('10%')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Proposal_' . date('YmdHis');
    }
}
