<!-- Initial: Static Data -->
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
      <tr>
        <th scope="row">1</th>
        <td>Ren Stanforth</td>
        <td>Pizza</td>
        <td>1</td>
        <td>3.00</td>
        <td>0.10</td>
        <td>0.10</td>
        <td>Restaurant 1</td>
        <td><a href="#">Delete</a></td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Ren Stanforth</td>
        <td>Milkshake</td>
        <td>1</td>
        <td>2.50</td>
        <td>0.05</td>
        <td>0.0</td>
        <td>Restaurant 1</td>
        <td><a href="#">Delete</a></td>
      </tr>
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
            <input type="text" class="form-control" aria-label="Default" aria-describedby="client-name" name="clientName">
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
          <div class="form-group row">
            <div class="col-sm-12">
              Food to order:
            </div>
            <div class="col-sm-4">
              <input type="radio" aria-label="Radio button for following text input" name="selectedProduct"> Pizza
            </div>
            <div class="col-sm-4">
              <input type="radio" aria-label="Radio button for following text input" name="selectedProduct"> Empanada
            </div>
            <div class="col-sm-4">
              <input type="radio" aria-label="Radio button for following text input" name="selectedProduct"> Mac & Cheese
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
          <button type="button" class="btn btn-primary">Add</button>
        </div>
      </div>
    </div>
  </div>
</div>