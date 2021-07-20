var dataTable;
var minDate, maxDate;

$(document).ready(function() {
  $.noConflict();
  dataTable = $('#invoice-table').DataTable({
    "ajax": ajax_urls.api + "/invoices",
    "columns": [
        {
          data: null,
          className: "cip-checkbox",
          defaultContent: '<input type="checkbox">',
          orderable: false
        },
        {
          data: "id",
          render: function(data, type) {
            return "#" + data;
          }
        },
        {
          data: "restaurant",
          className: "cip-restaurant",
          render: function(data, type, row) {
            return '<div><img src="' + row.restaurant_logo + '" />' + row.restaurant + '</div>';
          }
        },
        {
          data: "status",
          render: function(data, type) {
            return '<span class="badge badge-pill badge-primary badge-' + data + '">' + data + '</span>';
          }
        },
        { "data": "start_date" },
        { "data": "end_date" },
        {
          data: "total",
          render: function(data, type) {
            return "HK$" + data.toFixed(2);
          }
        },
        {
          data: "fees",
          render: function(data, type) {
            return "HK$" + data.toFixed(2);
          }
        },
        {
          data: "transfer",
          render: function(data, type) {
            return "HK$" + data.toFixed(2);
          }
        },
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

  // Date Filtering Function(start date and end date)
  $.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
      var min = minDate.val();
      var max = maxDate.val();

      if (min != '' && max != '') {
        var startDate = new Date( data[4] );
        var endDate = new Date( data[5] );

        if (
            ( min === null && max === null ) ||
            ( startDate >= min && startDate <= max && endDate >= min && endDate <= max )
        ) {
            return true;
        }
        
        return false;
      }
    }
  );

  // Custom search
  $('#custom-search').keyup(function(){
    dataTable.search( $(this).val() ).draw();
 })

  // Create date inputs
  minDate = new DateTime($('#min'), {
      format: 'MM/DD/YYYY'
  });
  maxDate = new DateTime($('#max'), {
      format: 'MM/DD/YYYY'
  });

  // Refresh table
  $('#min, #max').on('change', function () {
    dataTable.draw();
  });
} );

function cipFilter(key, element) {
  dataTable.column(3).search(key).draw();

  if (key === 'all') {
    key = '';
  }
  dataTable.column(3).search(key).draw();

  $('.filter-buttons .btn').removeClass('btn-secondary');
  
  $(element).addClass('btn-secondary');
}

function cipDownload(e) {
  var rowId = $(e).parent().parent().children(':nth-child(2)').text();
  rowId = rowId.substring(1);
  window.location.href = ajax_urls.api + "/invoices/download?id=" + rowId;
}

function cipMarkPaid(e) {
  let a = [];
  $('.cip-checkbox input[type="checkbox"]:checked').each(function() {
    var idVal = $(this).parent().next().text();
    idVal = idVal.substring(1);
    a.push(idVal);
  });
  
  $.ajax({
    url: ajax_urls.api + "/invoices/paid",
    method: "POST",
    data: { 'data' : a},
    dataType: "json",
    success: function() {
      location.reload();
    }
  });
}