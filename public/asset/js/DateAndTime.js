$(function(){
	initdate();
	initime();
    initdatebyclass();
    initimebyclass();
    initimetominute();
});

//選擇日期
function initdate()
{
    $('input[name="start_date"],input[name="end_date"]').flatpickr({
        dateFormat: "Y-m-d"
    });
    // $('input[name="start_date"],input[name="end_date"]').bootstrapMaterialDatePicker({
    //     lang:'zh-tw',//日期顯示繁體中文
    //     weekStart :0,
    //     time:false,
    //     cancelText:'取消',
    //     okText:'確定',
    //     clearButton:false,
    // });
}

function initdatebyclass()
{
    $(".date_type_column").flatpickr({
        dateFormat: "Y-m-d"
    });
}

//選擇日期+時間
function initime()
{
    $('input[name="start_time"],input[name="end_time"]').flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i:S",
        allowInput: true,
        minDate: "today",
    });
}

function initimebyclass()
{
    $(".datetime_type_column").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i:S"
    });
}

//選擇日期+時間
function initimetominute()
{
    $(".date_to_minute").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i"
    });
}