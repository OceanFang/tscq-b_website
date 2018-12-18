$(function() {
    $('#insert_admin').click(function() {
        var admin_id = $('select[name="admin_name"]').val();
        var admin_txt = $('select[name="admin_name"] :selected').text();
        var userRoles = [];
        $(".users_role:checked").each(function() {
            userRoles.push($(this).val());
        });
        if (userRoles == '') {
            $.alert("請至少要勾選一個群組");
        } else {
            $.ajax({
                url: './admin/manage',
                data: { "admin_id": admin_id, "userRoles": userRoles },
                type: "POST",
                success: function(data) {
                    $.alert({
                        title: false,
                        content: '新增完畢',
                        confirmButton: 'OK',
                        onClose: function() {
                            window.location.reload();
                        }
                    })
                }
            });
        }
    });

    $('.admindel').click(function() {
        if(confirm("確認要進行刪除嗎?"))
        {
            var id = $(this).data('id');
            $.ajax({
                url: './admin/del',
                data: { "id": id },
                type: "POST",
                success: function(data) {
                    var content = '刪除失敗';
                    if(data == 'ok'){
                        content = '刪除完畢';
                    }
                    $.alert({
                        title: false,
                        content: content,
                        confirmButton: '確認',
                        onClose: function() {
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

    $('.freeze').click(function() {
        if(confirm("確認要凍結帳號嗎?"))
        {
            var id = $(this).data('id');
            $.ajax({
                url: './admin/lock-modify',
                data: { "id": id, "lock": 1 },
                type: "POST",
                success: function(data) {
                    var content = '凍結失敗';
                    if(data == 'ok'){
                        content = '凍結完畢';
                    }
                    $.alert({
                        title: false,
                        content: content,
                        confirmButton: '確認',
                        onClose: function() {
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

    $('.unfreeze').click(function() {
        if(confirm("確認要解凍帳號嗎?"))
        {
            var id = $(this).data('id');
            $.ajax({
                url: './admin/lock-modify',
                data: { "id": id, "lock": 0 },
                type: "POST",
                success: function(data) {
                    var content = '解凍失敗';
                    if(data == 'ok'){
                        content = '解凍完畢';
                    }
                    $.alert({
                        title: false,
                        content: content,
                        confirmButton: '確認',
                        onClose: function() {
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

    $('.groupdel').click(function() {
        var user = $(this).data('user');
        var text = '確認要進行群組刪除嗎';

        if(confirm(text))
        {
            var id = $(this).data('id');

            $.ajax({
                url: './group/destroy',
                data: { "id": id },
                type: "POST",
                success: function(data) {
                    var content = '刪除失敗';
                    if(data == 'ok'){
                        content = '刪除完畢';
                    }
                    $.alert({
                        title: false,
                        content: content,
                        confirmButton: '確認',
                        onClose: function() {
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });
});
