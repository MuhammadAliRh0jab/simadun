<div class="card">
  <div class="card-header card-header-content-sm-between d-flex justify-content-between ">
    <div class="mb-sm-0">
      <form>
        {{-- DO NOT REMOVE THIS --}}
        {{-- Start DataTable Search --}}
        <div class="input-group input-group-merge input-group-flush">
          <div class="input-group-prepend input-group-text">
            <i class="bi-search"></i>
          </div>
          <input id="datatableSearch" type="search" class="form-control" placeholder="{{ $search_text }}"
            aria-label="{{ $search_text }}">
        </div>
        {{-- End DataTable Search --}}
      </form>
    </div>

    @stack('custom_buttons')
    @if (isset($button_create))
      @if ($button_create)
        <a href="{{ $button_create }}">
          <button class="btn btn-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#dataTableFilter"
            aria-controls="dataTableFilter">
            <i class="ti ti-plus me-1"></i> Buat
          </button>
        </a>
      @endif
    @endif

  </div>
  <div class="datatable-custom table-responsive card-datatable">
    {{-- Render DataTable --}}
    {{ $table->table() }}
    {{-- End Render DataTable --}}
  </div>
  <div class="card-footer">
    <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
      <div class="col-sm mb-2 mb-sm-0">
        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
          <span class="me-2">Menampilkan:</span>
          <div class="tom-select-custom">
            <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto me-2"
              autocomplete="off"
              data-hs-tom-select-options='{
                                    "searchInDropdown": false,
                                    "hideSearch": true,
                                    "dropdownWidth": "min-content"
                                  }'>
              <option value="10" selected>10</option>
              <option value="20">20</option>
              <option value="30">30</option>
              <option value="40">40</option>
              <option value="50">50</option>
              <option value="-1">Semua</option>
            </select>
          </div>
          <span class="text-secondary me-2">dari</span>
          <span id="datatableWithPaginationInfoTotalQty"></span>
          <span class="text-secondary ms-2">total data</span>
        </div>
      </div>
      <div class="col-sm-auto">
        <div class="d-flex justify-content-center justify-content-sm-end">
          <nav id="datatablePagination" aria-label="Activity pagination"></nav>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
