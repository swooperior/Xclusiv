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
                    <div class="form-group">
                        <h5>Region Settings</h5>
                        <label for="region_lock_chk">
                            Region Lock
                        </label>
                        <input type="checkbox" id="region_lock_chk" name="region_lock_chk" value="1" {{$user->settings['privacy_settings']['region_lock'] == 1 ? "checked" : ""}}>
                        <input type="hidden" id="region_lock" name="region_lock" value="{{$user->settings['privacy_settings']['region_lock']}}">
                        <p style="font-size:small;font-style:italic;">
                            Region locking will make your profile and content unavailable to users in particular
                            regions based on your provided settings.  <span style="font-weight:bold;">Important:</span>

                        </p>
                    </div>
                    <div class="form-group hide" id="region_settings">
                        <label for="region_select">Enter Region to Lock Out</label>
{{--                        ToDo; Add Datalist autoselect from some geolocation search api.  --}}
                        <input type="text" name="region_select" id="region_select" placeholder="Enter Region">
                        <p style="font-size:small;font-style:italic;">
                            Accepts postcodes, towns/cities, counties, countries, etc.
                        </p>
                        <table class="table table-dark">
                            <tr>
                                <th>
                                    Blocked Region
                                </th>
                                <th class="d-flex justify-content-center">
                                    Delete
                                </th>
                            </tr>

                        @if(isset($user->settings['privacy_settings']['excluded_locations']))
                                @foreach($user->settings['privacy_settings']['excluded_locations'] as $location)
                                    <tr>
                                        <td>
                                            {{$location}}
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <input type="checkbox" name="del_chk[]" value="{{$location}}">
                                        </td>
                                    </tr>
                                @endforeach
                        @endif
                        </table>
                    </div>
                    <hr>
                    <div class="form-group">
                        <h5>Post Settings</h5>
                        <label for="default_post_visibility">
                            Default Post Visibility
                        </label>
                        <select name="default_post_visibility" id="default_post_visibility">
                            <option value="0" {{$user->settings['privacy_settings']['default_post_visibility'] == 0 ? 'selected' : ''}}>Exclusive</option>
                            <option value="1" {{$user->settings['privacy_settings']['default_post_visibility'] == 1 ? 'selected' : ''}}>Public</option>
                            <option value="2" {{$user->settings['privacy_settings']['default_post_visibility'] == 2 ? 'selected' : ''}}>Pay to View</option>
                        </select>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <input type="submit" value="Save Changes" class="p-2 btn btn-primary">
                    </div>
                </form>
        </div>
    </div>
    </div>

@endsection
@section('body_bottom_scripts')
    <script>
        $( document ).ready(function(){
            const $chk_regionlock = $('#region_lock_chk');
            const $region_lock = $('#region_lock');
            const $region_settings = $('#region_settings');
            const regionLockCheck = function(){
                if($chk_regionlock.is(':checked')){
                    $region_lock.val(1);
                    $region_settings.show();
                }else{
                    $region_settings.hide();
                    $region_lock.val(0);
                }
            }

            $chk_regionlock.on('input', function(){
                regionLockCheck();
            });

            regionLockCheck();
        });
    </script>
@endsection

