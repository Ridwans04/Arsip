@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-basic px-2">
  <div class="auth-inner my-2">
    <!-- Register basic -->
    <div class="card mb-0">
      <div class="card-body">
        <a href="#" class="brand-logo">
          <img src="{{asset('images/logo/Logo.png')}}" width="50" height="20" class="img-fluid me-1 mb-2" alt="Brand logo">
          <h2 class="brand-text text-primary mt-1 "> Arsip RJ</h2>
        </a>
        <p class="card-text mb-2">Registrasi Disini</p>

        <form class="auth-register-form mt-2" action="{{route('registrasi_store')}}" method="POST">
          @csrf
          <div class="mb-1">
            <label for="register-username" class="form-label">Username</label>
            <input
              type="text"
              class="form-control"
              id="register-username"
              name="username"
              placeholder="Nama Anda"
              aria-describedby="register-username"
              tabindex="1"
              autofocus
            />
          </div>
          <div class="mb-1">
            <label for="register-username" class="form-label">Institusi</label>
            <input
              type="text"
              class="form-control"
              id="register-username"
              name="institusi"
              placeholder="Nama Institusi"
              aria-describedby="register-username"
              tabindex="1"
              autofocus
            />
          </div>
          <div class="mb-1">
            <label for="register-username" class="form-label">Level</label>
            <input
              type="text"
              class="form-control"
              id="register-username"
              name="level"
              placeholder="Nama Anda"
              aria-describedby="register-username"
              tabindex="1"
              autofocus
            />
          </div>
          <div class="mb-1">
            <label for="register-password" class="form-label">Password</label>

            <div class="input-group input-group-merge form-password-toggle">
              <input
                type="password"
                class="form-control form-control-merge"
                id="register-password"
                name="password"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="register-password"
                tabindex="3"
              />
              <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
            </div>
          </div>
          <button class="btn btn-primary w-100" tabindex="5">Daftar</button>
        </form>
    <!-- /Register basic -->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/auth-register.js')}}"></script>
@endsection
