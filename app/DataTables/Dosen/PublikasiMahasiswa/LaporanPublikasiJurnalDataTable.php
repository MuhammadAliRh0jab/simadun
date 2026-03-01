<?php

namespace App\DataTables\Dosen\PublikasiMahasiswa;

use App\Helpers\DataTableHelper;
use App\Helpers\UserHelper;
use App\Models\PublikasiJurnal;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use App\Helpers\AuthHelper;
use Yajra\DataTables\Services\DataTable;

class LaporanPublikasiJurnalDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('judul', function ($data) {
                $volume = $data->volume ? "Vol. $data->volume" : '';
                $nomor = $data->nomor ? "No. $data->nomor" : '';
                $vol_nomor = trim("$volume $nomor");
                
                return <<<HTML
                    <div>
                        <span>{$data->judul}</span>
                    </div>
                    <div>
                        <span class="text-muted"><i>{$vol_nomor}</i></span>
                    </div>
                HTML;
            })
            ->editColumn('detail_mahasiswas.nama', function ($data) {
                $nama = $data->nama;
                $nim = $data->nim;
                $url = UserHelper::getMahasiswaPicture($nim);
                return DataTableHelper::namaPlaceholder($nama, $nim, $url);
            })
            ->addColumn('action', function ($data) {
                $url_delete = route('delete.dosen.jurnal', $data->id);
                return <<<HTML
                    <a href="{$data->link}" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                    <form action="{$url_delete}" method="post" class="d-inline ms-2">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="delete">
                      <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                          <i class="fas fa-trash"></i>
                      </button>
                    </form>
                HTML;
            })
            ->rawColumns(['detail_mahasiswas.nama', 'judul', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(PublikasiJurnal $model): QueryBuilder
    {
        $user = AuthHelper::user();
        
        // Debug user info
        \Log::info('Dosen logged in: ' . $user->id);
        
        $query = $model->newQuery()
            ->join('mahasiswas', 'mahasiswas.nim', '=', 'publikasi_jurnals.nim')
            ->join('detail_mahasiswas', 'detail_mahasiswas.nim', '=', 'mahasiswas.nim')
            ->select('publikasi_jurnals.*', 'detail_mahasiswas.nama');
        
        if (AuthHelper::isDosen()) {
            $query->where(function ($q) use ($user) {
                $q->where('mahasiswas.promotor_id', $user->id)
                  ->orWhere('mahasiswas.co_promotor1_id', $user->id)
                  ->orWhere('mahasiswas.co_promotor2_id', $user->id);
            });
            
            // Debug the SQL query
            \Log::info('SQL Query: ' . $query->toSql());
            \Log::info('SQL Bindings: ' . json_encode($query->getBindings()));
        }
        
        return $query->orderBy('detail_mahasiswas.nama', 'asc');
    }

    /**
     * Optional method if you want to use the HTML builder.
     */
    public function html(): HtmlBuilder
    {
        return DataTableHelper::builder($this, 'datatable');
    }

    /**
     * Get the DataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('detail_mahasiswas.nama')->title('Nama Mahasiswa'),
            Column::make('judul')->title('Judul Publikasi'),
            Column::make('jurnal')->title('Jurnal'),
            Column::make('tanggal_terbit')->title('Tanggal Terbit'),
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
        return 'LaporanPublikasiJurnal_' . now()->format('YmdHis');
    }
}