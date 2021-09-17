@extends('admin::layouts.layout')

@section('content')
    <img src="{{ asset(config('admin.login_background_image')) }}" alt="Login Background" class="full-bg">

    <div class="dk-container">
        <!-- Login Container -->
        <div id="login-container">
            <!-- Login Title -->

            <div class="login-title text-center">
                <div  class="logo">
                    @foreach(config('admin.login_logo') as $logo)
                        <img src="{{ $logo['src'] }}" alt="" style="{{ $logo['style'] }}">
                    @endforeach
                </div>

                <div>
                    @if(count(config('admin.login_web_modules')))
                    <h1><strong class="title-bold">@lang('WEB')</strong></h1>
                        <ul class="page-list regular">
                            @foreach(config('admin.login_web_modules') as $webModule)
                                <li><a href="{{ $webModule['url'] }}" target="_blank">{{ $webModule['name'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif

                </div>
                <h1><strong class="title-black">{{ config('admin.project_name') }} {{ config('admin.version') }}</strong></h1>
            </div>

            <!-- END Login Title -->

            <!-- Login Block -->
            <div class="block push-bit">
                <div>
                    <h1 class="title-black cms"><strong>{{ __('admin.auth.login_title') }}</strong></h1>
                    <!-- Login Form -->
                    <form class="form-horizontal form-bordered form-control-borderless" id="form-login" method="POST"
                          action="{{ route('admin.login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    <input type="text" id="login-email" name="email" value="{{ old('email') }}" class="form-control" placeholder="{{ __('admin.auth.email') }}">
                                </div>

                                @if ($errors->has('email'))
                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                    <input type="password" id="login-password" name="password" class="form-control"
                                           placeholder="{{ __('admin.auth.password') }}">
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <div class="col-xs-8 text-right">
                                <button type="submit"
                                        @if(config('admin.recaptcha.modules.login.status'))
                                        data-callback='onSubmit'
                                        data-sitekey="{{ config('admin.recaptcha.public_key') }}"
                                        @endif
                                        class="btn btn-sm btn-primary @if(config('admin.recaptcha.modules.login.status')) g-recaptcha @endif">
                                    <i class="fa fa-angle-right"></i>
                                    {{ __('admin.auth.login') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- END Login Form -->
            </div>
            <!-- END Login Block -->

            <!-- Footer -->
        <!-- <footer class="text-muted text-center">
            <small><span id="year-copy"></span> &copy; <a href="{{ config('admin.handcrafted_by_url') }}" target="_blank">Handcrafted by {{ config('admin.handcrafted_by') }}</a>
            </small>
        </footer> -->
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->
    </div>
@endsection

@section('footer_scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSubmit(token) {
            document.getElementById("form-login").submit();
        }
    </script>
@endsection
