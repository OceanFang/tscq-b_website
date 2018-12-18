@extends('layouts.app')
@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3><b>{{ ($groupPermissions['id'] == '') ? trans('lang.create_group') : trans('lang.modify_group') }}</b></h3>
		</div>

		<div class="title_right">

		</div>
	</div>

	<div class="clearfix"></div>

	<div class="row">
		<div class="x_panel">
			{{ Form::open(['action' => 'GroupController@save' , 'id' => 'tree_form','method' => 'post']) }}
			<div class="x_title">
				<div class="form-inline">
					<div class="form-group">
						<h2><b>{{ trans('lang.group_name') }}：</b></h2>
						{{ Form::text('name', set_default($groupPermissions['name']),['class' => 'form-control']) }}
					</div>
					<div class="form-group" style="margin-left:14%;">
						{{ Form::hidden('prev_url', session('prev_url')) }}
						{{ Form::hidden('id', $groupPermissions['id']) }}
						<a type="button" id="tree_submit" name="submit" class="btn btn-success">
							<i class="fa fa-edit"></i> {{ trans('lang.ok') }}
						</a>
						&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
						<a type="button" class="btn" style="border-color: #337ab7" href="{{ url('/admin/group/') }}">
							<i class="fa fa-remove"></i> {{ trans('lang.cancel_btn') }}
						</a>
					</div>
				</div><br>

				<div class="clearfix"></div>

				<div class="tree">
				<h2><b>{{ trans('lang.authority_tree') }}</b></h2>
				<p style="padding-left:55px;display:inline-block;font-weight:bold;">
				{{ Form::checkbox('checkAll',null,null,['id' => 'checkAll']) }} {{ trans('lang.all_check') }}</p>
				<ul class="">
		        @foreach ($menuTree['modules'] as $module)
		            <li>
		            	<span style="background-color:#0888c1;color:white;">{{ $module['name'] }} </span>{{ Form::checkbox('permissions[]', $module['id'],(in_array($module['id'], $groupPermissions['groupPermissions']))?true:false) }}
			            @if (isset($menuTree['mainMenu'][$module['id']]))
			            <ul>
			                @foreach ($menuTree['mainMenu'][$module['id']] as $function)
			                <li class>
			                	<span style="background-color:#e8b20e;color:white;">{{ $function['name'] }} </span> {{ Form::checkbox('permissions[]', $function['id'], (in_array($function['id'], $groupPermissions['groupPermissions']))?true:false) }}
								@if (isset($menuTree['subMenu'][$function['id']]))
					            <ul>
					                @foreach ($menuTree['subMenu'][$function['id']] as $subFunction)
					                <li>
					                	<span style="background-color:#F44336;color:white;">{{ $subFunction['name'] }} </span> {{ Form::checkbox('permissions[]', $subFunction['id'], (in_array($subFunction['id'], $groupPermissions['groupPermissions']))?true:false) }}
					                </li>
					                @endforeach
					            </ul>
						         @endif
			                </li>
			                @endforeach
			            </ul>
			            @endif
		            </li>
		        @endforeach
	        	</ul>
	        	</div>

			</div>

			{{ Form::close() }}
		</div>
	</div>
</div>
@stop
@section('js')
<script src="{{ URL::asset('asset/js/tree.js') }}"></script>
@stop
