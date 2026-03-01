@extends('layouts.mahasiswa.app')
@section('title', 'Edit Publikasi Conference')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="col-lg-12 mb-4 h-100">
  <div class="card mb-5">
    <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
      <div class="card-title mb-3">
        <h2 class="mb-2">Form Publikasi Conference</h2>
        <small class="text-muted">Perbaiki Kembali Publikasi Conference Anda !!</small>
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
            <form action="{{ route('conference.update') }}" method="post" id="myForm" enctype="multipart/form-data">
              @csrf
              {{-- nim penulis --}}
              <div class="form-group row mb-3 ">

                <div class="col-12 col-md-6">
                  <label for="judul" class="col-sm-5 col-form-label">Judul</label>
                <br>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ $item->judul }}">
                @error('judul')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
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

            {{-- file input type hidden --}}
            <input type="hidden" name="id" value="{{ $item->id }}">

            {{-- nama penyelenggara --}}
            <div class="form-group row mb-3 ">
              <div class="col-12 col-md-6">
                <label for="namaConference" class="col-sm-5 col-form-label">Nama Conference</label>
                <input type="text" class="form-control" id="namaConference" name="namaConference"
                value="{{ $item->namaConference }}" >
                @error('namaConference')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
              
              <div class="col-12 col-md-6">
                <label for="penyelenggra" class="col-sm-5 col-form-label">penyelenggara</label>
                <input type="text" class="form-control" id="penyelenggra" name="penyelenggra"
                value="{{ $item->penyelenggara }}" >
                @error('penyelenggra')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            
            {{-- hal nomor --}}
            <div class="form-group row mb-3 ">
              <div class="col-12 col-md-6">
                <label for="tanggal_conference" class="col-sm-5 col-form-label">Tanggal Conference</label>
                <input type="date" class="form-control" id="tanggal_conference" name="tanggal_conference" value="{{ $item->tanggal_conference }}">
                @error('tanggal_conference')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="col-12 col-md-6">
                <label for="lokasi_Conference" class="col-sm-5 col-form-label">Lokasi Conference</label>
                <input type="text" class="form-control" id="lokasi_Conference" name="lokasi_Conference" value="{{ $item->lokasi_Conference }}" >
                @error('lokasi_Conference')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            
            
            {{-- tgl publikasi dan link --}}
            <div class="form-group row mb-3 ">
              <div class="col-12 col-md-6">
                <label for="tanggalPublikasi" class="col-sm-5 col-form-label">Tanggal Publikasi</label>
                <input type="date" class="form-control" id="tanggalPublikasi" name="tanggalPublikasi" value="{{ $item->tanggalPublikasi}}">
                @error('tanggalPublikasi')
                <div class="text-danger">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="col-12 col-md-6">
                <label for="naskah" class="form-label" style="margin-top: 0.8rem">Link Google Drive naskah</label>
                <input type="url" class="form-control" id="naskah" name="link" value="{{ $item->link }}"
                placeholder="Masukan link gdrive naskah" required>
                <div class="form-text" id="err">Pastikan link/url Google Drive naskah dapat diakses</div>
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
      var regex = new RegExp('');
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
    // Ambil nilai dari input form
    var judul = document.getElementById('judul').value;
    var nim = document.getElementById('nim').value;
    var namaConference = document.getElementById('namaConference').value;
    var penyelenggra = document.getElementById('penyelenggra').value;
    var tanggalConference = document.getElementById('tanggal_conference').value;
    var lokasiConference = document.getElementById('lokasi_Conference').value;
    var tanggalPublikasi = document.getElementById('tanggalPublikasi').value;
    var naskah = document.getElementById('naskah').value;

    // Tampilkan sweet alert dengan nilai input form
    Swal.fire({
        title: 'Konfirmasi',
        html: `
            <table class="table text-left">
                <tbody>
                    <tr>
                        <th>Judul:</th>
                        <td>${judul}</td>
                    </tr>
                    <tr>
                        <th>NIM:</th>
                        <td>${nim}</td>
                    </tr>
                    <tr>
                        <th>Nama Conference:</th>
                        <td>${namaConference}</td>
                    </tr>
                    <tr>
                        <th>Penyelenggara:</th>
                        <td>${penyelenggra}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Conference:</th>
                        <td>${tanggalConference}</td>
                    </tr>
                    <tr>
                        <th>Lokasi Conference:</th>
                        <td>${lokasiConference}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Publikasi:</th>
                        <td>${tanggalPublikasi}</td>
                    </tr>
                    <tr>
                        <th>Link Google Drive naskah:</th>
                        <td>${naskah}</td>
                    </tr>
                </tbody>
            </table>
        `,
        icon: 'question',
        showCancelButton: true,
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