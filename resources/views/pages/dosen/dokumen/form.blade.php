@extends('layouts.dosen.app')

@section('title', 'Dokumen')

@section('content')
<div class="card mb-3">
    
    <div class="card-header d-flex align-items-center">
        <a href="#" class="btn btn-icon me-2 btn-primary" onClick="window.history.back();">
          <i class="ti ti-chevron-left"></i>
        </a>
        <h4 id="form-dokumen-title" class="card-header-title mb-0">Tambah Dokumen</h4>
    </div>
      
    <div class="card-body">
        <div class="row">
            <form method="POST" action="{{ route('dokumen.store') }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                
                {{-- nama --}}
                <div class="form-group mb-3">
                    <label class="form-label mb-0"><b>Judul</b></label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul">
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- dokumen --}}
                <div class="form-group mb-3">
                    <label class="form-label mb-0"><b>Dokumen</b></label>
                    <input type="file" class="form-control @error('dokumen') is-invalid @enderror" name="dokumen">
                    @error('dokumen')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary my-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
