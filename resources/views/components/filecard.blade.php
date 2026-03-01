@php
  $fileformat = pathinfo($fileUrl, PATHINFO_EXTENSION);
  $fileformat = strtoupper($fileformat);
  $filename = pathinfo($fileUrl, PATHINFO_FILENAME);
@endphp
<div class="border rounded shadow-none my-2">
  <div class="card-body d-flex align-items-center">
    <div>
      <i class="ti ti-file fs-2"></i>
    </div>
    <div class="ms-4 flex-grow-1 me-3">
      <p class="mb-0"><b>{{ $fileformat }}</b></p>
      <p class="mb-0">{{ $filename }}</p>
    </div>
    <div class="text-end">
      <a class="btn btn-sm btn-white ms-2" href="{{ $fileUrl }}" target="_blank">
        <i class="ti ti-download me-sm-1"></i> <span class="d-none d-sm-inline"></span>
      </a>
    </div>
  </div>
</div>
