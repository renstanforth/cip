<!-- Initial: Static Data -->
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
      <tr>
        <th scope="row">1</th>
        <td>Product 1</td>
        <td>1.10</td>
        <td>Restaurant 1</td>
        <td><a href="#">Delete</a></td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Product 2</td>
        <td>2.00</td>
        <td>Restaurant 1</td>
        <td><a href="#">Delete</a></td>
      </tr>
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
              <option selected>Choose...</option>
              <option value="1">Resto 1</option>
              <option value="2">Resto 2</option>
              <option value="3">Resto 3</option>
              <option value="4">Resto 4</option>
              <option value="5">Resto 5</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>