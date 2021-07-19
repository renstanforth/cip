<div class="filter-buttons">
  <button type="button" class="btn btn-secondary cip-filter-key" onclick="cipFilter('all', this)">ALL</button>
  <button type="button" class="btn cip-filter-key" onclick="cipFilter('ongoing', this)">ONGOING</button>
  <button type="button" class="btn cip-filter-key" onclick="cipFilter('verified', this)">VERIFIED</button>
  <button type="button" class="btn cip-filter-key" onclick="cipFilter('pending', this)">PENDING</button>
</div>
<table id="invoice-table" class="display" style="width:100%">
  <thead>
    <tr>
      <th>ID</th>
      <th>Restaurant</th>
      <th>Status</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Total</th>
      <th>Fees</th>
      <th>Transfer</th>
      <th>Orders</th>
      <th></th>
    </tr>
  </thead>
</table>