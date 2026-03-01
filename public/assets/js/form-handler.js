axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
function addSelectChangeListener(id, callback) {
    const select = tomSelects.find(x => x.id == id);
    if (select) {
        select.select.on('change', function() {
            callback($(this).val());
        });
    }
}

function setSelectValue(id, value) {
    const select = tomSelects.find(x => x.id == id);
    if (select) {
        select.select.setValue(value);
    }
}

function initRadio() {
    $('.radio-box').each(function () {
        $(this).on('change', function () {
            $(this).parent().parent().parent().children().each(function() {
                $(this).removeClass('is-invalid');
            });
            $(this).parent().parent().parent().parent().find('.error-feedback').text('');
        });
    });
}
function initInputResetEventHandler() {
    initSelect();
    initRadio();
    addEventResetFeedback();
}
function addEventResetFeedback() {
    // loop through all input and select in form student
    $("#form-student input").each(function() {
        $(this).on('keyup', function() {
            // remove is invalid
            $(this).removeClass('is-invalid');
            // check if invalid feedback in neighbor
            const invalid_feedback = $(this).next('.invalid-feedback');
            if (invalid_feedback.length > 0) {
                invalid_feedback.text('');
            } else {
                $(this).parent().next('.invalid-feedback').text('');
            }
        });

        $(this).on('change', function() {
            // remove is invalid
            $(this).removeClass('is-invalid');
            // check if invalid feedback in neighbor
            const invalid_feedback = $(this).next('.invalid-feedback');
            if (invalid_feedback.length > 0) {
                invalid_feedback.text('');
            } else {
                $(this).parent().next('.invalid-feedback').text('');
            }
        });
    });
}

function submitForm(form, successFunction, errorFunction = null, clearForm = true, blob = false) {
    const submit_button = $(form).find('button[data-submit]');
    changeButtonLoading(submit_button, true);
    const form_instance = $(form);
    form_instance.find('input, select, textarea, button').attr('disabled', true);
    const formData = new FormData();
    $.each($(form).find('input, select, textarea'), function (key, value) {
        if ($(this).attr('type') == 'file') {
            const file = $(this)[0].files[0];
            if (file) {
                formData.append($(this).attr('name'), file);
            }
        } else if ($(this).attr('type') == 'checkbox') {
            if ($(this).is(':checked')) {
                formData.append($(this).attr('name'), $(this).val());
            }

        } else if ($(this).attr('type') == 'radio') {
            if ($(this).is(':checked')) {
                formData.append($(this).attr('name'), $(this).val());
            }
        } else {
            formData.append($(this).attr('name'), $(this).val());
        }
    });


    axios.post($(form).attr('action'), formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
        responseType: blob ? 'blob' : 'json'
    }).then(function (response) {
        if (clearForm) {
            $(form).trigger('reset');
        }
        if (successFunction) {
            successFunction(response);
        }
    }).catch(function (error) {
        if (errorFunction) {
            errorFunction(error);
        } else {
            if (error.response) {
                if (error.response.status == 422) {
                    showValidationErrors(error.response.data.errors);
                } else if (error.response.status == 419) {
                    window.location.reload();
                } else if (error.response.status == 500) {
                    SweetAlert.error('Terjadi kesalahan', 'Terjadi kendala pada server saat mengirim data. Kami mohon maaf atas ketidaknyamanan ini.');
                } else if (error.response.status == 400) {
                    try {
                        const data = error.response.data;
                        if (data.message) {
                            SweetAlert.error('Terjadi kesalahan', data.message);
                        }
                    } catch (e) {

                    }
                } else if (error.response.status == 403) {
                    SweetAlert.error('Tidak dapat mengirim data', 'Anda tidak memiliki akses untuk melakukan aksi');
                }
            } else if (error.request) {
                SweetAlert.error('Jaringan Tidak Tersedia', 'Kami tidak dapat terhubung ke server. Mohon periksa koneksi internet Anda.');
            } else {
                SweetAlert.error('Terjadi kesalahan', 'Terjadi kesalahan yang tidak diketahui saat mengirim data');
            }

        }
    }).finally(function () {
        form_instance.find('input, select, textarea, button').attr('disabled', false);
        changeButtonLoading(submit_button, false);
    });
}

