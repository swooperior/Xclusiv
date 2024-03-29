@php($user = $user ?? \Illuminate\Support\Facades\Auth::user())

@extends('layouts.app')
@section('title', "Fans - ".$user->username)
@section('content')
    <div class="container">
        <a href="{{route('fans.grant')}}" class="btn btn-primary">Manually add Fan</a>
        <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <h5 class="card-header">Statistics</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Fans: {{count($data['fans'])}}</h5>
                        </div>
                        <div class="col-md-6">
                            <h5>Sales: {{count($data['sales'])}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Recent Fans</h5>
                    <div class="card-body">

                        @php($data['fans'] = array_reverse($data['fans']))
                        <ul class="list-group">

                        @foreach($data['fans'] as $fan)
                            @php($fan = \App\Models\User::where('id',$fan)->first())

                            {{--                        Replace with user component--}}
                            <li class="list-group-item">
                                <a href="{{route('user.profile',$fan->username)}}">{{$fan->username}}</a>
                            </li>
                            {{--                        End replace--}}
                        @endforeach
                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Notifications</h5>
                    <div class="card-body">
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
