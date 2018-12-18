$(function() {
    //跑馬燈編輯器=>刪除
    $('.marquee_del').click(function() {
        if (confirm("確認要進行刪除嗎?")) {
            var id = $(this).data('id');
            $.ajax({
                url: './marquee/delete',
                data: { "id": id },
                type: "POST",
                success: function(data) {
                    var content = '刪除失敗';
                    if (data == 'ok') {
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
    //跑馬燈編輯器=>複製文字 到編輯區
    $('.marquee_edit').click(function() {
        var id = $(this).data('id');
        v = $('#m_' + id).text();
        $('#content001').val(v);
        $('#content_id').val(id);
        $('#idtext').text("修改第" + id + "條");
    });
    //跑馬燈編輯器=>清空
    $('#no10clear').click(function() {
        $('#content001').val('');
        $('#content_id').val('');
        $('#idtext').text('新增');
    });
    //編輯按鈕按下去
    $('#no10edit').click(function() {
        var content = $('#content001').val();
        var id = $('#content_id').val();
        if (content == "") {
            alert("你尚未填寫內容");
            return 0;
        }
        $.ajax({
            url: './marquee/edit',
            data: { "id": id, "content": content },
            type: "POST",
            success: function(data) {
                var content = '儲存失敗';
                if (data == 'ok') {
                    content = '已儲存成功';
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
    });
 
    //======================================
});