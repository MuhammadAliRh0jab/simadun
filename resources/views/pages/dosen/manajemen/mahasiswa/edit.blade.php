@extends('layouts.dosen.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="col-lg-12 mb-4 h-100">
  <div class="d-flex align-items-center mb-3">
    <a href="#" class="btn btn-icon me-2 btn-primary" onClick="window.history.back();">
      <i class="ti ti-chevron-left"></i>
    </a>
    <div class="ms-3">
      <h4 class="card-header-title mb-0">
        Data {{ $mahasiswa->nama }}
      </h4>
      <p class="mb-0 text-muted">{{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}</p>
    </div>
  </div>

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
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card mb-3">
        <div class="card-header">
          <h4 class="card-header-title">Edit Data Mahasiswa</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('dosen.manajemen.mahasiswa.update', $mahasiswa->id) }}"
            id="updateMahasiswa">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="form-group mb-3">
              <label class="form-label mb-0"><b>Nama Lengkap</b></label>
              <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                value="{{ $mahasiswa->nama }}">
              @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- NIM --}}
            <div class="form-group mb-3">
              <label class="form-label mb-0"><b>NIM</b></label>
              <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim"
                value="{{ $mahasiswa->nim }}">
              @error('nim')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Judul --}}
            <div class="form-group mb-3">
              <label class="form-label mb-0"><b>Judul</b></label>
              <textarea class="form-control @error('judul') is-invalid @enderror" name="judul"
                rows="3">{{ $mahasiswa->judul }}</textarea>
              @error('judul')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- Promotor --}}
            <div class="form-group mb-3">
              <label class="form-label mb-0"><b>Promotor, CO-Promotor 1, dan CO-Promotor 2</b></label>
              <select class="form-select form-search @error('promotors') is-invalid @enderror" name="promotors[]"
                multiple id="promotors">
                @if ($mahasiswa->promotor1)
                <option value="{{ $mahasiswa->promotor_id }}" selected>{{ $mahasiswa->promotor1 }}</option>
                @endif
                @if ($mahasiswa->promotor2)
                <option value="{{ $mahasiswa->co_promotor1_id }}" selected>{{ $mahasiswa->promotor2 }}</option>
                @endif
                @if ($mahasiswa->promotor3)
                <option value="{{ $mahasiswa->co_promotor2_id }}" selected>{{ $mahasiswa->promotor3 }}</option>
                @endif
              </select>
              @error('promotors')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group mb-5">
              <button type="submit" class="btn btn-primary my-2">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- Tambahkan Sortable.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>

<script>
  $(document).ready(function() {
    // Inisialisasi Select2 dengan pencarian AJAX
    $(".form-search").select2({
      placeholder: "Pilih Promotor",
      maximumSelectionLength: 3,
      minimumInputLength: 3,
      tags: true, // Pastikan ini tidak menyebabkan reordering
      closeOnSelect: false, // Cegah Select2 menutup otomatis setelah memilih
      sorter: function(data) {
        return data; // Hindari pengurutan otomatis oleh Select2
      },
      ajax: {
        delay: 500,
        url: "{{ route('search.dosen') }}",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        data: function(params) {
          return {
            nipNikOrNama: params.term,
          };
        },
        processResults: function(response) {
          return {
            results: response.map(function(item) {
              return {
                id: item.id,
                nomor_induk: item.no_induk,
                text: item.nama,
              };
            })
          };
        },
        cache: true,
      }
    });


    function formatSearch(data) {
      if (data.loading) return data.text;
      return $('<span><h6 class="mb-0">' + data.text + '</h6>' +
              '<span class="text-muted">' + data.nomor_induk + '</span></span>');
    }

    function formatSelection(data) {
      return data.text;
    }

    function enableSorting() {
      var container = $(".select2-selection__rendered");
      Sortable.create(container[0], {
        animation: 150,
        onEnd: function(evt) {
          let newOrder = [];

          $(".select2-selection__rendered .select2-selection__choice").each(function() {
            let text = $(this).attr("title");
            let selectedOption = $("#promotors option").filter(function() {
              return $(this).text() === text;
            });

            if (selectedOption.length) {
              newOrder.push(selectedOption.val());
            }
          });

          // Susun ulang opsi dalam elemen <select>
          let select = $("#promotors");
          let options = select.find("option").sort(function(a, b) {
            return newOrder.indexOf($(a).val()) - newOrder.indexOf($(b).val());
          });

          select.empty().append(options); // Atur ulang opsi dalam <select>

          select.val(newOrder).trigger("change"); // Pastikan Select2 mendapatkan nilai terbaru
        }
      });
    }


    // Aktifkan sorting setiap kali Select2 berubah
    $(".form-search").on("select2:select select2:unselect", function() {
      setTimeout(enableSorting, 100);
    });

    // Aktifkan sorting saat halaman dimuat
    enableSorting();
  });
</script>
@endsection