@php($user = $user ?? \Illuminate\Support\Facades\Auth::user())
@extends('layouts.app')
@section('title', "Grant Access - ".$user->username)
@section('content')
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{route('fans.grant')}}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <input list="fans" class="form-control" type="text" id="fan" name="fan">
                        <datalist id="fans">
                            @foreach(\App\Models\User::where('settings->account_settings->account_visibility', '1')
                                                        ->get() as $user)
                                <option value="{{$user->username}}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group col-md-6">
                        <input class="btn btn-primary w-100" type="submit" value="Grant Access">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
