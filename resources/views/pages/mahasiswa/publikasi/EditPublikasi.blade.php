@extends('layouts.mahasiswa.app')
@section('title', 'Edit Publikasi Conference')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="col-lg-12 mb-4 h-100">
  <div class="card mb-5">
    <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
      <div class="card-title mb-3">
        <h2 class="mb-2">Form Publikasi Publikasi Anda</h2>
        <small class="text-muted">Perbaiki Kembali Publikasi Anda !!</small>
        @if (Session::has('berhasil'))
        <div class="alert alert-success mt-2">
          {{ Session::get('berhasil') }}
          data berhasil di kirim
        </div>
        {{-- else --}}
        @elseif (Session::has('gagal'))
        <div class="alert alert-danger mt-2">
          {{ Session::get('gagal') }}
          data gagal di kirim
          @endif
          <div class="mt-3">
          </div>
        </div>
      </div>
    </div>
    {{-- form --}}
    <div class="card mt-5">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h3 class="mb-2">Form Pengisian</h3>
          <small class="text-muted">Harap isi form dengan benar</small>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          @foreach ($ambilData as $item)
              
          <div class="col-lg-12">
            <form action="{{ route('publikasi.update') }}" method="post" id="myForm" enctype="multipart/form-data">
              @csrf
              {{-- nim penulis --}}
              <div class="form-group row mb-3 ">
                <div class="col-12 col-md-6">
                  <label for="judul_Artikel" class="col-sm-5 col-form-label">Judul Artikel</label>
                  <br>
                  <input type="text" class="form-control" id="judul_Artikel" name="judul_Artikel"
                    value="{{ $item->judul_Artikel }}">
                    @error('judul_Artikel')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <input type="hidden" name="id" value="{{ $item->id }}">
                  <div class="col-12 col-md-6">
                <label for="nim" class="col-sm-5 col-form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" value="{{ Auth::user()->nim }}" readonly>
                {{-- ambil nim dari auth --}}
                @error('nim')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            {{-- nama penyelenggara --}}
            <div class="form-group row mb-3 ">
              <div class="col-12 col-md-6">
                <label for="nama_jurnal" class="col-sm-5 col-form-label">Nama Jurnal</label>
                <input type="text" class="form-control" id="nama_jurnal" name="nama_jurnal"
                  value="{{ $item->nama_jurnal }}">
                @error('nama_jurnal')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
              
              <div class="col-12 col-md-6">
                <label for="volume" class="col-sm-5 col-form-label">Volume</label>
                <input type="text" class="form-control" id="volume" name="volume" value="{{ $item->volume }}">
                @error('volume')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            
            {{-- hal nomor --}}
            <div class="form-group row mb-3 ">
              <div class="col-12 col-md-6">
                <label for="nomor" class="col-sm-5 col-form-label">Nomor</label>
                <input type="text" class="form-control" id="nomor" name="nomor" value="{{ $item->nomor }}">
                @error('nomor')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="col-12 col-md-6">
                <label for="tanggal_terbit" class="col-sm-5 col-form-label">Tanggal Terbit</label>
                <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit"
                  value="{{ $item->tanggal_terbit }}">
                @error('tanggal_terbit')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            
            
            {{-- tgl publikasi dan link --}}
            <div class="form-group row mb-3 ">
              <div class="col-12 col-md-6">
                <label for="naskah" class="form-label" style="margin-top: 0.8rem">Link Google Drive naskah</label>
                <input type="url" class="form-control" id="naskah" name="link" value="{{ $item->link }}"
                placeholder="Masukan link gdrive naskah" required>
                <div class="form-text" id="err">Pastikan link/url Google Drive naskah dapat diakses</div>
              </div>
            </div>
            
              
              
              {{-- submit --}}
              <div class="form-group mb-3">
                <button type="button" id="submitBtn" class="btn btn-primary" onclick="confirmUpload()">Submit</button>
              </div>
            </form>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    {{-- end of form --}}
  </div>
</div>
<!-- Pastikan SweetAlert dan jQuery dimuat sebelum skrip JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('scripts')
<script>
  $(document).ready(function () {
    // add regex check on type of input naskah to follow google drive link example: https://drive.google.com/file/d/1
    $('#naskah').on('input', function () {
      var url = $(this).val();
      var regex = new RegExp('^(https?:\/\/drive.google.com\/file\/d\/[a-zA-Z0-9-_]+)');
      if (url.trim() === '') {
        // Jika input kosong
        $(this).removeClass('is-valid').removeClass('is-invalid');
        $('#err').text('');
      } else if (regex.test(url)) {
        // Jika input sesuai dengan pola regex
        $(this).removeClass('is-invalid').addClass('is-valid');
        $('#err').text('Pastikan link/url Google Drive naskah dapat diakses').removeClass('text-danger');
      } else {
        // Jika input tidak sesuai dengan pola regex
        $(this).removeClass('is-valid').addClass('is-invalid');
        $('#err').text('Link/url Google Drive naskah tidak valid').addClass('text-danger');
        // Tampilkan SweetAlert
        Swal.fire({
          icon: 'error',
          title: 'Link/URL tidak valid',
          text: 'Pastikan Anda memasukkan link Google Drive yang valid.',
        });
      }
    });
  });



  //sweet alert
  function confirmUpload() {
    // Get form input by element id
    var judul_Artikel = document.getElementById('judul_Artikel').value;
    var nim = document.getElementById('nim').value;
    var nama_jurnal = document.getElementById('nama_jurnal').value;
    var volume = document.getElementById('volume').value;
    var nomor = document.getElementById('nomor').value;
    var tanggal_terbit = document.getElementById('tanggal_terbit').value;
    var link = document.getElementById('naskah').value;

    // Show confirmation dialog with form input values
    Swal.fire({
      title: 'Konfirmasi',
      html: `
            <table class="table text-left">
                <tr>
                    <td>Judul Artikel</td>
                    <td>:</td>
                    <td>${judul_Artikel}</td>
                </tr>
                <tr>
                    <td>Nama Jurnal</td>
                    <td>:</td>
                    <td>${nama_jurnal}</td>
                </tr>
                <tr>
                    <td>Volume</td>
                    <td>:</td>
                    <td>${volume}</td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td>${nim}</td>
                </tr>
                <tr>
                  <td>NOMOR</td>
                    <td>:</td>
                    <td>${nomor}</td>
                </tr>
                <tr>
                  <td>Tanggal Terbit</td>
                    <td>:</td>
                    <td>${tanggal_terbit}</td>
                </tr>
                <tr>
                  <td>Link</td>
                    <td>:</td>
                    <td>${link}</td>
                </tr>
            </table>
        `,
      icon: 'question',
      showCancelButton: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, lanjutkan!',
      cancelButtonText: 'Batal',
    }).then((result) => {
      if (result.isConfirmed) {
        // Jika pengguna menyetujui, lanjutkan dengan mengirim formulir
        document.getElementById('myForm').submit();
      }
    });
  }

</script>
@endsection

@push('scripts')
@endpush