'use strict';

function initBookings() {
    let datatable = $('#bookings-datatable').DataTable({
        columnDefs: [
            {
                targets: 'no-sort', orderable: false
            }
        ],
        order: [[2, "asc"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/admin/bookings/list",
            type: "POST",
            data: {
                is_admin: $("#user_is_admin").val(),
                tenant_id: $("#user_tenant_id").val(),
            }
        },
        columns: [
            {data: 'code'},
            {data: 'confirmation_code'},
            {data: 'customer'},
            {data: 'place'},
            {data: 'book_date_data'},
            {data: 'guests_count'},
            {data: 'total_amount'},
            {data: 'spent_amount'},
            /*{
                data: null, render: function (data) {
                    return null;
                }
            },*/
            {
                data: null, render: function (data) {
                    return '<a href="/booking/' + data['id'] + '" class="text-success load"><i class="mdi mdi-pencil font-size-18"></i></a>';
                }
            }
        ],
        drawCallback: function () {
            initLoad();
            sweetWarning();
        }
    });
}

function initBooking() {
}
