var dataTable;

$(document).ready(function() {
  $.noConflict();
  dataTable = $('#invoice-table').DataTable({
    "ajax": ajax_urls.api + "/invoices",
    "columns": [
        { "data": "id" },
        { "data": "restaurant" },
        { "data": "status" },
        { "data": "start_date" },
        { "data": "end_date" },
        { "data": "total" },
        { "data": "fees" },
        { "data": "transfer" },
        { "data": "orders" },
        {
            data: null,
            className: "cip-download",
            defaultContent: '<a href="#" onclick="cipDownload(this)"><img src="' + ajax_urls.plugin_public_images + '/download.png"/></a>',
            orderable: false
        }
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

function cipDownload(e) {
  var rowId = $(e).parent().parent().children(':first-child').text();
  window.location.href = ajax_urls.api + "/invoices/download?id=" + rowId;
}