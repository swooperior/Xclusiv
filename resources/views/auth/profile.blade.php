@extends('layouts.app')
@section('title', $user->username)
@section('hero')
    <div class="container-fluid hero-section p-5" style="background:#EEE url({{\App\Utilities\CDN::get_media(null, $user->settings['profile_settings']['cover_image'])}}) no-repeat center; background-size:cover;">
        <div class="col-12 d-flex justify-content-center">

            <img src="{{\App\Utilities\CDN::get_media(null, $user->settings['profile_settings']['profile_image'])
                ?? 'https://via.placeholder.com/50'}}"
                 class="ml-1 rounded-circle m-0 p-0"
                 height="300px"
                 width="300px"
            />
        </div>
        <div class="col-12 d-flex justify-content-center">
            <h1 style="color:{{$user->settings['profile_settings']['header_text_color']}};">{{$user->username}}</h1>
        </div>
        <div class="p-1 col-12 d-flex justify-content-center">
            <span style="color:#fff;" class="badge badge-pill {{$user->role == 0 ? 'badge-info' : 'badge-danger'}}">{{$user->role == 0 ? 'Member' : 'Administrator'}}</span>
        </div>
        <div class="col-12 d-flex justify-content-center" style="color:{{$user->settings['profile_settings']['header_text_color']}}!important;">
            <div style="text-align:center;">
                {!! strip_tags($user->bio, '<p></p>') !!}
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4" id="gallery">
                {{--                    {{ $user->getImages() }}--}}

                <div class="row">
                    <div class="col-6 pb-4">
                        <img class="img-fluid" src="http://via.placeholder.com/300">
                    </div>
                    <div class="col-6 pb-4">
                        <img class="img-fluid" src="http://via.placeholder.com/300">
                    </div>
                </div> <div class="row">
                    <div class="col-6">
                        <img class="img-fluid" src="http://via.placeholder.com/300">
                    </div>
                    <div class="col-6">
                        <img class="img-fluid" src="http://via.placeholder.com/300">
                    </div>
                </div>
            </div>

            <div class="col-md-8" id="wall">
                @php($posts = \App\Models\Post::where('owner', $user->id)
                    ->orderBy('id', 'desc')
                    ->paginate(15)
                )
                @if(!is_null($posts))
                    @foreach($posts as $post)
                        @if($post->visible(true))
                            <x-feed.post id="{{ $post->id }}" />
                        @endif
                    @endforeach
                @endif
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
