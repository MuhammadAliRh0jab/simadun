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
          Data {{ $dosen->nama }}
        </h4>
        <p class="mb-0 text-muted">{{ $dosen->nama }} - {{ $dosen->no_induk }}</p>
      </div>
    </div>

    <div class="row gap-3 gap-lg-0">
      <div class="col-lg-4">
        <div class="d-grid gap-3">
          <div class="card">
            <div class="card-header mb-0 pb-0">
              <h4 class="card-header-title">Data dosen</h4>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-start align-items-center mb-3">
                <div class="avatar avatar-xl me-4">
                  <img class="rounded" src="{{ UserHelper::getDosenPicture($dosen->no_induk) }}" alt="Foto"
                    onerror="onImageErrorGuest(this)" style="object-fit: cover; aspect-ratio: 1/1; object-position: top;">
                </div>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>Nama Lengkap</b></p>
                <p class="mb-0">{{ $dosen->nama }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>NIK/NIP/NIDN</b></p>
                <p class="mb-0">{{ $dosen->no_induk }}</p>
              </div>
              {{-- buttons to reset password/reset account --}}
              <div class="row mb-3">
                <p class="form-label mb-2"><b>Kelola Akun</b></p>
                <form method="POST" class="col-7" id="resetPassword"
                  action="{{ route('dosen.manajemen.dosen.reset-password', $dosen->id) }}">
                  @csrf
                  <button type="submit" class="btn btn-warning"> <i class="ti ti-key me-1"></i> Reset Password</button>
                </form>
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
              <form method="POST" action="{{ route('dosen.manajemen.dosen.update', $dosen->id) }}" id="updatedosen">
                @csrf
                @method('PUT')
                {{-- nama --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Nama Lengkap</b></label>
                  <input type="text" class="form-control @error('nama') is-invalid @enderror"
                  name="nama" value="{{ $dosen->nama }}">
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- no_induk --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>NIK/NIP/NIDN</b></label>
                  <input type="number" class="form-control @error('no_induk') is-invalid @enderror"
                  name="no_induk" value="{{ $dosen->no_induk }}">
                  @error('no_induk')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Email</b></label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror"
                  name="email" value="{{ $dosen->email }}">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- pangkat/gol --}}
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Pangkat/gol</b></label>
                  <input type="text" class="form-control @error('nim') is-invalid @enderror"
                  name="pangkat_gol" value="{{ $dosen->pangkat_gol }}">
                  @error('pangkat_gol')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label class="form-label mb-0"><b>Role</b></label>
                  <select class="form-select @error('role') is-invalid @enderror" name="role">
                    <option value="dosen" {{ $dosen->role == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="kaprodi" {{ $dosen->role == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                    <option value="eksternal" {{ $dosen->role == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
                  </select>
                  @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group mb-3">
                  <button type="submit" class="btn btn-primary my-2">Update</button>
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
  $('#updatedosen').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data dosen akan diupdate!",
      icon: 'warning',
      showCancelButton: true,
      customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-primary ms-1'
      },
      confirmButtonText: 'Ya, update!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        form.off('submit');
        form.submit();
      }
    });
  });

  $('#resetPassword').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Password Akun Dosen akan direset ke Sandi default (NIM/NIP/NIDN)",
      icon: 'warning',
      showCancelButton: true,
      customClass: {
        confirmButton: 'btn btn-warning',
        cancelButton: 'btn btn-outline-warning ms-1'
      },
      confirmButtonText: 'Ya, reset!',
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
