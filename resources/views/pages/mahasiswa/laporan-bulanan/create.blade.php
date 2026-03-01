@extends('layouts.mahasiswa.app')

@section('title', 'Laporan Kemajuan')


@section('content')
  <div class="col-lg-12 mb-4 h-100">
    <div class="card mb-3">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h2 class="mb-2">Laporan Kemajuan Bulanan</h2>
          <small class="text-muted">Proses pengajuan laporan kemajuan bulanan, harap isi laporan kemajuan bulanan setiap
            awal bulan dari tanggal 1 sampai 10</small>
        </div>
      </div>
      <div class="card-body">
        <div class="row">

        </div>
      </div>
    </div>

    {{-- card form --}}
    <div class="card">
      <div class="card-header pb-4 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-3">
          <h3 class="mb-2">Form Laporan Bulanan</h3>
          <small class="text-muted">Harap isi form laporan dengan benar</small>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group mb-3">
              <label for="example-textarea">Judul Laporan</label>
              <input type="text" class="form-control" id="example-textarea" rows="3" placeholder="Judul Laporan"
                autocomplete="off" required>
            </div>
            <div id="snow-editor" class="mb-3">
              <p>Hello World!</p>
              <p>Some initial <strong>bold</strong> text</p>
              <p><br></p>
            </div>
            <div class="form-group mb-3">
              <button type="submit" class="btn btn-primary" id="submit">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $('#submit').on('click', function() {
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda tidak dapat mengubah laporan kemajuan bulanan setelah mengajukan!",
        icon: 'warning',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ml-1'
        },
        // change confirm button text
        confirmButtonText: 'Ya, Ajukan!',
        cancelButtonText: 'Batal',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
              title: 'Menyimpan...',
              text: 'Tunggu sebentar, laporan kemajuan bulanan sedang diajukan.',
              icon: 'info',
              showConfirmButton: false,
              allowOutsideClick: false,

              onOpen: () => {
                Swal.showLoading();
              }
            }),
            axios.post("{{ route('laporan-bulanan.store') }}", {
              _token: "{{ csrf_token() }}",
              judul: $('#example-textarea').val(),
              isi: JSON.stringify(snowEditor.getContents()),
            }).then(function(response) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Laporan kemajuan bulanan berhasil diajukan.',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              }).then(function(result) {
                if (result.isConfirmed) {
                  window.location.href = "{{ route('laporan-bulanan.index') }}";
                }
              });
            }).catch(function(error) {
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
                  html: "Terjadi kesalahan saat mengajukan laporan kemajuan bulanan.",
                  customClass: {
                    confirmButton: 'btn btn-danger'
                  }
                });
              }


            });
        }
      })
    });
  </script>

  <script>
    const fullToolbar = [
      [{
          font: []
        },
        {
          size: []
        }
      ],
      ['bold', 'italic', 'underline', 'strike'],
      [{
          color: []
        },
        {
          background: []
        }
      ],
      [{
          script: 'super'
        },
        {
          script: 'sub'
        }
      ],
      [{
          header: '1'
        },
        {
          header: '2'
        },
        'blockquote',
        'code-block'
      ],
      [{
          list: 'ordered'
        },
        {
          list: 'bullet'
        },
        {
          indent: '-1'
        },
        {
          indent: '+1'
        }
      ],
      [
        'direction',
        {
          align: []
        }
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
  </script>
@endsection
