@extends('layouts.guest.app')
@section('title', 'Lupa Kata Sandi | SIMADUN')
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

    .auth-cover-bg-color {
      max-height: 100vh;
      overflow: hidden;
    }

    .auth-cover-bg-color img {
      object-fit: cover;
      width: 100%;
      height: 100%;
      object-position: center;
    }
    .auth-cover-bg-color::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-blend-mode: multiply;
    background-image: linear-gradient(120deg,#377dff 0,#00a2ff07 100%);
    opacity: .4;
    }
  </style>
@endsection
@section('content')
  <div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row">
      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center0">
          <img src="{{ url('/assets/img/backgrounds/um.jpg') }}" alt="auth-login-cover" class="img-fluid ">
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Login -->
      <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
          <!-- Logo -->
          <div class="app-brand mb-4">
            <a href="/" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">

              </span>
            </a>
          </div>
          <!-- /Logo -->
          <h3 class="mb-1">Lupa Kata Sandi</h3>
          <p class="mb-4">
            Gunakan email UM Anda untuk mendapatkan link lupa kata sandi
          </p>

          {{-- notification --}}
            @if (session('status'))
                <div class="alert alert-info alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <span>{{ session('status') }}</span>
                </div>
            @endif

          <form id="formAuthentication" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('forgot.password.act') }}" method="POST">
            @csrf
            <div class="mb-3 fv-plugins-icon-container">
              <label for="email" class="form-label">Email UM</label>
              <input type="email" class="form-control @if ($errors->has('creds')) is-invalid @endif" required id="email" name="email" value="{{ old('email') }}" autofocus="" placeholder="@um.ac.id atau @students.um.ac.id">
              <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
            </div>

            <div class="mb-3">
              <span>Sudah ingat sandi Anda?</span>
              <a href="{{ route('auth.login') }}" class="text-h-primary fw-bold">
                Masuk
              </a>
            </div>

            <button type="submit" class="btn btn-primary d-grid w-100 waves-effect waves-light">
              Kirim
            </button>
          </form>
        </div>
      </div>
      <!-- /Login -->
    </div>
  </div>
@endsection