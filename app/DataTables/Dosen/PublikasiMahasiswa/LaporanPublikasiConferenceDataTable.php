<?php

namespace App\DataTables\Dosen\PublikasiMahasiswa;

use App\Helpers\DataTableHelper;
use App\Helpers\UserHelper;
use App\Models\PublikasiConference;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\AuthHelper;

class LaporanPublikasiConferenceDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('judul', function ($data) {
                return DataTableHelper::limitText($data->judul, 65);
            })
            ->editColumn('detail_mahasiswa.nama', function ($data) {
                $nama = $data->detail_mahasiswa->nama;
                $nim = $data->nim;
                $url = UserHelper::getMahasiswaPicture($nim);
                return DataTableHelper::namaPlaceholder($nama, $nim, $url);
            })
            ->editColumn('tanggal_conference', function ($data) {
                return <<<HTML
                    <div>
                        <span><b>Conference:</b><span class="ms-2">$data->tanggal_conference</span></span>
                    </div>
                    <div>
                        <span><b>Publikasi:</b><span class="ms-2">$data->tanggalPublikasi</span></span>
                    </div>
                HTML;
            })
            ->addColumn('action', function ($data) {
                $url_delete = route('delete.dosen.Conf', $data->id);
                return <<<HTML
                    <a href="$data->link" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                    <form action="$url_delete" method="post" class="d-inline ms-2">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="off">
                      <input type="hidden" name="_method" value="delete">
                      <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                    </form>
                HTML;
            })
            ->rawColumns(['detail_mahasiswa.nama', 'tanggal_conference', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PublikasiConference $model): QueryBuilder
    {
        $user = AuthHelper::user();
        
        // Debug user info
        \Log::info('Dosen logged in: ' . $user->id);
        
        $query = $model->newQuery()
            ->with('detail_mahasiswa')
            ->join('mahasiswas', 'mahasiswas.nim', '=', 'publikasi_conferences.nim');
        
        if (AuthHelper::isDosen()) {
            $query->where(function ($q) use ($user) {
                $q->where('mahasiswas.promotor_id', $user->id)
                  ->orWhere('mahasiswas.co_promotor1_id', $user->id)
                  ->orWhere('mahasiswas.co_promotor2_id', $user->id);
            });
            
            // Debug the SQL query
            \Log::info('Conference SQL Query: ' . $query->toSql());
            \Log::info('Conference SQL Bindings: ' . json_encode($query->getBindings()));
        }
        
        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return DataTableHelper::builder($this, 'datatable');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('detail_mahasiswa.nama')->title('Nama Mahasiswa'),
            Column::make('judul'),
            Column::make('namaConference')->title('Conference'),
            Column::make('penyelenggara')->title('Penyelenggara'),
            Column::make('tanggal_conference')->title('Tanggal'),
            Column::make('lokasi_Conference')->title('Lokasi'),
            Column::computed('action')
                ->title('Aksi')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'LaporanPublikasiConference_' . date('YmdHis');
    }
}