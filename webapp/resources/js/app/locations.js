(function () {
    $(document).ready(function () {

    });
})();

function initCities() {
    $('#example').dataTable({
        "ajax": {
            "url": "data.json",
            "type": "POST"
        }
    });
}

function initCity() {
    $('#example').dataTable({
        "ajax": {
            "url": "data.json",
            "type": "POST"
        }
    });
}
