@if(isset($message) && !is_null($message))
    <div class="alert alert-info">
        {{$message ?? null}}
    </div>
@endif
@if(isset($error) && !is_null($error))
    <div class="alert alert-danger">
        {{$error ?? null}}
    </div>
@endif
