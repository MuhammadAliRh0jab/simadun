@extends('layouts.dosen.app')

@section('title', 'Ujian Kelayakan Disertasi')

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
          Pengajuan Ujian Tertutup Disertasi
        </h4>
        <p class="mb-0 text-muted">{{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}</p>
      </div>
    </div>
    @if ($tertutup->status != 2 && $tertutup->status != 4)
      <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
        <div><strong class="me-2">Perhatian!</strong> Form hanya dapat
          diakses ketika status pengajuan Ujian Tertutup Disertasi adalah <b>Diajukan</b> atau <b>Finalisasi.</b></div>
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

        @if ($jadwal_ujian)
          <div class="d-grid gap-3 mt-3">
            <div class="card">
              <div class="card-header mb-0 pb-0">
                <h4 class="card-header-title">Jadwal Ujian</h4>
              </div>
              <div class="card-body">
                <div class="row mb-3">
                  <p class="form-label mb-0"><b>Tanggal Ujian</b></p>
                  <div class="">
                    <p class="mb-0">{{ \Carbon\Carbon::parse($jadwal_ujian->tanggal)->isoFormat('dddd, D MMMM Y') }}
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="form-label mb-0"><b>Jam Ujian</b></p>
                  <div class="">
                    <p class="mb-0">{{ \Carbon\Carbon::parse($jadwal_ujian->jam)->format('H:i') }} </p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="form-label mb-0"><b>Ruangan Ujian</b></p>
                  <div class="">
                    <p class="mb-0">{{ $jadwal_ujian->ruangan }} </p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="form-label mb-0"><b>Penguji 1</b></p>
                  <div class="">
                    <p class="mb-0">{{ $jadwal_ujian->penguji1 }} </p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="form-label mb-0"><b>Penguji 2 </b></p>
                  <div class="">
                    <p class="mb-0">{{ $jadwal_ujian->penguji2 }} </p>
                  </div>
                </div>
                @if ($jadwal_ujian->penguji3)
                  <div class="row mb-3">
                    <p class="form-label mb-0"><b>Penguji 3 </b></p>
                    <div class="">
                      <p class="mb-0">{{ $jadwal_ujian->penguji3 }} </p>
                    </div>
                  </div>
                @endif
                <div class="row mb-3">
                  <p class="form-label mb-0"><b>Penguji Eksternal </b></p>
                  <div class="">
                    <p class="mb-0">{{ $jadwal_ujian->penguji_eks }} </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif

      </div>
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4 class="card-header-title">Data Pengajuan Ujian Tertutup Disertasi</h4>
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
                  <p class="mb-0">{{ $tertutup->created_at }}, {{ $tertutup->created_at->diffForHumans() }}</p>
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
                          4 => '<span class="badge bg-label-warning">Sedang dalam Revisi</span>',
                          5 => '<span class="badge bg-label-secondary">Revisi Diajukan</span>',
                          6 => '<span class="badge bg-label-success">Selesai</span>',
                      ];
                    @endphp
                    {!! $status[$tertutup->status] !!}
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Usulan Penguji 1</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    {{ $tertutup->usulan_penguji1 }}
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Usulan Penguji 2</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    {{ $tertutup->usulan_penguji2 }}
                  </p>
                </div>
              </div>
              @if ($tertutup->usulan_penguji3)
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Usulan Penguji 3</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">
                      {{ $tertutup->usulan_penguji3 }}
                    </p>
                  </div>
                </div>
              @endif
              @if ($tertutup->penguji_eks1)
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Usulan Penguji Eksternal</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">
                      {{ $tertutup->penguji_eks1->nama }}, {{ $tertutup->penguji_eks1->id }},
                      {{ $tertutup->penguji_eks1->email }}
                    </p>
                  </div>
                </div>
              @endif
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Berkas Naskah @if ($tertutup->status == 5)
                      (Revisi)
                    @endif
                  </b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    @if (!empty($tertutup->file))
                      <a href="{{ $tertutup->file }}" target="_blank" rel="noopener noreferrer">{{ $tertutup->file }}</a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        @if (
            $tertutup->nilai_penguji1 ||
                $tertutup->nilai_penguji2 ||
                $tertutup->nilai_penguji3 ||
                $tertutup->nilai_promotor ||
                $tertutup->nilai_co_promotor1 ||
                $tertutup->nilai_co_promotor2 ||
                $tertutup->nilai_kaprodi ||
                $tertutup->nilai_penguji_eks)
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Status Penilaian
              </h4>
              <span class="text-muted">Ini adalah status penilaian saat ini, harap refresh halaman ini untuk
                melihat perubahan status penilaian terbaru.</span>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Satu</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    @if ($tertutup->nilai_penguji1)
                      @if ($tertutup->nilai_penguji1 >= 50)
                        <span class="badge bg-label-success">{{ $tertutup->nilai_penguji1 }}</span>
                      @else
                        <span class="badge bg-label-danger">{{ $tertutup->nilai_penguji1 }}</span>
                      @endif
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
                    @if ($tertutup->nilai_penguji2)
                      @if ($tertutup->nilai_penguji2 >= 50)
                        <span class="badge bg-label-success">{{ $tertutup->nilai_penguji2 }}</span>
                      @else
                        <span class="badge bg-label-danger">{{ $tertutup->nilai_penguji2 }}</span>
                      @endif
                    @else
                      <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                    @endif
                  </p>
                </div>
              </div>

              {{-- MUNCULKAN Penguji Tiga HANYA jika ada di jadwal --}}
              @if ($jadwal_ujian && $jadwal_ujian->penguji3_id)
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Tiga</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">
                      @if ($tertutup->nilai_penguji3)
                        @if ($tertutup->nilai_penguji3 >= 50)
                          <span class="badge bg-label-success">{{ $tertutup->nilai_penguji3 }}</span>
                        @else
                          <span class="badge bg-label-danger">{{ $tertutup->nilai_penguji3 }}</span>
                        @endif
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
                    @if ($tertutup->nilai_promotor)
                      @if ($tertutup->nilai_promotor >= 50)
                        <span class="badge bg-label-success">{{ $tertutup->nilai_promotor }}</span>
                      @else
                        <span class="badge bg-label-danger">{{ $tertutup->nilai_promotor }}</span>
                      @endif
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
                    @if ($tertutup->nilai_co_promotor1)
                      @if ($tertutup->nilai_co_promotor1 >= 50)
                        <span class="badge bg-label-success">{{ $tertutup->nilai_co_promotor1 }}</span>
                      @else
                        <span class="badge bg-label-danger">{{ $tertutup->nilai_co_promotor1 }}</span>
                      @endif
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
                      @if ($tertutup->nilai_co_promotor2)
                        @if ($tertutup->nilai_co_promotor2 >= 50)
                          <span class="badge bg-label-success">{{ $tertutup->nilai_co_promotor2 }}</span>
                        @else
                          <span class="badge bg-label-danger">{{ $tertutup->nilai_co_promotor2 }}</span>
                        @endif
                      @else
                        <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                      @endif
                    </p>
                  </div>
                </div>
              @endif
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Eksternal</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    @if ($tertutup->nilai_penguji_eks)
                      @if ($tertutup->nilai_penguji_eks >= 50)
                        <span class="badge bg-label-success">{{ $tertutup->nilai_penguji_eks }}</span>
                      @else
                        <span class="badge bg-label-danger">{{ $tertutup->nilai_penguji_eks }}</span>
                      @endif
                    @else
                      <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                    @endif
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Kaprodi</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    @if ($tertutup->nilai_kaprodi)
                      @if ($tertutup->nilai_kaprodi >= 50)
                        <span class="badge bg-label-success">{{ $tertutup->nilai_kaprodi }}</span>
                      @else
                        <span class="badge bg-label-danger">{{ $tertutup->nilai_kaprodi }}</span>
                      @endif
                    @else
                      <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                    @endif
                  </p>
                </div>
              </div>
            </div>
          </div>
        @endif

        <div class="card mt-3">
          <div class="card-header mb-0">
            <h4 class="card-header-title mb-0">Komentar Penguji
            </h4>
            <span class="text-muted">Tekan tombol komentar untuk menampilkan komentar masing masing penguji. Komentar
              hanya dapat dilihat oleh dosen dan mahasiswa.</span>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col">
                 @if ($tertutup->komentar1)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                            onclick='showk({!! json_encode($tertutup->komentar1) !!}, 1)'>
                      <i class="ti ti-message me-2"></i> Penguji 1
                    </button>
                  @endif
                  @if ($tertutup->komentar2)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                            onclick='showk({!! json_encode($tertutup->komentar2) !!}, 2)'>
                      <i class="ti ti-message me-2"></i> Penguji 2
                    </button>
                  @endif
                  @if ($tertutup->komentar3)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                            onclick='showk({!! json_encode($tertutup->komentar3) !!}, 3)'>
                      <i class="ti ti-message me-2"></i> Penguji 3
                    </button>
                  @endif
                  @if ($tertutup->komentar4)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                            onclick='showk({!! json_encode($tertutup->komentar4) !!}, 4)'>
                      <i class="ti ti-message me-2"></i> Promotor
                    </button>
                  @endif
                  @if ($tertutup->komentar5)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                            onclick='showk({!! json_encode($tertutup->komentar5) !!}, 5)'>
                      <i class="ti ti-message me-2"></i> Co-Promotor 1
                    </button>
                  @endif
                  @if ($tertutup->komentar7)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                            onclick='showk({!! json_encode($tertutup->komentar7) !!}, 7)'>
                      <i class="ti ti-message me-2"></i> Co-Promotor 2
                    </button>
                  @endif
                  @if ($tertutup->komentar6)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                    onclick='showk({!! json_encode($tertutup->komentar6) !!}, "Kaprodi")'>
                    <i class="ti ti-message me-2" id="penguji_eks"></i> Kaprodi
                  </button>
                @endif
                  @if ($tertutup->komentar_eks)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                    onclick='showk({!! json_encode($tertutup->komentar_eks) !!}, "Eksternal")'>
                    <i class="ti ti-message me-2" id="penguji_eks"></i> Eksternal
                  </button>
                @endif
              </div>
            </div>
            <div class="mt-3 alert alert-info d-flex align-items-center" role="alert">
              <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
              <div><strong class="me-2">Perhatian!</strong> Tombol hanya akan muncul jika penguji sudah memberikan
                komentar.</div>
            </div>
          </div>
        </div>

        {{-- === [TAMBAHAN] Modal Komentar (tidak mengubah bagian lain) === --}}
        <div class="modal fade" id="modalComment" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="m_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col mb-3">
                    <div id="showkomentars" class="mb-3"></div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
              </div>
            </div>
          </div>
        </div>
        {{-- === [AKHIR TAMBAHAN MODAL] === --}}

        @if ($jadwal_ujian && !$jadwal_ujian->penilaian)
          <div class="mt-3 alert alert-info d-flex align-items-center" role="alert">
            <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
            <div><strong class="me-2">Perhatian!</strong> Form penilaian akan terbuka pada
              {{ \Carbon\Carbon::parse($jadwal_ujian->tanggal)->isoFormat('dddd, D MMMM Y') }} pukul
              {{ \Carbon\Carbon::parse($jadwal_ujian->jam)->format('H:i') }}.</div>
          </div>
        @endif

        @if (!$tertutup->nilai_kaprodi && ($jadwal_ujian && $jadwal_ujian->penilaian))
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Form Penilaian Kaprodi</h4>
              <span class="text-muted">Harap mengisi komentar, karena penilaian tidak akan diproses jika komentar
                tidak diisi.</span>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="form-label mb-2"><b>Penilaian</b></p>
                <div class="col">
                  <input type="number" class="form-control" id="nilai_kaprodi" name="nilai_kaprodi" min="0"
                    max="100" required>
                </div>
              </div>
              <div class="row mb-3">
                <p class="form-label mb-2"><b>Catatan</b></p>
                <div class="">
                  <div id="snow-editor" class="mb-3"></div>
                </div>
              </div>
              <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                <div><strong class="me-2">Perhatian!</strong> Harap memastikan input penilaian anda, karena form tidak
                  dapat diubah kembali ketika sudah disubmit.</div>
              </div>
              <div class="d-flex justify-content-end gap-2 my-3">
                <button class="btn btn-success" id="btnApprove">
                  <i class="ti ti-circle-check me-2"></i> <b>Konfirmasi Penilaian</b>
                </button>
              </div>
            </div>
          </div>
        @endif

        @if ($tertutup->komentar6)
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Penilaian Anda</h4>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-2"><b>Penilaian</b></p>
                <div class="col-sm-7 col-md-8">
                  <div class="mb-3">
                    @if ($tertutup->nilai_kaprodi >= 50)
                      <span class="badge bg-label-success">{{ $tertutup->nilai_kaprodi }}</span>
                    @else
                      <span class="badge bg-label-danger">{{ $tertutup->nilai_kaprodi }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-2"><b>Komentar</b></p>
                <div class="col-sm-7 col-md-8">
                  <div class="mb-3">
                    <div id="snow-editor" class="mb-3"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif

        @if (!$jadwal_ujian)
          <div class="card mt-3">
            <div class="card-header mb-0 d-flex justify-content-between">
              <div class="col-md-7">
                <h4 class="card-header-title mb-0">Jadwalkan Ujian</h4>
                <span class="text-muted">Pilih Penguji, Tanggal, Jam, dan Ruangan Ujian</span>
              </div>
              <div class="col-md-5 d-flex justify-content-end">
                <div class="d-none d-md-block">
                  <button class="btn btn-primary" onclick="addPengujiEks()">
                    <i class="ti ti-plus me-2"></i> <b>Tambah Penguji Eksternal</b>
                  </button>
                </div>
                <div class="d-block d-md-none">
                  <button class="btn btn-primary btn-small" onclick="addPengujiEks()">
                    <i class="ti ti-plus"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form action="{{ route('dosen.ujian.tertutup.store', $tertutup->id) }}" method="POST" id="penjadwalan">
                @csrf
                <div class="row mb-3">
                  <div class="form-group mb-3">
                    <label for="penguji" class="form-label">Penguji</label>
                    <select class="form-select @error('penguji') is-invalid @enderror" multiple="multiple"
                      id="dosen_search" name="penguji[]" data-search-dosen-url="{{ route('search.dosen') }}"
                      data-csrf-token="{{ csrf_token() }}">
                    </select>
                    <div class="form-text">Isikan 2-3 dosen sebagai penguji</div>
                    @error('penguji')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group mb-3">
                    <label for="penguji_eks" class="form-label">Penguji Eksternal</label>
                    <select class="form-select @error('penguji_eks') is-invalid @enderror" multiple="multiple"
                      id="dosen_eks_search" name="penguji_eks[]" required
                      data-search-dosen-url="{{ route('search.dosen.eksternal') }}"
                      data-csrf-token="{{ csrf_token() }}">
                    </select>
                    <div class="form-text">Isikan 1 dosen sebagai penguji eksternal, jika tidak ada maka tambahkan
                      terlebih dahulu</div>
                    @error('penguji_eks')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group mb-3">
                    <label for="tanggal" class="col-form-label">Tanggal Ujian</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                      name="tanggal" required>
                    @error('tanggal')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group mb-3">
                    <label for="jam" class="col-form-label">Jam Ujian</label>
                    <input type="time" class="form-control @error('jam') is-invalid @enderror" id="jam"
                      name="jam" required>
                    @error('jam')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group mb-3">
                    <label for="ruangan" class="col-form-label">Ruangan Ujian</label>
                    <input type="text" class="form-control @error('ruangan') is-invalid @enderror" id="ruangan"
                      name="ruangan" required>
                    @error('ruangan')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="alert alert-info d-flex align-items-center" role="alert">
                  <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                  <strong class="me-2">Perhatian!</strong> Harap mengisi data dengan benar, data yang sudah diinput tidak dapat diubah.
                </div>
                <div class="d-flex justify-content-end gap-2 my-3">
                  <button class="btn btn-success" disabled id="penjadlawanSubmit">
                    <i class="ti ti-circle-check me-2"></i> <b>Jadwalkan</b>
                  </button>
                </div>
              </form>
            </div>
          </div>
        @endif

        @if ($tertutup->is_penilaian_done && $tertutup->status < 6)
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Finalisasi Ujian</h4>
              <span class="text-muted">Pastikan anda sudah mempertimbangkan dengan matang sebelum melakukan finalisasi ujian.</span>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col d-flex justify-content-center gap-2 my-3 w-100">
                  <button type="button" class="w-50 btn btn-warning"
                    @if ($tertutup->status != 4) onclick="finalisasi('revisi', event)" @else disabled @endif>
                    <i class="ti ti-circle-x me-2"></i> <b>Revisi</b>
                  </button>
                  <button type="button" class="w-50 btn btn-success"
                    @if ($tertutup->status != 4) onclick="finalisasi('layak', event)" @else disabled @endif>
                    <i class="ti ti-circle-check me-2"></i> <b>Layak</b>
                  </button>
                </div>
              </div>
              @if ($tertutup->status != 4)
                <div class="mt-3 alert alert-info d-flex align-items-center" role="alert">
                  <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                  <div><strong>Perhatian!</strong> Jika anda menekan tombol revisi, maka mahasiswa harus
                    mengajukan ulang naskah. Jika anda menekan tombol layak, maka ujian akan dianggap selesai.</div>
                </div>
              @else
                <div class="mt-3 alert alert-info d-flex align-items-center" role="alert">
                  <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                  <div><strong>Perhatian!</strong> Tombol Finalisasi hanya akan muncul jika status pengajuan Tertutup
                    Disertasi adalah <b>Revisi Diajukan</b>. Harap menunggu hingga mahasiswa mengajukan ulang naskah.</div>
                </div>
              @endif
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function() {
      window.addPengujiEks = function() {
        Swal.fire({
          title: 'Tambah Penguji Eksternal',
          html: '<form id="formPengujiEks" class="text-start">' +
            '<div class="form-group mb-3">' +
            '<label for="nama" class="form-label">Nama</label>' +
            '<input type="text" class="form-control" id="nama" name="nama" required>' +
            '</div>' +
            '<div class="form-group mb-3">' +
            '<label for="nidn" class="form-label mb-0">NIDN/NIP/NIK</label>' +
            '<input type="text" class="form-control" id="no_induk" name="no_induk" required>' +
            '</div>' +
            '<div class="form-group mb-3">' +
            '<label for="email" class="form-label mb-0">Email</label>' +
            '<input type="email" class="form-control" id="email" name="email" required>' +
            '</div>' +
            '<div class="mt-3 alert alert-info d-flex align-items-center" role="alert">' +
            '<i class="ti ti-exclamation-circle me-1 fw-bold"></i>' +
            '<div><strong>Perhatian!</strong> Pastikan Data Sudah benar dan penguji belum ditambahkan.</div>' +
            '</div>' +
            '</form>',
          showCancelButton: true,
          confirmButtonText: 'Tambah Penguji',
          customClass: {
            confirmButton: 'btn btn-success me-3',
            cancelButton: 'btn btn-danger'
          },
          preConfirm: () => {
            const nama = Swal.getPopup().querySelector('#nama').value;
            const nidn = Swal.getPopup().querySelector('#no_induk').value;
            const email = Swal.getPopup().querySelector('#email').value;
            if (!nama || !nidn || !email) {
              Swal.showValidationMessage(`Data harus diisi lengkap`);
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
              Swal.showValidationMessage(`Email tidak valid`);
            }
            return {
              nama: nama,
              nidn: nidn,
              email: email
            };
          }
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post("{{ route('dosen.ujian.tertutup.addPenguji') }}", {
              _token: "{{ csrf_token() }}",
              nama: result.value.nama,
              no_induk: result.value.nidn,
              email: result.value.email,
            }).then((response) => {
              Swal.fire({
                title: 'Berhasil!',
                text: "Penguji Eksternal berhasil ditambahkan",
                icon: 'success',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
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
                  html: "Terjadi kesalahan saat menambahkan penguji eksternal.",
                  customClass: {
                    confirmButton: 'btn btn-danger'
                  }
                });
              }
            });
          }
        });
      };
    });
  </script>
  <script>
    $(document).ready(function() {
      window.finalisasi = function(status, e) {
        e.preventDefault();
        let msg = '';
        if (status == 'revisi') {
          msg = "Anda akan menilai ujian ini sebagai REVISI, harap pastikan kembali penilaian anda!";
        } else if (status == 'layak') {
          msg =
            "Anda akan menilai ujian ini sebagai LAYAK, progress akan dilanjutkan ke ujian selanjutnya, harap pastikan kembali penilaian anda!";
        }
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: msg,
          icon: 'warning',
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          showCancelButton: true,
          confirmButtonText: 'Ya, lanjutkan!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post("{{ route('dosen.ujian.tertutup.finalisasi') }}", {
              _token: "{{ csrf_token() }}",
              _method: "PATCH",
              mahasiswa_id: "{{ $mahasiswa->id }}",
              tertutup_id: "{{ $tertutup->id }}",
              role: "kaprodi",
              jenis_ujian: "{{ $tertutup->jenis_ujian }}",
              status: status,
            }).then((response) => {
              Swal.fire({
                title: 'Berhasil!',
                text: "Penilaian berhasil disimpan",
                icon: 'success',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "{{ route('dosen.ujian.tertutup') }}";
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
      };
    });
  </script>

  {{-- === [TAMBAHAN] Lazy-init Quill untuk modal komentar === --}}
  <script>
    $(document).ready(function() {
      let showkomentars = null;

      // Inisialisasi saat modal ditampilkan (aman jika elemen belum ada sebelumnya)
      $('#modalComment').on('shown.bs.modal', function () {
        if (!showkomentars && document.querySelector('#showkomentars')) {
          showkomentars = new Quill('#showkomentars', {
            bounds: '#showkomentars',
            modules: { formula: true, toolbar: false },
            theme: 'snow'
          });
          showkomentars.disable();
        }
      });

      // Bersihkan isi saat modal ditutup
      $('#modalComment').on('hidden.bs.modal', function () {
        if (showkomentars) showkomentars.setContents([]);
      });

      // Fungsi dipanggil dari tombol
      window.showk = function(komentar, num) {
        $("#m_title").text("Komentar Penguji " + num);
        try {
          const delta = (typeof komentar === 'string') ? JSON.parse(komentar) : komentar;
          if (showkomentars) {
            showkomentars.setContents(delta);
          } else {
            // Jika user sangat cepat klik, paksa init lalu set
            showkomentars = new Quill('#showkomentars', {
              bounds: '#showkomentars',
              modules: { formula: true, toolbar: false },
              theme: 'snow'
            });
            showkomentars.disable();
            showkomentars.setContents(delta);
          }
        } catch (e) {
          if (showkomentars) showkomentars.setText('Gagal memuat komentar.');
          console.error(e);
        }
      };
    });
  </script>
  {{-- === [AKHIR TAMBAHAN] === --}}

  <script>
    $(document).ready(function() {
      const fullToolbar = [
        [
          { font: [] },
          { size: [] }
        ],
        ['bold', 'italic', 'underline', 'strike'],
        [
          { color: [] },
          { background: [] }
        ],
        [
          { script: 'super' },
          { script: 'sub' }
        ],
        [
          { header: '1' },
          { header: '2' },
          'blockquote',
          'code-block'
        ],
        [
          { list: 'ordered' },
          { list: 'bullet' },
          { indent: '-1' },
          { indent: '+1' }
        ],
        [
          'direction',
          { align: [] }
        ],
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

      @if ($tertutup->komentar6)
        const komentar = {!! $tertutup->komentar6 !!};
        if (komentar) {
          snowEditor.disable();
          document.querySelector('.ql-toolbar').remove();
          snowEditor.setContents(komentar);
        }
      @endif

      $('#btnApprove').on('click', function() {
        if (($('#nilai_kaprodi').val() < 0 || $('#nilai_kaprodi').val() > 100) || $('#nilai_kaprodi').val() == "") {
          Swal.fire({
            title: 'Peringatan!',
            text: "Nilai harus diantara 0-100",
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else if ($('#snow-editor').text().trim().length < 1) {
          Swal.fire({
            title: 'Peringatan!',
            text: "Anda belum mengisi komentar, harap isi komentar terlebih dahulu!",
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else {
          Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan menilai ujian ini, harap pastikan kembali penilaian anda!",
            icon: 'warning',
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            showCancelButton: true,
            confirmButtonText: 'Ya, lanjutkan!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              axios.post("{{ route('dosen.ujian.terjadwal.penilaian') }}", {
                _token: "{{ csrf_token() }}",
                nim: "{{ $mahasiswa->nim }}",
                mahasiswa_id: "{{ $mahasiswa->id }}",
                ujian_id: "{{ $tertutup->id }}",
                role: "kaprodi",
                jenis_ujian: "{{ $tertutup->jenis_ujian }}",
                nilai: $('#nilai_kaprodi').val(),
                dosen: "kaprodi",
                catatan: JSON.stringify(snowEditor.getContents())
              }).then((response) => {
                Swal.fire({
                  title: 'Berhasil!',
                  text: "Penilaian berhasil disimpan",
                  icon: 'success',
                  customClass: {
                    confirmButton: 'btn btn-success'
                  }
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
        }
      });
    });
  </script>

  <script>
    $("#dosen_eks_search").select2({
      placeholder: "Pilih Dosen Penguji Eksternal",
      maximumSelectionLength: 1,
      minimumInputLength: 1,
      ajax: {
        delay: 500,
        url: $("#dosen_eks_search").data("search-dosen-url"),
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $("#dosen_eks_search").data("csrf-token")
        },
        data: function(params) {
          return {
            nipNikOrNama: params.term
          };
        },
        processResults: function(response) {
          var data = response.map(function(item) {
            return {
              id: item.id,
              nomor_induk: item.no_induk,
              text: item.nama
            };
          });
          return {
            results: data
          };
        },
        cache: true
      },
      templateResult: formatSearch,
      templateSelection: formatSelection
    });

    $("#dosen_search").select2({
      placeholder: "Pilih Dosen Penguji",
      maximumSelectionLength: 3,
      minimumInputLength: 1,
      ajax: {
        delay: 500,
        url: $("#dosen_search").data("search-dosen-url"),
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $("#dosen_search").data("csrf-token")
        },
        data: function(params) {
          return {
            nipNikOrNama: params.term
          };
        },
        processResults: function(response) {
          var data = response.map(function(item) {
            return {
              id: item.id,
              nomor_induk: item.no_induk,
              text: item.nama
            };
          });
          return {
            results: data
          };
        },
        cache: true
      },
      templateResult: formatSearch,
      templateSelection: formatSelection
    });

    function formatSearch(data) {
      if (data.loading) {
        return data.text;
      }
      var $markup = $(
        '<span>' +
        '<h6 class="mb-0">' + data.text + "</h6>" +
        '<span class="text-muted">' + data.nomor_induk + "</span>" +
        "</span>"
      );
      return $markup;
    }

    function formatSelection(data) {
      return data.text;
    }
  </script>

  <script>
    $('#penjadwalan').on('change', 'input, select', function() {
      let penguji = $('#dosen_search').val();
      let penguji_eks = $('#dosen_eks_search').val();
      let tanggal = $('#tanggal').val();
      let jam = $('#jam').val();
      let ruangan = $('#ruangan').val();

      if (penguji.length >= 2 && penguji_eks.length >= 1 && tanggal && jam && ruangan) {
        $('#penjadlawanSubmit').prop('disabled', false);
      } else {
        $('#penjadlawanSubmit').prop('disabled', true);
      }
    });

    @if ($tertutup->status != 2 && $tertutup->status != 4)
      $('#penjadwalan').find('input, select, button').prop('readonly', true);
    @endif
  </script>
  <script>
    $('#penjadwalan').submit(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda akan menjadwalkan ujian disertasi tertutup mahasiswa ini!",
        icon: 'warning',
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        showCancelButton: true,
        confirmButtonText: 'Ya, lanjutkan!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      });
    });
  </script>
@endsection
