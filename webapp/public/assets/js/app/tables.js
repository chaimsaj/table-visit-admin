'use strict';

function initTables() {
    let datatable = $('#tables-datatable').DataTable({
        columnDefs: [
            {
                targets: 'no-sort', orderable: false
            }
        ],
        order: [[1, "asc"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/admin/tables/list",
            type: "POST",
            "deferRender": true,
            data: function (data) {
                data.is_admin = $("#user_is_admin").val();
                data.tenant_id = $("#user_tenant_id").val();
            }
        },
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'table_type_name'},
            {data: 'minimum_spend'},
            {data: 'guests_count'},
            {data: 'place_name'},
            {
                data: null, render: function (data) {
                    return '<a href="/table/delete/' + data['id'] + '" class="text-danger sweet-warning"><i class="mdi mdi-delete font-size-18"></i></a>';
                }
            },
            {
                data: null, render: function (data) {
                    return '<a href="/table/' + data['id'] + '" class="text-success load"><i class="mdi mdi-pencil font-size-18"></i></a>';
                }
            }
        ],
        drawCallback: function () {
            initLoad();
            sweetWarning();
        }
    });
}

function initTable() {
}

function initTableTypes() {
}

function initTableType() {
}

function initTableRates() {
}

function initTableRate() {
}
