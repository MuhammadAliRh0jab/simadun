@extends('layouts.mahasiswa.app')

@section('title', 'Profile')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">


  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light"><a href="/"> Dashboard </a></span> / Profile
  </h4>
  <div class="row">
    <!-- User Sidebar -->
    <div class="col-xl-4 col-lg-5 col-md-5 order-0 order-md-0">
      <!-- User Card -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="user-avatar-section">
            <div class=" d-flex align-items-center flex-column">
              <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ $photo }}" style="width: 15.5rem" alt="User avatar">
              <div class="user-info text-center">
                <h4 class="mb-2">{{ $profileData->nama }}</h4>
                {{-- <span class="badge bg-label-secondary mt-1">Mahasiswa</span> --}}
              </div>
            </div>
          </div>
          {{-- profile nilai  --}}
          <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
            <div class="d-flex align-items-start me-4 mt-3 gap-2">
              <span class="badge bg-label-primary p-2 rounded"><i class="ti ti-checkbox ti-sm"></i></span>
              <div>
                <p class="mb-0 fw-medium">{{ $profileData->PT_S1 }}</p>
                <small>PT-S1</small>
              </div>
            </div>
            <div class="d-flex align-items-start mt-3 gap-2">
              <span class="badge bg-label-primary p-2 rounded"><i class="ti ti-briefcase ti-sm"></i></span>
              <div>
                <p class="mb-0 fw-medium">{{ $profileData->PT_S2 }}</p>
                <small>PT-S2</small>
              </div>
            </div>
          </div>

          {{-- tahap ujian --}}
          <p class="mt-4 small text-uppercase text-muted">Tahap ujian</p>
          <div class="info-container">
            <ul class="list-unstyled">
              <li class="mb-2 pt-1">
                <span class="fw-medium me-1">Status Ujian:</span>
                @if($statusUjian->progress == 0)
                <span class="badge bg-label-success">Belum Mengajukan</span>
                @elseif($statusUjian->progress == 1)
                <span class="badge bg-label-success">Ujian Proposal</span>
                @elseif($statusUjian->progress == 2)
                <span class="badge bg-label-success">Ujian Semhas</span>
                @elseif($statusUjian->progress == 3)
                <span class="badge bg-label-success">Ujian Publikasi</span>
                @elseif($statusUjian->progress == 4)
                <span class="badge bg-label-success">Ujian Disertasi</span>
                @elseif($statusUjian->progress == 5)
                <span class="badge bg-label-success">Ujian Tertutup</span>
                @endif

              </li>
            </ul>

            {{-- promotor 1 --}}
            <hr>
            <p class="mt-4 small text-uppercase text-muted">Promotor dan Co Promotor</p>
            <div class="row ">
              <div class="d-flex align-items-start mt-3 gap-2 col-6">
                <span class="badge bg-label-primary p-2 rounded"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                    height="20" fill="currentColor" class="bi bi-person-fill-check" viewBox="0 0 16 16">
                    <path
                      d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path
                      d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
                  </svg></span>
                <div>
                  <p class="mb-0 fw-medium">{{ $tampilPromotor->nama }}</p>
                  <small>Promotor</small>
                </div>
              </div>
              {{-- promotr 2 --}}
              <div class="d-flex align-items-start mt-3 gap-2 col-6">
                <span class="badge bg-label-primary p-2 rounded"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                    height="20" fill="currentColor" class="bi bi-person-fill-check" viewBox="0 0 16 16">
                    <path
                      d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path
                      d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
                  </svg></span>
                <div>
                  <p class="mb-0 fw-medium">{{ $tampilPromotor1 ->nama }}</p>
                  <small>Co Promotor 1</small>
                </div>
              </div>
            </div>
            {{-- promotr 2 --}}
            <div class="d-flex align-items-start mt-3 gap-2">
              <span class="badge bg-label-primary p-2 rounded"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                  height="20" fill="currentColor" class="bi bi-person-fill-check" viewBox="0 0 16 16">
                  <path
                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                  <path
                    d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4" />
                </svg></span>
              <div>
                <p class="mb-0 fw-medium">
                  @if ($tampilPromotor2 != null)
                  {{ $tampilPromotor2->nama }}
                  @else
                  anda tidak memilih co promotor 2
                  @endif

                </p>
                <small>Co Promotor 2</small>
              </div>
            </div>

            {{-- alert --}}
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
            <div class="d-flex justify-content-center">
              <a href="javascript:;" class="btn btn-primary me-3  waves-effect waves-light" data-bs-target="#editUser"
                data-bs-toggle="modal">Edit</a>
            </div>
          </div>
        </div>
      </div>
      <!-- /User Card -->
    </div>
    <!--/ User Sidebar -->


    <!-- User Content -->
    <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-1">
      <div class="card mb-4">
        <h5 class="card-header">Detail Pengguna</h5>
        <div class="card-body container">
          <p>Judul Disertasi Anda</p>
          <div class="row mb-3">
            <p class="col-sm-12 col-md-12 form-label mb-0"><b>{{ $statusUjian->judul}}</b></p>
          </div>
          <div class="card-body ">
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Nama Lengkap</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->nama }}</p>
              </div>
            </div>

            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>NIM</b></p>
              <div class="col-sm-7 col-md-9">
                <p id="nim" class="mb-0">{{ $profileData->nim }}</p>
                <button class="btn btn-primary btn-sm" onclick="copyToClipboard('nim')">Copy</button>
              </div>
            </div>

            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>No Telp</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->no_hp }}</p>
              </div>
            </div>

            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Email UM</b></p>
              <div class="col-sm-7 col-md-9">
                <p id="email_um" class="mb-0">{{ $profileData->email_um }}</p>
                <button class="btn btn-primary btn-sm" onclick="copyToClipboard('email_um')">Copy</button>
              </div>
            </div>



            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Email lain</b> <br>
              </p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->email_lain }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Alamat Malang</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->alamat_malang }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Alamat Asli</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->alamat_asal }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Asal Instansi</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->asal_instansi}}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>PT-S1</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->PT_S1 }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>PT-S2</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->PT_S2 }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Skor TOEFL</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->skor_toefl }}</p>
              </div>
            </div>
            <div class="row mb-3">
              <p class="col-sm-5 col-md-3 form-label mb-0"><b>Skor TPA</b></p>
              <div class="col-sm-7 col-md-9">
                <p class="mb-0">{{ $profileData->skor_TPA }}</p>
              </div>
            </div>
            {{-- button to reset password --}}
            <div class="row mb-3">
              <div class="col-sm-12 col-md-12">
                <a href="{{ route('change.password.mhs',Auth::user()->nim) }}" class="btn btn-primary">Reset Password</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Invoice table -->

        <!-- /Invoice table -->
      </div>
      <!--/ User Content -->
    </div>

    <!-- Modal -->
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
          <div class="modal-body">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-4">
              <h3 class="mb-2">Edit Profile Anda</h3>
              <p class="text-muted">Perbarui data sesuai dengan prefrensi anda. Tidak semua harus di rubah</p>
            </div>
            <form id="editUserForm" class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST"
              action="{{ url("/update-profile") }}">
              @csrf
              <div class="col-12 col-md-6 fv-plugins-icon-container">
                <label class="form-label" for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Dimas Ardiminda ST, MT"
                  value="{{ $profileData->nama }}">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>

              <div class="col-12 col-md-6 fv-plugins-icon-container">
                <label class="form-label" for="no_hp">No - Telepon</label>
                <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="+62838632***"
                  value="{{ $profileData->no_hp }}">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>

              <div class="col-12 col-md-6 fv-plugins-icon-container">
                <label class="form-label" for="email_um">Email - UM</label>
                <input type="text" id="email_um" name="email_um" class="form-control"
                  value="{{ $profileData->email_um }}" readonly>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>

              <div class="col-12 col-md-6 fv-plugins-icon-container">
                <label class="form-label" for="nim">NIM</label>
                <input type="text" id="nim" name="nim" class="form-control" readonly value="{{ $profileData->nim }}">
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
              </div>


              <div class="col-12 col-md-6">
                <label class="form-label" for="email_lain">Email lain</label>
                <input type="email" id="email_lain" name="email_lain" class="form-control"
                  value="{{ $profileData->email_lain }}" placeholder="example@domain.com">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label" for="alamat_malang">Alamat Malang</label>
                <input type="text" id="alamat_malang" name="alamat_malang" class="form-control modal-edit-tax-id"
                  value="{{ $profileData->alamat_malang }}" placeholder="123 456 7890">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label" for="alamat_asal">Alamat Asal</label>
                <input type="text" id="alamat_asal" name="alamat_asal" class="form-control"
                  value="{{ $profileData->alamat_asal }}" placeholder="example@domain.com">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label" for="asal_instansi">Asal Instansi</label>
                <input type="text" id="asal_instansi" name="asal_instansi" class="form-control modal-edit-tax-id"
                  placeholder="123 456 7890" value="{{ $profileData->asal_instansi }}">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label" for="PT_S1">PT-S1</label>
                <input type="text" id="PT_S1" name="PT_S1" class="form-control" value="{{ $profileData->PT_S1 }}"
                  placeholder="example@domain.com">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label" for="PT_S2">PT-S2</label>
                <input type="text" id="PT_S2" name="PT_S2" class="form-control modal-edit-tax-id"
                  placeholder="123 456 7890" value="{{ $profileData->PT_S2 }}">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label" for="skor_toefl">Skor TPA</label>
                <input type="text" id="skor_toefl" name="skor_toefl" class="form-control"
                  value="{{ $profileData->skor_toefl }}" placeholder="example@domain.com">
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label" for="skor_TPA">Skor Toefl</label>
                <input type="text" id="skor_TPA" name="skor_TPA" class="form-control modal-edit-tax-id"
                  placeholder="123 456 7890" value="{{ $profileData->skor_TPA }}">
              </div>


              <div class="col-12 text-center">
                <button type="button" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light" id="submitBtn"
                  onclick="confirmUpload()">Submit</button>
                <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"
                  aria-label="Close">Cancel</button>
              </div>
              <input type="hidden">
            </form>
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