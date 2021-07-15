<?php
$restaurant = new Restaurant();
$restaurants = $restaurant->getRestaurants();

$product = new Product();
$products = $product->getProducts();
?>
<div class="container">
  <div class="content-header">
    <h1 class="display-4">Products</h1>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProductModal">+</button>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Product</th>
        <th scope="col">Price</th>
        <th scope="col">Restaurant</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach ($products as $key => $value) {
          ?>
          <tr>
            <th scope="row"><?= $value->id?></th>
            <td><?= $value->name?></td>
            <td><?= $value->price?></td>
            <td><?= $restaurant->getRestaurant($value->resto_id)->name?></td>
            <td><a href="#" onclick="cip_remove('product', <?= $value->id?>)">Delete</a></td>
          </tr>
          <?php
        }
      ?>
    </tbody>
  </table>

  <!-- Modal -->
  <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductModalLabel">Add a product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" class="form-control" id="productName" placeholder="Enter Product Name">
          </div>
          <div class="form-group">
            <label for="priceName">Product Price</label>
            <input type="number" class="form-control" id="priceName" placeholder="0.0" step="0.1">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="add-product">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>