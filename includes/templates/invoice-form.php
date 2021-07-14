<!-- Initial: Static Data -->
<form>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Restaurant:</label>
    <div class="col-sm-10">
      <select class="form-control" id="restaurant">
        <option>Resto 1</option>
        <option>Resto 2</option>
        <option>Resto 3</option>
        <option>Resto 4</option>
        <option>Resto 5</option>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Status:</label>
    <div class="col-sm-10">
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-secondary active">
          <input type="radio" name="status" id="option1" autocomplete="off" checked> Ongoing
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="status" id="option2" autocomplete="off"> Pending
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="status" id="option3" autocomplete="off"> Verified
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="status" id="option4" autocomplete="off"> Paid
        </label>
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Date Range:</label>
    <div class="col-sm-5">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon3">Start Date:</span>
        </div>
        <input type="text" class="form-control" id="date-start" name="dateStart" aria-describedby="basic-addon3">
      </div>
    </div>
    <div class="col-sm-5">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon3">End Date:</span>
        </div>
        <input type="text" class="form-control" id="date-end" name="dateEnd" aria-describedby="basic-addon3">
      </div>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Order List:</label>
    <div class="col-sm-10">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Order #</th>
            <th scope="col">Date</th>
            <th scope="col">Total</th>
            <th scope="col">Fees</th>
            <th scope="col">Transfer</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>16/08/2018</td>
            <td>2.99</td>
            <td>3.99</td>
            <td>0.99</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>16/08/2018</td>
            <td>2.99</td>
            <td>3.99</td>
            <td>0.99</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>16/08/2018</td>
            <td>2.99</td>
            <td>3.99</td>
            <td>0.99</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</form>