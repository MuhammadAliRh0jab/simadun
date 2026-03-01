@extends('layouts.dosen.app')

@section('title', 'Ujian Publikasi')

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
          Pengajuan Ujian Publikasi
        </h4>
        <p class="mb-0 text-muted">{{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}</p>
      </div>
    </div>
    @if ($publikasi->status != 2 && $publikasi->status != 4)
      <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
        <div><strong class="me-2">Perhatian!</strong> Form hanya dapat
          diakses ketika status pengajuan Ujian Publikasi adalah <b>Diajukan</b> atau <b>Finalisasi.</b></div>
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
                <div class="row mb-3">
                  <p class="form-label mb-0"><b>Penguji 1</b></p>
                  <div class="">
                    <p class="mb-0">{{ $jadwal_ujian->penguji1 }}</p>
                  </div>
                </div>
                <div class="row mb-3">
                  <p class="form-label mb-0"><b>Penguji 2</b></p>
                  <div class="">
                    <p class="mb-0">{{ $jadwal_ujian->penguji2 }}</p>
                  </div>
                </div>
                @if ($jadwal_ujian->penguji3)
                  <div class="row mb-3">
                    <p class="form-label mb-0"><b>Penguji 3</b></p>
                    <div class="">
                      <p class="mb-0">{{ $jadwal_ujian->penguji3 }}</p>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endif
      </div>
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4 class="card-header-title">Data Pengajuan Ujian Publikasi</h4>
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
                          4 => '<span class="badge bg-label-warning">Sedang dalam Revisi</span>',
                          5 => '<span class="badge bg-label-secondary">Revisi Diajukan</span>',
                          6 => '<span class="badge bg-label-success">Selesai</span>',
                      ];
                    @endphp
                    {!! $status[$publikasi->status] !!}
                  </p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Usulan Penguji 1</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">{{ $publikasi->usulan_penguji1 }}</p>
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Usulan Penguji 2</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">{{ $publikasi->usulan_penguji2 }}</p>
                </div>
              </div>
              @if ($publikasi->usulan_penguji3 && $publikasi->usulan_penguji3 != '-')
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Usulan Penguji 3</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">{{ $publikasi->usulan_penguji3 }}</p>
                  </div>
                </div>
              @endif
              <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Naskah Disertasi @if ($publikasi->status == 5) (Revisi) @endif</b></p>
                  <div class="col-sm-7 col-md-8">
                      <a href="{{ $publikasi->file }}" target="_blank" class="btn-sm text-primary" rel="noopener noreferrer">
                          <h6 class="card-title mb-0 text-primary"><i class="ti ti-link me-1"></i>Lihat Naskah Disertasi</h6>
                      </a>
                  </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Publikasi Jurnal @if ($publikasi->status == 5) (Revisi) @endif</b></p>
                <div class="col-sm-7 col-md-8">
                  @forelse ($publikasi_jurnal as $jurnal)
                    <div class="card border-1 p-3 shadow-none mb-1">
                      <div class="row">
                        <div class="col-6">
                          <a href="{{ $jurnal->link }}" target="_blank" class="btn-sm text-primary">
                            <h6 class="card-title mb-0 text-primary"><i class="ti ti-link me-1"></i>{{ $jurnal->judul }}</h6>
                          </a>
                          <p class="card-text mb-0 small">{{ $jurnal->jurnal }}</p>
                        </div>
                        <div class="col-6 d-flex flex-column justify-content-start align-items-end">
                          <p class="card-text text-end mb-0 small">({{ $jurnal->tanggal_terbit }}), {{ $jurnal->volume }}({{ $jurnal->nomor }})</p>
                        </div>
                      </div>
                    </div>
                  @empty
                    <p class="form-text">Belum ada publikasi jurnal</p>
                  @endforelse
                </div>
              </div>
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Publikasi Conference @if ($publikasi->status == 5) (Revisi) @endif</b></p>
                <div class="col-sm-7 col-md-8">
                  @forelse ($publikasi_conference as $conference)
                    <div class="card border-1 p-3 shadow-none mb-1">
                      <div class="row">
                        <div class="col-6">
                          <a href="{{ $conference->link }}" target="_blank" class="btn-sm text-primary">
                            <h6 class="card-title mb-0 text-primary"><i class="ti ti-link me-1"></i>{{ $conference->judul }}</h6>
                          </a>
                          <p class="card-text mb-0 small">{{ $conference->namaConference }}, oleh {{ $conference->penyelenggara }}, ({{ $conference->tanggal_conference }})</p>
                        </div>
                        <div class="col-6 d-flex flex-column justify-content-start align-items-end">
                          <p class="card-text text-end mb-0 small">({{ $conference->tanggalPublikasi }}), {{ $conference->lokasi_Conference }}</p>
                        </div>
                      </div>
                    </div>
                  @empty
                    <p class="form-text">Belum ada publikasi conference</p>
                  @endforelse
                </div>
              </div>
            </div>
          </div>
        </div>

        @if (
            $publikasi->nilai_penguji1 ||
            $publikasi->nilai_penguji2 ||
            $publikasi->nilai_penguji3 ||
            $publikasi->nilai_promotor ||
            $publikasi->nilai_co_promotor1 ||
            $publikasi->nilai_co_promotor2 ||
            $publikasi->nilai_kaprodi
        )
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Status Penilaian</h4>
              <span class="text-muted">Ini adalah status penilaian saat ini, harap refresh halaman ini untuk melihat perubahan status penilaian terbaru.</span>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Satu</b></p>
                <div class="col-sm-7 col-md-8">
                  <p class="mb-0">
                    @if ($publikasi->nilai_penguji1)
                      @if ($publikasi->nilai_penguji1 == 100)
                        <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Layak</span>
                      @else
                        <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Tidak Layak</span>
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
                    @if ($publikasi->nilai_penguji2)
                      @if ($publikasi->nilai_penguji2 == 100)
                        <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Layak</span>
                      @else
                        <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Tidak Layak</span>
                      @endif
                    @else
                      <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Belum Dinilai</span>
                    @endif
                  </p>
                </div>
              </div>
              @if ($publikasi->penguji3_id != null)
                <div class="row mb-3">
                  <p class="col-sm-5 col-md-4 form-label mb-0"><b>Penguji Tiga</b></p>
                  <div class="col-sm-7 col-md-8">
                    <p class="mb-0">
                      @if ($publikasi->nilai_penguji3)
                        @if ($publikasi->nilai_penguji3 == 100)
                          <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Layak</span>
                        @else
                          <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Tidak Layak</span>
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
                    @if ($publikasi->nilai_promotor)
                      @if ($publikasi->nilai_promotor == 100)
                        <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Layak</span>
                      @else
                        <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Tidak Layak</span>
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
                    @if ($publikasi->nilai_co_promotor1)
                      @if ($publikasi->nilai_co_promotor1 == 100)
                        <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Layak</span>
                      @else
                        <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Tidak Layak</span>
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
                      @if ($publikasi->nilai_co_promotor2)
                        @if ($publikasi->nilai_co_promotor2 == 100)
                          <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Layak</span>
                        @else
                          <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Tidak Layak</span>
                        @endif
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
                    @if ($publikasi->nilai_kaprodi)
                      @if ($publikasi->nilai_kaprodi == 100)
                        <span class="badge bg-label-success"><i class="ti ti-circle-check"></i> Layak</span>
                      @else
                        <span class="badge bg-label-danger"><i class="ti ti-circle-x"></i> Tidak Layak</span>
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

        @if ($publikasi->komentar1 || $publikasi->komentar2 || $publikasi->komentar3 || $publikasi->komentar4 || $publikasi->komentar5 || $publikasi->komentar6 || $publikasi->komentar7)
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Komentar Penguji</h4>
              <span class="text-muted">Tekan tombol komentar untuk menampilkan komentar masing-masing penguji. Komentar hanya dapat dilihat oleh dosen dan mahasiswa.</span>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col">
                  @if ($publikasi->komentar1)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($publikasi->komentar1) !!}, 1)'>
                      <i class="ti ti-message me-2"></i> Penguji 1
                    </button>
                  @endif
                  @if ($publikasi->komentar2)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($publikasi->komentar2) !!}, 2)'>
                      <i class="ti ti-message me-2"></i> Penguji 2
                    </button>
                  @endif
                  @if ($publikasi->komentar3)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($publikasi->komentar3) !!}, 3)'>
                      <i class="ti ti-message me-2"></i> Penguji 3
                    </button>
                  @endif
                  @if ($publikasi->komentar4)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($publikasi->komentar4) !!}, 4)'>
                      <i class="ti ti-message me-2"></i> Promotor
                    </button>
                  @endif
                  @if ($publikasi->komentar5)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($publikasi->komentar5) !!}, 5)'>
                      <i class="ti ti-message me-2"></i> Co-Promotor 1
                    </button>
                  @endif
                  @if ($publikasi->komentar7)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($publikasi->komentar7) !!}, 7)'>
                      <i class="ti ti-message me-2"></i> Co-Promotor 2
                    </button>
                  @endif
                  @if ($publikasi->komentar6)
                    <button class="btn btn-light m-1" data-bs-toggle="modal" data-bs-target="#modalComment"
                      onclick='showk({!! json_encode($publikasi->komentar6) !!}, 6)'>
                      <i class="ti ti-message me-2"></i> Kaprodi
                    </button>
                  @endif
                </div>
              </div>
              <div class="mt-3 alert alert-info d-flex align-items-center" role="alert">
                <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                <div><strong class="me-2">Perhatian!</strong> Tombol hanya akan muncul jika penguji sudah memberikan komentar.</div>
              </div>
            </div>
          </div>

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
        @endif

        @if ($jadwal_ujian && !$jadwal_ujian->penilaian)
          <div class="mt-3 alert alert-info d-flex align-items-center" role="alert">
            <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
            <div><strong class="me-2">Perhatian!</strong> Form penilaian akan terbuka pada
              {{ \Carbon\Carbon::parse($jadwal_ujian->tanggal)->isoFormat('dddd, D MMMM Y') }} pukul
              {{ \Carbon\Carbon::parse($jadwal_ujian->jam)->format('H:i') }}.
            </div>
          </div>
        @endif

        @if (!$publikasi->nilai_kaprodi && ($jadwal_ujian && $jadwal_ujian->penilaian))
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Form Penilaian Kaprodi</h4>
              <span class="text-muted">Harap mengisi komentar, karena penilaian tidak akan diproses jika komentar tidak diisi.</span>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="form-label mb-2"><b>Catatan</b></p>
                <div class="">
                  <div id="snow-editor" class="mb-3"></div>
                </div>
              </div>
              <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                <div><strong class="me-2">Perhatian!</strong> Harap memastikan input penilaian anda, karena form tidak dapat diubah kembali ketika sudah disubmit.</div>
              </div>
              <div class="d-flex justify-content-end gap-2 my-3">
                <button class="btn btn-danger" id="btnReject">
                  <i class="ti ti-circle-x me-2"></i> <b>Tidak Layak</b>
                </button>
                <button class="btn btn-success" id="btnApprove">
                  <i class="ti ti-circle-check me-2"></i> <b>Layak</b>
                </button>
              </div>
            </div>
          </div>
        @endif

        @if ($publikasi->komentar6)
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Penilaian Anda</h4>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <p class="col-sm-5 col-md-4 form-label mb-2"><b>Penilaian</b></p>
                <div class="col-sm-7 col-md-8">
                  <div class="mb-3">
                    @if ($publikasi->nilai_kaprodi == 100)
                      <span class="badge bg-label-success">Layak</span>
                    @else
                      <span class="badge bg-label-danger">Tidak Layak</span>
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
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Jadwalkan Ujian</h4>
              <span class="text-muted">Pilih Penguji, Tanggal, Jam, dan Ruangan Ujian</span>
            </div>
            <div class="card-body">
              <form action="{{ route('dosen.ujian.publikasi.store', $publikasi->id) }}" method="POST" id="penjadwalan">
                @csrf
                <div class="row mb-3">
                  <div class="form-group mb-3">
                    <label for="penguji" class="form-label">Penguji</label>
                    <select class="form-select @error('penguji') is-invalid @enderror" multiple="multiple"
                      id="dosen_search" name="penguji[]" required data-search-dosen-url="{{ route('search.dosen') }}"
                      data-csrf-token="{{ csrf_token() }}">
                    </select>
                    <div class="form-text">Isikan 2–3 dosen sebagai penguji</div>
                    @error('penguji')
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
        @if ($publikasi->is_penilaian_done && $publikasi->status < 6)
          <div class="card mt-3">
            <div class="card-header mb-0">
              <h4 class="card-header-title mb-0">Finalisasi Ujian</h4>
              <span class="text-muted">Pastikan anda sudah mempertimbangkan dengan matang sebelum melakukan finalisasi ujian.</span>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col d-flex justify-content-center gap-2 my-3 w-100">
                  <button type="button" class="w-50 btn btn-warning"
                    @if ($publikasi->status != 4) onclick="finalisasi('revisi', event)" @else disabled @endif>
                    <i class="ti ti-circle-x me-2"></i> <b>Revisi</b>
                  </button>
                  <button type="button" class="w-50 btn btn-success"
                    @if ($publikasi->status != 4) onclick="finalisasi('layak', event)" @else disabled @endif>
                    <i class="ti ti-circle-check me-2"></i> <b>Layak</b>
                  </button>
                </div>
              </div>
              @if ($publikasi->status != 4)
                <div class="mt-3 alert alert-info d-flex align-items-center" role="alert">
                  <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                  <div><strong>Perhatian!</strong> Jika anda menekan tombol revisi, maka mahasiswa harus mengajukan ulang naskah. Jika anda menekan tombol layak, maka ujian akan dianggap selesai.</div>
                </div>
              @else
                <div class="mt-3 alert alert-info d-flex align-items-center" role="alert">
                  <i class="ti ti-exclamation-circle me-1 fw-bold"></i>
                  <div><strong>Perhatian!</strong> Tombol Finalisasi hanya akan muncul jika status pengajuan publikasi adalah <b>Revisi Diajukan</b>. Harap menunggu hingga mahasiswa mengajukan ulang naskah.</div>
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
      window.finalisasi = function(status, e) {
        e.preventDefault();
        let msg = '';
        if (status == 'revisi') {
          msg = "Anda akan menilai ujian ini sebagai REVISI, harap pastikan kembali penilaian anda!";
        } else if (status == 'layak') {
          msg = "Anda akan menilai ujian ini sebagai LAYAK, progress akan dilanjutkan ke ujian selanjutnya, harap pastikan kembali penilaian anda!";
        }
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: msg,
          icon: 'warning',
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
        }).then((result) => {
          if (result.isConfirmed) {
            axios.post("{{ route('dosen.ujian.publikasi.finalisasi') }}", {
              _token: "{{ csrf_token() }}",
              _method: "PATCH",
              mahasiswa_id: "{{ $mahasiswa->id }}",
              publikasi_id: "{{ $publikasi->id }}",
              role: "kaprodi",
              jenis_ujian: "{{ $publikasi->jenis_ujian }}",
              status: status,
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
                  window.location.href = "{{ route('dosen.ujian.publikasi') }}";
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
  </script>
  <script>
    $(document).ready(function() {
      const showkomentars = new Quill('#showkomentars', {
        bounds: '#showkomentars',
        modules: {
          formula: true,
          toolbar: false
        },
        theme: 'snow'
      });
      showkomentars.disable();

      window.showk = function(komentar, num) {
        $("#m_title").text("Komentar Penguji " + num);
        komentar = JSON.parse(komentar);
        showkomentars.setContents(komentar);
      };
    });
  </script>
  <script>
    $(document).ready(function() {
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

      @if ($publikasi->komentar6)
        const komentar = {!! $publikasi->komentar6 !!};
        if (komentar) {
          snowEditor.disable();
          document.querySelector('.ql-toolbar').remove();
          snowEditor.setContents(komentar);
        }
      @endif

      $('#btnReject').on('click', function() {
        if ($('#snow-editor').text().trim().length < 1) {
          Swal.fire({
            title: 'Peringatan!',
            text: "Anda belum mengisi komentar, harap isi komentar terlebih dahulu!",
            icon: 'warning',
            customClass: { confirmButton: 'btn btn-success' },
          });
        } else {
          Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan menilai ujian ini sebagai TIDAK LAYAK, harap pastikan kembali penilaian anda!",
            icon: 'warning',
            customClass: { confirmButton: 'btn btn-success', cancelButton: 'btn btn-danger' },
          }).then((result) => {
            if (result.isConfirmed) {
              axios.post("{{ route('dosen.ujian.terjadwal.penilaian') }}", {
                _token: "{{ csrf_token() }}",
                mahasiswa_id: "{{ $mahasiswa->id }}",
                nim: "{{ $mahasiswa->nim }}",
                role: "kaprodi",
                ujian_id: "{{ $publikasi->id }}",
                jenis_ujian: "{{ $publikasi->jenis_ujian }}",
                nilai: 1,
                dosen: "kaprodi",
                catatan: JSON.stringify(snowEditor.getContents()),
              }).then((response) => {
                Swal.fire({
                  title: 'Berhasil!',
                  text: "Penilaian berhasil disimpan",
                  icon: 'success',
                  customClass: { confirmButton: 'btn btn-success' },
                }).then((result) => {
                  if (result.isConfirmed) window.location.reload();
                });
              }).catch((error) => {
                if (error.response.status === 422) {
                  let errors = error.response.data.errors;
                  let message = error.response.data.message;
                  Swal.fire({
                    icon: 'warning',
                    title: 'Gagal!',
                    html: message,
                    customClass: { confirmButton: 'btn btn-warning' }
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: "Terjadi kesalahan saat melakukan penilaian.",
                    customClass: { confirmButton: 'btn btn-danger' }
                  });
                }
              });
            }
          });
        }
      });

      $('#btnApprove').on('click', function() {
        if ($('#snow-editor').text().trim().length < 1) {
          Swal.fire({
            title: 'Peringatan!',
            text: "Anda belum mengisi komentar, harap isi komentar terlebih dahulu!",
            icon: 'warning',
            customClass: { confirmButton: 'btn btn-success' },
          });
        } else {
          Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda akan menilai ujian ini sebagai LAYAK, harap pastikan kembali penilaian anda!",
            icon: 'warning',
            customClass: { confirmButton: 'btn btn-success', cancelButton: 'btn btn-danger' },
          }).then((result) => {
            if (result.isConfirmed) {
              axios.post("{{ route('dosen.ujian.terjadwal.penilaian') }}", {
                _token: "{{ csrf_token() }}",
                nim: "{{ $mahasiswa->nim }}",
                mahasiswa_id: "{{ $mahasiswa->id }}",
                ujian_id: "{{ $publikasi->id }}",
                role: "kaprodi",
                jenis_ujian: "{{ $publikasi->jenis_ujian }}",
                nilai: 100,
                dosen: "kaprodi",
                catatan: JSON.stringify(snowEditor.getContents()),
              }).then((response) => {
                Swal.fire({
                  title: 'Berhasil!',
                  text: "Penilaian berhasil disimpan",
                  icon: 'success',
                  customClass: { confirmButton: 'btn btn-success' },
                }).then((result) => {
                  if (result.isConfirmed) window.location.reload();
                });
              }).catch((error) => {
                if (error.response.status === 422) {
                  let errors = error.response.data.errors;
                  let message = error.response.data.message;
                  Swal.fire({
                    icon: 'warning',
                    title: 'Gagal!',
                    html: message,
                    customClass: { confirmButton: 'btn btn-warning' }
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: "Terjadi kesalahan saat melakukan penilaian.",
                    customClass: { confirmButton: 'btn btn-danger' }
                  });
                }
              });
            }
          });
        }
      });
    });
  </script>
  <script src="{{ url('/assets/js/dosenSearch.js') }}"></script>
  <script>
    $('#penjadwalan').on('change', 'input, select', function() {
      let penguji = $('#dosen_search').val();
      let tanggal = $('#tanggal').val();
      let jam = $('#jam').val();
      let ruangan = $('#ruangan').val();
      if (penguji.length >= 2 && penguji.length <= 3 && tanggal && jam && ruangan) {
        $('#penjadlawanSubmit').prop('disabled', false);
      } else {
        $('#penjadlawanSubmit').prop('disabled', true);
      }
    });

    @if ($publikasi->status != 2 && $publikasi->status != 4)
      $('#penjadwalan').find('input, select, button').prop('readonly', true);
    @endif
  </script>
  <script>
    $('#penjadwalan').submit(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda akan menjadwalkan ujian publikasi mahasiswa ini!",
        icon: 'warning',
        customClass: { confirmButton: 'btn btn-success', cancelButton: 'btn btn-danger' },
      }).then((result) => {
        if (result.isConfirmed) this.submit();
      });
    });
  </script>
@endsection