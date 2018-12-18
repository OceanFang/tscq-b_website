
	function dataRange() {
        $('[data-min]').on('change', function() {
            var min = parseInt($(this).data('min'));
            var val = parseInt($(this).val());

            if (val < min) {
                $(this).val(min);
            }
        });

        $('[data-max]').on('change', function() {
            var max = parseInt($(this).data('max'));
            var val = parseInt($(this).val());

            if (val > max) {
                $(this).val(max);
            }
        });
    }

	var ck = $('[name="ck"]');
	function btn_check_all() {
		ck.prop('checked', !ck.prop('checked'));
	}

	function btn_del(id,delMethodUrl) {
		$.confirm({
            title: '',
            confirmButton: '確定',
            cancelButton: '取消',
			content: '確定要刪除嗎？',
			confirm: function() {
				$.post(delMethodUrl, {id: id}, function(result) {
					if (result !== 'done') {
						$.alert({
							content: result
						});
					} else {
						window.location.reload();
					}
				});
			}
		});
	}

	function btn_del_all(delMethodUrl) {
		if (ck.filter(':checked').size() === 0) {
			$.alert({
				content: '尚未選取任何項目'
			});
		} else {
			$.confirm({
                title: '',
                confirmButton: '確定',
                cancelButton: '取消',
				content: '確定要刪除嗎？',
				confirm: function() {
					var ids = ck.filter(':checked').map(function() {
						return $(this).attr('data-id');
					}).get().join(',');

					$.post(delMethodUrl, {id: ids}, function() {
						window.location.reload();
					});
				}
			});
		}
	}

	function initDate() {

        $('[name="batchType"], [name="batchDate"]').on('change', function() {
            chgDate();
        });
        $('#batchHour').on('change', function() {
            chgType();
        });
        $('#batchLimit').on('change', function() {
            maxRun();
        });
        $('[name^="batchNum"]').on('change', function() {
            checkNum(this);
        });
        chgDate();
    }

	function getNowDate(){
		var d = new Date();
		var yyyy = d.getFullYear().toString();
		var mm = (d.getMonth()+1).toString();
		var dd  = d.getDate().toString();
		var mmChars = mm.split('');
		var ddChars = dd.split('');
		var today = yyyy + '-' + (mmChars[1]?mm:"0"+mmChars[0]) + '-' + (ddChars[1]?dd:"0"+ddChars[0]);
		return today;
	}

    function chgDate() {
		var d = new Date();
		var batchHour = $('#batchHour');
		var hour = parseInt(d.getHours());
		var today= getNowDate();

		var start = 0;

		batchHour.empty();

		if ($("#batchDate").val() == today) {
			start = parseInt(hour) + 1;
		}

		for (var i = start; i < 24; i++) {
			batchHour.append($("<option></option>").val(i).text(i + "時"));
		}

		chgType();

	}

    function chgType() {

        var batchLimit = $('#batchLimit').empty();
        var batchHour = $('#batchHour');
        var hour = parseInt(batchHour.val());
        var i;

        switch ($('[name=batchType]:checked').val()) {
            case '1':
                batchHour.hide();

                for (i = 1; i <= 14; i++) {
                    batchLimit.append($("<option></option>").val(i).text(i + "日"));
                }
                break;
            case '2':
                batchHour.show();
                var rest = 1;

                for (i = hour; i < 24; i++) {
                    batchLimit.append($("<option></option>").val(rest).text(rest + "小時"));
                    rest++;
                }
                break;
        }

        maxRun();
    }

    function maxRun() {

        var today = getNowDate();
        var max = 0;
        var fromHour = $("#batchHour").val();
        var hour = $("#batchLimit").val();
        var remain = 0;
        var batchNums = $('[name*=batchNum]').val(0);
        var calTimes = window.calTimes || 1;

        switch ($('[name="batchType"]:checked').val()) {
            case '1':
                if ($("#batchDate").val() == today) {
                    remain = 24 - fromHour;
                    max = ((hour - 1) * 24 + remain) * 12 * calTimes;
                } else {
                    max = hour * 12 * 24 * calTimes;
                }
                break;
            case '2':
                max = hour * 12 * calTimes;
                break;
        }

        batchNums.attr('max', max);
        $('#batchMaxNum').val(max);
        checkNum();

    }

    function checkNum (item) {

        var max = $('#batchMaxNum').val();
        var total = 0;
        var sum = $('#sum');

        item = (item === undefined) ? $('[name*="batchNum"]:first') : $(item);

        $('[name*="batchNum"]').each(function() {
            total += parseInt($(this).val());
        });

        if (total > max) {
            var cal = 0;

            $('[name*="batchNum"]').not(item).each(function() {
                cal += parseInt(this.value);
            });

            item.val(max - cal);

            $.alert({
                content: '開彩次數過大，目前條件最大總和為' + max
            });

            sum.text(max + ' / ' + max);
        } else {
            sum.text(total + ' / ' + max);
        }
    }

    function saveSingle(methodUrl, methodName) {

        var send = $('button[data-target="submit"]');
        var date = $('#date').val();
        var hour = $('#hour').val();
        var min = $('#min').val();
        var filter = /^[0-9a-zA-Z@]+/;
        var index = 0;

        try {
            if (isNaN(hour) || isNaN(min)) {
                throw new Error('時間格式錯誤');
            }

            if (!filter.test(date) || date.length != 10) {
                throw new Error('日期格式錯誤');
            }

            $.confirm({
                title: '',
                confirmButton: '確定',
                cancelButton: '取消',
                content: '確定要設定要排程類型?',
                confirm: function() {
                    send.prop('disabled', true);
                    var params = $("#contentForm").serializeArray();
                    params.push({name: 'class', value: methodName});

                    $.post(methodUrl, params, function(result) {
                        if (result === 'done') {
                            $.alert({
                                content: '已經設定完成',
                                confirm: function() {
                                    window.location.reload();
                                }
                            });
                        } else {
                            send.prop("disabled", false);
                            $.alert({
                                content: result
                            });
                        }
                    });
                }
            });
        } catch (e) {
            $.alert({
                content: e.message
            });
        }

    }

    function saveBatch(methodUrl, methodName) {

        var send = $('button[data-target="submit"]');
        var batchDate = $('#batchDate').val();
        var filter = /^[0-9a-zA-Z@]+/;

        try {
            if (!filter.test(batchDate) || batchDate.length != 10) {
                throw new Error('日期格式錯誤');
            }

            var count = 0;

            $('[name*=batchNum]').each(function() {
                count += parseInt(this.value);
            });

            if (count === 0) {
                throw new Error('請至少選設定一筆');
            }

            $.confirm({
                title: '',
                confirmButton: '確定',
                cancelButton: '取消',
                content: '確定要設定排程類型?',
                confirm: function() {
                     send.prop("disabled", true);
                    var params = $("#batchForm").serializeArray();
                    params.push({name: 'class', value: methodName});

                    $.post(methodUrl, params, function(result) {
                        if (result === 'done') {
                            send.prop("disabled", false);
                            $.alert({
                                content: '已經設定完成',
                                confirm: function() {
                                    window.location.reload();
                                }
                            });
                        } else {
                            send.prop("disabled", false);
                            $.alert({
                                content: result
                            });
                        }
                    });
                }
            });
        } catch (e) {
            $.alert({
                content: e.message
            });
        }

    }

	function saveNowSet(methodUrl, methodName,gameNo) {
        var title = $("#setTitle").val();

        if(title.trim() == ''){
            alert('請填入設定值名稱!');
        }else{
    		var send = $('#saveNowSet');
            try {
                $.confirm({
                    title: '',
                    confirmButton: '確定',
                    cancelButton: '取消',
                    content: '確定要儲存參數?',
                    confirm: function() {
                        send.prop('disabled', true);
                        var params = $("#contentForm2").serializeArray();
                        params.push({name: 'class', value: methodName});
    					params.push({name: 'gameNo', value: gameNo});
                        $.post(methodUrl, params, function(result) {
                            if (result === 'done') {
                                send.prop("disabled", false);
                                $.alert({
                                    content: '已經設定完成',
                                    confirm: function() {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                send.prop("disabled", false);
                                $.alert({
                                    content: result
                                });
                            }
                        });
                    }
                });
            } catch (e) {
                $.alert({
                    content: e.message
                });
            }
        }
	}

	function setListValue(methodUrl, methodName) {
		var send = $('#setListValue');
		var data=$('#savedSet :selected').attr('alt');
        try {
            $.confirm({
                title: '',
                confirmButton: '確定',
                cancelButton: '取消',
                content: '確定要儲存參數?',
                confirm: function() {
                    send.prop('disabled', true);
                    var params = $("#contentForm2").serializeArray();
                    params.push({name: 'class', value: methodName});
					params.push({name: 'data', value: data});
                    $.post(methodUrl, params, function(result) {
                        if (result === 'done') {
                            send.prop("disabled", false);
                            $.alert({
                                content: '已經設定完成',
                                confirm: function() {
                                    window.location.reload();
                                }
                            });
                        } else {
                            send.prop("disabled", false);
                            $.alert({
                                content: result
                            });
                        }
                    });
                }
            });
        } catch (e) {
            $.alert({
                content: e.message
            });
        }
	}

	function delSetListValue(methodUrl, methodName) {
		var send = $('#delSetListValue');
		try {
			$.confirm({
                title: '',
                confirmButton: '確定',
                cancelButton: '取消',
				content: '確定要刪除參數?',
				confirm: function() {
					send.prop('disabled', true);
					var params = $("#contentForm2").serializeArray();
					params.push({name: 'class', value: methodName});
					$.post(methodUrl, params, function(result) {
						if (result === 'done') {
							send.prop("disabled", false);
							$.alert({
								content: '已經刪除完成',
								confirm: function() {
									window.location.reload();
								}
							});
						} else {
							send.prop("disabled", false);
							$.alert({
								content: result
							});
						}
					});
				}
			});
		} catch (e) {
			$.alert({
				content: e.message
			});
		}
	}

	function showSetListValue(methodUrl, methodName) {
		var data=$('#savedSet :selected').attr('alt');
		var array=data.split('#');
		var str='<table class="table table-striped"><thead><tr><th>組別</th><th></th><th></th></tr></thead><tbody>';
		var ct=1;
		var ct1=1;
		var limit;
		var expectation=0;
		var RTPValue=[65,94,98,104,94,98,104];
		for (var i in array) {
			expectation=0;
			str += "<tr><td>第" + ct + "組";
			var val = array[i].split(",");
			for (var l in val){
				if (ct1>2){
					var set=val[l].split("/");
					if (ct1>3) str +=",";
					str += "RTP" + set[0] + "=" + set[1] + "%";
					expectation+=RTPValue[set[0]]*set[1]/100;
				}else if (ct1==2){
					limit=numeral((parseInt(val[l])-1)/1000);
					str += "(" + limit.format('0,0.000') + ")</td>";
					str += "<td>RTP設定為:";
				}
				ct1++;
			}
			str += "</td><td>期望值為:" + expectation.toFixed(2) + "</td>";
			ct1=1;
			ct++;
		}
        str+='</tbody></table>';
		$('#dialog').html( str );
		$('#dialog').css({display:'block'});
	}

	function showSetListValue1(methodUrl, methodName) {
		var data=$('#savedSet :selected').attr('alt');
		var array=data.split('#');
		var str='<div class="x_content"><div class="table-responsive"><table class="table table-striped"><thead><tr><th>組別</th><th></th></tr></thead><tbody>';
        var ct=1;
		var ct1=1;
		var limit;
		var expectation=0;
		var RTPValue=[1,2,3,4,5,6,7,8,9,10];
		for (var i in array) {
			expectation=0;
            // str += "<div><span style='width:15%;display: inline-block;'>第" + ct + "組";
			str += "<tr><td>第" + ct + "組";
			var val = array[i].split(",");
			for (var l in val){
				if (ct1>2){
					var set=val[l].split("/");
					if (ct1>3) str +=",";
					str += set[0];
				}else if (ct1==2){
					limit=numeral((parseInt(val[l])-1)/1000);
					str += "(" + limit.format('0,0.000') + ")</td>";
					str += "<td>設定為:";
				}
				ct1++;
			}
			str += "</td><tr>";
			ct1=1;
			ct++;
		}
        str+='</tbody></table>';
		$('#dialog').html( str );
		$('#dialog').css({display:'block'});
	}

	function closeSetListValue() {
		$('#dialog').css({display:'none'});
	}

	function tempSave(methodUrl, methodName,gameNo,bettingValue) {
		var itemContainer = $('.item_container');
		var send = $('#tempSave');
		var date = $('#date').val();
        var hour = $('#hour').val();
        var min = $('#min').val();
        var filter = /^[0-9a-zA-Z@]+/;
        var index = 0;
		var no1 = parseInt($('#no1').val());
		var no2 = parseInt($('#no2').val());
        try {
            if (isNaN(hour) || isNaN(min)) {
                throw new Error('時間格式錯誤');
            }

            if (!filter.test(date) || date.length != 10) {
                throw new Error('日期格式錯誤');
            }
			//alert($('input:radio:checked[name="type"]').val());
			if ($('input:radio:checked[name="type"]').val() == 1){
				if (no1>no2){
					throw new Error('組號區間設定錯誤!');
				}
			}

            itemContainer.each(function(i) {
                index = i;

                itemContainer.removeClass('red_outline');

                if ($(this).find('[name*="rtp_check"]:checked').size() === 0) {
                    throw new Error('請至少勾選一個項目');
                }

				if (gameNo!=36 && gameNo!=45){
					var sum = 0;

					$(this).find('[name*="rtp_check"]:checked').each(function() {
						sum += parseInt($(this).next().val());
					});

					if (sum !== 100) {
						throw new Error('比重總合必須為 100');
					}
				}
            });

            $.confirm({
                title: '',
                confirmButton: '確定',
                cancelButton: '取消',
                content: '確定要設定暫存資料?',
                confirm: function() {
                    send.prop('disabled', true);
                    var params = $("#contentForm").serializeArray();
                    params.push({name: 'class', value: methodName});
					params.push({name: 'gameNo', value: gameNo});
					params.push({name: 'bettingValue', value: bettingValue});
                    $.post(methodUrl, params, function(result) {
						//alert(result);
                        if (result === 'done') {
                            send.prop("disabled", false);
                            $.alert({
                                content: '已經設定完成',
                                confirm: function() {
                                    window.location.reload();
                                }
                            });
                        } else {
                            send.prop("disabled", false);
                            $.alert({
                                content: result
                            });
                        }
                    });
                }
            });
        } catch (e) {
            itemContainer.eq(index).addClass('red_outline');
            $.alert({
                content: e.message
            });
        }
	}

	function saveOnLine(methodUrl, methodName,bettingValue) {
		var send = $('#tempSave');
		var date = $('#date').val();
        var hour = $('#hour').val();
        var min = $('#min').val();
        var filter = /^[0-9a-zA-Z@]+/;
        try {
            if (isNaN(hour) || isNaN(min)) {
                throw new Error('時間格式錯誤');
            }

            if (!filter.test(date) || date.length != 10) {
                throw new Error('日期格式錯誤');
            }

            $.confirm({
                title: '',
                confirmButton: '確定',
                cancelButton: '取消',
                content: '確定要儲存設定排程?',
                confirm: function() {
                    send.prop('disabled', true);
                    var params = $("#contentForm").serializeArray();
                    params.push({name: 'class', value: methodName});

                    $.post(methodUrl, params, function(result) {
						//alert(result);
                        if (result === 'done') {
                            send.prop("disabled", false);
                            $.alert({
                                content: '已經設定完成',
                                confirm: function() {
                                    window.location.reload();
                                }
                            });
                        } else {
                            send.prop("disabled", false);
                            $.alert({
                                content: result
                            });
                        }
                    });
                }
            });
        } catch (e) {
            itemContainer.eq(index).addClass('red_outline');
            $.alert({
                content: e.message
            });
        }
	}

	function showType(){
		if ($('input:radio:checked[name="type"]').val()==1){
			$("#no").show();
		}else{
			$("#no").hide();
		}
	}