@extends('layouts.mahasiswa.app')
@section('title', 'Dashboard Mahasiswa')

@section('styles')
<style>

</style>
@endsection

@section('content')
<div class="col-lg-12 mb-4">
  {{-- welcome --}}
  <div class="my-5">
    <div class="text-start">
      <h3 class="">Selamat Datang, {{ Auth::user()->nama }}
        <span class="hand-icon">
          👋
        </span>
      </h3>
      <p class="text-muted col-12 col-md-6">Selamat data di dashboard mahasiswa, ini adalah progress anda dalam tahapan
        ujian disertasi. Silahkan pilih tahapan ujian disertasi yang ingin anda lihat!</p>
    </div>
  </div>

  {{-- row 1 --}}
  <div class="row justify-content-center align-items-center g-2">
    <div class="card mb-3 mt-3">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h3 class="mb-2">Tahapan Ujian Disertasi</h3>
          <small class="text-muted">Ini adalah progress anda dalam tahapan ujian disertasi</small>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <ul class="step step-md">

            <li class="step-item">
              <a>
                <div class="step-content-wrapper">
                  <span steps="0" class="step-icon step-icon-soft-primary"
                    link="{{ route('ujian.proposal') }} ">1</span>
                  <div class="step-content">
                    <h4 class="step-title">Ujian Proposal</h4>
                    <p class="step-text">Tahap awal ujian disertasi, pengajuan proposal</p>
                  </div>
                </div>
              </a>
            </li>

            <li class="step-item">
              <a>
                <div class="step-content-wrapper">
                  <span steps="2" class="step-icon step-icon-soft-secondary"
                    link="{{ route('ujian.semhas') }} ">2</span>
                  <div class="step-content">
                    <h4 class="step-title">Ujian Seminar Hasil</h4>
                    <p class="step-text">Presentasi hasil penelitian</p>
                  </div>
                </div>
              </a>
            </li>
            <li class="step-item">
              <a>
                <div class="step-content-wrapper">
                  <span steps="3" class="step-icon step-icon-soft-secondary"
                    link="{{ route('ujian.publikasi') }} ">3</span>
                  <div class="step-content">
                    <h4 class="step-title">Ujian Kelayakan</h4>
                    <p class="step-text">Ujian kelayakan publikasi jurnal dan disertasi</p>
                  </div>
                </div>
              </a>
            </li>
              <a>
                <div class="step-content-wrapper">
                  <span steps="5" class="step-icon step-icon-soft-secondary"
                    link="{{ route('ujian.tertutup') }} ">4</span>
                  <div class="step-content">
                    <h4 class="step-title">Ujian Disertasi Tertutup</h4>
                    <p class="step-text">Ujian disertasi tertutup</p>
                  </div>
                </div>
              </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </div>

  {{-- row 2 --}}
  <div class="row justify-content-start align-items-start g-2">
    <div class="col-12 col-md-5">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Promotor</h5>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless border-top">
            <thead class="border-bottom">
              <tr>
                <th>Nama</th>
                <th class="text-end">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="pt-2">
                  <div class="d-flex justify-content-start align-items-center mt-lg-4">
                    <div class="avatar me-3 avatar-sm">
                      <img src="{{ UserHelper::getDosenPicture($mahasiswa->promotor1?->no_induk ?: '') }}" alt="Avatar"
                        class="rounded-circle" onerror="onImageErrorGuest(this)"
                        style="object-fit: cover; object-position:top;">
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-0">{{ $mahasiswa->promotor1?->nama ?: '' }}</h6>
                      <small class="text-truncate text-muted">{{ $mahasiswa->promotor1?->no_induk ?: '' }}</small>
                    </div>
                  </div>
                </td>
                <td class="text-end pt-2">
                  <div class="user-progress mt-lg-4">
                    <p class="mb-0 fw-medium">Promotor</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="avatar me-3 avatar-sm">
                      <img src="{{ UserHelper::getDosenPicture($mahasiswa->promotor2?->no_induk ?: '') }}" alt="Avatar"
                        class="rounded-circle" onerror="onImageErrorGuest(this)"
                        style="object-fit: cover; object-position:top;">
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-0">{{ $mahasiswa->promotor2?->nama ?: '' }}</h6>
                      <small class="text-truncate text-muted">{{ $mahasiswa->promotor1?->no_induk ?: '' }}</small>
                    </div>
                  </div>
                </td>
                <td class="text-end">
                  <div class="user-progress">
                    <p class="mb-0 fw-medium">CO-Promotor 1</p>
                  </div>
                </td>
              </tr>
              @if ($mahasiswa->promotor3)
              <tr>
                <td>
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="avatar me-3 avatar-sm">
                      <img src="{{ UserHelper::getDosenPicture($mahasiswa->promotor3?->no_induk ?: '') }}" alt="Avatar"
                        class="rounded-circle" onerror="onImageErrorGuest(this)"
                        style="object-fit: cover; object-position:top;">
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-0">{{ $mahasiswa->promotor3->nama }}</h6>
                      <small class="text-truncate text-muted">{{ $mahasiswa->promotor3->no_induk }}</small>
                    </div>
                  </div>
                </td>
                <td class="text-end">
                  <div class="user-progress">
                    <p class="mb-0 fw-medium">CO-Promotor 2</p>
                  </div>
                </td>
              </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
    {{-- <div class="col-12 col-md-7">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div class="card-title mb-0">
            <h5 class="m-0 me-2">Jadwal Ujian Terkini</h5>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-borderless border-top">
            <thead class="border-bottom">
              <tr>
                <th>Keterangan</th>
                <th class="text-end">Detail</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="pt-2">
                  <div class="d-flex justify-content-start align-items-center mt-lg-4">
                    <div class="d-flex flex-column">
                      <h6 class="mb-0">Tanggan Ujian</h6>
                    </div>
                  </div>
                </td>
                <td class="text-end pt-2">
                  <div class="user-progress mt-lg-4">
                    <p class="mb-0 fw-medium">11111</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="d-flex flex-column">
                      <h6 class="mb-0">Jam Ujian</h6>
                    </div>
                  </div>
                </td>
                <td class="text-end">
                  <div class="user-progress">
                    <p class="mb-0 fw-medium">11:45</p>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="d-flex flex-column">
                      <h6 class="mb-0">Ruangan Ujian</h6>
                    </div>
                  </div>
                </td>
                <td class="text-end">
                  <div class="user-progress">
                    <p class="mb-0 fw-medium">B-11 212</p>
                  </div>
                </td>
              </tr>
              </tr>
              <tr>
                <td>
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="d-flex flex-column">
                      <h6 class="mb-0">Penguji 1</h6>
                    </div>
                  </div>
                </td>
                <td class="text-end">
                  <div class="user-progress">
                    <p class="mb-0 fw-medium">Pasdasd asd </p>
                  </div>
                </td>
              </tr>
              </tr>
              <tr>
                <td>
                  <div class="d-flex justify-content-start align-items-center">
                    <div class="d-flex flex-column">
                      <h6 class="mb-0">Penguji 2</h6>
                    </div>
                  </div>
                </td>
                <td class="text-end">
                  <div class="user-progress">
                    <p class="mb-0 fw-medium">B-11 212</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div> --}}
  </div>
</div>

</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {

      var progress = {{ Auth::user()->progress }};
      init();
      $('[steps]').click(function() {
        var state = $(this).attr('steps');
        changeState(state, this);
      });

      function init() {
        $('[steps="' + progress + '"]').parent().find('span').removeClass();
        $('[steps="' + progress + '"]').parent().find('span').addClass('step-icon step-icon-soft-primary');
        checkStepProgress(progress)
      }

      function checkStepProgress(currentProgress) {
        for (let index = 0; index < currentProgress; index++) {
          $('[steps="' + index + '"]').parent().find('span').removeClass();
          $('[steps="' + index + '"]').parent().find('span').addClass('step-icon step-icon-soft-success');
        }
      }
      window.changeState = function(state, clickedElement) {
        if (state > progress) {
          Swal.fire({
            title: 'Tahap ini belum tersedia',
            text: 'Silahkan lengkapi tahap sebelumnya terlebih dahulu',
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-primary'
            },
          });
          return
        }

        window.location.href = $(clickedElement).attr('link');

        $(clickedElement).parent().find('span').addClass('step-icon-active')
        $('[steps]').not(clickedElement).parent().find('span').removeClass('step-icon-active')
      }

    });
</script>
@endsection