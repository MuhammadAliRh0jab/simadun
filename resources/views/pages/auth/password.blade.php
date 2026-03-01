@extends('layouts.guest.app')
@section('title', 'Ganti kata sandi')

@section('styles')
  <style>
    .authentication-wrapper {
      display: flex;
      flex-basis: 100%;
      min-height: 100vh;
      width: 100%
    }

    .authentication-wrapper .authentication-inner {
      width: 100%
    }

    .authentication-wrapper.authentication-basic {
      align-items: center;
      justify-content: center
    }

    .authentication-wrapper.authentication-basic .card-body {
      padding: 2rem
    }

    .authentication-wrapper.authentication-cover {
      align-items: flex-start
    }

    .authentication-wrapper.authentication-cover .authentication-inner {
      height: 100%;
      margin: auto 0
    }

    .authentication-wrapper.authentication-cover .authentication-inner .auth-cover-bg {
      width: 100%;
      margin: 2rem 0 2rem 2rem;
      height: calc(100vh - 4rem);
      border-radius: 1.125rem;
      position: relative
    }

    .authentication-wrapper.authentication-cover .authentication-inner .auth-cover-bg .auth-illustration {
      max-height: 65%;
      z-index: 1
    }

    .authentication-wrapper.authentication-cover .authentication-inner .platform-bg {
      position: absolute;
      width: 100%;
      bottom: 0%;
      left: 0%;
      height: 35%
    }

    .authentication-wrapper.authentication-cover .authentication-inner .auth-multisteps-bg-height {
      height: 100vh
    }

    .authentication-wrapper.authentication-cover .authentication-inner .auth-multisteps-bg-height>img:first-child {
      z-index: 1
    }

    .authentication-wrapper.authentication-basic .authentication-inner {
      max-width: 400px;
      position: relative
    }

    .authentication-wrapper.authentication-basic .authentication-inner:before {
      width: 238px;
      height: 233px;
      content: " ";
      position: absolute;
      top: -55px;
      left: -40px;
      background-image: url("data:image/svg+xml,%3Csvg width='239' height='234' viewBox='0 0 239 234' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='88.5605' y='0.700195' width='149' height='149' rx='19.5' stroke='%237367F0' stroke-opacity='0.16'/%3E%3Crect x='0.621094' y='33.761' width='200' height='200' rx='10' fill='%237367F0' fill-opacity='0.08'/%3E%3C/svg%3E%0A")
    }

    @media(max-width: 575.98px) {
      .authentication-wrapper.authentication-basic .authentication-inner:before {
        display: none
      }
    }

    .authentication-wrapper.authentication-basic .authentication-inner:after {
      width: 180px;
      height: 180px;
      content: " ";
      position: absolute;
      z-index: -1;
      bottom: -30px;
      right: -56px;
      background-image: url("data:image/svg+xml,%3Csvg width='181' height='181' viewBox='0 0 181 181' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='1.30469' y='1.44312' width='178' height='178' rx='19' stroke='%237367F0' stroke-opacity='0.16' stroke-width='2' stroke-dasharray='8 8'/%3E%3Crect x='22.8047' y='22.9431' width='135' height='135' rx='10' fill='%237367F0' fill-opacity='0.08'/%3E%3C/svg%3E")
    }

    @media(max-width: 575.98px) {
      .authentication-wrapper.authentication-basic .authentication-inner:after {
        display: none
      }
    }

    .authentication-wrapper .auth-input-wrapper .auth-input {
      max-width: 50px;
      padding-left: .4rem;
      padding-right: .4rem;
      font-size: 150%
    }

    @media(max-height: 636px) {
      .auth-multisteps-bg-height {
        height: 100% !important
      }
    }

    @media(max-width: 575.98px) {
      .authentication-wrapper .auth-input-wrapper .auth-input {
        font-size: 1.125rem
      }
    }

    #twoStepsForm .fv-plugins-bootstrap5-row-invalid .form-control {
      border-color: #ea5455
    }

    .light-style .authentication-wrapper.authentication-bg {
      background-color: #fff
    }

    .light-style .auth-cover-bg-color {
      background-color: #f8f7fa
    }

    .dark-style .authentication-wrapper.authentication-bg {
      background-color: #2f3349
    }

    .dark-style .auth-cover-bg-color {
      background-color: #25293c
    }
  </style>
  <link rel="stylesheet" href="assets/vendor/libs/@form-validation/form-validation.css" />
