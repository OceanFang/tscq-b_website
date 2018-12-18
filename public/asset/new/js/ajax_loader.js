$(function(){

	$(document).ajaxStart(function ()
    {
        $('#loader').modal('toggle').show();
    }).ajaxStop(function ()
    {
        $('#loader').modal('toggle').hide();
    });

});