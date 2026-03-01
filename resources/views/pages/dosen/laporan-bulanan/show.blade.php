@extends('layouts.dosen.app')

@section('title', 'Mahasiswa Bimbingan')

@section('styles')

@endsection

@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="d-flex align-items-center mb-3">
      <a href="#" class="btn btn-icon me-2 btn-primary" onClick="window.history.back();">
        <i class="ti ti-chevron-left"></i>
      </a>
      <div class="ms-3">
        <h4 class="card-header-title mb-0">
          Laporan Progress Bulanan Mahasiswa
        </h4>
        <p class="mb-0 text-muted">{{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}</p>
      </div>
    </div>

    <div class="row gap-3 gap-lg-0">
      <div class="col-lg-4">
        <div class="d-grid gap-3">
          <div class="card">
            <div class="card-header mb-0 pb-0">
              <h4 class="card-header-title">Data Mahasiswa</h4>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-start align-items-center mb-3">
                <div class="avatar avatar-xl me-4">
                  <img class="rounded" src="{{ UserHelper::getMahasiswaPicture($mahasiswa->nim) }}" alt="Foto"
                    onerror="onImageErrorGuest(this)" style="object-fit: cover; aspect-ratio: 1/1;">
                </div>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>Nama Lengkap</b></p>
                <p class="mb-0">{{ $mahasiswa->nama }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>NIM</b></p>
                <p class="mb-0">{{ $mahasiswa->nim }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>Promotor</b></p>
                <p class="mb-0">{{ $mahasiswa->promotor1 }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>CO-Promotor 1</b></p>
                <p class="mb-0">{{ $mahasiswa->promotor2 }}</p>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-0"><b>CO-Promotor 2</b></p>
                <p class="mb-0">{{ $mahasiswa->promotor3 }}</p>
              </div>
            </div>
          </div>
        </div>



      </div>
      <div class="col-lg-8">
        @if ($laporan)
          <div class="card mb-3">
            <div class="card-header">
              <h4 class="card-header-title">Data Laporan Progress Bulanan</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Judul Laporan</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0 ">{{ $laporan->judul }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Isi Laporan</b></p>
                  <div class="col-sm-7 col-md-8">
                    <div id="laporan" class="border rounded p-1"></div>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Status Laporan</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">
                      @if ($isCommented)
                        <span class="badge bg-label-success">Sudah Dikomentari</span>
                      @else
                        <span class="badge bg-label-warning">Belum Dikomentari</span>
                      @endif
                    </p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Tanggal Diajukan</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $laporan->created_at }} ({{ $laporan->created_at->diffForHumans() }})</p>
                  </div>
                </div>


              </div>
            </div>
          </div>
        @endif

        <div class="card">
          <div class="card-header">
            <h4 class="card-header-title">Komentar Sebagai {{ $currentPromotor }}
          </div>
          <div class="card-body">
            <div class="row">
              <div class="row mb-3">
                <div class="col-sm-5 col-md-4 form-label mb-0"><b>Komentar</b></div>
                <div class="col-sm-7 col-md-8">
                  <div class="border rounded p-1" id="komentar">

                  </div>
                </div>
              </div>
               @if (!$isCommented)
              <div class="d-flex justify-content-end gap-2 my-3">
                <button class="btn btn-success" id="btnKomentar">
                  <i class="ti ti-circle-check me-2"></i> <b>Komentar</b>
                </button>
              </div>
              @endif
            </div>
          </div>



        </div>
      </div>
    </div>
  @endsection

  @section('scripts')
    <script>
      $(document).ready(function() {

        // initailize quill
        var laporan = new Quill('#laporan', {
          theme: 'bubble',
          readOnly: true,
        });

        // set quill content
        laporan.setContents({!! $laporan->isi_progress !!});

        const fullToolbar = [
          [{
            font: []
          }, {
            size: []
          }],
          ['bold', 'italic', 'underline', 'strike'],
          [{
            color: []
          }, {
            background: []
          }],
          [{
            script: 'super'
          }, {
            script: 'sub'
          }],
          [{
            header: '1'
          }, {
            header: '2'
          }, 'blockquote', 'code-block'],
          [{
            list: 'ordered'
          }, {
            list: 'bullet'
          }, {
            indent: '-1'
          }, {
            indent: '+1'
          }],
          ['direction', {
            align: []
          }],
          ['link', 'formula'],
          ['clean']
        ];

        var komentar = new Quill('#komentar', {
          @if ($isCommented)
            theme: 'bubble',
            readOnly: true,
          @else
            theme: 'snow',
            toolbar: fullToolbar,
          @endif
        });

        @if ($isCommented)
          komentar.setContents({!! $komentar !!});
        @endif

        $('#btnKomentar').click(function() {
          Swal.fire({
            title: 'Komentar',
            text: 'Apakah anda yakin ingin mengirim komentar ini?',
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success me-2',
              cancelButton: 'btn btn-danger'
            },
            dangerMode: true,
          }).then((result) => {
            if (result.isConfirmed) {
              var isiKomentar = komentar.getContents();
              axios.post("{{ route('dosen.laporan.komentar', $laporan->id) }}", {
                promotor: '{{ $currentPromotor }}',
                komentar: isiKomentar
              }).then((response) => {
                Swal.fire({
                  title: 'Berhasil!',
                  text: "Penilaian berhasil disimpan",
                  icon: 'success',
                  customClass: {
                    confirmButton: 'btn btn-success'
                  },
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.reload();
                  }
                });
              }).catch((error) => {
                if (error.response.status === 422) {
                  let errors = error.response.data.errors;
                  let message = error.response.data.message;
                  Swal.fire({
                    icon: 'warning',
                    title: 'Gagal!',
                    html: message,
                    customClass: {
                      confirmButton: 'btn btn-warning'
                    }
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: "Terjadi kesalahan saat melakukan penilaian.",
                    customClass: {
                      confirmButton: 'btn btn-danger'
                    }
                  });
                }
              });
            }
          });

        });
      });
    </script>
  @endsection
