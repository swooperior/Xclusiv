@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h2>Privacy Settings</h2>
            </div>
            <div class="card-body">
                <form action="{{route('settings.privacy')}}" method="POST" enctype="multipart/form-data">
                    @csrf


                    <div class="d-flex flex-row-reverse">
                        <input type="submit" value="Save Changes" class="p-2 btn btn-primary">
                    </div>
                </form>
        </div>
    </div>
    </div>

@endsection

