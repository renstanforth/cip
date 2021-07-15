$(document).ready(function() {
  $.noConflict();
  $('#invoice-table').DataTable({
    "ajax": "/wp-json/cip/v1/invoices",
    "columns": [
        { "data": "id" },
        { "data": "restaurant" },
        { "data": "status" },
        { "data": "start_date" },
        { "data": "end_date" },
        { "data": "total" },
        { "data": "fees" },
        { "data": "transfer" },
        { "data": "orders" }
    ]
  });
} );