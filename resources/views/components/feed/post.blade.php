<div class="col-md-12 mb-2">
    <a href="{{route('single-post', $post->id)}}">
        <div class="card">
            @if(!is_null($post->uri))
                <img class="{{(is_null($post->title) && is_null($post->body)) ? 'img-fluid' : 'card-img-top'}}" src="{{ \App\Utilities\CDN::get_media(null,$post->uri) }}">
            @endif
            <div class="card-body">
                @if(!is_null($post->title))
                    <h5 class="card-title">{{$post->title}}</h5>
                @endif
                @if(!is_null($post->body))
                    <p class="card-text">{{$post->body}}</p>
                @endif
            </div>
        </div>
    </a>
</div>

