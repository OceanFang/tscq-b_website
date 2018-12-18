$(function () {

    treeForm();

    $('#tree_submit').on('click', function (e) {
        $.confirm({
            title: false,
            content: '是否確定送出?',
            cancelButton: '取消',
            confirmButton: '確定',
            theme: 'material',
            confirm: function() {
                $('#tree_form').submit();
            }
        });
    });

    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', '點擊此階層可以收合');

    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', '點擊此階層可以收合');
        } else {
            children.show('fast');
            $(this).attr('title', '點擊此階層可以收合');
        }
        e.stopPropagation();
    });

    $("#checkAll").click(function(){
        if($(this).prop('checked')){//如果全選按鈕有被選擇的話（被選擇是true）
            $("input[name='permissions[]']").each(function(){
                $(this).prop('checked',true);//把所有的核取方框的property都變成勾選
            });
            $("input[name='all_check[]']").each(function(){
                $(this).prop('checked',true);//把所有的核取方框的property都變成勾選
            });
        } else {
            $("input[name='permissions[]']").each(function(){
                $(this).prop('checked',false);
            });
            $("input[name='all_check[]']").each(function(){
                $(this).prop('checked',false);
            });
        }
    });

    $('input[type=checkbox]').click(function(){
        // if is checked
        if($(this).is(':checked')){

            // check all children
            $(this).parent().find('li input[type=checkbox]').prop('checked', true);

            // check all parents
            $(this).parent().prev().prop('checked', true);
        } else {
            // uncheck all children
            $(this).parent().find('li input[type=checkbox]').prop('checked', false);
        }
    });
});

function treeForm() {
    //表單驗證
    var form = $('#tree_form');
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
                        window.location.href=prevUrl;
                    }
                });

            }
        }
    });
}