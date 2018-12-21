@extends('layouts.app') @section('js')
<script src="{{ URL::asset('asset/js/toolControllers.js') }}"></script>

@stop @section('content')
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
                <!-- <button id="admin_add" class="btn btn-primary" type="button" data-toggle="modal" data-target="#add" data-id=""> -->
                    <a href="/tool/bulletins/add">
                        <button id="admin_add" class="btn btn-primary" type="button">
					       <i class="fa fa-plus"></i> {{ trans('lang.add_btn') }}
                        </button>
                    </a>
                <div class="clearfix"></div>
            </div>


            <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- add list start-->
                <!-- add list end -->
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">


                        <thead>
                            <tr class="headings">
                                <th class="text-center">id</th>
                                <th class="text-center">類型</th>
                                <th class="text-center">{{ trans('lang.theme') }}</th>
                                <th class="text-center">{{ trans('lang.bulletins') }} {{ trans('lang.time') }}</th>
                                <th class="text-center">拖拉可{{ trans('lang.change_the_position') }}</th>
                                <th class="text-center">{{ trans('lang.operating') }}</th>
                                <th class="column-title">
                                    <span class="btn btn-round btn-danger btn_del_all"><em class="fa fa-trash"></em></span>
                                    <input type="checkbox" name="DelALL" style="position: absolute; zoom: 1.8;" value="ALL">
                                </th>
                            </tr>
                        </thead>
                        @foreach($data as $datas)
                        <tr class="data" draggable="true">
                            <td align="center" class="id">{{$datas->id}}</td>
                            <td>{{$datas->short}}</td>
                            <td>{{$datas->title}}</td>
                            <td align="center">
                                {{$datas->start_time." ~ ".$datas->end_time}}
							</td>
							<!--拖拉可更動位置-->
							<td align="center">
								<i class="fa fa-arrows"></i>
							</td>
                            <td align="center">
                                <!--修改 刪除按鈕 S-->
                                <!-- <button type="button" class="btn btn-default bulletins_edit" data-toggle="modal" data-target="#edit_Modal" data-id="{{ $datas->id }}" data-title="{{ $datas->title }}"
                                    data-type_id="{{ $datas->type_id }}" data-start_time="{{ $datas->start_time }}" data-end_time="{{ $datas->end_time }}" data-content="{{ $datas->content }}"
                                    data-created_at="{{ $datas->created_at }}" data-updated_at="{{ $datas->updated_at }}" data-sort="{{ $datas->sort }}"><em class="fa fa-pencil"></em>
                                </button> -->

                                <a href="/tool/bulletins/edit?id={{ $datas->id }}">
                                <button type="button" class="btn btn-default bulletins_edit" ><em class="fa fa-pencil"></em>
                                </button>
                                </a>
                                <!--修改 刪除按鈕 END-->
                            </td>
                            <td class="center">
                                <span class="btn btn-round btn-danger bulletins_del" data-id="{{ $datas->id }}"><em class="fa fa-trash"></em></span>
                                <input type="checkbox" name="Del[]" style="position: absolute; zoom: 1.8;" data-id="{{$datas->id}}">
                            </td>

                            <td class="sort text-center" style="display:none">{{$datas->sort}}</td>
                        </tr>
                        @endforeach
                    </table>
                    <!--內容 END-->
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_Modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="modal-title" style="font-weight:bold;font-size:18pt;">{{ trans('lang.modify_btn') }}</span>
            </div>
    <form class="form-horizontal" role="form" method="POST" action="/tool/bulletins/editok">
    {{ csrf_field() }}
     <div class="modal-body">

        <div class="form-group">
        <label for="input_button" class="col-sm-2 control-label">公告時間</label>

        <fieldset>
            <!-- 日期 -->
            <div class="col-sm-6 xdisplay_inputx form-group has-feedback">
                <input type="text" class="form-control has-feedback-left" placeholder="開始時間" aria-describedby="inputSuccessStatus" name="start_time" value="">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccessStatus" class="sr-only">(success)</span>
             </div>
            <!-- 日期 -->
            <div class="col-sm-6 xdisplay_inputx form-group has-feedback">
                <input type="text" class="form-control has-feedback-left" placeholder="結束時間" aria-describedby="inputSuccessEnd" name="end_time" value="">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccessEnd" class="sr-only">(success)</span>
            </div>
        </fieldset>

        </div>

        <div class="form-group">
            <label for="input_mode" class="col-sm-2 control-label">類型</label>
            <div class="col-sm-10">
                <select id="input_mode" class="form-control" name="type_id">
                @foreach($list as $val)
                <option value="{{ $val->id}}">{{ $val->short}}</option>
                @endforeach
              </select>
            </div>
        </div>

        <div class="form-group">
        <label for="input_title" class="col-sm-2 control-label" >公告主題</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="input_title" name="title" required>
        </div>
        </div>

        <div class="form-group">
        <label for="input_content" class="col-sm-2 control-label">公告內容</label>
        <div class="col-sm-10">
          <textarea style="height: 600px" class="form-control" rows="100"  id="input_edit_content" name="content" required></textarea>
        </div>
        </div>
            </div>
            <!-- 頁尾 S -->
            <div class="modal-footer">
                <!--
                <div class="alert alert-danger" >
                    !! 注意 ，若選擇已有群組的人員則將會取代原本的設定 !!
                </div>-->
                <input type="hidden" name="q" value="edit">
                <input type="hidden" class="form-control" name="id">
                <button type="submit" class="btn btn-primary">送出</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
            </div>
            <!-- 頁尾 END -->
            </div>
    </form>
        </div>
    </div>



