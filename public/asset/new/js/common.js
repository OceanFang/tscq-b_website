$(function(){

	//chose ALL Del Btn
	$("input[name='DelALL']").click(function() {
		if($("input[name='DelALL']").prop("checked")) {
			$("input[name='Del[]']").each(function() {
				$(this).prop("checked", true);
			});
		} else {
			$("input[name='Del[]']").each(function() {
				$(this).prop("checked", false);
			});
		}
	});
});


function delBtn(url, id, dataType='text', type='GET', msg=''){
	var default_msg = '確認要進行刪除嗎?';

	if(msg == '') {
		msg = default_msg;
	}
	if(confirm(msg))
	{
		var data = {
			"id" : id
		};

		var act_url = url;
		var res= doAjax(act_url, data, dataType, type);

		alertMsgReload(res, '刪除完畢。');
	}

}

function delAllBtn(url, dataType='text', type='GET'){

	if(confirm("請確認是否一鍵刪除?"))
	{
		var cnt = parseInt($("input[name='Del[]']:checked").length);

		if(cnt == 0){
			$.alert("至少勾選一個項目");
			return false;
		}

		$("input[name='Del[]']:checked").each(function(i) {
			var data = {
			"id" :$(this).data('id')
			};

			var act_url = url;
			var res= doAjax(act_url, data, dataType, type);

			if(i==(cnt-1)){
				alertMsgReload(res, '刪除完畢。');
			}
		});
	}
}

function doAjax(url, data, dataType='text', type='GET'){

	var result_arr;
	$.ajax({
			url: url,
			data: data,
			dataType : dataType,
			type: type,
			async: false,
			success: function(data)
			{
				return result_arr = data;
			}
		});

	return result_arr;
}

function alertMsgReload(data, msg){

	if (data =='error')	{
		msg = '很抱歉，您尚無此權限。';
	} else {
		msg = msg;
	}

	if (data =='fail')	{
		$.alert({
			title: false,
			content: msg,
			confirmButton: '確定'
		});
	} else {
		$.alert({
			title: false,
			content: msg,
			confirmButton: 'OK',
			onClose: function() {
				window.location.reload();
			}
		});
	}
}

function falseAlert(column, msg = '') {
	$.alert(column+"為必填欄位"+msg);
}

