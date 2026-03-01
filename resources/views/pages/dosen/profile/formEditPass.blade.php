@extends('layouts.guest.app')
@section('title', 'Isi Profile')
@section('content')
<div class="row justify-content-center align-items-center w-100" style="overflow-x: hidden">
  <div class=" col-12 col-md-10 col-lg-10 mb-4 h-100">
    <div class="card my-5" style="overflow-x: hidden !important">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h2 class="mb-2">Update Password</h2>
          <small class="text-muted">Pastikan password benar !!</small>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <form action="{{ route('new.password.dosen') }}" method="post" id="myForm" enctype="multipart/form-data">
                @csrf
                {{-- nim penulis --}}
                <div class="form-group row mb-3 ">
                  <div class="col-12 col-md-6">
                    <label for="pass_1" class="col-sm-5 col-form-label">Password</label>
                    <input type="password" class="form-control" id="pass_1" name="pass_1" value="{{ old('pass_1') }}">
                    @error('pass_1')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  {{-- pass 2 --}}
                  <div class="col-12 col-md-6">
                    <label for="pass_2" class="col-sm-5 col-form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="pass_2" name="pass_2" value="{{ old('pass_2') }}">
                    @error('pass_2')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>

                  <div class="col-12 col-md-6">
                    <label for="nim" class="col-sm-5 col-form-label ">No. Induk Anda</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="{{ $getDatadsn->no_induk }}"
                      readonly> {{-- ambil nim dari auth --}}
                    @error('nim')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              

                {{-- submit --}}
                <div class="form-group mb-3">
                  <button type="button" id="submitBtn" class="btn btn-primary" onclick="confirmUpload()">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    @endsection

    @section('scripts')
    <script>
      // js  for confirm same password beetwen pass_1 and pass_2
      $(document).ready(function () {
        $('#submitBtn').click(function () {
          var pass_1 = $('#pass_1').val();
          var pass_2 = $('#pass_2').val();
          if (pass_1 != pass_2) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Password tidak sama!',
            });
          }
        });
      });
      //sweet alert
      function confirmUpload() {
        Swal.fire({
          title: 'Konfirmasi',
          text: 'Anda Yakin mengganti password?',
          icon: 'question',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, lanjutkan!',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            // Jika pengguna menyetujui, lanjutkan dengan mengirim formulir
            document.getElementById('myForm').submit();
          }
        });
      }
    </script>
    @endsection

    @push('scripts')
    @endpush