function addSubmitFormHandler(form, successFunction, errorFunction = null, clearForm = true, blob = false) {
    $(form).submit(function (e) {
        e.preventDefault();

        const submit_button = $(this).find('button[type="submit"]');
        changeButtonLoading(submit_button, true);
        const form_instance = $(this);
        form_instance.find('input, select, textarea, button').attr('disabled', true);
        const formData = new FormData();
        $.each($(this).find('input, select, textarea'), function (key, value) {
            if ($(this).attr('type') == 'file') {
                const file = $(this)[0].files[0];
                if (file) {
                    formData.append($(this).attr('name'), file);
                }
            } else if ($(this).attr('type') == 'checkbox') {
                if ($(this).is(':checked')) {
                    formData.append($(this).attr('name'), $(this).val());
                }

            } else if ($(this).attr('type') == 'radio') {
                if ($(this).is(':checked')) {
                    formData.append($(this).attr('name'), $(this).val());
                }
            } else {
                formData.append($(this).attr('name'), $(this).val());
            }
        });


        axios.post($(this).attr('action'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            responseType: blob ? 'blob' : 'json'
        }).then(function (response) {
            if (clearForm) {
                $(form).trigger('reset');
            }
            if (successFunction) {
                successFunction(response);
            }
        }).catch(function (error) {
            if (errorFunction) {
                errorFunction(error);
            } else {
                if (error.response) {
                    if (error.response.status == 422) {
                        showValidationErrors(error.response.data.errors);
                    } else if (error.response.status == 419) {
                        window.location.reload();
                    } else if (error.response.status == 500) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: 'Terjadi kendala pada server saat mengirim data. Kami mohon maaf atas ketidaknyamanan ini.'
                        });
                    } else if (error.response.status == 400) {
                        try {
                            const data = error.response.data;
                            if (data.message) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan',
                                    text: data.message
                                });
                            }
                        } catch (e) {

                        }
                    }
                } else if (error.request) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Terjadi kesalahan saat mengirim data'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        text: 'Terjadi kesalahan yang tidak diketahui saat mengirim data'
                    });
                }

            }
        }).finally(function () {
            form_instance.find('input, select, textarea, button').attr('disabled', false);
            changeButtonLoading(submit_button, false);
        });
    });
}
function changeButtonLoading(button, loading = true, text = null) {
    if (text == null) {
        text = button.attr('data-text');
    }

    let loading_text = button.attr('data-text-loading')
    loading_text = loading_text === undefined ? text : loading_text;

    if (loading) {
        button.addClass('disabled');
        button.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> ' + loading_text);
    } else {
        button.removeClass('disabled');
        button.html(text);
    }
}

function showValidationError(input, message) {
    const parent = input.parent();
    if (parent.hasClass('input-group')) {
        parent.addClass('is-invalid');
        parent.parent().find('.invalid-feedback').html(message);
    } else {
        input.addClass('is-invalid');
        input.parent().find('.invalid-feedback').html(message);
    }
    input.on('keyup', function () {
        const inputParent = input.parent();
        if (inputParent.hasClass('input-group')) {
            parent.removeClass('is-invalid');
            parent.parent().find('.invalid-feedback').html('');
        } else {
            input.removeClass('is-invalid');
            input.parent().find('.invalid-feedback').html('');
        }
    });
}


function showValidationErrors(errors, type = "name") {
    $.each(errors, function (key, value) {
        if (type == "name") {
            showValidationError($('[name="' + key + '"]'), value + " ");
        } else if (type == "class") {
            showValidationError($('.' + key), value);
        }
    });
}

function addFormEditedEventHandler(form) {
    $(form + " :input").change(function() {
        $(form).data("changed", true);

        // bind
        $(window).on('beforeunload', function(e){
            e.preventDefault();
        });
    });

    $(form).submit(function(e) {
        $(form).data("changed", false);
        // unbind
        $(window).off('beforeunload');
    });
}

function populateFormData(form, url, successFunction = null, errorFunction = null) {
    form.find('input, textarea, button').attr('disabled', true);
    axios.get(url).then(function (response) {
        $.each(response.data.data, function (key, value) {
            if (value != null) {
                // check if ionput is checkbox
                if (form.find('[name="' + key + '"]').attr('type') == 'checkbox') {
                    if (value == 1) {
                        form.find('[name="' + key + '"]').prop('checked', true);
                    } else {
                        form.find('[name="' + key + '"]').prop('checked', false);
                    }
                } else {
                    form.find('[name="' + key + '"]').val(value);
                }
            }
        });
        if (successFunction) {
            successFunction(response);
        }
    }).catch(function (error) {
        if (errorFunction) {
            errorFunction(error);
        } else {
            if (error.response) {
                if (error.response.status == 404) {
                    SweetAlert.error('Terjadi Kesalahan', 'Kami tidak menemukan data yang Anda cari');
                } else if (error.response.status == 419) {
                    window.location.reload();
                } else {
                    SweetAlert.error('Terjadi Kesalahan', 'Terjadi kesalahan yang tidak diketahui saat memuat data');
                }
            } else if (error.request) {
                SweetAlert.error('Jaringan Tidak Tersedia', 'Kami tidak dapat terhubung ke server. Mohon periksa koneksi internet Anda.');
            } else {
                SweetAlert.error('Terjadi Kesalahan', 'Mohon maaf, terjadi kesalahan yang tidak diketahui saat memuat data');
            }

            // close form
            form.closest('.modal').modal('hide');
        }
    }).finally(function () {
        form.find('input, textarea, button').attr('disabled', false);
    });
}

function populate(modal, url) {
    // add modal overlay inside modal-content
    $(modal).find('.modal-content').append('<div class="overlay" style="border: none;"><div class="spinner-border text-white" role="status"><span class="visually-hidden"> Loading...</span></div></div>');
    const form = $(modal).find('form');
    form.trigger('reset');
    form.find('.invalid-feedback').html('');
    form.find('.is-invalid').removeClass('is-invalid');
    // change the form url action
    form.attr('action', url);
    $(modal).modal('show');
    populateFormData(form, url, function () {
        // remove modal overlay
        $(modal).find('.modal-content').find('.overlay').remove();
    }, function (error) {
        $(modal).find('.modal-content').find('.overlay').remove();
        setTimeout(function () {
            $(modal).modal('hide');
        }, 500);
        SweetAlert.error('Terjadi Kesalahan', 'Terjadi kesalahan saat memuat data');
    });
}