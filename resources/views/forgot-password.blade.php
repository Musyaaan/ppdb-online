@extends('layouts.app')

@section('title', 'Lupa Password - SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/forgotpass.css') }}">
@endsection

@section('content')

<div class="auth-wrapper">
    <div class="auth-card">

        {{-- Logo --}}
        <div class="auth-logo">
            <img src="{{ asset('image/Logo2.jpeg') }}" alt="Logo SD Negeri Legok III">
        </div>

        {{-- Title --}}
        <h1 class="auth-card-title">
            Lupa Password
        </h1>

        {{-- Description --}}
        <p class="form-hint" style="text-align:center; margin-bottom:20px;">
            Masukkan email yang terdaftar untuk menerima kode verifikasi OTP.
        </p>

        {{-- Success Message --}}
        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <x-alert-error>
                {{ session('error') }}
            </x-alert-error>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <x-alert-error>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </x-alert-error>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('forgot-password.send') }}">
            @csrf

            <div class="form-group">

                <label class="form-label" for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-input"
                    placeholder="Masukkan email anda"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                >

            </div>

            <button type="submit" class="btn-primary">
                Kirim Kode Verifikasi
            </button>

        </form>

        {{-- Footer --}}
        <div class="auth-footer">

            <a href="{{ route('login') }}">
                Kembali ke login
            </a>

            <div class="copyright">
                <p>
                    &copy; {{ date('Y') }} SD Negeri Legok III.
                    All rights reserved.
                </p>
            </div>

        </div>

    </div>
</div>

@endsection