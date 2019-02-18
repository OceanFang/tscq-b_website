@extends('layouts.app') @section('js')
<script src="{{ URL::asset('asset/js/toolControllers.js') }}"></script>
@stop @section('content')
<style>
    /*圖片大小*/
    .img-w240 {
        /*width: 240px;*/
        height: 140px;
    }
</style>
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
                <button id="admin_add" class="btn btn-primary" type="button" data-toggle="modal" data-target="#add">
					<i class="fa fa-plus"></i> {{ trans('lang.add_btn') }}
				</button>
                <div class="clearfix"></div>
            </div>


            <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- add list start-->
                @include('tool.banner_add') @include('tool.banner_edit')
                <!-- add list end -->
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">id</th>
                                <th class="text-center">{{ trans('lang.image') }}</th>
                                <th class="text-center">說明</th>
                                <th class="text-center">上架時間</th>
                                <th class="text-center">拖拉可{{ trans('lang.change_the_position') }}</th>
                                <th class="text-center">{{ trans('lang.operating') }}</th>
                                <th class="column-title" style="width: 100px">
                                    <span class="btn btn-round btn-danger btn_del_all"><em class="fa fa-trash"></em></span>
                                    <input type="checkbox" name="DelALL" style="position: absolute; zoom: 1.8;" value="ALL">
                                </th>
                            </tr>
                        </thead>
                        @foreach($data as $datas)
                        <tr class="data" draggable="true">
                            <td align="center" class="id">{{$datas->id}}</td>
                            <!--a連結圖片-->
                            <td align="center"><a href="{{ $datas->url }}" target="_blank"><img src="{{$datas->img}}"  class="img-thumbnail img-w240" draggable="false" ></a></td>
                            <td>{{$datas->description}}</td>
                            <td align="center">
                                {{$datas->start_time." ~ ".$datas->end_time}}
                            </td>

                            <!--拖拉可更動位置-->
                            <td align="center">
                                <i class="fa fa-arrows"></i>
                            </td>
                            <td class="sort text-center" style="display:none">{{$datas->sort}}</td>
                            <td align="center">
                                <!--修改按鈕 S-->
                                <button type="button" class="btn btn-default bulletins_edit" data-toggle="modal" data-target="#edit_Modal" data-id="{{ $datas->id }}" data-description="{{ $datas->description }}" data-img="{{ $datas->img }}" data-url="{{ $datas->url }}"
                                    data-start_time="{{ $datas->start_time }}" data-end_time="{{ $datas->end_time }}" ><em class="fa fa-pencil"></em></button>
                                <!--修改 END-->
                            </td>
                            <td class="center">
                                <span class="btn btn-round btn-danger banner_del" data-id="{{ $datas->id }}"><em class="fa fa-trash"></em></span>
                                <input type="checkbox" name="Del[]" style="position: absolute; zoom: 1.8;" data-id="{{$datas->id}}">
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <!--內容 END-->
                </div>

            </div>
        </div>
    </div>
</div>
@stop @section('footerjs')
<script>
    //互動視窗內容修改
    $('#edit_Modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // 觸發模式的按鈕
        var modal = $(this)
        modal.find(".modal-body input[name='id']").val(button.data('id'))
        modal.find(".modal-body input[name='description']").val(button.data('description'))
        modal.find(".modal-body input[name='img']").val(button.data('img'))
        modal.find(".modal-body input[name='url']").val(button.data('url'))
        modal.find(".modal-body input[name='start_time']").val(button.data('start_time'))
        modal.find(".modal-body input[name='end_time']").val(button.data('end_time'))
    })

    //自設-日期選擇-新增的時間
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

    //自設-日期選擇-編輯的時間
    $('#edit_start_time').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        //timePickerIncrement: 30, // 以 30 分鐘為一個選取單位
        singleClasses: "picker_2",
        locale: {
            format: "YYYY-MM-DD HH:mm:ss" // 日期+時間的顯示格式
        }
    });
    $('#edit_end_time').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        //timePickerIncrement: 30, // 以 30 分鐘為一個選取單位
        singleClasses: "picker_2",
        locale: {
            format: "YYYY-MM-DD HH:mm:ss" // 日期+時間的顯示格式
        },
    });
    //載入完後執行
    $(function() {
        //活動編輯器=>刪除
        $('.banner_del').on('click', function() {
            if (confirm("確認要進行刪除嗎?")) {
                var data = {
                    "id": $(this).data('id')
                };

                $.ajax({
                    url: '/tool/banner/delete',
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
                        url: '/tool/banner/delete',
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
        $.get('/tool/banner/ajax', {
            "data": data
        });
    }, false);
</script>
