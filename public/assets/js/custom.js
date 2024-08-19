// Common Modal
$(document).on('click', 'a[data-ajax-popup="true"],a[data_ajax_popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"], span[data-ajax-popup="true"]', function (e) {
   

    var title = $(this).data('title');
    var size = ($(this).data('size') == '') ? 'md' : $(this).data('size');
    var url = $(this).data('url');

    if(url == null){
        var title = $(this).attr('data_title');
        var url = $(this).attr('data_url');
        var size = $(this).attr('data_size');
    }
    $("#commonModal .modal-dialog").addClass('modal-' + size);
    $("#commonModal .modal-footer").addClass('modal-footer');


    $.ajax({
        url: url,
        cache: false,
        success: function (data) {
            $('#commonModal .body').html(data);
            $("#commonModal").modal('show');
              $("#commonModal .modal-title").html(title);
        },
        error: function (data) {
            data = data.responseJSON;
            toaster('Error', data.error, 'error')
        }
    });
    e.stopImmediatePropagation();
    return false;
});
// end

// toaster js
function toaster(text, message, type) {
    var f = document.getElementById('liveToaster');
    var a = new bootstrap.Toast(f).show();
    if (type == 'success') {
        $('#liveToaster').addClass('bg-success');
    } else {
        $('#liveToaster').addClass('bg-danger');
    }
    $('#liveToaster .toast-body').html(message);
}
// end


