{{-- alert status session success, error --}}
<div class="row">
  @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      <strong>Success!</strong> {{ session('success') }}
    </div>
  @elseif (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      <strong>Error!</strong> {{ session('error') }}
    </div>
  @endif
</div>