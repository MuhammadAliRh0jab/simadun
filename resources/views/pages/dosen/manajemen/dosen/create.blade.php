@extends('layouts.dosen.app')

@section('title', 'Edit Dosen')

@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="d-flex align-items-center mb-3">
      <a href="#" class="btn btn-icon me-2 btn-primary" onClick="window.history.back();">
        <i class="ti ti-chevron-left"></i>
      </a>
      <div class="ms-3">
        <h4 class="card-header-title mb-0">
          Buat Akun Dosen
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
              {{-- alert kata sandi secara default adalah nim --}}
              <div class="alert alert-warning d-flex align-items-start" role="alert">
                <i class="ti ti-exclamation-circle me-1 fw-bold"></i> <strong class="me-2">Perhatian!</strong> Kata
                sandi secara default adalah NIK/NIP/NIDN. Harap untuk segera mengganti kata sandi default.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-3">
          <div class="card-header">
            <h4 class="card-header-title">Data Dosen</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <form method="POST" action="{{ route('dosen.manajemen.dosen.store') }}" id="createdosen">
                @csrf
                {{-- nama --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Nama Lengkap</b></label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                    value="{{ old('nama') }}">
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- no_induk --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>NIK/NIP/NIDN</b></label>
                  <input type="number" class="form-control @error('no_induk') is-invalid @enderror" name="no_induk"
                    value="{{ old('no_induk') }}">
                  @error('no_induk')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Email</b></label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- pangkat/gol --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Pangkat/gol</b></label>
                  <input type="text" class="form-control @error('nim') is-invalid @enderror" name="pangkat_gol"
                    value="{{ old('pangkat_gol') }}">
                  @error('pangkat_gol')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Role</b></label>
                    <select class="form-select @error('role') is-invalid @enderror" name="role">
                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="kaprodi" {{ old('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                    <option value="eksternal" {{ old('role') == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
                    </select>
                  @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
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
    // add swal to confirm create record
    $('#createdosen').on('submit', function(e) {
      e.preventDefault();
      var form = $(this);
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data dosen akan disimpan!",
        icon: 'warning',
        showCancelButton: true,
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-primary ms-1'
        },
        confirmButtonText: 'Ya, simpan!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          form.off('submit');
          form.submit();
        }
      });
    });
  </script>

@endsection
