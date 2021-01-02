@extends('layouts.app')
@section('content')
    <div class="container-fluid">
    @if(isset($_POST['file']))
{{--        Display a loading bar with the upload progress.--}}
        <h3>Uploading...</h3>
    @else
        <div class="row">
            <h1>New Post</h1>
        </div>
        <form method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="file">Select File:</label>
                        <input class="form-control-file" type="file" name="file" id="file">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Post Title:</label>
                        <input class="form-control" type="text" name="title" id="title">
                    </div>
                    <div class="form-group">
{{--                        Change for wysiwyg text entry--}}
                        <label for="body">Post Body:</label>
                        <textarea id="body_text" name="body_text"></textarea>
                    </div>
                    <div class="row">
                    <div class="form-group col">
                        <label for="privacy">Privacy Setting </label>
                            <select id="privacy" name="privacy">
                                <option value="0" {{$user->settings['privacy_settings']['default_post_visibility'] == 0 ? 'selected' : ''}}>Exclusive</option>
                                <option value="1" {{$user->settings['privacy_settings']['default_post_visibility'] == 1 ? 'selected' : ''}}>Public</option>
                                <option value="2" {{$user->settings['privacy_settings']['default_post_visibility'] == 2 ? 'selected' : ''}}>Purchasable</option>
                            </select>
                    </div>
                    <div class="form-group col" id="content-price">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&pound;</span>
                            </div>
                            <input class="form-control" type="number" step="0.01" id="price" name="price">
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Upload">
                    </div>
                </div>
            </div>
        </form>
    @endif
    </div>
@endsection
@section('body_bottom_scripts')
    <script>
        var $ckeditor = ClassicEditor
            .create( document.querySelector( '#body_text' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

    <script>
        const priceOpts = $('#content-price');
        const privacySelect = $('#privacy');
        $(document).ready(function(){
            if(privacySelect.value != 2){
                priceOpts.hide();
            }
            privacySelect.on('change keypress', function(){
                priceOpts.hide();
                if(this.value == 2){
                    priceOpts.show();
                }
            });
            $('#price').on('change', function(){
                this.value = parseFloat(this.value).toFixed(2);
                console.log(this.value);
            });
        });
    </script>
@endsection

