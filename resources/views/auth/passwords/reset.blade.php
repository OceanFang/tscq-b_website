@extends('layouts.app')

@section('content')
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><b>{{ trans('lang.reset_password') }}</b></h3>
        </div>

        <div class="title_right">

        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="x_panel">
            <div class="x_title">
                <div class="clearfix"></div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <br />
                        <form id="{{ $formType }}" class="form-horizontal form-label-left" data-parsley-validate role="form" method="POST" action="{{ url('/password/reseting') }}">
                        {{ csrf_field() }}

                            <div class="form-group">
                                <label for="username" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ trans('lang.username') }}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" name="username" value="{{ $info->username }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ trans('lang.petname') }}
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" name="name" value="{{ $info->name }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ trans('lang.new_password') }}<span class="required">*</span>
                                </label>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password" type="password" class="form-control col-md-7 col-xs-12" name="password" value="{{ old('password') }}" required="required">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">
                                    {{ trans('lang.confirm_password') }}<span class="required">*</span>
                                </label>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="password_confirm" type="password" class="form-control col-md-7 col-xs-12" name="password_confirm" value="{{ old('password_confirm') }}" required="required">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                {{ Form::hidden('user',$id) }}
                                {{ Form::hidden('resetType', $resetType) }}
                                {{ Form::hidden('prev_url', url('admin')) }}
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <button type="submit" class="btn btn-primary">
                                      <i class="fa fa-btn fa-refresh"></i> {{ trans('lang.reset_btn') }}
                                  </button>
                                  <span style="padding-left:10px;"></span>
                                    <a style="color:#fff;" href="{{ url('admin') }}"><button class="btn btn-danger" type="button"><i class="fa fa-arrow-left"></i> {{ trans('lang.back') }}</button></a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
