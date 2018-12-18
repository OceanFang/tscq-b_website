<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ trans('lang.web_name') }}</title>

    <!-- Bootstrap -->
    <link href="{{ URL::asset('/asset/new/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('/asset/new/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('/asset/new/css/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ URL::asset('/asset/new/css/animate.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('/asset/new/css/custom.min.css') }}" rel="stylesheet">
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    <h1>Login</h1>
                    {{ csrf_field() }}
                        <div>
                            <input type="text" class="form-control" placeholder="{{ trans('lang.username') }}" required="" id="username" name="username" value="{{ old('username') }}"/>
                            @if ($errors->has('username'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div>
                            <input type="password" class="form-control" placeholder="{{ trans('lang.password') }}" required="" id="password" name="password" />
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!-- add CAPTCHA -->
                        <div>
                            <img style="cursor: pointer;" src="{{captcha_src('flat')}}" onclick="this.src='{{captcha_src('flat')}}' + Math.random()">
                            <input type="text" class="form-control" placeholder="{{ trans('lang.captcha_msg') }}" required="" id="captcha" name="captcha" />
                            @if ($errors->has('captcha'))
                                <span class="help-block">
                                    <strong>{{ trans('lang.captcha_error') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div>
                            <button class="btn btn-default submit" type="submit">Login</button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">
                            {{ trans('lang.login_msg') }}
                            <code>{{ trans('lang.login_ie') }}</code>
                            {{ trans('lang.login_msg2') }}
                            <code>{{ trans('lang.login_chrome') }}</code>、
                            <code>{{ trans('lang.login_firefox') }}</code>
                            {{ trans('lang.login_msg3') }}
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1></h1>
                                <p>Copyright © 2018 All Rights Reserved.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>

    </div>
  </body>
</html>
