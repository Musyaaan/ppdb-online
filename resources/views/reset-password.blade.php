@extends('layouts.app')

@section('title', 'Reset Password')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/resetpass.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')

<div class="auth-wrapper">
    <div class="auth-card">

        <div class="auth-logo">
            <img src="{{ asset('image/Logo2.jpeg') }}" alt="Logo">
        </div>

        <h1 class="auth-card-title">
            Password Baru
        </h1>

        {{-- VALIDATION ERROR --}}
        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- SESSION ERROR --}}
        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('reset.password.post') }}">
            @csrf

            {{-- Password Baru --}}
            <div class="form-group">

                <label class="form-label">
                    Password Baru
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-input"
                        placeholder="Masukkan password baru"
                        required
                    >

                    <span
                        class="toggle-password"
                        onclick="togglePassword('password', this)"
                    >
                        <i class="fa-regular fa-eye"></i>
                    </span>

                </div>

            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-group">

                <label class="form-label">
                    Konfirmasi Password
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-input"
                        placeholder="Ulangi password"
                        required
                    >

                    <span
                        class="toggle-password"
                        onclick="togglePassword('password_confirmation', this)"
                    >
                        <i class="fa-regular fa-eye"></i>
                    </span>

                </div>

            </div>

            <button type="submit" class="btn-primary">
                Simpan Password
            </button>

        </form>

    </div>
</div>

<script>
    function togglePassword(id, element) {

        const input = document.getElementById(id);
        const icon = element.querySelector('i');

        if (input.type === "password") {

            input.type = "text";

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        } else {

            input.type = "password";

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

@endsection