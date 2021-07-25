<!-- View Merchants -->
<div class="row mt-4 txt-dark">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4>Orders</h4>
        <hr class="mt-2" />
        <div class="row mb-2">
            <div class="col-sm-7">
                <form>
                    <p class="txtlab">Search</p>
                    <div class="input-group">
                        <input id="stxt" type="text" class="form-control p-2 mtxtbx rounded-0" placeholder="Search by transaction id or customer name" required />
                        <input type="hidden" id="shd" />
                        <button id="sbtn" type="submit" class="input-group-addon btn m-0 rounded-0 btn-sm py-0 pt-1 px-2 bg-light txt-dark bord" style="box-shadow:none;margin-bottom:2px;"><i class="fa fa-search" style="font-size:16px;"></i></button>
                    </div>
                    <div class="myinfo p-1 pl-2 mt-2">
                        <p class="small"><i class="fa fa-info-circle"></i> Enter <b>*</b> to view all</p>
                    </div>
                    <p class="text-danger small mt-2" id="err" style="display:none;"><i class="fa fa-exclamation-circle"></i> <span id="errsp">Error</span></p>
                </form>
            </div>
        </div>
        <div class="row" style="overflow-x:hidden;">
            <div class="col-12 py-1">	
				<div class="mspinner" id="loader1" style="display:none;">
  					<div class="bg-morange mcard"></div>
  					<div class="mcard"></div>
  					<div class="bg-morange mcard"></div>
  					<div class="mcard"></div>
				</div>
			</div>
        </div>
        <div id="tabdiv">
        <?php if(count($orders) > 0){ ?>
        <div class="table-responsive txt-dark mt-2">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">#ID</th>
                        <th class="py-2 font-weight-normal">Customer</th>
                        <th class="py-2 font-weight-normal">Items</th>
                        <th class="py-2 font-weight-normal">Total(&#8358;)</th>
                        <th class="py-2 font-weight-normal">&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
                        <th class="py-2 font-weight-normal">Paid?</th>
                        <th class="py-2 font-weight-normal">Del.&nbsp;Status</th>
                        <th class="py-2 font-weight-normal">Cancel</th>
                        <th class="py-2 font-weight-normal">More</th>
                    </tr>
                </thead>
                <tbody class="lato">
                <?php foreach($orders as $o){ ?>
                    <tr class="<?php echo $o['status']==1?'cancelled':''; ?>">
                        <td><?php echo $count; ?></td>
                        <td><?php echo $o['tid']; ?></td>
                        <td><?php echo $o['cname']; ?></td>
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
                        <td class="<?php echo $o['status']==1?'disabled':''; ?>">
                            <?php if($o['pstatus']==0){ ?>
                            <a href="javascript:void(0);" oid="<?php echo $o['id']; ?>" class="btn btn-info btn-sm f12 rounded-0 px-2 pady-2 m-0 text-capitalize <?php echo $o['method']==0?'disabled':''; ?>" style="min-width:60px;box-shadow:none !important;" onclick="pay(this);">No &nbsp;<i class="fa fa-exclamation-circle"></i></a>
                            <?php }else{ ?>
                            <a href="javascript:void(0);" oid="<?php echo $o['id']; ?>" class="btn btn-success btn-sm f12 rounded-0 px-2 pady-2 m-0 text-capitalize <?php echo $o['method']==0?'disabled':''; ?>" style="min-width:60px;box-shadow:none !important;" onclick="unpay(this);">Yes &nbsp;<i class="fa fa-check-circle"></i></a>
                            <?php } ?>
                        </td>
                        <td class="<?php echo $o['status']==1?'disabled':''; ?>">
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn <?php echo $o['dstatus']==0?'btn-sec':($o['dstatus']==1?'btn-primary':'btn-success'); ?> rounded-0 text-capitalize pady-2 f12"><?php echo $o['dstatus']==0?'Pending':($o['dstatus']==1?'Transit':'Delivered'); ?></button>
                                <button type="button" class="btn <?php echo $o['dstatus']==0?'btn-sec':($o['dstatus']==1?'btn-primary':'btn-success'); ?> dropdown-toggle dropdown-toggle-split rounded-0 pady-2" data-toggle="dropdown">
                                    <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu rounded-0">
                                    <a class="dropdown-item small" href="javascript:void(0);" onclick="$dstatus(this, 0);" oid="<?php echo $o['id']; ?>">Pending</a>
                                    <a class="dropdown-item small" href="javascript:void(0);" onclick="$dstatus(this, 1);" oid="<?php echo $o['id']; ?>">Transit</a>
                                    <a class="dropdown-item small" href="javascript:void(0);" onclick="$dstatus(this, 2);" oid="<?php echo $o['id']; ?>">Delivered</a>
                                </div>
                            </div>
                        </td>
                        <td>
                        <?php if($o['status']==0){ ?>
                            <a href="javascript:void(0);" oid="<?php echo $o['id']; ?>" class="btn btn-danger btn-sm rounded-0 px-2 py-1 m-0 text-capitalize <?php echo $o['dstatus']==2?'disabled':''; ?>" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="cancel(this, 1);">Cancel &nbsp;<i class="fa fa-times f13"></i></a>
                            <?php }else{ ?>
                            <a href="javascript:void(0);" oid="<?php echo $o['id']; ?>" class="btn btn-danger btn-lg rounded-0 px-2 py-1 m-0 text-capitalize <?php echo $o['dstatus']==2?'disabled':''; ?>" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="cancel(this, 0);">Cancelled &nbsp;<i class="fa fa-exclamation-circle f13"></i></a>
                            <?php } ?>
                        </td>
                        <td><a href="javascript:void(0);" oid="<?php echo $o['id']; ?>" class="btn text-info btn-lg rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="view(this);"><i class="fa fa-ellipsis-h"></i></a></td>
                    </tr>
                <?php $count++;} ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
            <div class="myinfo p-3 txt-sec text-center">
                <p><i class="fa fa-info-circle"></i> No orders have been made yet</p>
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
        <div class="row" style="overflow-x:hidden;">
            <div class="col-12 py-1">	
				<div class="mspinner" id="loader2" style="display:none;">
  					<div class="bg-morange mcard"></div>
  					<div class="mcard"></div>
  					<div class="bg-morange mcard"></div>
  					<div class="mcard"></div>
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
            <h6 class="txt-morange m-0 mt-2">Customer Information</h6>
            <hr class="m-0" />
            <div class="p-2">
                <p class="txt-dark mt-1"><b class="font-weight-bold">Name:</b> <span id="cname">Active</span></p>
                <p class="txt-dark mt-1"><b class="font-weight-bold">Email:</b> <span id="cemail">Active</span></p>
                <p class="txt-dark mt-1"><b class="font-weight-bold">Phone Number:</b> <span id="cphno">Active</span></p>
            </div>
            <h6 class="txt-morange m-0 mt-2">Seller(s)</h6>
            <hr class="m-0" />
            <div class="row" id="mdiv">
                <div class="col-1 px-0 py-2">
                    <p class="text-right">1.</p>
                </div>
                <div class="col-11 px-0">
                    <div class="p-1">
                        <p class="txt-dark mt-1"><b class="font-weight-bold">Name:</b> <span id="cname">Active</span></p>
                        <p class="txt-dark mt-1"><b class="font-weight-bold">Email:</b> <span id="cemail">Active</span></p>
                        <p class="txt-dark mt-1"><b class="font-weight-bold">Phone Number:</b> <span id="cphno">Active</span></p>
                        <p class="txt-dark mt-1"><b class="font-weight-bold">Products:</b> <span id="cphno">Active</span></p>
                    </div>
                </div>
            </div>
            </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer pl-2 pr-2 pt-0 pb-0">
        <button type="button" class="btn btn-sm bg-morange bg-white rounded-0 py-1 rbord" data-dismiss="modal">ok</button>
      </div>

    </div>
  </div>
</div>