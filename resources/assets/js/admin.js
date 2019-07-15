$(document).ready(function () {
    var links = $('.sidebar ul li a');
    $.each(links, function (key, va) {
        if (va.href == document.URL) {
            $(this).addClass('active');
        }
    });

});


window.runToastmessage = function (text, type) {
    type = type || 'success';  // "notice", "success", "warning", "error"
    $().toastmessage('showToast', {
        text     : text,
        sticky   : false,
        inEffectDuration:  600,
        stayTime: 3000,
        position : 'top-right',
        type     : type,
    });
};
