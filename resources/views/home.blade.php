@extends('layouts.app')

@section('content')
<div class="row tile_count">
	<div class="row x_title">
		<div class="col-md-6"></div>
		<div class="col-md-6">
			{{ Form::open(['action' => 'HomeController@index' , 'id' => 'selectForm','method' => 'get']) }}
			<div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
				<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
				<span></span> <b class="caret"></b>
			</div>
			{{ Form::hidden('start',$startDate,['id' => 'start']) }}
			{{ Form::hidden('end',$endDate,['id' => 'end']) }}
			{{ Form::close() }}
		</div>
    </div>
</div>
<div class="">
	<!-- top tiles -->
	<div class="row top_tiles" style="background: white">

	</div>
</div>
@endsection
@section('js')
<script src="{{ URL::asset('asset/js/home.js') }}"></script>
<!-- Chart.js -->
<script src="{{ URL::asset('asset/new/vendors/Chart.js/dist/Chart.min.js') }}"></script>
@stop
