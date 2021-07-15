<?php
$restaurant = new Restaurant();
$restaurants = $restaurant->getRestaurants();

$post_meta = get_post_meta(get_the_ID());
?>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Restaurant:</label>
  <div class="col-sm-10">
    <select class="form-control" id="restaurant" name="cip_restaurant_id">
      <option value="" disabled hidden>Choose here</option>
      <?php
        foreach ($restaurants as $key => $value) {
          $selected = '';
          if( $post_meta['cip_restaurant_id'][0] === $value->id ) {
            $selected = 'selected';
          }
          ?>
            <option value="<?= $value->id?>" <?= $selected?>><?= $value->name?></option>
          <?php
        }
      ?>
    </select>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Status:</label>
  <div class="col-sm-10">
    <?php
      $status_check = 'checked';
      $status1 = '';
      $status2 = '';
      $status3 = '';
      $status4 = '';

      switch ($post_meta['cip_invoice_status'][0]) {
        case 'ongoing':
          $status1 = $status_check;
          break;
        case 'pending':
          $status2 = $status_check;
          break;
        case 'verified':
          $status3 = $status_check;
          break;
        case 'paid':
          $status4 = $status_check;
          break;
      }
    ?>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
      <label class="btn btn-secondary active">
        <input type="radio" name="cip_invoice_status" id="option1" autocomplete="off" value="ongoing" <?= $status1?>> Ongoing
      </label>
      <label class="btn btn-secondary">
        <input type="radio" name="cip_invoice_status" id="option2" autocomplete="off" value="pending" <?= $status2?>> Pending
      </label>
      <label class="btn btn-secondary">
        <input type="radio" name="cip_invoice_status" id="option3" autocomplete="off" value="verified" <?= $status3?>> Verified
      </label>
      <label class="btn btn-secondary">
        <input type="radio" name="cip_invoice_status" id="option4" autocomplete="off" value="paid" <?= $status4?>> Paid
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
      <input type="text" class="form-control" id="date-start" name="cip_date_start" aria-describedby="basic-addon3" value="<?= $post_meta['cip_date_start'][0]?>">
    </div>
  </div>
  <div class="col-sm-5">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon3">End Date:</span>
      </div>
      <input type="text" class="form-control" id="date-end" name="cip_date_end" aria-describedby="basic-addon3" value="<?= $post_meta['cip_date_end'][0]?>">
    </div>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Order List:</label>
  <div class="col-sm-10">
    <table class="table table-striped cip-order-list">
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
      </tbody>
    </table>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Total:</label>
  <div class="col-sm-10">
    <table class="table table-striped cip-total-sum-table">
      <tbody>
      <tr>
        <td></td>
        <td></td>
        <td><h4 class="cip-invoice-total"></h4></td>
        <td><h4 class="cip-invoice-total-fees"></h4></td>
        <td><h4 class="cip-invoice-total-transfer"></h4></td>
      </tr>
      </tbody>
    </table>
  </div>
</div>