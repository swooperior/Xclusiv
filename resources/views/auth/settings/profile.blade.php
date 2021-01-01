@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h2>Profile Settings</h2>
            </div>
            <div class="card-body">
                <form action="{{route('settings.profile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <h5>Header images</h5>
                        <label for="profile_image">Profile Image</label>
                        <input type="file" class="form-control-file" name="profile_image" value="{{$user->email}}">
                    </div>

                    <div class="form-group">
                        <label for="cover_image">Cover Image</label>
                        <input type="file" class="form-control-file" name="cover_image">
                    </div>
                    <div class="form-group">
                        <h5>Header text colour</h5>
                        <label for="light">Light</label>
                        <input type="radio" name="text_color" id="light" value="light">

                        <label for="dark">Dark
                        <input type="radio" name="text_color" id="dark" value="dark">
                        </label>
                    </div>

                    <div class="form-group">
{{--                        WYSIWYG EDITOR HERE --}}
                        <label for="bio">Bio (<span class="bioWordCount">300</span>/300)</label>
                        <textarea
                            name="bio"
                            id="bio"
                            rows="5"
                            class="form-control bio"
                            maxlength="300"
                        >{{$user->bio}}</textarea>
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
                var $ckeditor = ClassicEditor
                    .create( document.querySelector( '#bio' ) )
                    .catch( error => {
                        console.error( error );
                    } );
            </script>

            <script>
                var $wc = $('.bioWordCount');
                var $bio = $('.bio');


                $( document ).ready(function(){
                    $bio.on('change input', function(){
                        bioWordCount();
                    });
                    bioWordCount();
                });
                //Update the remaining character limit
                function bioWordCount(){
                    var max = 300;
                    var count = $bio.val().length;

                    $wc.html(count);
                }
            </script>
@endsection

