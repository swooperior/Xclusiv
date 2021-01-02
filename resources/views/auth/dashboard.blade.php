@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Welcome back!') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul>
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
                                @if($post->visible())
                                    <x-feed.post id="{{ $post->id }}" />
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
