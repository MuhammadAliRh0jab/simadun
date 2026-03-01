$("#dosen_search").select2({
    placeholder: "Pilih Dosen Penguji",
    maximumSelectionLength: 3,
    minimumInputLength: 2,
    language: {
        maximumSelected: function(e) {
            return "Anda hanya dapat memilih maksimal " + e.maximum + " dosen";
        },
        inputTooShort: function(e) {
            return "Masukkan minimal 2 karakter untuk mencari dosen";
        },
        noResults: function() {
            return "Tidak ada dosen yang ditemukan";
        },
        searching: function() {
            return "Mencari...";
        }
    },
    ajax: {
        delay: 500,
        url: $("#dosen_search").data("search-dosen-url"),
        type: "POST", // Ensure POST is used
        headers: {
            "X-CSRF-TOKEN": $("#dosen_search").data("csrf-token")
        },
        data: function(params) {
            return {
                nipNikOrNama: params.term
            };
        },
        processResults: function(response) {
            if (!response || response.error) {
                console.error("Error in response:", response);
                return { results: [] };
            }
            var data = response.map(function(item) {
                return {
                    id: item.id,
                    nomor_induk: item.no_induk,
                    text: item.nama
                };
            });
            return {
                results: data
            };
        },
        cache: true,
        error: function(xhr, status, error) {
            console.error("AJAX error:", status, error, xhr);
        }
    },
    templateResult: formatSearch,
    templateSelection: formatSelection
});

function formatSearch(data) {
    if (data.loading) {
        return data.text;
    }
    var $markup = $(
        '<span>' +
            '<h6 class="mb-0">' +
            data.text +
            '</h6>' +
            '<span class="text-muted">' +
            (data.nomor_induk || 'N/A') +
            '</span>' +
        '</span>'
    );
    return $markup;
}

function formatSelection(data) {
    return data.text || data.id;
}