</div>
@stop @section('footerjs')
<script>
    //互動視窗內容修改
    $('#edit_Modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // 觸發模式的按鈕
        var modal = $(this)
        modal.find(".modal-footer input[name='id']").val(button.data('id'))
        modal.find(".modal-body select[name='type_id']").val(button.data('type_id'))
        modal.find(".modal-body input[name='title']").val(button.data('title'))
        modal.find(".modal-body textarea[name='content']").val(button.data('content'))
        modal.find(".modal-body input[name='start_time']").val(button.data('start_time'))
        modal.find(".modal-body input[name='end_time']").val(button.data('end_time'))

    })
    /*
        //選擇日期
        $("#single_cala","#single_calb").flatpickr({
          enableTime: true,
          dateFormat: "Y-m-d H:i:S",
          minDate:new Date(),//預設顯示現在時間
        });
    */

    //自設-日期選擇
    /*
    $('#single_cala').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        //timePickerIncrement: 30, // 以 30 分鐘為一個選取單位
        singleClasses: "picker_2",
        locale: {
            format: "YYYY-MM-DD HH:mm:ss" // 日期+時間的顯示格式
        }
    });
    $('#single_calb').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        //timePickerIncrement: 30, // 以 30 分鐘為一個選取單位
        singleClasses: "picker_2",
        locale: {
            format: "YYYY-MM-DD HH:mm:ss" // 日期+時間的顯示格式
        },
        startDate: "{{ date("Y-m-d") }} 23:59:59"
    });
    */

    //載入完後執行
    $(function() {
        //活動編輯器=>刪除
        $('.bulletins_del').on('click', function() {
            if (confirm("確認要進行刪除嗎?")) {
                var data = {
                    "id": $(this).data('id')
                };

                $.ajax({
                    url: '/tool/bulletins/delete',
                    type: 'GET',
                    data: data,
                    success: function(data) {
                        if (data == 'error') {
                            msg = '很抱歉，您尚無此權限。';
                        } else {
                            msg = '刪除完畢。';
                        }

                        $.alert({
                            title: false,
                            content: msg,
                            confirmButton: 'OK',
                            onClose: function() {
                                window.location.reload();
                            }
                        })
                    }
                });
            }

        });
        //活動編輯器=全選
        $("input[name='DelALL']").click(function() {
            if ($("input[name='DelALL']").prop("checked")) {
                $("input[name='Del[]']").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $("input[name='Del[]']").each(function() {
                    $(this).prop("checked", false);
                });
            }
        });
        //活動編輯器=批次選
        $("input[name='DelALL']").click(function() {
            if ($("input[name='DelALL']").prop("checked")) {
                $("input[name='Del[]']").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $("input[name='Del[]']").each(function() {
                    $(this).prop("checked", false);
                });
            }
        });
        //活動編輯器=全刪除
        $('.btn_del_all').on('click', function() {

            if (confirm("請確認是否一鍵刪除?")) {
                var cnt = parseInt($("input[name='Del[]']:checked").length);

                if (cnt == 0) {
                    $.alert("至少勾選一個項目審核");
                    return false;
                }
                $("input[name='Del[]']:checked").each(function(i) {
                    var data = {
                        "id": $(this).data('id')
                    };
                    $.ajax({
                        url: '/tool/bulletins/delete',
                        type: 'GET',
                        data: data,
                        success: function(data) {
                            if (i == (cnt - 1)) {
                                if (data == 'error') {
                                    msg = '很抱歉，您尚無此權限。';
                                } else {
                                    msg = '刪除完畢。';
                                }

                                $.alert({
                                    title: false,
                                    content: msg,
                                    confirmButton: 'OK',
                                    onClose: function() {
                                        window.location.reload();
                                    }
                                })
                            }
                        }
                    });
                });
            }
        });
        //活動編輯器=全刪除END
        //載入完執行END======================================
    });
</script>
@stop {{-- 引入JS直接到頁面 --}} @include('tool.drag_js')
<script>
    //拖曳排序參數
    document.addEventListener('drop', function(event) {
        var id = document.querySelectorAll('.id');
        var data = []; // 儲存所有 ID

        for (var i = 0, len = id.length; i < len; i++) {
            // 取得所有 ID 並存為 array
            data.push(id[i].innerHTML);
            // 重新排序表格 Sort 數值
            id[i].parentNode.querySelector('.sort').innerHTML = i;
        }

        // jQuery AJAX
        $.get('/tool/bulletins/ajax', {
            "data": data
        });
    }, false);
</script>
