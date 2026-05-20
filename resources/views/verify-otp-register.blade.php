@extends('layouts.app')

@section('title', 'Verifikasi OTP')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/verifyotp.css') }}">
@endsection

@section('content')

<div class="auth-wrapper">
    <div class="auth-card">

        <div class="auth-logo">
            <img src="{{ asset('image/Logo2.jpeg') }}" alt="Logo">
        </div>

        <h1 class="auth-card-title">
            Verifikasi OTP
        </h1>

        <p class="form-hint">
            Masukkan 6 digit kode OTP yang dikirim ke email anda.
        </p>

        {{-- ERROR --}}
        @if(session('error'))
            <x-alert-error>
                {{ session('error') }}
            </x-alert-error>
        @endif

        {{-- SUCCESS --}}
        @if(session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- TIMER --}}
        <div class="otp-timer">
            OTP akan expired dalam
            <span id="countdown">05:00</span>
        </div>

        {{-- FORM OTP --}}
        <form method="POST" action="{{ route('register.otp.verify') }}">
            @csrf

            <div class="form-group">

                <label class="form-label">Kode OTP</label>

                <div class="otp-wrapper">
                    <input type="text" maxlength="1" class="otp-box" required>
                    <input type="text" maxlength="1" class="otp-box" required>
                    <input type="text" maxlength="1" class="otp-box" required>
                    <input type="text" maxlength="1" class="otp-box" required>
                    <input type="text" maxlength="1" class="otp-box" required>
                    <input type="text" maxlength="1" class="otp-box" required>
                </div>

                <input type="hidden" name="otp" id="otp-value">

            </div>

            <button type="submit" class="btn-primary">
                Verifikasi OTP
            </button>

        </form>

        {{-- RESEND OTP --}}
        <div class="auth-footer">
            <form method="POST" action="{{ route('register.resend-otp') }}">
                @csrf
                <button type="submit" class="resend-btn">
                    Kirim ulang OTP
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    /*
    |--------------------------------------------------------------------------
    | OTP INPUT
    |--------------------------------------------------------------------------
    */

    const inputs = document.querySelectorAll('.otp-box');
    const hiddenInput = document.getElementById('otp-value');

    inputs.forEach((input, index) => {

        input.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');

            if (e.target.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            updateOTP();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    function updateOTP() {
        hiddenInput.value = [...inputs]
            .map(input => input.value)
            .join('');
    }

    /*
    |--------------------------------------------------------------------------
    | COUNTDOWN TIMER 5 MENIT
    |--------------------------------------------------------------------------
    */

    let time = 300;
    const countdown = document.getElementById('countdown');

    const timer = setInterval(() => {

        let minutes = Math.floor(time / 60);
        let seconds = time % 60;

        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        countdown.textContent = `${minutes}:${seconds}`;

        if (time <= 0) {
            clearInterval(timer);
            countdown.textContent = 'Expired';
        }

        time--;

    }, 1000);
</script>

@endsection