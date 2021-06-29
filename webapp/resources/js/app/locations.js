'use strict';

function initCountries() {
}

function initStates() {
}

function initCities() {
    /*$('#example').dataTable({
        "ajax": {
            "url": "data.json",
            "type": "POST"
        }
    });*/
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
