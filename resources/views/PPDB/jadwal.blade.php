@extends('layouts.app')

@section('title', 'Beranda - SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endsection

@section('content')

    @include('components.navbar')



     @include('components.footer')

@endsection

@section('scripts')
    <script src="{{ asset('js/homepage.js') }}"></script>
@endsection