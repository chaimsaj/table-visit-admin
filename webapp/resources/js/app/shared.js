!function ($) {

}(window.jQuery),
    function ($) {
        "use strict";
        sweetWarning();
    }(window.jQuery);

function initLoad() {
    $('.load').click(function (e) {
        showLoad();
    });
}

function showLoad() {
    $('#status').show();
    $('#preloader').fadeIn('slow');
}

function hideLoad() {
    $('#status').fadeOut();
    $('#preloader').delay(350).fadeOut('slow');
}

function sweetWarning() {
    $('.sweet-warning').click(function (e) {
        e.preventDefault();
        let action = $(this).attr('href');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#34c38f",
            cancelButtonColor: "#f46a6a",
            confirmButtonText: "Yes, I'm sure!"
        }).then(function (result) {
            if (result.value) {
                showLoad();
                window.location.href = action;

                // Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
        });

        return false;
    });
}
