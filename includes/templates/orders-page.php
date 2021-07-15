<?php
$restaurant = new Restaurant();
$restaurants = $restaurant->getRestaurants();

$product = new Product();

$order = new Order();
$orders = $order->getOrders();
?>
<div class="container">
  <div class="content-header">
    <h1 class="display-4">Orders</h1>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addOrderModal">+</button>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Order #</th>
        <th scope="col">Client Name</th>
        <th scope="col">Item</th>
        <th scope="col">Quantity</th>
        <th scope="col">Total</th>
        <th scope="col">Fees</th>
        <th scope="col">Transfer</th>
        <th scope="col">Restaurant</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($orders as $key => $value) {
          ?>
          <tr>
            <th scope="row"><?= $value->id?></th>
            <td><?= $value->client_name?></td>
            <td><?= $product->getProduct($value->prod_id)->name?></td>
            <td><?= $value->quantity?></td>
            <?php
              $prod_price = $product->getProduct($value->prod_id)->price;
              $total = (float)$prod_price * (int)$value->quantity;
            ?>
            <td><?= $total?></td>
            <td><?= $value->fees?></td>
            <td><?= $value->transfer?></td>
            <td><?= $restaurant->getRestaurant($value->resto_id)->name?></td>
            <td><a href="#" onclick="cip_remove('order', <?= $value->id?>)">Delete</a></td>
          </tr>
          <?php
        }
      ?>
    </tbody>
  </table>

  <!-- Modal -->
  <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addOrderModalLabel">Add a order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="client-name">Client Name</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" aria-describedby="client-name" id="clientName">
          </div>
          <div class="input-group mb-3 input-group-fix">
            <div class="input-group-prepend">
              <label class="input-group-text" for="restaurantName">Restaurant</label>
            </div>
            <select class="custom-select" id="restaurantName">
              <option value="" selected disabled hidden>Choose here</option>
              <?php
                foreach ($restaurants as $key => $value) {
                  ?>
                    <option value="<?= $value->id?>"><?= $value->name?></option>
                  <?php
                }
              ?>
            </select>
          </div>
          <div class="form-group row">
            <div class="col-sm-12">
              Food to order:
              <div class="row food-list">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="orderQty">Quantity</label>
            <input type="number" class="form-control" id="orderQty" placeholder="0" step='1'>
          </div>
          <div class="form-group row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="feeAmount">Fees</label>
                <input type="number" class="form-control" id="feeAmount" placeholder="0.0" step="0.1">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="transferAmount">Transfer</label>
                <input type="number" class="form-control" id="transferAmount" placeholder="0.0" step="0.1">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="add-order">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>