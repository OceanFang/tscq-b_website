$(function() {
    initForm();
    initFormBackForPreURL();
    initFormByClass();
});

function initForm() {
    //表單驗證
    var form = $('#modify_form');
    var prevUrl = $('[name="prev_url"]').val();

    form.ajaxForm({
        dataType: 'json',
        success: function(response) {
            if (response.status === 'fail') {
                $.alert({
                    title: false,
                    content: response.message,
                    confirmButton: '确定',
                    theme: 'material',
                });
            } else {
                if (response.data) {
                    data = response.data;
                } else {
                    data = response.status;
                }
                $.alert({
                    title:false,
                    content:data,
                    theme: 'material',
                    onClose:function(){
                        window.location.reload();
                    }
                });

            }
        }
    });
}

function initFormByClass() {
    //表單驗證
    var form = $('.reloadAfterModify');
    var prevUrl = $('[name="prev_url"]').val();

    form.ajaxForm({
        dataType: 'json',
        success: function(response) {
            if (response.status === 'fail') {
                $.alert({
                    title: false,
                    content: response.message,
                    confirmButton: '确定',
                    theme: 'material',
                });
            } else {
                if (response.data) {
                    data = response.data;
                } else {
                    data = response.status;
                }
                $.alert({
                    title:false,
                    content:data,
                    theme: 'material',
                    onClose:function(){
                        window.location.reload();
                    }
                });

            }
        }
    });
}

function initFormBackForPreURL() {
    //表單驗證
    var form = $('#form_back_to_main');
    var prevUrl = $('[name="prev_url"]').val();
    var submitDisable = function() {
        $(':submit').prop('disabled', true);
    };
    var submitRestore = function() {
        $(':submit').prop('disabled', false);
    };

    form.ajaxForm({
        dataType: 'json',
        beforeSubmit: function() {
            submitDisable();
            $('body').append("<img id='loading_pic' style='top: 45%; position: absolute; height: 100px; width: 100px;left: 45%;' src='/asset/image/loader.gif' />");
        },
        success: function(response) {
            if (response.status === 'fail') {
                $.alert({
                    title: false,
                    content: response.message,
                    confirmButton: '确定',
                    theme: 'material',
                });
                $('#loading_pic').remove();
                submitRestore();
            } else {
                if (response.data) {
                    data = response.data;
                } else {
                    data = response.status;
                }
                $.alert({
                    title:false,
                    content:data,
                    theme: 'material',
                    onClose:function(){
                        window.location.href=$('[name="prev_url"]').val();
                    }
                });
                $('#loading_pic').remove();
            }
        },
        error: function() {
            submitRestore();
            $('#loading_pic').remove();
        }
    });
}
