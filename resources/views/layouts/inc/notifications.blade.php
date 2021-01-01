@if(isset($message) && !is_null($message))
    <div class="alert alert-info">
        {{$message ?? null}}
    </div>
@endif
