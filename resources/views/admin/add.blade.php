<div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<span class="modal-title" style="font-weight:bold;font-size:18pt;">新增管理人員</span>
		</div>
		<div class="modal-body">
			<form>
				<div class="form-group" style="vertical-align: middle;">
					<label for="admin_name" class="form-control-label">選擇人員 : </label>
					{{ Form::select('admin_name', $selectUser) }}
				</div>
				<div class="form-group" style="vertical-align: middle;">
					<ul>
					@foreach($roles as $role)
					<li><span> {{ $role->name }} {{ Form::radio('roles[]', $role->id ,(in_array($role->id,$user_role['userRoles'])) ? true : false, ['class' => 'users_role']) }}
					</span>
					</li>
					@endforeach
					</ul>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<div class="alert alert-danger" style="text-align:left;">
				!! 注意 ，若選擇已有群組的人員則將會取代原本的設定 !!
			</div>
			<button type="button" class="btn btn-primary" id="insert_admin">送出</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
		</div>
		</div>
	</div>
</div>
