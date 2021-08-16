/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************************!*\
  !*** ./resources/js/pages/datatables.init.js ***!
  \***********************************************/
$(document).ready(function () {
  $('#datatable').DataTable({
    columnDefs: [{
      targets: 'no-sort',
      orderable: false
    }],
    order: [[1, "asc"]]
  }); //Buttons examples

  var table = $('#datatable-buttons').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf', 'colvis']
  });
  table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
  $(".dataTables_length select").addClass('form-select form-select-sm');
});
/******/ })()
;