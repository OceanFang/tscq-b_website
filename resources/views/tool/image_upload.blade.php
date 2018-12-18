@extends('layouts.app')
@section('js')
<script src="{{ URL::asset('asset/new/js/bootstrap-filestyle.min.js') }}"></script>
<script src="{{ URL::asset('asset/new/js/upload.js') }}"></script>

@stop
@section('content')
<!-- page content -->
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
            <div class="form-group">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal3">
                    <i class="fa fa-plus"></i> 新增類型
                </button>
            </div>
            <div class="alert alert-danger" style="text-align:left;">
              <ul>
                <li>請選擇類型</li>
                <li>點選 查詢 或 上傳檔案</li>
                <li>請勿上傳中文檔名</li>
              </ul>
            </div>

            <label>類型： </label>
            <select name="type" id="type">
              <option value="" data-id="">=== 請選擇 ===</option>
              @foreach($types as $type)
                <option value="{{ $type->id }}" data-id="{{ $type->en_name }}">{{ $type->name }}</option>
              @endforeach
            </select>
            {{ Form::hidden('hidden_type', ($request->type === null) ? '' : $request->type, ['id' => 'hidden_type'] ) }}

            <button type="submit" class="btn btn-success" id="search_btn">查詢</button>

            <form id="up_form" action="{{ action('UploadController@imageUpload') }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="form-group" style="width: 20%;display: inline-block;">
                  <input type="file" name="file[]" id="inputFiles" tabindex="-1" calss="position: absolute;"  multiple="multiple">
              </div>
              <div class="form-group" style="width: 20%;display: inline-block;position: absolute;">
                  <button type="submit" class="btn btn-primary btn-file" id='up_btn'> 上傳 </button>
              </div>
              {{ Form::hidden('hidden_en_name', $en_name, ['id' => 'hidden_en_name'] ) }}
            </form>
            @if(Session::has('alert-msg'))
                <div class="alert alert-success">{!! session('alert-msg') !!}</div>
            @endif
            <div class="form-group" id="up_msg"></div>
            <div class="clearfix"></div>
        </div>

      <div class="x_content">

          <div class="table-responsive">
              <div class="modal fade" id="myModal3" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">編輯類型</h4>
                  </div>
                  <div class="modal-body">
                    <form id="parent_form" method="get">
                        <div class="form-group row">
                          <div class="col-xs-3">
                            <label for="ex1">類型名稱</label>
                            <input class="form-control" type="text" name="name" value="" id='c_name'>
                          </div>
                          <div class="col-xs-3">
                            <label for="ex1">類型英文名稱</label>
                            <input class="form-control" type="text" name="en_name" value="" id='en_name'>
                          </div>
                        </div>
                        {{ Form::hidden('upload_type', 'image', ['id' => 'upload_type'] ) }}
                        <input type="submit" class="btn btn-primary btn-block" value="送出" id="ins_parent">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action table-bordered">
              <thead>
                <tr class="headings">
                  <th class="column-title">圖片</th>
                  <th class="column-title">網址</th>
                  <th class="column-title">檔名</th>
                  <th class="column-title">建立時間</th>
                </tr>
              </thead>

              <tbody>
                @if (isset($list))
                @foreach($list as $data)
                <tr class="even pointer">
                  <td class=" " align="center"><img src="{{ config('site.event.url'). $data->folder .'/'.$data->file_name }}" style="margin: auto; height: 100px; width: 100px;"></td>
                  <td class=" ">{{config('site.event.url'). $data->folder .'/'.$data->file_name}}</td>
                  <td class=" ">{{$data->file_name}}</td>
                  <td class=" ">{{$data->created_at}}</td>
                </tr>
                @endforeach
                @endif
              </tbody>

            </table>
          </div>

      </div>

    </div>
  </div>
</div>
<!-- /page content -->
@stop
