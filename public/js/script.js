var dataTable;

$(document).ready(function() {
  $.noConflict();
  dataTable = $('#invoice-table').DataTable({
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
    ],
    "lengthChange": false,
    "language": {
      "info": "PAGE _PAGE_ of _PAGES_",
      paginate: {
        next: '&gt;', // or '>'
        previous: '&lt;' // or '<' 
      }
    }
  });
} );

function cipFilter(key, element) {
  dataTable.column(2).search(key).draw();

  if (key === 'all') {
    key = '';
  }
  dataTable.column(2).search(key).draw();

  $('.filter-buttons .btn').removeClass('btn-secondary');
  
  $(element).addClass('btn-secondary');
}