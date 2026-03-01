<?php

namespace App\DataTables\Dosen;

use App\Helpers\DataTableHelper;
use App\Helpers\UserHelper;
use App\Models\Mahasiswa as UjianTerjadwal;
use App\Models\Dosen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UjianTerjadwalDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('tanggal', function ($data) {
                return DataTableHelper::tanggal($data->tanggal, $data->jam);
            })
            ->editColumn('jenis', function ($data) {
                return <<<HTML
                <span class="badge bg-label-primary">{$data->jenis_ujian}</span>
                HTML;
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
            ->editColumn('penguji', function ($data) {
                $penguji_ids = [$data->penguji1_id, $data->penguji2_id, $data->penguji_eks_id, $data->penguji3_id];
                $penguji_ids = array_filter($penguji_ids);
                $pengujis = [];

                foreach ($penguji_ids as $id) {
                    $penguji = new \stdClass();
                    $dosen = Dosen::select('nama', 'no_induk')->where('id', $id)->first();
                    $penguji->nama = $dosen->nama;
                    $penguji->url = UserHelper::getDosenPicture($dosen->no_induk);
                    $pengujis[] = $penguji;
                }

                return DataTableHelper::pengujis($pengujis);
            })
            ->editColumn(
                'aksi',
                function ($row) {
                    $edit_route = null;
                    $delete_route = null;
                    $show_route = route('dosen.ujian.terjadwal.show', $row->pendaftaran_id);
                    $csrf = csrf_field();
                    return DataTableHelper::actionButton($show_route, $edit_route, $delete_route, $csrf);
                }
            )
            ->rawColumns(['jenis', 'nama', 'promotor', 'penguji', 'aksi']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UjianTerjadwal $model): QueryBuilder
    {
        $uid = auth()->guard('dosen')->user()->id;
        $test = $model
            ->join('pendaftaran_ujians', 'pendaftaran_ujians.nim', '=', 'mahasiswas.nim')
            ->join('jadwal_ujians', 'jadwal_ujians.pendaftaran_ujian_id', '=', 'pendaftaran_ujians.id')
            ->select('mahasiswas.*', 'pendaftaran_ujians.id as pendaftaran_id', 'jenis_ujian', 'jadwal_ujians.penguji1_id', 'jadwal_ujians.penguji2_id', 'jadwal_ujians.penguji_eks_id', 'jadwal_ujians.tanggal', 'jadwal_ujians.jam')->where('pendaftaran_ujians.status', '3')
            ->where(function ($query) use ($uid) {
                $query->where(function ($query) use ($uid) {
                    $query->where('jadwal_ujians.penguji1_id', $uid)
                        ->orWhere('jadwal_ujians.penguji2_id', $uid)
                        ->orWhere('jadwal_ujians.penguji3_id', $uid)
                        ->orWhere('jadwal_ujians.penguji_eks_id', $uid);
                })
                    ->orWhere(function ($query) use ($uid) {
                        $query->where('promotor_id', $uid)
                            ->orWhere('co_promotor1_id', $uid)
                            ->orWhere('co_promotor2_id', $uid);
                    });
            })->newQuery();

        return $test;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return DataTableHelper::builder($this, 'datatable')
            ->orderBy(3, 'asc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('tanggal')->width('15%'),
            Column::computed('jenis')->width('10%'),
            Column::make('nama')->width('35%'),
            Column::make('nim')->visible(false),
            Column::computed('promotor')->width('15%'),
            Column::computed('penguji')->width('15%'),
            Column::computed('aksi')
                ->width('10%')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UjianTerjadwal_' . date('YmdHis');
    }
}
