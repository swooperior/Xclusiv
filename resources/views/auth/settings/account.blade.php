@extends('layouts.app')
@section('title', 'Account Settings')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h2>Account Settings</h2>
            </div>
            <div class="card-body">
                <form action="{{route('settings.account')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                    <div class="form-group">
                        <h4 >Account visibility</h4>
                        <input type="checkbox" name="vis_check" id="vis_check" value="0" {{$user->settings['account_settings']['account_visibility'] == 0 ? 'checked' : ''}}>
                        <input type="hidden" id="account_visibility" name="account_visibility" value="{{$user->settings['account_settings']['account_visibility']}}">
                        <label class="form-check-label" for="vis_check">
                            Hide my account, Account will be unavailable to everyone.
                        </label>
                    </div>
                        <hr>
                        <div class="form-group">
                            <h4>Account Details</h4>
                            <div class="row">


                            <div class="col-md-6">
                                <h5>Update Email</h5>
                                <label for="updated_email">New Email Address</label>
                                <input type="text" class="form-control email_input" name="updated_email" id="updated_email">
                                <label for="v_updated_email">Verify New Email Address</label>
                                <input type="text" class="form-control email_input" name="v_updated_email" id="v_updated_email">
                                <span id="email_validation"><p>Both email fields must match exactly!</p></span>
                            </div>
                            <div class="col-md-6">
                                <h5>Reset Password</h5>
                                <a href="/password/reset" class="btn btn-danger">Reset Password</a>
                            </div>
                            </div>
                        </div>
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
        $( document).ready(function(){
            //Handle account_visibility checkbox
            const $vis_attri = $('#account_visibility');
            const $vis_input = $('#vis_check');

            const hidden_checked = function(){
                if($vis_input.is(':checked')){
                    $vis_attri.val(0);
                    return true;
                }else{
                    $vis_attri.val(1);
                    return false;
                }
            }

            $vis_input.on('change', function(){
                hidden_checked();
            });
            hidden_checked();
            //End account_visibilty

            // Handle email validation
            const $email_input = $('.email_input');
            const $v_email = $('#v_updated_email');
            const $email_validation = $('#email_validation');
            $email_validation.hide();

            $email_input.each(function(self){
                $( this ).on('input', function(){
                    if($(this).val().length > 0){
                        if($(this).is('#updated_email')){
                            $v_email.attr('required', 'true');
                            if($(this).val() != $v_email.val()){
                                $email_validation.show();
                            } else{
                                $email_validation.hide();
                            }
                        }else{
                            $v_email.attr('required', 'false');
                            if($(this).val() != $('#updated_email').val()){
                                $email_validation.show();
                            } else{
                                $email_validation.hide();
                            }
                        }

                    }else{
                        $email_validation.hide();
                    }
                });
            });
        });
    </script>
@endsection

