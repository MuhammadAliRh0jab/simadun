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
      <a href="{{ route('mahasiswa.home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Dashboards">Dashboard</div>
      </a>
    </li>
    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text" data-i18n="Apps &amp; Pages">Progress Ujian</span>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-file-description"></i>
        <div data-i18n="Wizard Examples">Ujian</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{ route('ujian.proposal') }}" class="menu-link">
            <div data-i18n="Checkout">Ujian Proposal</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('ujian.semhas') }}" class="menu-link">
            <div data-i18n="Property Listing">Ujian Seminar Hasil</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('ujian.publikasi') }}" class="menu-link">
            <div data-i18n="Create Deal">Ujian Kelayakan</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('ujian.tertutup') }}" class="menu-link">
            <div data-i18n="Create Deal">Ujian Tertutup Disertasi</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="{{ route('laporan-bulanan.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-report"></i>
        <div data-i18n="Modal Examples">Laporan Bulanan</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="{{ route('index.Publikasi') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-file-import"></i>
        <div data-i18n="Modal Examples">Publikasi</div>
      </a>
    </li>

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

    <!-- Cards -->
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
