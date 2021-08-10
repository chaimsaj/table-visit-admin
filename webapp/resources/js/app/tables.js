'use strict';

function initTables() {
    let datatable = $('#tables-datatable').DataTable({
        columnDefs: [
            {
                targets: 'no-sort', orderable: false
            }
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/admin/tables/list",
            type: "POST"
        },
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'place_name'},
            {data: 'display_order'},
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
