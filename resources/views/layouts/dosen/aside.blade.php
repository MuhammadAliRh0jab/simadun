<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" data-bg-class="bg-menu-theme"
  style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
  <div class="app-brand demo ">
    <a href="/" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ url('/assets/img/logos/logo-um.png') }}" alt="Brand Logo" class="img-fluid">
      </span>
      <span class="app-brand-text demo menu-text fw-bold">SIMADUN</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow" style="display: none;"></div>
  <ul class="menu-inner py-1 ps ps--active-y">
    <!-- Dashboards -->
    <li class="menu-item">
      <a href="{{ route('dosen.home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Dashboards">Dashboard</div>
      </a>
    </li>
    <!-- Kaprodi -->
    @if (UserHelper::isKaprodi())
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Apps &amp; Pages">Progress Ujian</span>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-file-description"></i>
          <div data-i18n="Wizard Examples">Progress Ujian</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('dosen.ujian.proposal') }}" class="menu-link">
              <div data-i18n="Checkout">Ujian Proposal</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('dosen.ujian.semhas') }}" class="menu-link">
              <div data-i18n="Property Listing">Ujian Seminar Hasil</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('dosen.ujian.publikasi') }}" class="menu-link">
              <div data-i18n="Create Deal">Ujian Kelayakan</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('dosen.ujian.tertutup') }}" class="menu-link">
              <div data-i18n="Create Deal">Ujian Tertutup Disertasi</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item">
        <a href="{{ route('dosen.ujian.arsip') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-file-import"></i>
          <div data-i18n="Modal Examples">Arsip Ujian</div>
        </a>
      </li>
    @endif

    <!-- Dosens Penguji-->
    <li class="menu-item">
      <a href="{{ route('dosen.ujian.terjadwal.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-file-import"></i>
        <div data-i18n="Modal Examples">Ujian Terjadwal</div>
      </a>
    </li>
    @if (UserHelper::isDosen() || UserHelper::isKaprodi())
    <!-- Dosens Promotor-->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text" data-i18n="Components">Bimbingan</span>
    </li>
    <li class="menu-item">
      <a href="{{ route('dosen.bimbingan.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-user"></i>
        <div data-i18n="Modal Examples">Bimbingan</div>
      </a>
    </li>
    {{-- <li class="menu-item">
        <a href="modal-examples.html" class="menu-link">
          <i class="menu-icon tf-icons ti ti-file-import"></i>
          <div data-i18n="Modal Examples">Publikasi Mahasiswa</div>
        </a>
      </li> --}}
      <li class="menu-item">
        <a href="{{ route('dosen.laporan.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-report"></i>
          <div data-i18n="Modal Examples">Laporan Bulanan</div>
        </a>
      </li>
{{--      <li class="menu-item">--}}
{{--        <a href="{{ route('show.dosen.publikasi') }}" class="menu-link">--}}
{{--          <i class="menu-icon tf-icons ti ti-file"></i>--}}
{{--          <div data-i18n="Wizard Examples">Publikasi Mahasiswa</div>--}}
{{--        </a>--}}
{{--      </li>--}}

      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-file"></i>
          <div data-i18n="Wizard Examples">Publikasi Mahasiswa</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('dosen.publikasi.jurnal.index') }}" class="menu-link">
              <div data-i18n="Checkout">Jurnal</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('dosen.publikasi.conference.index') }}" class="menu-link">
              <div data-i18n="Property Listing">Conference</div>
            </a>
          </li>
        </ul>
      </li>

      {{-- <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-file"></i>
          <div data-i18n="Wizard Examples">Publikasi Mahasiswa</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('dosen.ujian.proposal') }}" class="menu-link">
              <div data-i18n="Checkout">Publikasi Jurnal</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('dosen.ujian.semhas') }}" class="menu-link">
              <div data-i18n="Property Listing">Publikasi Conference</div>
            </a>
          </li>
        </ul>
      </li> --}}
    @endif

    @if (UserHelper::isKaprodi())
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text" data-i18n="Components">Manajemen Pengguna</span>
      </li>
      <li class="menu-item">
        <a href="{{ route('dosen.manajemen.mahasiswa') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-users-group"></i>
          <div data-i18n="Modal Examples">Mahasiswa</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{ route('dosen.manajemen.dosen') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-users"></i>
          <div data-i18n="Modal Examples">Dosen</div>
        </a>
      </li>
    @endif

    <!-- Components -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text" data-i18n="Components">Lain-lain</span>
    </li>

    <li class="menu-item">
      <a href="{{ route('dokumen.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-id"></i>
        <div data-i18n="Modal Examples">Dokumen</div>
      </a>
    </li>

{{--    <li class="menu-item">--}}
{{--      <a href="javascript:void(0);" class="menu-link menu-toggle">--}}
{{--        <i class="menu-icon tf-icons ti ti-id"></i>--}}
{{--        <div data-i18n="Cards">Dokumen</div>--}}
{{--      </a>--}}
{{--      <ul class="menu-sub">--}}
{{--        <li class="menu-item">--}}
{{--          <a href="cards-basic.html" class="menu-link">--}}
{{--            <div data-i18n="Basic">Basic</div>--}}
{{--          </a>--}}
{{--        </li>--}}
{{--      </ul>--}}
{{--    </li>--}}
{{--    <li class="menu-item">--}}
{{--      <a href="javascript:void(0);" class="menu-link menu-toggle">--}}
{{--        <i class="menu-icon tf-icons ti ti-id"></i>--}}
{{--        <div data-i18n="Cards">Akademik</div>--}}
{{--      </a>--}}
{{--      <ul class="menu-sub">--}}
{{--        <li class="menu-item">--}}
{{--          <a href="cards-basic.html" class="menu-link">--}}
{{--            <div data-i18n="Basic">Basic</div>--}}
{{--          </a>--}}
{{--        </li>--}}
{{--      </ul>--}}
{{--    </li>--}}
{{--    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">--}}
{{--      <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>--}}
{{--    </div>--}}
{{--    <div class="ps__rail-y" style="top: 0px; height: 847px; right: 4px;">--}}
{{--      <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 464px;"></div>--}}
{{--    </div>--}}
  </ul>
</aside>