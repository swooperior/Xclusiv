@extends('layouts.app')
@section('content')
    @if($post != null)
        @php($user = \Illuminate\Support\Facades\Auth::user())
        @php($owner = \App\Models\User::find($post->owner))

        @php($access = in_array($user->id, $owner->whitelist))
        @php($admin = $owner == $user ? true : false)


        @if($access || $admin)
            <div class="card">
                <img class="card-img-top" src="{{\App\Utilities\CDN::get_media(null, $post->uri)}}">
                <div class="card-title">
                    {{$post->title}}
                </div>
                <div class="card-body">
                    {{$post->body}}
                </div>
            </div>
        @else
            <div class="jumbotron alert-danger">
                <h1>You dont have access to this content.</h1>
            </div>

        @endif











    @else
        <div class="jumbotron">
            <h1>Post not found.</h1>
        </div>
    @endif
@endsection

