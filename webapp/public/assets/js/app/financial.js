'use strict';

function initCommissions() {
    let commissions = $('#commissions-datatable').DataTable({
        columnDefs: [
            {
                targets: 'no-sort',
                orderable: false
            }
        ],
        "paging": false,
        "searching": false,
        "ordering": false,
        order: [[0, "asc"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/admin/reports/commissions",
            type: "POST",
            "deferRender": true,
            data: function (data) {
                data.date_from = $("#date_from").val();
                data.date_to = $("#date_to").val();
                data.place_id = $("#place_id").val();
            }
        },
        columns: [
            {data: 'id'},
            {data: 'code'},
            {data: 'confirmation_code'},
            {data: 'book_date_data'},
            {data: 'total_amount'},
            {data: 'spent_total_amount'},
            {data: 'commission_amount'},
        ],
        drawCallback: function () {
            initLoad();
        },
        "footerCallback": function () {
            let api = this.api();

            let intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            let total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            $(api.column(4).footer()).html(
                formatMoney(total)
            );

            total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            $(api.column(5).footer()).html(
                formatMoney(total)
            );

            total = api
                .column(6)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            $(api.column(6).footer()).html(
                formatMoney(total)
            );
        }
    });

    $('#btnSearch').on('click', function (e) {
        e.preventDefault();
        commissions.ajax.reload();
    });
}

function initCommission() {
}

function initFees() {
}

function initFee() {
}

function initTableSpends() {
    let table_spends = $('#table-spends-datatable').DataTable({
        columnDefs: [
            {
                targets: 'no-sort',
                orderable: false
            }
        ],
        "paging": false,
        "searching": false,
        "ordering": false,
        order: [[0, "asc"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: "/api/admin/reports/table-spends",
            type: "POST",
            "deferRender": true,
            data: function (data) {
                data.is_admin = $("#user_is_admin").val();
                data.tenant_id = $("#user_tenant_id").val();
                data.date_from = $("#date_from").val();
                data.date_to = $("#date_to").val();
                data.place_id = $("#place_id").val();
            }
        },
        columns: [
            {data: 'id'},
            {data: 'code'},
            {data: 'confirmation_code'},
            {data: 'book_date_data'},
            {data: 'total_amount'},
            {data: 'spent_total_amount'},
        ],
        drawCallback: function () {
            initLoad();
        },
        "footerCallback": function () {
            let api = this.api();

            let intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            let total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            $(api.column(4).footer()).html(
                formatMoney(total)
            );

            total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            $(api.column(5).footer()).html(
                formatMoney(total)
            );
        }
    });

    $('#btnSearch').on('click', function (e) {
        e.preventDefault();
        table_spends.ajax.reload();
    });
}

function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
    try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign +
            (j ? i.substr(0, j) + thousands : '') +
            i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) +
            (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e)
    }
};
