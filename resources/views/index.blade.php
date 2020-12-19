@extends('layouts.app')
@section('content')
    <div class="h-100 d-flex flex-column">
        <div class="jumbotron jumbotron-fluid shadow-sm">
            <div class="d-flex flex-column align-items-center m-3">
                <h1>Welcome to {{ config('app.name') }}</h1>
                <p>Share content exclusively with your fans!</p>
            </div>
            <div class="d-flex justify-content-around align-items-center">
                <a class="btn btn-lg btn-primary" href="/login">Log In</a>
                <a class="btn btn-lg btn-secondary" href="/register">Register</a>
            </div>
        </div>
    </div>


@endsection
