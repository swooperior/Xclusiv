@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h2>Settings</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <a class="btn btn-secondary w-100" href="{{route('settings.profile')}}">Profile Settings</a>
                    </div>
                    <div class="col-sm-12 col-md-5 ">
                        <p><small>Edit your profile picture, header and about section</small>.</p>
                    </div>
                </div>
            <div class="row">
                <div class="col-sm-12 col-md-5 ">
                    <a class="btn btn-secondary w-100" href="{{route('settings.account')}}">Account Settings</a>
                </div>
                <div class="col-sm-12 col-md-5 ">
                    <p><small>Update your email or password.</small></p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-5 ">
                    <a class="btn btn-secondary w-100" href="{{route('settings.privacy')}}">Privacy Settings</a>
                </div>
                <div class="col-sm-12 col-md-5 ">
                    <p><small>Edit your privacy settings, blacklist countries, allow/revoke user access.</small></p>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
