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
                    <a href="/tool/events/add/{{ $game }}">
                        <button id="admin_add" class="btn btn-primary" type="button">
					       <i class="fa fa-plus"></i> {{ trans('lang.add_btn') }}
                        </button>
                    </a>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <?php $count = 0;?>

                    @foreach($list as $k => $val)
                    <li role="presentation" class="{{$count==0? 'active' : ''}}"><a href="#tab_content{{$val->id}}" id="home-tab" role="tab" data-toggle="tab">{{ $val->description }}</a>
                    </li>
                    <?php $count++;?>
                    @endforeach
                </ul>

                <div id="myTabContent" class="tab-content">
                    <?php $count = 0;?>
                    @foreach($list as $k => $type)
                    <div role="tabpanel" class="tab-pane fade {{$count==0? 'active in' : ''}}" id="tab_content{{$type->id}}" aria-labelledby="home-tab">
                      <?php $count++;?>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <!-- add list start-->
                            <!-- add list end -->
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                        <tr class="headings">
                                            <th class="text-center">id</th>
                                            <th class="text-center">{{ trans('lang.image') }}</th>
                                            <th class="text-center">{{ trans('lang.theme') }}</th>
                                            <th class="text-center">作者</th>
                                            <th class="text-center">票數</th>
                                            <th class="text-center">{{ trans('lang.operating') }}</th>
                                            <th class="column-title">
                                                <span class="btn btn-round btn-danger btn_del_all"><em class="fa fa-trash"></em></span>
                                                <input type="checkbox" name="DelALL" style="position: absolute; zoom: 1.8;" value="ALL">
                                            </th>
                                        </tr>
                                    </thead>
                                    @if (array_key_exists($type->id, $a_data))
                                    @foreach($a_data[$type->id] as $datas)
                                    <tr class="data" draggable="true">
                                        <td align="center" class="id">{{ $datas->id }}</td>
                                        <td align="center"><img src="{{ $datas->img }}"  class="img-thumbnail img-w240" draggable="false" style="margin: auto; height: 100px; width: 100px;"></td>
                                        <td>{{ $datas->title }}</td>
                                        <td align="center">
                                            {{ $datas->author }}
                                        </td>
                                        <td align="center">
                                            {{ $datas->like_cnt }}
                                        </td>
                                        <td align="center">
                                            <!--修改 刪除按鈕 S-->

                                            <a href="/tool/events/edit/{{ $game }}?id={{ $datas->id }}">
                                            <button type="button" class="btn btn-default events_edit" ><em class="fa fa-pencil"></em>
                                            </button>
                                            </a>
                                            <!--修改 刪除按鈕 END-->
                                        </td>
                                        <td class="center">
                                            <span class="btn btn-round btn-danger events_del" data-id="{{ $datas->id }}"><em class="fa fa-trash"></em></span>
                                            <input type="checkbox" name="Del[]" style="position: absolute; zoom: 1.8;" data-id="{{$datas->id}}">
                                        </td>

                                    </tr>
                                    @endforeach
                                    @endif


                                </table>
                                <!--內容 END-->
                            </div>

                        </div>
                    </div>
                    @endforeach

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
        $('.events_del').on('click', function() {
            if (confirm("確認要進行刪除嗎?")) {
                var data = {
                    "id": $(this).data('id')
                };

                $.ajax({
                    url: '/tool/events/delete',
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
                        url: '/tool/events/delete',
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
        $.get('/tool/events/ajax', {
            "data": data
        });
    }, false);
</script>