@endsection

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Reset Password -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-4 mt-2">
              <a href="index.html" class="app-brand-link gap-2">
                <span class="app-brand-text demo text-body fw-bold ms-1">SIMADUN</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1 pt-2">Ganti Kata Sandi 🔒</h4>
            <p class="mb-4">Untuk <span class="fw-bolder">{{ Auth::guard('mahasiswa')->user()->nama ?? Auth::guard('dosen')->user()->nama }}</span>
              <br>
              <small class="text-muted">Harap mengganti kata sandi default anda untuk keamanan akun anda</small>
            </p>
            <form id="formAuthentication" action="{{ route('auth.password.update') }}" method="POST"
              class="fv-plugins-bootstrap5 fv-plugins-framework">
              @csrf
              <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                <label class="form-label @error('password') text-danger @enderror" for="password">Password</label>
                <div class="input-group input-group-merge has-validation">
                  <input type="password" id="password" class="form-control" name="password" placeholder="············"
                    aria-describedby="password">
                </div>
              </div>
              <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <div class="input-group input-group-merge has-validation">
                  <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    placeholder="············" aria-describedby="password">
                </div>
              </div>
              {{-- error any paswoord --}}
              @error('password')
                <div class="fv-plugins
                fv-plugins-message-container">
                  <div data-field="password" data-validator="notEmpty"
                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                    {{ $message }}</div>
                </div>
              @enderror
              <button class="btn btn-primary d-grid w-100 mb-3 waves-effect waves-light">
                Ganti kata sandi
              </button>
              <div class="text-center">
                <a href="{{ route('auth.login') }}" class="text-muted text-underline">
                  Lewati
                  <i class="ti ti-chevron-right scaleX-n1-rtl"></i>
                </a>
              </div>
              <input type="hidden">
            </form>
          </div>
        </div>
        <!-- /Reset Password -->
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ url('assets/vendor/libs/@form-validation/popular.js') }}"></script>
  <script src="{{ url('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
  <!-- AutoFocus plugin, automatically focus on the first invalid input  -->
  <script src="{{ url('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
  <script>
    $(document).ready(function() {
      var formAuthentication = $("#formAuthentication");
      console.log(formAuthentication);
      if (formAuthentication.length > 0) {
        FormValidation.formValidation(formAuthentication.get(0), {
          fields: {
            password: {
              validators: {
                notEmpty: {
                  message: "Masukkan kata sandi anda"
                },
                stringLength: {
                  min: 6,
                  message: "Kata sandi harus lebih dari 6 karakter"
                },
                regexp: {
                  regexp: /^(?=.*[A-Z])(?=.*\d)/,
                  message: "Kata sandi harus mengandung setidaknya satu huruf besar dan satu angka"
                }

              }
            },
            "password_confirmation": {
              validators: {
                notEmpty: {
                  message: "Konfiramsi password"
                },
                identical: {
                  compare: function() {
                    return formAuthentication.find('[name="password"]').val();
                  },
                  message: "Kata sandi tidak sama"
                },
                stringLength: {
                  min: 6,
                  message: "Kata sandi harus lebih dari 6 karakter"
                },
                regexp: {
                  regexp: /^(?=.*[A-Z])(?=.*\d)/,
                  message: "Kata sandi harus mengandung setidaknya satu huruf besar dan satu angka"
                }
              }
            },
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger,
            bootstrap5: new FormValidation.plugins.Bootstrap5({
              eleValidClass: "",
              rowSelector: ".mb-3"
            }),
            submitButton: new FormValidation.plugins.SubmitButton,
            defaultSubmit: new FormValidation.plugins.DefaultSubmit,
            autoFocus: new FormValidation.plugins.AutoFocus
          },
          init: function(e) {
            e.on("plugins.message.placed", function(e) {
              if ($(e.element).parent().hasClass("input-group")) {
                $(e.element).parent().after(e.messageElement);
              }
            });
          }
        });

        $(".numeral-mask").each(function() {
          new Cleave(this, {
            numeral: true
          });
        });
      }
    });
  </script>
@endsection
