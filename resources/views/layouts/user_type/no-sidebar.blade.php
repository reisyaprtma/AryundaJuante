@extends('layouts.app')

@section('content')
<div class="main-content position-relative max-height-vh-100 h-100">
    <div class="container-fluid py-4">
        @yield('content')
    </div>
</div>
@endsection
