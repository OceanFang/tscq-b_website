<div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<span class="modal-title" style="font-weight:bold;font-size:18pt;">{{ trans('lang.add_btn') }}</span>
		</div>
<form class="form-horizontal" role="form" method="POST" action="/tool/bulletins/add">
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
	  <textarea class="form-control" rows="10"  id="input_content" name="content" required></textarea>
    </div>
	</div>
		</div>
		<!-- 頁尾 S -->
		<div class="modal-footer">
			<!--
			<div class="alert alert-danger" >
				!! 注意 ，若選擇已有群組的人員則將會取代原本的設定 !!
			</div>-->
			<button type="submit" class="btn btn-primary">送出</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
		</div>
		<!-- 頁尾 END -->
		</div>
</form>
	</div>
</div>
