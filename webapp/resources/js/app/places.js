'use strict';

function initPlaces() {
    let datatable = $('#places-datatable').DataTable({
        columnDefs: [
            {
                targets: 'no-sort', orderable: false
            }
        ],
        order: [[2, "asc"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/admin/places/list",
            type: "POST",
            "deferRender": true,
            data: function (data) {
                data.is_admin = $("#user_is_admin").val();
                data.tenant_id = $("#user_tenant_id").val();
            }
        },
        columns: [
            {data: 'id'},
            {
                data: null, render: function (data) {
                    return '<img class="rounded avatar-sm" src="' + data['image'] + '" alt="' + data['name'] + '"/>';
                }
            },
            {data: 'name'},
            {data: 'city_name'},
            {data: 'state_name'},
            {data: 'display_order'},
            {
                data: null, render: function (data) {
                    return '<a href="/place/delete/' + data['id'] + '" class="text-danger sweet-warning"><i class="mdi mdi-delete font-size-18"></i></a>';
                }
            },
            {
                data: null, render: function (data) {
                    return '<a href="/place/' + data['id'] + '" class="text-success load"><i class="mdi mdi-pencil font-size-18"></i></a>';
                }
            }
        ],
        drawCallback: function () {
            initLoad();
            sweetWarning();
        }
    });
}

function initPlace() {
    if ($("#place_detail").length > 0) {
        tinymce.init({
            selector: "textarea#place_detail",
            height: 300,
            menubar: false,
            toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify",
            branding: false,
            statusbar: false,
        });
    }

    $('#state_id').change(function () {
        const id = $(this).val();
        const selected_id = parseInt($(this).data('selected'));
        // Empty the dropdown
        //$('#state_id').find('option').not(':first').remove();

        let select = "<option value='0'>Select..</option>";
        $('#city_id').empty();
        $("#city_id").append(select);

        $.ajax({
            url: '/api/admin/locations/load_cities/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                let len = 0;
                if (response && response.data) {
                    len = response.data.length;
                }

                if (len > 0) {
                    for (let i = 0; i < len; i++) {
                        let id = response.data[i].id;
                        let name = response.data[i].name;
                        let selected = id == selected_id ? 'selected' : '';
                        let option = "<option " + selected + " value='" + id + "'>" + name + "</option>";
                        $("#city_id").append(option);
                    }
                }
            }
        });
    });
}

function initPlaceFeatures() {
}

function initPlaceFeature() {
}

function initPlaceMusicList() {
}

function initPlaceMusic() {
}

function initPlaceTypes() {
}

function initPlaceType() {
}
