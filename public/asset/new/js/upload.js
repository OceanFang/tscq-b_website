$(function(){
	// 類型下拉指定
	$('#type').val($('#hidden_type').val());

	// 檔案上傳樣式
    $('#inputFiles').filestyle({
      htmlIcon : '<span class="oi oi-folder"></span> ',
      text: '請選擇檔案',
      btnClass : 'btn-info glyphicon glyphicon-folder-open bg-control',
    });

	// 圖片上傳工具 - 新增類型
	$('#ins_parent').click(function() {
		var c_name = $('#c_name').val();
		var en_name = $('#en_name').val();
        var upload_type = $('#upload_type').val();

        if (c_name == '' || en_name == '') {
            $.alert("請輸入內容");
			return false;
        } else {

			$.ajax({
			   url: './upload/addParent/'+upload_type,
			   data: $("#parent_form").serialize(),
			   type: "GET",
			   success: function(data)
			   {
				   if (data =='error')
					{
						msg = '很抱歉，您尚無此權限。';
					}else{
						msg = data;
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
			return false;
        }
    });

	// 影片編輯器 - 編輯類型
    $('#modify_parent').click(function() {
        var upload_type = $('#upload_type').val();
        var valid_status = true;


        $("input[name='new_type_tw[]").each(function() {
            if ($(this).val().trim() == '' || $(this).val().trim().length > 32) {
            	valid_status = false;
            	return false;
            }
        });

        $("input[name='new_type_en[]").each(function() {
            if ($(this).val().trim() == '' || $(this).val().trim().length > 32) {
            	valid_status = false;
            	return false;
            }
        });

        if (valid_status == false) {
			alert('類型名稱與類型英文名稱為必填欄位，長度需小於32字元');
			return false;
        }

        $.ajax({
		   url: './upload/addParent/'+upload_type,
		   data: $("#parent_form").serialize(),
		   type: "GET",
		   success: function(data)
		   {
			   if (data =='error')
				{
					msg = '很抱歉，您尚無此權限。';
				}else{
					msg = data;
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
		return false;
    });


    // 影片編輯器 - 編輯類型 - 新增
    $('.addRow').on('click', function() {
		var item = '';
		item += '<div class="form-group row">';
		item += '<div class="col-xs-3"><input class="form-control" type="text" style="margin-left:5px" name="new_type_tw[]" value=""></div>';
		item += '<div class="col-xs-3"><input class="form-control alphanumeric" type="text" name="new_type_en[]" value=""></div>';
		item += '<div class="col-xs-3"><button class="btn btn-danger delRow" type="button"><i class="fa fa-minus"></i></button></div>';
		item += '</div>';
		$('#new_type').append(item);

		$('.alphanumeric').on('keydown', function(e) {
			var a = e.key;
			if (a.length == 1) return /^[\w-]*$/i.test(a);
			return true;
		})

		$('.delRow').on('click', function() {
			var elmnt = $(this).parent().parent();
			elmnt.remove();
		});
	});

    // 影片編輯器 - 編輯影片
	$('.editVideo').on('click', function() {
		$('#video_type').val($(this).data('filetype'));
		$('#video_type').prop('disabled', true);
		$("#video_type").css({ "background": '#eaeaea' });
		$('#inputFiles').prop('disabled', true);
		$(".bg-control").css({ "background": 'gray', "border-color":'gray' });
		$('#content').val($(this).data('content'));
		$('#url').val($(this).data('url'));
		$('#auto_play').val($(this).data('auto'));
		$("input[name='start_time']").val($(this).data('start'));
		$("input[name='end_time']").val($(this).data('end'));
		$('#edit_id').val($(this).data('id'));
	});

	// 影片編輯器 - 新增影片清除
	$('.addVideo').on('click', function() {
		$("#video_type").find('option').removeAttr("selected");
		$('#video_type').prop('disabled', false);
		$("#video_type").css({ "background": '#fff' });
		$('#inputFiles').prop('disabled', false);
		$(".bg-control").css({ "background": '#5bc0de', "border-color":'#5bc0de' });
		$('#content').val('');
		$('#url').val('');
		$('#auto_play').val('0');
		$("input[name='start_time']").val('');
		$("input[name='end_time']").val('');
		$('#edit_id').val('');
	});

    // 影片編輯器 - 刪除類型全選
    $("#all_type_delete").click(function() {
        if ($(this).prop('checked')) { //如果全選按鈕有被選擇的話（被選擇是true）
            $("input[name='delete_type_check[]']").each(function() {
                $(this).prop('checked', true); //把所有的核取方框的property都變成勾選
            });
        } else {
            $("input[name='delete_type_check[]']").each(function() {
                $(this).prop('checked', false);
            });
        }
    });

    // 影片編輯器 - 刪除類型
    $('.delete_type').click(function() {
        var delete_type = $(this).data('type');
        var upload_type = $('#upload_type').val();
        var delete_array = [];

        if (delete_type == 'all') {
            $("input[name='delete_type_check[]']:checked").each(function() {
                delete_array.push($(this).val());
            });
        } else {
            var delete_id = $(this).data('id');
            delete_array.push(delete_id);
        }

        if (delete_array.length == 0) {
            $.alert("請勾選要刪除的類型");
            return false;
        }

        $.confirm({
            content: '是否確定要刪除類型？',
            confirmButton: '確定',
            cancelButton: '取消',
            title: false,
            confirm: function() {
                $.ajax({
                    url: './upload/delParent',
                    data: { 'delete_array': delete_array, 'type': upload_type },
                    type: 'post',
                    success: function(data) {
                        if (data == 'success') {
                            $.alert({
                                theme: 'material',
                                confirmButton: 'OK',
                                content: '類型已刪除成功',
                                title: false,
                                onClose: function() {
                                    window.location.reload();
                                }
                            });
                        } else {
                            $.alert({
                                theme: 'material',
                                confirmButton: 'OK',
                                content: data,
                                title: false
                            });
                        }
                    }
                });
            }
        });
    });

    // 影片編輯器 - 刪除影片全選
    $("#all_file_delete").click(function() {
        if ($(this).prop('checked')) { //如果全選按鈕有被選擇的話（被選擇是true）
            $("input[name='delete_file_check[]']").each(function() {
                $(this).prop('checked', true); //把所有的核取方框的property都變成勾選
            });
        } else {
            $("input[name='delete_file_check[]']").each(function() {
                $(this).prop('checked', false);
            });
        }
    });

    // 刪除檔案
    $('.delete_file').click(function() {
        var delete_type = $(this).data('type');
        var delete_array = [];

        if (delete_type == 'all') {
            $("input[name='delete_file_check[]']:checked").each(function() {
                delete_array.push($(this).val());
            });
        } else {
            var delete_id = $(this).data('id');
            delete_array.push(delete_id);
        }

        if (delete_array.length == 0) {
            $.alert("請勾選要刪除的檔案");
            return false;
        }

        $.confirm({
            content: '是否確定要刪除檔案？',
            confirmButton: '確定',
            cancelButton: '取消',
            title: false,
            confirm: function() {
                $.ajax({
                    url: './upload/delSub',
                    data: { 'delete_array': delete_array },
                    type: 'post',
                    success: function(data) {
                        if (data == 'success') {
                            $.alert({
                                theme: 'material',
                                confirmButton: 'OK',
                                content: '檔案已刪除成功',
                                title: false,
                                onClose: function() {
                                    window.location.reload();
                                }
                            });
                        } else {
                            $.alert({
                                theme: 'material',
                                confirmButton: 'OK',
                                content: data,
                                title: false
                            });
                        }
                    }
                });
            }
        });
    });

    // 查詢
	$('#search_btn').on('click',function(){
		var upload_type = $('#upload_type').val();
		var type = $('#type :selected').val();
		if (type == '') {
	    	$.alert("請選擇類型。");
			return false;
	    }
		window.location.href="./"+ upload_type +"Upload?type=" + type ;
	});

	// 圖片上傳工具 - 上傳圖片
	$('#up_btn').on('click',function(){
		var upload_type = $('#upload_type').val();
		var path = $('#type :selected').data('id');
		var parent = $('#type :selected').val();
		$('#hidden_en_name').val(path);
		if (path == '') {
	    	$.alert("請選擇類型。");
			return false;
	    }else{

            var data = new FormData();
            var files = $("#inputFiles").get(0).files;

            if (files.length > 0) {
				data.append("path", path);
				data.append("parentId", parent);
				for(i = 0; i < files.length; i++){

					var imagefile = files[i].type;
					var match= ["image/jpeg","image/png","image/jpg","image/gif"];
					if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[2])))
					{
						$.alert("檔案格式錯誤，請選擇圖片檔案。");
						return false;
					}

					var str = files[i].name;
					for(var k = 0; k < str.length; k++) {
						var subStr = str.charCodeAt(k);
						if ((subStr > 256)){
							$.alert('請勿上傳中文檔名');
							return false;
							break;
						}
					}

					data.append("file[]", files[i]);
				}
            }else{
				$.alert("請選擇欲上傳之檔案。");
				return false;
			}

			$.ajax({
				url: './'+upload_type+'Upload/act',
			    data: data,
			    type: "post",
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(data)
				{
				   if (data =='error')
					{
						msg = '很抱歉，您尚無此權限。';
					}else{
						msg = data;
					}
					window.location.reload();
				}
			 });
			 return false;
		}
	});

	// 影片編輯器 - 新增/修改影片
	$('#up_video_btn').on('click',function(){
		var upload_type = $('#upload_type').val();
		var path = $('#video_type :selected').data('id');
		var parent = $('#video_type :selected').val();
		var content = $('#content').val();
		var edit_id = $('#edit_id').val();
		var url = $('#url').val();
		var auto_play = $('#auto_play :selected').val();
		var start_time = $("input[name='start_time']").val();
		var end_time = $("input[name='end_time']").val();

		if (content.trim() == '' || content.trim().length > 64) {
            alert('影片名稱為必填欄位，長度需小於64字元');
			return false;
        }

		$('#hidden_en_name').val(path);

        var data = new FormData();
        var files = $("#inputFiles").get(0).files;

        if (files.length > 0) {
			data.append("content", content);
			data.append("url", url);
			data.append("auto_play", auto_play);
			data.append("start_time", start_time);
			data.append("edit_id", edit_id);
			data.append("end_time", end_time);
			data.append("path", path);
			data.append("parentId", parent);

			for(i = 0; i < files.length; i++){
				var videofile = files[i].type;

				var match= ["video/mp4","video/x-msvideo","video/avi","video/quicktime","video/x-ms-wmv","video/x-ms-asf"];
				if($.inArray(videofile, match) == '-1')
				{
					$.alert("檔案格式錯誤。");
					return false;
				}

				var str = files[i].name;
				for(var k = 0; k < str.length; k++) {
					var subStr = str.charCodeAt(k);
					if ((subStr > 256)){
						$.alert('請勿上傳中文檔名');
						return false;
						break;
					}
				}

				data.append("file[]", files[i]);
			}
        } else if (edit_id > 0 && edit_id != '') {
        	data.append("content", content);
			data.append("url", url);
			data.append("auto_play", auto_play);
			data.append("start_time", start_time);
			data.append("edit_id", edit_id);
			data.append("end_time", end_time);
        } else{
			$.alert("請選擇欲上傳之檔案。");
			return false;
		}

		$.ajax({
			url: './'+upload_type+'Upload/act',
		    data: data,
		    type: "post",
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(data)
			{
			   if (data =='error')
				{
					msg = '很抱歉，您尚無此權限。';
				}else{
					msg = data;
				}
				window.location.reload();
			}
		 });
		 return false;

	});

});