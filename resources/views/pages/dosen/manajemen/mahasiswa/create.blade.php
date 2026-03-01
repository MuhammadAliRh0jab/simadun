@extends('layouts.dosen.app')

@section('title', 'Data Mahasiswa')

@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="d-flex align-items-center mb-3">
      <a href="#" class="btn btn-icon me-2 btn-primary" onClick="window.history.back();">
        <i class="ti ti-chevron-left"></i>
      </a>
      <div class="ms-3">
        <h4 class="card-header-title mb-0">
          Buat Akun Mahasiswa
        </h4>
      </div>
    </div>

    <div class="row gap-3 gap-lg-0">
      <div class="col-lg-4">
        <div class="d-grid gap-3">
          <div class="card">
            <div class="card-header mb-0 pb-0">
              <h4 class="card-header-title">Catatan</h4>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="mb-0">Pastikan data yang diinputkan benar dan sesuai dengan data mahasiswa yang bersangkutan. Pastikan data promotor, co-promotor 1, dan co-promotor 2 sudah benar. Jika data sudah benar, silahkan klik tombol submit.</p>

              </div>
              {{-- alert kata sandi secara default adalah nim --}}
              <div class="alert alert-warning d-flex align-items-start" role="alert">
                <i class="ti ti-exclamation-circle me-1 fw-bold"></i> <strong class="me-2">Perhatian!</strong> Kata sandi secara default adalah NIM mahasiswa. Harap untuk segera mengganti kata sandi default.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-3">
          <div class="card-header">
            <h4 class="card-header-title">Data Mahasiswa</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <form method="POST" action="{{ route('dosen.manajemen.mahasiswa.store') }}" id="storeMahasiswa">
                @csrf
                {{-- nama --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Nama Lengkap</b></label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror"
                  name="nama" value="{{ old('nama')}}">
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- nim --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>NIM</b></label>
                  <input type="text" class="form-control @error('nim') is-invalid @enderror"
                  name="nim" value="{{ old('nim') }}">
                  @error('nim')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- judul --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Judul</b></label>
                  <textarea class="form-control @error('judul') is-invalid @enderror"
                  name="judul" rows="3">{{ old('judul') }}</textarea>
                  @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- promotor --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Promotor, CO-Promotor 1, dan CO-Promotor 2</b></label>
                  <select class="form-select form-search @error('promotors') is-invalid @enderror " name="promotors[]"
                    multiple>
                  {{-- old --}}
                  </select>
                  @error('promotors')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-5">
                  <button type="submit" class="btn btn-primary my-2">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  // add swal to confirm update record
  $('#storeMahasiswa').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data mahasiswa akan disimpan!",
      icon: 'warning',
      showCancelButton: true,
      customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-primary ms-1'
      },
      confirmButtonText: 'Ya, Submit!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        form.off('submit');
        form.submit();
      }
    });
  });


</script>
  <script>
    $(".form-search").select2({
      placeholder: "Pilih Promotor",
      maximumSelectionLength: 3,
      minimumInputLength: 3,
      ajax: {
        delay: 500,
        url: "{{ route('search.dosen') }}",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": "{{ csrf_token() }}",
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
@endsection
