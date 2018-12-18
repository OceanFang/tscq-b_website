$(function() {
    init_date();
 });

function init_date() {
    if( typeof ($.fn.daterangepicker) === 'undefined'){ return; }

    var cb = function(start, end, label) {
        // $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    };

    var optionSet1 = {
      startDate: moment(),
      endDate: moment(),
      minDate: '01/01/2016',
      // maxDate: '12/31/2015',
      // dateLimit: {
      //   days: 60
      // },
      showDropdowns: true,
      showWeekNumbers: true,
      timePicker: false,
      timePickerIncrement: 1,
      timePicker12Hour: true,
      ranges: {
        '今日': [moment(), moment()],
        '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '最近7日': [moment().subtract(6, 'days'), moment()],
        '最近30日': [moment().subtract(29, 'days'), moment()],
        '本月': [moment().startOf('month'), moment().endOf('month')],
        '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      opens: 'left',
      buttonClasses: ['btn btn-default'],
      applyClass: 'btn-small btn-primary',
      cancelClass: 'btn-small',
      format: 'YYYY-MM-DD',
      separator: ' to ',
      locale: {
        applyLabel: '確定',
        cancelLabel: '取消',
        fromLabel: '起始時間',
        toLabel: '结束時間',
        customRangeLabel: '自定義',
        daysOfWeek: ["日", "一", "二", "三", "四", "五", "六"],
        monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        firstDay: 1
      }
    };

    var start = $('#start').val();
    var end  = $('#end').val();
    if($('#start').val() == ''){
      start = moment().format('YYYY-MM-DD');
    }
    if($('#end').val() == ''){
      end = moment().format('YYYY-MM-DD');
    }

    $('#reportrange span').html(start + ' - ' + end);
    $('#reportrange').daterangepicker(optionSet1, cb);

    $('#reportrange').on('show.daterangepicker', function() {
      // console.log("show event fired");
    });
    $('#reportrange').on('hide.daterangepicker', function() {
      // console.log("hide event fired");
    });

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('YYYY-MM-DD') + " to " + picker.endDate.format('YYYY-MM-DD'));
        $('#start').val(picker.startDate.format('YYYY-MM-DD'));
        $('#end').val(picker.endDate.format('YYYY-MM-DD'));
        $('#reportrange span').html(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        $('#selectForm').submit();
    });
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
    });
    $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
    });
    $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
    });
    $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
    });

    $("input[name='tester_filter").click(function() {
        $('#selectForm').submit();
    });
};