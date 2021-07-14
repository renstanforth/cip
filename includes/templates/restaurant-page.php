<!-- Initial: Static Data -->
<div class="container">
  <div class="jumbotron">
    <h1 class="display-4">Restaurants</h1>
    <p class="lead">This page is to add/delete restaurant information.</p>
    <hr class="my-4">
    <p>If you would like to add a restaurant entry, click the button below.</p>
    <p class="lead">
      <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addRestoModal">
        Add a restaurant
      </button>
    </p>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Logo</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td>Restaurant 1</td>
        <td><img src="https://www.logodesign.net/images/tutorials/restaurent-logos/restaurant-logo-designer-needs.png"/></td>
        <td><a href="#">Delete</a></td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Restaurant 1</td>
        <td><img src="https://www.pngkit.com/png/full/291-2913293_big-image-restaurant-logo.png"/></td>
        <td><a href="#">Delete</a></td>
      </tr>
    </tbody>
  </table>

  <!-- Modal -->
  <div class="modal fade" id="addRestoModal" tabindex="-1" role="dialog" aria-labelledby="addRestoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addRestoModalLabel">Add a restaurant</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="restaurantName">Restaurant Name</label>
            <input type="text" class="form-control" id="restaurantName" placeholder="Enter Restaurant Name">
          </div>
          <div class="form-group">
            <label for="restaurantLogo">Restaurant Logo</label>
            <input type="text" class="form-control" id="restaurantLogo" placeholder="Provide URL of the image">
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