@extends('layouts.mahasiswa.app')
@section('title', 'Isi Profile')
@section('content')
  <h3 class="mb-1"><b>Lengkapi Data</b></h3>
  <p class="text-muted">Untuk dapat melanjutkan, lengkapi data Anda terlebih dahulu. Mohon pastikan data yang Anda masukkan benar.</p>
  @session('warning')
    <div class="alert alert-primary alert-dismissible" role="alert">
      <i class="fas fa-exclamation-triangle me-2"></i>
      <strong>Perhatian!</strong> {{ session('warning') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      </button>
    </div>
  @endsession
  <div class="card shadow-xs border">
    <form id="form-profile" action="{{ route('mahasiswa.lengkapi-profil.store') }}" enctype="multipart/form-data" method="POST">
    <div class="card-body">
      @csrf
      <h3 class="mb-3"><b>Data Mahasiswa</b></h3>
      <div class="row mb-3">
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="nama">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Contoh: Muhammad Fahli Saputra">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="nim">Nomor Induk Mahasiswa <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="nim" id="nim" placeholder="NIM Anda">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="no_hp">Nomor HP <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="Contoh: 62xxxx">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="email_um">Email UM <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email_um" id="email_um" placeholder="Contoh: mahasiswa@students.um.ac.id">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="email_lain">Email Pribadi (selain UM) <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email_lain" id="email_lain" placeholder="Contoh: mahasiswa@gmail.com">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="alamat_malang">Alamat di Malang <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="alamat_malang" id="alamat_malang" placeholder="Contoh: Jl. Cakrawala No. 5">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="alamat_asal">Alamat Asal <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="alamat_asal" id="alamat_asal" placeholder="Contoh: Jl. Jalan No. 1, Kota Surabaya, Jawa Timur">
            <div class="form-text"> Isi alamat yang sama jika Anda berdomisili di Malang </div>
            <div class="invalid-feedback"></div>
          </div>
        </div>
      </div>

      <h3 class="mb-3"><b>Data Riwayat Pendidikan</b></h3>
      <div class="row mb-3">
        <div class="col-12">
          <div class="mb-3">
            <label class="form-label" for="asal_instansi">Asal Instansi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="asal_instansi" id="asal_instansi" placeholder="Contoh: Universitas Negeri Malang">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="PT_S1">Indeks Prestasi Kumulatif (IPK) Jenjang S1 <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="PT_S1" id="PT_S1" placeholder="Contoh: 3.9">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="PT_S2">Indeks Prestasi Kumulatif (IPK) Jenjang S2 <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="PT_S2" id="PT_S2" placeholder="Contoh: 4">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="skor_TPA">Skor TPA <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="skor_TPA" id="skor_TPA" placeholder="Masukkan Skor TPA Anda">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="mb-3">
            <label class="form-label" for="skor_toefl">Skor Toefl <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="skor_toefl" id="skor_toefl" placeholder="Masukkan Skor Toefl Anda">
            <div class="invalid-feedback"></div>
          </div>
        </div>
      </div>

      <h3 class="mb-3"><b>Data Disertasi</b></h3>
      <div class="row mb-3">
        <div class="col-12">
          <div class="mb-3">
            <label class="form-label" for="judul">Judul Disertasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="judul" id="judul" placeholder="Masukkan Judul Disertasi Anda">
            <div class="form-text">Judul disertasi tidak dapat diubah, mohon periksa kembali</div>
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="col-12">
          <div class="mb-0">
            <label class="form-label" for="PT_S1">Usulan Promotor <span class="text-danger">*</span></label>
            <select style="width: 100%;" class="form-select @error('usulan_promotor') is-invalid @enderror" multiple
                    id="promotor_search" name="usulan_promotor" data-search-dosen-url="{{ route('search.dosen') }}"
                    data-csrf-token="{{ csrf_token() }}"></select>
            <div class="form-text">Pilih Promotor (wajib), CO-Promotor 1 (wajib), CO-Promotor 2 (opsional) secara berturut turut</div>
            <div class="invalid-feedback"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button id="btnSave" data-submit="true" type="button" class="btn btn-primary" data-text="Simpan" data-text-loading="Memproses">Submit</button>
    </div>
    </form>
  </div>

  <div class="modal fade" id="modal-confirm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCenterTitle"><b>Konfirmasi</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-warning mb-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Mohon periksa kembali data yang telah Anda masukkan. Beberapa data yang sudah disimpan tidak dapat diubah.
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Nama Lengkap</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-nama">: </p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>NIM</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-nim">:</p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Nomor HP</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-no_hp">:</p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Email UM</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-email_um">: </p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4 d-flex">
              <p class="m-0"><b>Email Pribadi</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-email_lain">: </p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Alamat di Malang</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-alamat_malang">: </p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Alamat Asal</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-alamat_asal">: </p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Asal Instansi</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-asal_instansi">: </p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>IPK S1</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-PT_S1">: </p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>IPK S2</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-PT_S2">: </p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Skor TPA</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-skor_TPA"></p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Skor Toefl</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-skor_toefl"></p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Judul Disertasi</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <p class="m-0" id="field-judul"></p>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 col-md-4">
              <p class="m-0"><b>Usulan Promotor</b></p>
            </div>
            <div class="col-12 col-md-8 d-flex">
              <p class="m-0 me-2 d-none d-md-block">:</p>
              <div class="m-0" id="field-usulan_promotor"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="btnSendData">Simpan</button>
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
      $('#btnSave').on('click', function () {
        // get form data
        var formData = $('#form-profile').serializeArray();
        let promotorContent = '<ol style="padding-left: 1.3em">';
        let counter = 0;
        $.each(formData, function (index, field) {
          $('#field-' + field.name).text(field.value || '-');

          if (field.name == 'usulan_promotor') {
            let promotor = field.value.split(',');
            $.each(promotor, function (index, value) {
              counter++;
              promotorContent += '<li>' + $('#promotor_search option[value="' + value + '"]').text();
              if (counter == 1) {
                promotorContent += ' <span class="text-muted"><i>(Promotor)</i></span></li>';
              } else {
                promotorContent += ' <span class="text-muted"><i>(Co-Promotor ' + (counter - 1) + ')</i></span></li>';
              }
            });
          }
        });

        promotorContent += '</ol>';

        if (counter == 0) {
          $('#field-usulan_promotor').html('<span class="text-muted"><i>Belum dipilih</i></span>');
        } else {
          $('#field-usulan_promotor').html(promotorContent);
        }

        // show modal confirmation
        $('#modal-confirm').modal('show');
      });

      $('#btnSendData').on('click', function () {
        // hide modal confirmation
        $('#modal-confirm').modal('hide');
        submitForm('#form-profile', function () {
          Swal.fire({
            title: "Berhasil!",
            text: "Data berhasil disimpan",
            icon: "success",
            showCancelButton: 0,
            confirmButtonText: "OK",
            customClass: {
              confirmButton: "btn btn-primary me-3 waves-effect waves-light",
            },
            buttonsStyling: !1
          }).then(function(t) {
            window.location.reload();
          });
        });
      });


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