$(document).ready(function() {
  $( "#date-start" ).datepicker();
  $( "#date-end" ).datepicker();
  cip_refresh_order_list();

  $( "#add-restaurant" ).on( "click", function() {
    var data = {
      'name' : $( '#addRestoModal #restaurantName' ).val(),
      'logo' : $( '#addRestoModal #restaurantLogo' ).val()
    }

    $.ajax({
      url: "../wp-json/cip/v1/restaurants/insert",
      method: "POST",
      data: data,
      dataType: "json"
    }).done(function() {
      location.reload();
    });
  });

  $( "#add-product" ).on( "click", function() {
    var data = {
      'name' : $( '#addProductModal #productName' ).val(),
      'price' : $( '#addProductModal #priceName' ).val(),
      'resto_id' : $( '#addProductModal #restaurantName' ).val(),
    }

    $.ajax({
      url: "../wp-json/cip/v1/products/insert",
      method: "POST",
      data: data,
      dataType: "json"
    }).done(function() {
      location.reload();
    });
  });

  $( "#addOrderModal #add-order" ).on( "click", function() {
    var data = {
      'prod_id' : $( '#addOrderModal input[name="selectedProduct"]:checked' ).val(),
      'quantity' : $( '#addOrderModal #orderQty' ).val(),
      'resto_id' : $( '#addOrderModal #restaurantName' ).val(),
      'fees' : $( '#addOrderModal #feeAmount' ).val(),
      'transfer' : $( '#addOrderModal #transferAmount' ).val(),
      'client_name' : $( '#addOrderModal #clientName' ).val(),
    }

    $.ajax({
      url: "../wp-json/cip/v1/orders/insert",
      method: "POST",
      data: data,
      dataType: "json"
    }).done(function() {
      location.reload();
    });
  });

  $( "#addOrderModal #restaurantName" ).on( "change", function() {
    var restoId = $(this).val();

    $.ajax({
      url: "../wp-json/cip/v1/products?resto_id=" + restoId,
      method: "GET",
      dataType: "json",
      success: function(response) {
        $("#addOrderModal .food-list").empty();
        response.forEach(element => {
          var div = document.createElement('DIV');
          var inpt = document.createElement('INPUT');
          div.className = 'col-sm-6';
          inpt.type = 'radio';
          inpt.name = 'selectedProduct';
          inpt.value = element.id;
          $(div).append(inpt);
          $(div).append(element.name + " ($ " + element.price + ")");
          $("#addOrderModal .food-list").append(div);
        });
      }
    });
  });

  $( ".post-type-invoices #restaurant" ).on( "change", function() {
    $('table.cip-order-list tbody').empty();
    $('.post-type-invoices #date-start').val('');
    $('.post-type-invoices #date-end').val('');
  });

  $( ".post-type-invoices #date-start, .post-type-invoices #date-end" ).on( "change", function() {
    cip_refresh_order_list();
  });
} );

function cip_remove( keyword, id ) {
  $.ajax({
    url: "../wp-json/cip/v1/" + keyword + "s/remove?id=" + id,
    method: "DELETE"
  }).done(function() {
    location.reload();
  });
}

function cip_refresh_order_list() {
  var dateStart = $('.post-type-invoices #date-start').val();
  var dateEnd = $('.post-type-invoices #date-end').val();
  var restoID = $('.post-type-invoices #restaurant').val();
  
  if (dateStart !== '' && dateEnd !== '') {
    $.ajax({
      url: "../wp-json/cip/v1/orders?resto-id=" + restoID + "&start-date=" + dateStart + "&end-date=" + dateEnd,
      method: "GET",
      dataType: "json",
      success: function(response) {
        var totalOrders = 0;
        var totalFees = 0;
        var totalTransfer = 0;
        $('table.cip-order-list tbody').empty();
        response.forEach(element => {
          var tRow = document.createElement('TR');
          var tH = document.createElement('TH');
          var tD = document.createElement('td');
          tH.innerText = element.id;
          $(tRow).append(tH);

          var dateColumn = tD.cloneNode();
          dateColumn.innerText = element.date_created.slice(0, element.date_created.indexOf(' '));
          $(tRow).append(dateColumn);

          var totalColumn = tD.cloneNode();
          totalColumn.innerText = element.total;
          totalOrders = totalOrders + parseFloat(element.total);
          $(tRow).append(totalColumn);
          
          var feesColumn = tD.cloneNode();
          feesColumn.innerText = element.fees;
          totalFees = totalFees + parseFloat(element.fees);
          $(tRow).append(feesColumn);

          var transferColumn = tD.cloneNode();
          transferColumn.innerText = element.transfer;
          totalTransfer = totalTransfer + parseFloat(element.transfer);
          $(tRow).append(transferColumn);

          $('table.cip-order-list tbody').append(tRow);
        });

        $(".cip-invoice-total").text(totalOrders);
        $(".cip-invoice-total-fees").text(totalFees);
        $(".cip-invoice-total-transfer").text(totalTransfer);
      }
    });
  }
}