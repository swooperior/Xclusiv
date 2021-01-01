@extends('layouts.app')
@section('content')
    @if($post != null)
        @if($post->visible())
            <div class="row">
                <div class="col-md-6">
                    <img class="img-fluid" src="{{\App\Utilities\CDN::get_media(null, $post->uri)}}">
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <p class="card-text"> {!! strip_tags($post->body, '<b><i><u><h1><h2><h3><h4><h5><p><table><li><tr><td><th>') !!} </p>
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

