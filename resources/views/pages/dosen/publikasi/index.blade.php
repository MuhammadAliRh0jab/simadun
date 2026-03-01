@extends('layouts.dosen.app')

@section('title', 'Laporan Kemajuan')

@section('styles')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" defer></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection

@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="card mb-3">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h2 class="mb-2">Laporan Publikasi Conference</h2>
          <small class="text-muted">Disini anda dapat mengupload jurnal yang sudah anda publikasikan. pastikan link Gdrive
            dapat di akses!</small>

          {{-- catch error --}}
          @if (Session::has('berhasil'))
            <div class="alert alert-success mt-2">
              {{ Session::get('berhasil') }}
            </div>
            {{-- else --}}
          @elseif (Session::has('gagal'))
            <div class="alert alert-danger mt-2">
              {{ Session::get('gagal') }}
              data gagal di hapus
          @endif
          {{-- end catch error --}}

        </div>
      </div>
    </div>
    {{-- PUBLIKASI Conference --}}
    <div class="row card">
      {{-- PUBLIKASI Conference --}}
      <div class="col-lg-12 mt-3">
        <div class="table-responsive b5">
          <table class="table table-striped rounded-4" id="tabelConference">
            <thead>
              <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Nim</th>
                <th>Nama Conference</th>
                <th>Penyelenggara</th>
                <th>Tanggal Conference</th>
                <th>Lokasi Conference</th>
                <th>Tanggal Publikasi</th>
                <th>Link</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dataPublikasiConference as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->judul }}</td>
                  <td>{{ $item->nim }}</td>
                  <td>{{ $item->namaConference }}</td>
                  <td>{{ $item->penyelenggara }}</td>
                  <td>{{ $item->tanggal_conference }}</td>
                  <td>{{ $item->lokasi_Conference }}</td>
                  <td>{{ $item->tanggalPublikasi }}</td>
                  <td><a href="{{ $item->link }}" class="btn btn-primary">link conference</a></td>
                  <td>{{ $item->created_at }}</td>
                  <td>{{ $item->updated_at }}</td>
                  <td>
                      <form action="{{ route('delete.dosen.Conf', $item->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger"
                          onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
                      </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="12" class="text-center">Tidak ada data...</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- publikasi jurnal --}}
    <div class="card mb-3 mt-5">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h2 class="mb-2">Laporan Publikasi Jurnal</h2>
          <small class="text-muted">Disini anda dapat mengupload jurnal yang sudah anda publikasikan. pastikan link
            Gdrive
            dapat di akses!</small>
        </div>
      </div>
    </div>
    {{-- tabel --}}
    <div class="row card">
      {{-- tabel jurnal --}}
      <div class="table-responsive">
        <table class="table table-striped " id="tabel">
          <thead>
            <tr>
              <th>#</th>
              <th>Judul</th>
              <th>Nim</th>
              <th>Nama Jurnal</th>
              <th>Volume</th>
              <th>Nomor</th>
              <th>Tanggal Terbit</th>
              <th>Link</th>
              <th>Created At</th>
              <th>Updated At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($dataPublikasiJurnal as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->judul_Artikel }}</td>
                <td>{{ $item->nim }}</td>
                <td>{{ $item->nama_jurnal }}</td>
                <td>{{ $item->volume }}</td>
                <td>{{ $item->nomor }}</td>
                <td>{{ $item->tanggal_terbit }}</td>
                <td><a href="{{ $item->link }}" class="btn btn-primary">Link Jurnal</a></td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->updated_at }}</td>
                <td>
                    <form action="{{ route('delete.dosen.jurnal', $item->id) }}" method="post" class="d-inline">
                      @csrf
                      @method('delete')
                      <button class="btn btn-danger"
                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
                    </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="12" class="text-center">Tidak ada data...</td>
              </tr>
            @endforelse
          </tbody>

        </table>
      </div>
    </div>



    @section('scripts')
      <script>
        // datatables
        document.addEventListener("DOMContentLoaded", function() {
          // Tabel Jurnal
          new DataTable('#tabel');
          // Tabel Conference
          new DataTable('#tabelConference');


        });
      </script>
    @endsection
  @endsection
