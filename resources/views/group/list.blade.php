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
				<div class="clearfix"></div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="table-responsive">
					<table class="table table-striped jambo_table bulk_action">
						<thead>
							<tr class="headings">
								<th alight="center">
									<a href="{{ action('GroupController@manage') }}" class="btn btn-primary">
										<i class="fa fa-plus"></i>
									</a>
								</th>
								<th style="vertical-align: middle;">{{ trans('lang.group_name') }}</th>
								<th style="vertical-align: middle;">{{ trans('lang.created_time') }}</th>
								<th style="vertical-align: middle;">{{ trans('lang.updated_time') }}</th>
							</tr>
						</thead>
						@foreach($groups as $group)
						<tr>
							<td align="center">
								@if(master(['GroupController','manage',$userPermissions]))
			                    <a class="btn btn-default" href="{{ action('GroupController@manage' , ['id' => $group->id]) }}"><em class="fa fa-pencil"></em></a>
			                    @endif
			                    &nbsp;&nbsp;
			                    @if(master(['GroupController','destroy',$userPermissions]))
			                    <button data-id="{{ $group->id }}" type="button" class="btn btn-danger  groupdel">{{ trans('lang.delete_btn') }}</button>
			                    @endif
			                </td>
							<td>{{ $group->name }}</td>
							<td>{{ $group->created_at }}</td>
							<td>
							@if ($group->updated_at == null)
							{{ trans('lang.none_group_update') }}
							@else
							{{ $group->updated_at }}
							@endif
							</td>
						</tr>
						@endforeach
					</table>

				</div>

			</div>
		</div>
	</div>
</div>
@stop
