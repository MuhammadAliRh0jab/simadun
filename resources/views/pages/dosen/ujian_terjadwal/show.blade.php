@extends('layouts.dosen.app')

@section('title', 'Penilaian Ujian')

@section('styles')
@endsection

@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="d-flex align-items-center mb-3">
      <a href="#" class="btn btn-icon me-2 btn-primary" onClick="window.history.back();">
        <i class="ti ti-chevron-left"></i>
      </a>
      @php
        $tanggal = \Carbon\Carbon::parse($jadwal_ujian->tanggal)->format('Y-m-d');
        $jam = \Carbon\Carbon::parse($jadwal_ujian->jam)->format('H:i');
        $countdown = \Carbon\Carbon::parse($tanggal . ' ' . $jam)->diffForHumans();
      @endphp
      <div class="ms-3">
        <h4 class="card-header-title mb-0">
          Penilaian Ujian {{ $proposal->jenis_ujian }} | <span class="badge bg-label-primary">Dibuka dalam
            {{ $countdown }}</span>
        </h4>
        <p class="mb-0 text-muted">{{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}</p>
      </div>
    </div>

    @if ($jadwal_ujian->penilaian)
      <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
        <div>
          <strong class="me-2">Perhatian!</strong> Form penilaian sudah dapat diakses
          harap segera melakukan penilaian.
        </div>
      </div>
    @else
      <div class="alert alert-warning d-flex align-items-center" role="alert">
        <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
        <div>
          <strong class="me-2">Perhatian!</strong> Form penilaian belum dapat diakses
          harap menunggu hingga tanggal ujian
          ({{ \Carbon\Carbon::parse($jadwal_ujian->tanggal)->isoFormat('dddd, D MMMM Y') }}) pada jam
          {{ \Carbon\Carbon::parse($jadwal_ujian->jam)->format('H:i') }}.
        </div>
      </div>
    @endif

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
                  <img
                    class="rounded"
                    src="{{ UserHelper::getMahasiswaPicture($mahasiswa->nim) }}"
                    alt="Foto"
                    style="object-fit: cover; aspect-ratio: 1/1;"
                  >
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
                <p class="mb-0">{{ $mahasiswa->promotor3 ?? '-' }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="d-grid gap-3 mt-3">
          <div class="card">
            <div class="card-header mb-0 pb-0">
              <h4 class="card-header-title">Jadwal Ujian</h4>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="form-label mb-0"><b>Tanggal Ujian</b></p>
                <div class="">
                  <p class="mb-0">{{ \Carbon\Carbon::parse($jadwal_ujian->tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
              </div>

              <div class="row mb-3">
                <p class="form-label mb-0"><b>Jam Ujian</b></p>
                <div class="">
                  <p class="mb-0">{{ \Carbon\Carbon::parse($jadwal_ujian->jam)->format('H:i') }}</p>
                </div>
              </div>

              <div class="row mb-3">
                <p class="form-label mb-0"><b>Ruangan Ujian</b></p>
                <div class="">
                  <p class="mb-0">{{ $jadwal_ujian->ruangan }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4 class="card-header-title">Data Ujian {{ $proposal->jenis_ujian }}</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Judul Naskah</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">{{ $mahasiswa->judul }}</p>
                </div>
              </div>

              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Tanggal Pengajuan</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">{{ $mahasiswa->created_at }}, {{ $mahasiswa->created_at->diffForHumans() }}</p>
                </div>
              </div>

              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Status</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    @php
                      $status = [
                        0 => '<span class="badge bg-label-secondary">Belum Diajukan</span>',
                        2 => '<span class="badge bg-label-primary">Diajukan</span>',
                        3 => '<span class="badge bg-label-success">Terjadwal</span>',
                        4 => '<span class="badge bg-label-warning">Revisi</span>',
                        5 => '<span class="badge bg-label-success">Selesai</span>',
                      ];
                    @endphp
                    {!! $status[$proposal->status] !!}
                  </p>
                </div>
              </div>

              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji 1</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">{{ $jadwal_ujian->penguji1 }}</p>
                </div>
              </div>

              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji 2</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">{{ $jadwal_ujian->penguji2 }}</p>
                </div>
              </div>

              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji 3</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">{{ $jadwal_ujian->penguji3 ?? '-' }}</p>
                </div>
              </div>

              @if ($proposal->jenis_ujian == 'tertutup')
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Berkas Naskah</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">
                      @if (!empty($proposal->file) && $proposal->file !== '-')
                        <a href="{{ $proposal->file }}" target="_blank" rel="noopener noreferrer">{{ $proposal->file }}</a>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </p>
                  </div>
                </div>
              @elseif ($proposal->jenis_ujian == 'publikasi')
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Berkas Naskah Disertasi</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">
                      @if (!empty($proposal->file) && $proposal->file !== '-')
                        <a href="{{ $proposal->file }}" target="_blank" rel="noopener noreferrer">{{ $proposal->file }}</a>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </p>
                  </div>
                </div>
              @elseif ($proposal->file != '-' and $proposal->jenis_ujian != 'publikasi')
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Berkas Naskah</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">
                      <a href="{{ $proposal->file ?? '' }}" target="_blank" rel="noopener noreferrer">
                        <p class="mb-0" id="naskah">{{ $proposal->file ?? '' }}</p>
                      </a>
                    </p>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>

        @if ($proposal->file != '-' and $proposal->jenis_ujian == 'publikasi')
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Berkas Publikasi Jurnal</h4>
              <span class="text-muted">Ini adalah berkas publikasi jurnal yang diunggah oleh mahasiswa, harap unduh
                berkas ini untuk melakukan penilaian.</span>
            </div>
            <div class="card-body">
              <div class="row mb-3 mx-1">
                @forelse ($proposal->publikasi_jurnal as $jurnal)
                  <div class="card border-1 p-3 shadow-none mb-1">
                    <div class="row">
                      <div class="col-6">
                        <a href="{{ $jurnal->link }}" target="_blank" class="btn-sm text-primary">
                          <h6 class="card-title mb-0 text-primary">
                            <i class="ti ti-link me-1"></i>{{ $jurnal->judul }}
                          </h6>
                        </a>
                        <p class="card-text mb-0 small">{{ $jurnal->jurnal }}</p>
                      </div>
                      <div class="col-6 d-flex flex-column justify-content-start align-items-end">
                        <p class="card-text text-end mb-0 small">
                          ({{ $jurnal->tanggal_terbit }}), {{ $jurnal->volume }}({{ $jurnal->nomor }})
                        </p>
                      </div>
                    </div>
                  </div>
                @empty
                @endforelse
              </div>
            </div>
          </div>

          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Berkas Publikasi Conference</h4>
              <span class="text-muted mb-0">Ini adalah berkas publikasi conference yang diunggah oleh mahasiswa, harap
                unduh berkas ini untuk melakukan penilaian.</span>
            </div>
            <div class="card-body">
              <div class="row mb-3 mx-1">
                @forelse ($proposal->publikasi_conference as $conference)
                  <div class="card border-1 p-3 shadow-none mb-1 ">
                    <div class="row">
                      <div class="col-6">
                        <a href="{{ $conference->link }}" target="_blank" class="btn-sm text-primary">
                          <h6 class="card-title mb-0 text-primary">
                            <i class="ti ti-link me-1"></i>{{ $conference->judul }}
                          </h6>
                        </a>
                        <p class="card-text mb-0 small">
                          {{ $conference->namaConference }}, oleh {{ $conference->penyelenggara }},
                          ({{ $conference->tanggal_conference }})
                        </p>
                      </div>
                      <div class="col-6 d-flex flex-column justify-content-start align-items-end">
                        <p class="card-text text-end mb-0 small">
                          ({{ $conference->tanggalPublikasi }}), {{ $conference->lokasi_Conference }}
                        </p>
                      </div>
                    </div>
                  </div>
                @empty
                @endforelse
              </div>
            </div>
          </div>
        @endif

        <div class="card mt-3">
          <div class="card-header mb-0">
            <h4 class="card-header-title mb-0">Status Penilaian</h4>
            <span class="text-muted">Ini adalah status penilaian saat ini, harap refresh halaman ini untuk
              melihat perubahan status penilaian terbaru.</span>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Satu</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">
                  @if ($proposal->nilai_penguji1)
                    <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Sudah Dinilai</span>
                  @else
                    <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                  @endif
                </p>
              </div>
            </div>

            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Dua</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">
                  @if ($proposal->nilai_penguji2)
                    <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Sudah Dinilai</span>
                  @else
                    <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                  @endif
                </p>
              </div>
            </div>

            @if ($jadwal_ujian->penguji3)
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Tiga</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    @if ($proposal->nilai_penguji3)
                      <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Sudah Dinilai</span>
                    @else
                      <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                    @endif
                  </p>
                </div>
              </div>
            @endif

            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Promotor</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">
                  @if ($proposal->nilai_promotor)
                    <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Sudah Dinilai</span>
                  @else
                    <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                  @endif
                </p>
              </div>
            </div>

            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Co-Promotor 1</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">
                  @if ($proposal->nilai_co_promotor1)
                    <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Sudah Dinilai</span>
                  @else
                    <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                  @endif
                </p>
              </div>
            </div>

            @if ($mahasiswa->co_promotor2_id)
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Co-Promotor 2</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    @if ($proposal->nilai_co_promotor2)
                      <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Sudah Dinilai</span>
                    @else
                      <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                    @endif
                  </p>
                </div>
              </div>
            @endif

            @if ($proposal->jenis_ujian == 'tertutup')
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Eksternal</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    @if ($proposal->nilai_penguji_eks)
                      <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Sudah Dinilai</span>
                    @else
                      <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                    @endif
                  </p>
                </div>
              </div>
            @endif

            <div class="row mb-3">
              <p class="col-sm-5 col-md-4 form-label mb-0"><b>Kaprodi</b></p>
              <div class="col-sm-7 col-md-8">
                <p class="mb-0">
                  @if ($proposal->nilai_kaprodi)
                    <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Sudah Dinilai</span>
                  @else
                    <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                  @endif
                </p>
              </div>
            </div>
          </div>
        </div>

        @php
          $penguji = $promotor = $penguji1Done = $penguji2Done = $penguji3Done = $promotorDone = $coPromotor1Done = $coPromotor2Done = $pengujiEksDone = false;

          if ($dosen == 'Penguji 1') {
            $penguji = 1;
            $penguji1Done = $proposal->nilai_penguji1;
          } elseif ($dosen == 'Penguji 2') {
            $penguji = 2;
            $penguji2Done = $proposal->nilai_penguji2;
          } elseif ($dosen == 'Penguji 3') {
            $penguji = 3;
            $penguji3Done = $proposal->nilai_penguji3;
          } elseif ($dosen == 'Promotor') {
            $promotor = 1;
            $promotorDone = $proposal->nilai_promotor;
          } elseif ($dosen == 'CO-Promotor 1') {
            $promotor = 2;
            $coPromotor1Done = $proposal->nilai_co_promotor1;
          } elseif ($dosen == 'CO-Promotor 2') {
            $promotor = 3;
            $coPromotor2Done = $proposal->nilai_co_promotor2;
          } elseif ($dosen == 'eksternal') {
            $pengujiEksDone = $proposal->nilai_penguji_eks;
          }
        @endphp

        @if (
          $jadwal_ujian->penilaian &&
          (
            ($penguji == 1 && !$penguji1Done) ||
            ($penguji == 2 && !$penguji2Done) ||
            ($penguji == 3 && !$penguji3Done) ||
            ($promotor == 1 && !$promotorDone) ||
            ($promotor == 2 && !$coPromotor1Done) ||
            ($promotor == 3 && !$coPromotor2Done) ||
            ($dosen == 'eksternal' && !$pengujiEksDone)
          )
        )
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Form Penilaian {{ $dosen }}</h4>
              <span class="text-muted">Apabila terdapat revisi, harap mengisi catatan dan menekan tombol revisi. Jika
                tidak terdapat revisi sama sekali maka tekan tombol lulus.</span>
            </div>
            <div class="card-body">
              @if ($proposal->jenis_ujian == 'tertutup')
                <div class="row mb-3">
                  <p class="form-label mb-2"><b>Penilaian</b></p>
                  <div class="col">
                    <input
                      type="number"
                      class="form-control"
                      id="nilai_kaprodi"
                      name="nilai_kaprodi"
                      min="1"
                      max="100"
                      required
                    >
                  </div>
                </div>
              @endif

              <div class="row mb-3">
                <p class="form-label mb-2"><b>Catatan Revisi</b></p>
                <div class="">
                  <div id="snow-editor" class="mb-3"></div>
                </div>
              </div>

              <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                <div>
                  <strong class="me-2">Perhatian!</strong> Harap memastikan input penilaian anda, karena form tidak
                  dapat diubah kembali ketika sudah disubmit.
                </div>
              </div>

              @if ($proposal->jenis_ujian != 'tertutup')
                <div class="d-flex justify-content-end gap-2 my-3">
                  <button class="btn btn-danger" id="btnReject">
                    <i class="ti ti-circle-x me-2"></i> <b>Tidak Layak</b>
                  </button>
                  <button class="btn btn-success" id="btnApprove">
                    <i class="ti ti-circle-check me-2"></i> <b>Layak</b>
                  </button>
                </div>
              @else
                <div class="d-flex justify-content-end gap-2 my-3">
                  <button class="btn btn-success" id="btnConfirm">
                    <i class="ti ti-check me-2"></i> <b>Konfirmasi Penilaian</b>
                  </button>
                </div>
              @endif
            </div>
          </div>
        @endif

        @if ($proposal->komentar)
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Penilaian Anda</h4>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-2"><b>Penilaian</b></p>
                <div class="col-sm-7 col-md-8">
                  <div class="mb-3">
                    @if ($proposal->jenis_ujian != 'tertutup')
                      @if ($proposal->nilai == 100)
                        <span class="badge bg-label-success">Layak</span>
                      @else
                        <span class="badge bg-label-danger">Tidak Layak</span>
                      @endif
                    @else
                      @if ($proposal->nilai > 50)
                        <span class="badge bg-label-success">{{ $proposal->nilai }}</span>
                      @else
                        <span class="badge bg-label-danger">{{ $proposal->nilai }}</span>
                      @endif
                    @endif
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-2"><b>Komentar</b></p>
                <div class="col-sm-7 col-md-8">
                  <div class="mb-3">
                    <div id="snow-editor-komentar" class="mb-3"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function () {
      const fullToolbar = [
        [{ font: [] }, { size: [] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ color: [] }, { background: [] }],
        [{ script: 'super' }, { script: 'sub' }],
        [{ header: '1' }, { header: '2' }, 'blockquote', 'code-block'],
        [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
        ['direction', { align: [] }],
        ['link', 'formula'],
        ['clean']
      ];

      const snowEditor = new Quill('#snow-editor', {
        bounds: '#snow-editor',
        modules: {
          formula: true,
          toolbar: fullToolbar
        },
        theme: 'snow'
      });

      @if ($proposal->komentar)
        const snowEditorKomentar = new Quill('#snow-editor-komentar', {
          bounds: '#snow-editor-komentar',
          modules: {
            formula: true,
            toolbar: false
          },
          theme: 'snow'
        });
        snowEditorKomentar.disable();
        const komentar = {!! $proposal->komentar->komentar !!};
        if (komentar) {
          snowEditorKomentar.setContents(komentar);
        }
      @endif

      $('#btnReject').on('click', function () {
        if ($('#snow-editor .ql-editor').text().trim().length < 1) {
          Swal.fire({
            title: 'Peringatan!',
            text: "Anda belum mengisi komentar, harap isi komentar terlebih dahulu!",
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success',
            },
          });
        } else {
          Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan menilai ujian ini sebagai TIDAK LAYAK, harap pastikan kembali penilaian anda!",
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
          }).then((result) => {
            if (result.isConfirmed) {
              axios.post("{{ route('dosen.ujian.terjadwal.penilaian') }}", {
                _token: "{{ csrf_token() }}",
                nim: "{{ $mahasiswa->nim }}",
                ujian_id: "{{ $proposal->id }}",
                role: "dosen",
                jenis_ujian: "{{ $proposal->jenis_ujian }}",
                nilai: 1,
                dosen: "{{ $dosen }}",
                catatan: JSON.stringify(snowEditor.getContents()),
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
        }
      });

      $('#btnApprove').on('click', function () {
        if ($('#snow-editor .ql-editor').text().trim().length < 1) {
          Swal.fire({
            title: 'Peringatan!',
            text: "Anda belum mengisi komentar, harap isi komentar terlebih dahulu!",
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success',
            },
          });
        } else {
          Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan menilai ujian ini sebagai LAYAK, harap pastikan kembali penilaian anda!",
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
          }).then((result) => {
            if (result.isConfirmed) {
              axios.post("{{ route('dosen.ujian.terjadwal.penilaian') }}", {
                _token: "{{ csrf_token() }}",
                nim: "{{ $mahasiswa->nim }}",
                ujian_id: "{{ $proposal->id }}",
                role: "dosen",
                jenis_ujian: "{{ $proposal->jenis_ujian }}",
                nilai: 100,
                dosen: "{{ $dosen }}",
                catatan: JSON.stringify(snowEditor.getContents()),
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
        }
      });

      $('#btnConfirm').on('click', function () {
        if ($('#nilai_kaprodi').val() > 100 || $('#nilai_kaprodi').val() < 1 || $('#nilai_kaprodi').val() == '') {
          Swal.fire({
            title: 'Peringatan!',
            text: "Nilai harus diantara 1-100",
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success',
            },
          });
          return;
        }

        if ($('#snow-editor .ql-editor').text().trim().length < 1) {
          Swal.fire({
            title: 'Peringatan!',
            text: "Anda belum mengisi komentar, harap isi komentar terlebih dahulu!",
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success',
            },
          });
          return;
        }

        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Anda akan menilai ujian ini, harap pastikan kembali penilaian anda!",
          icon: "warning",
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post("{{ route('dosen.ujian.terjadwal.penilaian') }}", {
              _token: "{{ csrf_token() }}",
              nim: "{{ $mahasiswa->nim }}",
              ujian_id: "{{ $proposal->id }}",
              role: "dosen",
              jenis_ujian: "{{ $proposal->jenis_ujian }}",
              nilai: $('#nilai_kaprodi').val(),
              dosen: "{{ $dosen }}",
              catatan: JSON.stringify(snowEditor.getContents()),
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

  <script src="{{ url('/assets/js/dosenSearch.js') }}"></script>
@endsection
