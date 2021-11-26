'use strict';

function initCommissions() {
    let commissions = $('#commissions-datatable').DataTable({
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
            url: "/api/admin/reports/commissions",
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
        commissions.ajax.reload();
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
