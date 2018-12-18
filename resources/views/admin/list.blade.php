@extends('layouts.app')
@section('js')
<script src="{{ URL::asset('asset/js/adminuser.js') }}"></script>
@stop
@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3><b>{{ $title->name }}</b></h3>
		</div>

		<div class="title_right">

		</div>
	</div>

	<div class="clearfix"></div>

	<div class="row">
		<div class="x_panel">

			<div class="x_title">
				@if(master(['RegisterController','index',$userPermissions]))
				<b>{{ trans('lang.create_administrator') }} : &nbsp;</b>
					<a style="color:#fff;" href="{{ url('register') }}"><button  class="btn btn-primary" type="button">
						<i class="fa fa-user-plus"></i> {{ trans('lang.create_account') }}
					</button></a>
				@endif
				<b>{{ trans('lang.modify_authority') }} : &nbsp;</b>
				<button id = "admin_add" class="btn btn-primary" type="button" data-toggle="modal" data-target="#add" data-id = "">
					<i class="fa fa-pencil"></i> {{ trans('lang.modify_btn') }}
				</button>
				<div class="clearfix"></div>
			</div>

			<div class="col-md-12 col-sm-12 col-xs-12">
				<!-- add list start-->
				@include('admin.add')
		  		<!-- add list end -->

				<div class="table-responsive">
					<table class="table table-striped jambo_table bulk_action">
						<thead>
							<tr class="headings">
								<th>{{ trans('lang.username') }}</th>
								<th>{{ trans('lang.petname') }}</th>
								<th>{{ trans('lang.duties') }}</th>
								<th>{{ trans('lang.function') }}</th>
							</tr>
						</thead>
						@if(count($users) > 0)
						@foreach($users as $user)
						<tr>
							<td>{{ $user->username }}</td>
							<td>{{ $user->name }}</td>
							<td>
								@if (count($user->roles) > 0)
								@foreach ($user->roles as $role)
								{{ $role->name . '  ' }}
								@endforeach
								@else
								{{ trans('lang.none_group') }}
								@endif
							</td>
							<td>
								@if(master(['Auth\PasswordController','index',$userPermissions]))
									<a style="color:#fff;" href="{{ action('Auth\PasswordController@index' , ['id' => $user->id]) }}"><button  class="btn btn-success" type="button">{{ trans('lang.reset_password') }}</button></a>
			                    @endif
								@if($user->is_lock==0)
								<button data-id="{{ $user->id }}" type="button" class="btn btn-warning freeze">{{ trans('lang.freeze') }}</button>
								@else
								<button data-id="{{ $user->id }}" type="button" class="btn btn-info unfreeze">{{ trans('lang.unfreeze') }}</button>
								@endif
								@if(master(['AdminController','destroy',$userPermissions]))
			                    <button data-id="{{ $user->id }}" type="button" class="btn btn-danger admindel">{{ trans('lang.delete_btn') }}</button>
			                    @endif
							</td>
						</tr>
						@endforeach
						@else
						<tr>
							<td colspan="4" align="center" style="font-weight:bold;font-size:14pt;">{{ trans('lang.no_data') }}</td>
						</tr>
						@endif
					</table>
					<div class="page">
					{{ $users->render() }}
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@stop
