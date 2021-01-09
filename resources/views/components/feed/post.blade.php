<div class="col-md-12 mb-2">

        <div class="card" id="{{!is_null($post) ? 'post-'.$post->id : ''}}">

            @if(!is_null($post->uri))
                <a href="#" data-featherlight="#{{'post-'.$post->id}}">
                    <img class="{{(is_null($post->title) && is_null($post->body)) ? 'img-fluid' : 'card-img-top'}}"
                         id="{{$post->id}}"
                         src="{{ \App\Utilities\CDN::get_media(null,$post->uri) }}">
                </a>
            @endif
            <div class="card-body">
{{--                Replace this with user component later.--}}
                <a href="{{route('user.profile', $owner->username)}}">
                    {{$owner->username}}
                </a>
{{--                End replace.--}}
                <h5>{{$post->created_at->diffForHumans()}}</h5>
                @if(!is_null($post->title))
                    <a href="{{route('single-post', $post->id)}}">
                        <h5 class="card-title">{{$post->title}}</h5>
                    </a>
                @endif
                @if(!is_null($post->body))
                    <p class="card-text">{!! \Illuminate\Support\Str::limit(strip_tags($post->body, '<b><i><u><h1><h2><h3><h4><h5><p><table><li><tr><td><th>'), 150, $end='...') !!}</p>
                @endif
                @if($post->user == \Illuminate\Support\Facades\Auth::user())
                    <a href="{{route('post.edit', $post->id) }}" class="btn btn-dark">Edit Post</a>
                @endif
            </div>
        </div>

</div>

