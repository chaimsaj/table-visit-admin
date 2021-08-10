'use strict';

function initCountries() {
}

function initStates() {
}

function initCities() {
    let datatable = $('#cities-datatable').DataTable({
        columnDefs: [
            {
                targets: 'no-sort', orderable: false
            }
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/admin/locations/cities",
            type: "POST"
        },
        columns: [
            // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id'},
            {data: 'name'},
            {data: 'iso_code'},
            {data: 'display_order'},
            {data: 'state_name'},
            {data: 'country_name'},
            {
                data: null, render: function (data) {
                    return '<a href="/city/delete/' + data['id'] + '" class="text-danger sweet-warning"><i class="mdi mdi-delete font-size-18"></i></a>';
                }
            },
            {
                data: null, render: function (data) {
                    return '<a href="/city/' + data['id'] + '" class="text-success load"><i class="mdi mdi-pencil font-size-18"></i></a>';
                }
            }
        ],
        drawCallback: function () {
            initLoad();
            sweetWarning();
        }
    });
}

function initCity() {
    $('#country_id').change(function () {
        const id = $(this).val();
        const selected_id = parseInt($(this).data('selected'));
        // Empty the dropdown
        //$('#state_id').find('option').not(':first').remove();

        let select = "<option value='0'>Select..</option>";
        $('#state_id').empty();
        $("#state_id").append(select);

        $.ajax({
            url: '/api/admin/locations/load_states/' + id,
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
                        $("#state_id").append(option);
                    }
                }
            }
        });
    });
}
