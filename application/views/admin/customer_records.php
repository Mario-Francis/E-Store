
<div class="row mt-4 txt-dark">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4>Customer Order Records</h4>
        <h6 class="hind font-weight-bold"><b class="txt-morange">Name: </b> <?php echo $cname; ?></h6>
        <hr class="mt-2" />
        <?php if(count($orders) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">#ID</th>
                        <th class="py-2 font-weight-normal">Items</th>
                        <th class="py-2 font-weight-normal">Total(&#8358;)</th>
                        <th class="py-2 font-weight-normal">&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
                        <th class="py-2 font-weight-normal">More</th>
                    </tr>
                </thead>
                <tbody class="lato">
                <?php foreach($orders as $o){ ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $o['tid']; ?></td>
                        <td class="p-0">
                            <table class="table table-sm m-0">
                                <tr>
                                    <th class="f12">#</th>
                                    <th class="f12">Product&nbsp;Name</th>
                                    <th class="f12">Qty</th>
                                    <th class="f12">Del.&nbsp;Fee</th>
                                    <th class="f12">Sub.&nbsp;Total(&#8358;)</th>
                                </tr>
                                <?php foreach($o['cart']['cart'] as $p){ ?>
                                <tr>
                                    <td class="f13"><?php echo array_search($p, $o['cart']['cart'])+1; ?></td>
                                    <td class="f13"><?php echo $p['pname']; ?></td>
                                    <td class="f13"><?php echo $p['qty']; ?></td>
                                    <td class="f13"><?php echo $p['fdfee']; ?></td>
                                    <td class="f13"><?php echo $p['fsub']; ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td><?php echo $o['total']; ?></td>
                        <td><?php echo date('M d, Y', $o['odate']); ?></td>
                        <td><a href="javascript:void(0);" oid="<?php echo $o['id']; ?>" class="btn text-info btn-lg rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="view(this);"><i class="fa fa-ellipsis-h"></i></a></td>
                    </tr>
                <?php $count++;} ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
            <div class="myinfo p-3 txt-sec text-center">
                <p><i class="fa fa-info-circle"></i> &nbsp;<?php echo $cname; ?> have not made any order yet</p>
            </div>
        <?php } ?>
        <div class="row mt-4">
            <div class="col-12">
                <div id="pagediv">
                    <?php echo $links; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="vModal">
  <div class="modal-dialog rounded-0">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header bg-morange rounded-0 p-2">
        <h5 class="modal-title pl-2">More Details</h5>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3">
            <div class="myinfo p-3 px-4 pl-sm-4 small" style="background-color:#eee !important;">
            <p class="txt-dark" id="d"><b class="font-weight-bold">Discount:</b> &#8358;<span id="discount">25.00</span></p>
            <p class="txt-dark mt-1" id="v"><b class="font-weight-bold">VAT:</b> &#8358;<span id="vat">30.00</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Destination Address:</b> <span id="adres">Ikorodu</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Payment Method:</b> <span id="method">paystack</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Payment Status:</b> <span id="pstatus">Paid</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Delivery Status:</b> <span id="dstatus">Delivered</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Order Status:</b> <span id="status">Active</span></p>
            </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer pl-2 pr-2 pt-0 pb-0">
        <button type="button" class="btn btn-sm bg-morange bg-white rounded-0 py-1 rbord" data-dismiss="modal">ok</button>
      </div>

    </div>
  </div>
</div>