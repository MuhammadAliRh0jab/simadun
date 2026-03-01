@extends('layouts.dosen.app')

@section('title', 'Profile')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><a href="/dosen"> Dashboard </a></span> / Profile
  </h4>
  <div class="row">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-0 order-md-0">
      <!-- User Card -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="user-avatar-section text-center">
            <img class="img-fluid rounded mb-3"
              src="{{ UserHelper::getDosenPicture(Auth::guard('dosen')->user()->no_induk) }}" alt="User avatar"
              style="width: 15.5rem">
            <div class="user-info">
              <h4 class="mb-2">{{ $dataDosen->nama  }}</h4>
              <span class="badge bg-label-secondary mt-1">Dosen</span>
            </div>
          </div>
          <!-- User Info -->
          <div class="user-info-section pt-3 pb-4">
            <div class="d-flex justify-content-between align-items-start mb-3 ">
              <div class="me-2">
                <p class="mb-0 fw-medium">No Induk</p>
                <p class="mb-0">{{ $dataDosen->no_induk  }}</p>
              </div>
              <button class="btn btn-primary btn-sm" onclick="copyToClipboard('no_induk')">Copy</button>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-start mb-3 ">
              <div class="me-2">
                <p class="mb-0 fw-medium">{{ $dataDosen->role  }}</p>
                <p class="mb-0">Role</p>
              </div>
            </div>
          </div>
          @if (Session::has('success'))
            <div class="alert alert-success mt-2">
              {{ Session::get('berhasil') }}
              data berhasil di perbarui
            </div>
            {{-- else --}}
            @elseif (Session::has('error'))
            <div class="alert alert-danger mt-2">
              {{ Session::get('error') }}
            </div>
            @endif
        </div>
      </div>
      <!-- /User Card -->
    </div>
    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-1">
      <div class="card mb-4">
        <h5 class="card-header">Detail Pengguna</h5>
        <div class="card-body container">
          <div class="card-body">
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Nama Lengkap</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $dataDosen->nama }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>No Induk</b></p>
              <div class="col-sm-7 col-md-9">
                <p id="no_induk" class="mb-0">{{ $dataDosen->no_induk }}</p>
                <button class="btn btn-primary btn-sm" onclick="copyToClipboard('no_induk')">Copy</button>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Pangkat/Gol</b></p>
              <div class="col-sm-7 col-md-9">
                <p id="no_induk" class="mb-0">{{ $dataDosen->pangkat_gol }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Email</b></p>
              <div class="col-sm-7 col-md-9">
                <p id="email" class="mb-0">{{ $dataDosen->email }}</p>
                <button class="btn btn-primary btn-sm" onclick="copyToClipboard('email')">Copy</button>
              </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12 col-md-12">
                  <a href="{{ route('change.password.dsn',Auth::guard('dosen')->user()->no_induk) }}" class="btn btn-primary">Reset Password</a>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



{{-- script --}}
<script>
  function copyToClipboard(elementId) {
    // Pilih elemen yang akan disalin berdasarkan id
    var element = document.getElementById(elementId);

    // Buat area seleksi untuk menyalin teks
    var selection = window.getSelection();
    var range = document.createRange();
    range.selectNodeContents(element);
    selection.removeAllRanges();
    selection.addRange(range);

    // Salin teks ke clipboard
    document.execCommand('copy');

    // Bersihkan seleksi
    selection.removeAllRanges();

    // Tampilkan pesan atau efek lainnya untuk memberi tahu pengguna bahwa teks telah disalin
    alert('Teks berhasil disalin: ' + element.innerText);
  }
  // alert

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
        document.getElementById('editUserForm').submit();
      }
    });
  }
</script>
{{-- end of script --}}
</div>
@endsection