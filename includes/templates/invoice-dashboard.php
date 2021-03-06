<div class="filter-options">
  <div class="filter-buttons">
    <button type="button" class="btn btn-secondary cip-filter-key" onclick="cipFilter('all', this)">ALL</button>
    <button type="button" class="btn cip-filter-key" onclick="cipFilter('ongoing', this)">ONGOING</button>
    <button type="button" class="btn cip-filter-key" onclick="cipFilter('verified', this)">VERIFIED</button>
    <button type="button" class="btn cip-filter-key" onclick="cipFilter('pending', this)">PENDING</button>
  </div>
  <div class="filter-dates">
    <div class="filter-dates-label">
      <img src="<?php echo plugin_dir_url( __FILE__ ) . "../../public/images/calendar.png"?>" alt="" srcset="">
      <span>From</span>
    </div>
    <div class="filter-dates-inputs">
      <span class="calendar">&#128197;</span>
      <input type="text" id="min" name="min" placeholder="Min Date">
      <span>&#8594;</span>
      <span class="calendar">&#128197;</span>
      <input type="text" id="max" name="max" placeholder="Max Date">
    </div>
  </div>
  <div class="filter-search">
    <img src="<?php echo plugin_dir_url( __FILE__ ) . "../../public/images/search.png"?>" alt="" srcset="">
    <input type="text" id="custom-search" placeholder="Search">
  </div>
  <div class="mark-paid">
    <button type="button" class="btn btn-primary btn-lg" onclick="cipMarkPaid(this)">Mark as paid</button>
  </div>
</div>
<table id="invoice-table" class="hover" style="width:100%">
  <thead>
    <tr>
      <!-- <th><input class="cip-checkbox" type="checkbox" value="all"></th> -->
      <th>More Info</th>
      <th></th>
      <th><span class="tick-mark">Tick to Mark</span></th>
      <th>ID</th>
      <th>Restaurant</th>
      <th>Status</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Total</th>
      <th>Fees</th>
      <th>Transfer</th>
      <th>Orders</th>
      <th><span class="download-csv">Download to CSV</span></th>
    </tr>
  </thead>
</table>
<div class="mark-paid-mobile">
    <button type="button" class="btn form-control btn-primary btn-lg" onclick="cipMarkPaid(this)">Mark as paid</button>
</div>