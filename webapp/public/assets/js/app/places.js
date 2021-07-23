'use strict';

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

function initPlaces() {

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
