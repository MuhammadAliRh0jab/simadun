@extends('layouts.guest.app')
@section('title', 'Isi Profile')
@section('content')
  <div class="row justify-content-center align-items-center w-100" style="overflow-x: hidden">
  <div class=" col-12 col-md-10 col-lg-10 mb-4 h-100">
    <div class="card my-5" style="overflow-x: hidden !important">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h2 class="mb-2">Profile Mahasiswa</h2>
          <small class="text-muted">isi form berikut untuk profile anda sebelum menjalankan fitur dari SIMADUN</small>
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
        </div>
      </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <form action="{{ route('save-data.new') }}" method="post" id="myForm" enctype="multipart/form-data">
                @csrf
                {{-- nim penulis --}}
                <div class="form-group row mb-3 ">
                  <div class="col-12 col-md-6">
                    <label for="nama" class="col-sm-5 col-form-label">Nama Lengkap</label>
                    <br>
                    <small>contoh : Dimas Ardiminda Edia Putra, MT</small>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                    @error('nama')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="nim" class="col-sm-5 col-form-label">Nim Pengupload</label>
                    <input type="text" class="form-control" id="nim" name="nim"
                      value="{{ Auth::user()->nim }}" readonly> {{-- ambil nim dari auth --}}
                    @error('nim')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                {{-- JUDUL VOLUME --}}
                <div class="form-group row mb-3 ">
                  <div class="col-12 col-md-6">
                    <label for="JudulThesis" class="col-sm-5 col-form-label">Judul Thesis</label>
                    <input type="text" class="form-control" id="JudulThesis" name="JudulThesis"
                      value="{{ old('JudulThesis') }}">
                    <strong>JUDUL THESIS TIDAK DAPAT DI GANTI!</strong>
                    @error('JudulThesis')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="no_hp" class="col-sm-5 col-form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}">
                    @error('no_hp')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                {{-- hal nomor --}}
                <div class="form-group row mb-3 ">
                  <div class="col-12 col-md-6">
                    <label for="email_um" class="col-sm-5 col-form-label">Email UM</label>
                    <input type="email" class="form-control" id="email_um" name="email_um"
                      value="{{ old('email_um') }}">
                    @error('email_um')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="email_lain" class="col-sm-5 col-form-label">Email Pribadi</label>
                    <input type="email" class="form-control" id="email_lain" name="email_lain"
                      value="{{ old('email_lain') }}">
                    @error('email_lain')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <div class="col-12 col-md-6">
                    <label for="alamat_malang" class="col-sm-5 col-form-label">Alamat Malang</label>
                    <p>isikan value yang sama di alamat malang dan asal jika anda asli malang</p>
                    <textarea type="text" class="form-control" id="alamat_malang" name="alamat_malang"
                      value="{{ old('alamat_malang') }}"></textarea>
                    @error('alamat_malang')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="alamat_asal" class="col-sm-5 col-form-label mt-2">Alamat Asli</label>
                    <textarea type="text" class="form-control" id="alamat_asal" style="margin-top: 2rem" name="alamat_asal"
                      value="{{ old('alamat_asal') }}"></textarea>
                    @error('alamat_asal')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="card-title mb-3">
                  <h3 class="mb-2">Form Riwayat Pendidikan</h3>
                  <small class="text-muted">isi Riwayat Pendidikan anda</small>
                </div>
                <div class="col-12 col-md-6">
                  <label for="asal_instansi" class="col-sm-5 col-form-label">Asal Instansi</label>
                  <input type="text" class="form-control" id="asal_instansi" name="asal_instansi"
                    value="{{ old('asal_instansi') }}">
                  @error('asal_instansi')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="form-group row mb-3">
                  <div class="col-12 col-md-6">
                    <label for="pt_s1" class="col-sm-5 col-form-label">IPK S1</label>
                    <input type="text" class="form-control" id="pt_s1" name="pt_s1"
                      value="{{ old('pt_s1') }}">
                    @error('pt_s1')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="pt_s2" class="col-sm-5 col-form-label">IPK S2</label>
                    <input type="text" class="form-control" id="pt_s2" name="pt_s2"
                      value="{{ old('pt_s2') }}">
                    @error('pt_s2')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <div class="col-12 col-md-6">
                    <label for="skor_tpa" class="col-sm-5 col-form-label">Skor TPA</label>
                    <input type="text" class="form-control" id="skor_tpa" name="skor_tpa"
                      value="{{ old('skor_tpa') }}">
                    @error('skor_tpa')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="col-12 col-md-6">
                    <label for="skor_toefl" class="col-sm-5 col-form-label">Skor Toefl</label>
                    <input type="text" class="form-control" id="skor_toefl" name="skor_toefl"
                      value="{{ old('skor_toefl') }}">
                    @error('skor_toefl')
                      <div class="text-danger">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>
                <div class="card-title mb-3">
                  <h3 class="mb-2">Form Pemilihan Promotor</h3>
                  <small class="text-muted">Pilih Promotor (dosen pebimbing) Anda</small>
                </div>
                <div class="form-group mb-3">
                  <label for="usulan_promotor" class="form-label">Usulan Penguji</label>
                  <select class="form-select @error('usulan_promotor') is-invalid @enderror" multiple="multiple"
                    id="promotor_search" name="usulan_promotor[]" data-search-dosen-url="{{ route('search.dosen') }}"
                    data-csrf-token="{{ csrf_token() }}" required>

                  </select>
                  <div class="form-text">Pilih Promotor (wajib), CO-Promotor 1 (wajib), CO-Promotor 2 (opsional) secara berturut turut</div>
                  @error('usulan_penguji')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- submit --}}
                <div class="form-group mb-3">
                  <button type="button" id="submitBtn" class="btn btn-primary"
                    onclick="confirmUpload()">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    </div>

  @endsection

  @section('scripts')
    <script>
      $("#promotor_search").select2({
        placeholder: "Pilih Promotor, CO-Promotor 1, CO-Promotor 2 secara berurutan",
        maximumSelectionLength: 3,
        minimumInputLength: 2,

        ajax: {
          delay: 500,
          url: $("#promotor_search").data("search-dosen-url"),
          type: "POST",
          headers: {
            "X-CSRF-TOKEN": $("#promotor_search").data("csrf-token"),
          },
          data: function(params) {
            return {
              nipNikOrNama: params.term,
            };
          },
          processResults: function(response) {
            var data = response.map(function(item) {
              return {
                id: item.id,
                nomor_induk: item.no_induk,
                text: item.nama,
              };
            });
            return {
              results: data,
            };
          },
          cache: true,
        },
        templateResult: formatSearch,
        templateSelection: formatSelection,
      });

      function formatSearch(data) {
        if (data.loading) {
          return data.text;
        }
        var $markup = $(
          '<span class="" >' +
          '<h6 class="mb-0">' +
          "   " +
          data.text +
          "</h6>" +
          '<span class="text-muted">' +
          "   " +
          data.nomor_induk +
          "</span>" +
          "</span>"
        );
        return $markup;
      }

      function formatSelection(data) {
        return data.text;
      }
    </script>
    <script>
      //sweet alert
      function confirmUpload() {
        Swal.fire({
          title: 'Konfirmasi',
          text: 'Apakah file yang diupload sudah benar?',
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
      $(document).ready(function() {
        // Inisialisasi Select2
        $('#promotorSelect').select2({
          placeholder: 'Pilih Promotor',
          ajax: {
            url: '/get-promotors', // URL untuk mengambil data promotor dari server
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
              return {
                results: data
              };
            },
            cache: true
          }
        });
      });
    </script>
  @endsection

  @push('scripts')
  @endpush
