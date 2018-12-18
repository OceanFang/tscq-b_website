@extends('layouts.app')
@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><b>{{ trans('lang.create_account') }}</b></h3>
        </div>

        <div class="title_right">

        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <h2><small>{{ trans('lang.msg_create') }}</small></h2>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <br />
                        <form class="form-horizontal form-label-left" data-parsley-validate role="form" method="POST" action="{{ url('/register/save') }}">
                        {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                                <label for="position" class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('lang.duties') }}<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control col-md-7 col-xs-12" name="position" required="required">
                                        @foreach($groups as $key => $data)
                                        <option value="{{ $key }}">{{ $data }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('position'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('position') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ trans('lang.name') }}<span class="required">*</span>
                                </label>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="name" type="text" class="form-control col-md-7 col-xs-12" name="name" value="{{ old('name') }}" required="required">

                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('lang.username') }}<span class="required">*</span></label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}">

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ trans('lang.email') }}<span class="required">*</span>
                                </label>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="email" type="email" class="form-control col-md-7 col-xs-12" name="email" value="{{ old('email') }}" required="required">
                                    <br>{{ trans('lang.mail_tip') }}
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="autoPass" class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('lang.autopass') }}</label>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ Form::checkbox('autoPass','auto',null,['id' => 'autoPass', 'checked' => 'checked', 'disabled'=>'disabled']) }}
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button id="register_sure" type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> {{ trans('lang.ok2') }}
                                </button>
                                <a style="color:#fff;" href="{{ url('admin') }}"><button class="btn btn-danger" type="button"><i class="fa fa-arrow-left"></i> {{ trans('lang.back') }}</button></a>
                                </div>
                            </div>

                        </form>
                        @if(Session::has('alert-success'))
                            <div class="alert alert-success">{!! session('alert-success') !!}</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
