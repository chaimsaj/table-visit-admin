'use strict';

function initCommissions() {
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
            {data: 'book_date'},
            {data: 'total_amount'},
            {data: 'guests_count'},
            {
                data: null, render: function (data) {
                    return null;
                    // return '<a href="/booking/delete/' + data['id'] + '" class="text-danger sweet-warning"><i class="mdi mdi-delete font-size-18"></i></a>';
                }
            },
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

function initCommission() {
}

function initFees() {
}

function initFee() {
}

function initTableSpends() {
    let table_spends = $('#table-spends-datatable').DataTable({
        columnDefs: [
            {
                targets: 'no-sort',
                orderable: false
            }
        ],
        "paging": false,
        "searching": false,
        order: [[0, "asc"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/admin/reports/table-spends",
            type: "POST",
            "deferRender": true,
            data: function (data) {
                data.is_admin = $("#user_is_admin").val();
                data.tenant_id = $("#user_tenant_id").val();
                data.date_from = $("#date_from").val();
                data.date_to = $("#date_to").val();
                data.place_id = $("#place_id").val();
            }
        },
        columns: [
            {data: 'id'},
            {data: 'code'},
            {data: 'confirmation_code'},
            {data: 'book_date_data'},
            {data: 'total_amount'},
            {data: 'spent_total_amount'},
        ],
        drawCallback: function () {
            initLoad();
        }
    });

    $('#btnSearch').on('click', function (e) {
        e.preventDefault();
        table_spends.ajax.reload();
    });
}
