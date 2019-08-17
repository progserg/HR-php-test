@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row text-center">
            <h1>Погода в Брянске</h1>
            <h3>{{ $weather }} °C</h3>
        </div>
    </div>
@endsection
