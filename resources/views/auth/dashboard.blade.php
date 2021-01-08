@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Welcome back!') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav">
                                <li>
                                    Option
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Wall') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($posts as $post)
                                    <x-feed.post id="{{ $post->id }}" />
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
