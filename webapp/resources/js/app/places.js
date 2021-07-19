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
