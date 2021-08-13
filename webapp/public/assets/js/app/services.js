'use strict';

function initServices() {
    let datatable = $('#services-datatable').DataTable({
        columnDefs: [
            {
                targets: 'no-sort', orderable: false
            }
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/admin/services/list",
            type: "POST",
            data: {
                is_admin: $("#user_is_admin").val(),
                tenant_id: $("#user_tenant_id").val(),
            }
        },
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'service_type_name'},
            {data: 'display_order'},
            {
                data: null, render: function (data) {
                    return '<a href="/service/delete/' + data['id'] + '" class="text-danger sweet-warning"><i class="mdi mdi-delete font-size-18"></i></a>';
                }
            },
            {
                data: null, render: function (data) {
                    return '<a href="/service/' + data['id'] + '" class="text-success load"><i class="mdi mdi-pencil font-size-18"></i></a>';
                }
            }
        ],
        drawCallback: function () {
            initLoad();
            sweetWarning();
        }
    });
}

function initService() {
}

function initServiceTypes() {
}

function initServiceType() {
}

function initServiceRates() {
}

function initServiceRate() {
}