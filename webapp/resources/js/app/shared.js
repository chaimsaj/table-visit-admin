!function ($) {
    "use strict";

    let SweetAlert = function () {
    };

    //examples
    SweetAlert.prototype.init = function () {
        //Basic
        $('.sweet-basic').on('click', function () {
            Swal.fire(
                {
                    title: 'Any fool can use a computer',
                    confirmButtonColor: '#556ee6',
                }
            )
        });

        //Warning Message
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
                confirmButtonText: "Yes, delete it!"
            }).then(function (result) {
                if (result.value) {
                    showLoad();
                    window.location.href = action;

                    // Swal.fire("Deleted!", "Your file has been deleted.", "success");
                }
            });

            return false;
        });

        //Parameter
        $('.sweet-warning-params').click(function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success mt-2',
                cancelButtonClass: 'btn btn-danger ms-2 mt-2',
                buttonsStyling: false,
            }).then(function (result) {
                if (result.value) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Your file has been deleted.',
                        icon: 'success',
                    })
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire({
                        title: 'Cancelled',
                        text: 'Your imaginary file is safe :)',
                        icon: 'error',
                    })
                }
            });
        });

    }, $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),
    function ($) {
        "use strict";
        $.SweetAlert.init()
    }(window.jQuery);

function showLoad() {
    $('#status').show();
    $('#preloader').fadeIn('slow');
}

function hideLoad() {
    $('#status').fadeOut();
    $('#preloader').delay(350).fadeOut('slow');
}
