<!-- View Merchants -->
<div class="row mt-4 txt-dark">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4>Payments/Debts to Merchants</h4>
        <hr class="mt-2" />
        <?php if(count($records) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">#Transaction&nbsp;ID</th>
                        <th class="py-2 font-weight-normal">Merchant</th>
                        <th class="py-2 font-weight-normal">Amount&nbsp;(&#8358;)</th>
                        <th class="py-2 font-weight-normal">Paid?</th>
                        <th class="py-2 font-weight-normal">More</th>
                    </tr>
                </thead>
                <tbody class="lato">
                <?php foreach($records as $r){ ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $r['tid']; ?></td>
                        <td><?php echo $r['mname']; ?></td>
                        <td><?php echo number_format($r['amt'], 2); ?></td>
                        <td><?php if($r['status']==0){ ?>
                            <a href="javascript:void(0);" oid="<?php echo $r['oid']; ?>" mid="<?php echo $r['mid']; ?>" amt="<?php echo $r['amt']; ?>" class="btn btn-info btn-sm f12 rounded-0 px-2 pady-2 m-0 text-capitalize" style="min-width:60px;box-shadow:none !important;" onclick="pay(this, 1);">No &nbsp;<i class="fa fa-exclamation-circle"></i></a>
                            <?php }else{ ?>
                                <a href="javascript:void(0);" oid="<?php echo $r['oid']; ?>" mid="<?php echo $r['mid']; ?>" amt="<?php echo $r['amt']; ?>" class="btn btn-success btn-sm f12 rounded-0 px-2 pady-2 m-0 text-capitalize" style="min-width:60px;box-shadow:none !important;" onclick="pay(this, 0);">Yes &nbsp;<i class="fa fa-check-circle"></i></a>
                            <?php } ?>
                            </td>
                            <td>
                                <a href="javascript:void(0);" oid="<?php echo $r['oid']; ?>" mid="<?php echo $r['mid']; ?>" class="btn text-info btn-lg rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;box-shadow:none !important;" onclick="view(this);"><i class="fa fa-ellipsis-h"></i></a>
                            </td>
                    </tr>
                <?php $count++;} ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
            <div class="myinfo p-3 txt-sec text-center">
                <p><i class="fa fa-info-circle"></i> &nbsp;No records found</p>
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
        <h5 class="modal-title pl-2">Customer Details</h5>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3 txt-dark">
            
            <div class="myinfo p-3 px-4 pl-sm-4 small" style="background-color:#eee !important;">
                <h6 class="txt-morange m-0">Products sold</h6>
                <hr class="mt-0 mb-2" />
                <div id="cartdiv">

                </div>
                <hr class="my-1" />
                <div class="row">
                    <div class="col-1 px-0 py-2"><p class="text-center">&nbsp;&nbsp;</p></div>
                    <div class="col-11 px-1">
                        <p class="txt-dark"><b class="font-weight-bold">Total:</b> &#8358;<span id="total">DENOBLE</span></p>
                    </div>
                </div>

                <h6 class="txt-morange m-0">Merchant Info</h6>
                <hr class="mt-0 mb-2" />
            
                <div class="pl-3">
                    <p class="txt-dark"><b class="font-weight-bold">Name:</b> <span id="mname">DENOBLE</span></p>
                    <p class="txt-dark mt-1"><b class="font-weight-bold">Email:</b> <span id="email">Mhjvhjs@uahoo.com</span></p>
                    <p class="txt-dark mt-1"><b class="font-weight-bold">Phone Number:</b> <span id="phno">878900</span></p>
                    <p class="txt-dark mt-1 phno"><b class="font-weight-bold">Phone Number 2:</b> <span id="phno2">878900</span></p>
                    <p class="txt-dark mt-1 bank"><b class="font-weight-bold">Bank:</b> <span id="bank">09087787676</span></p>
                    <p class="txt-dark mt-1 bank"><b class="font-weight-bold">Account Type:</b> <span id="acctype">Savings</span></p>
                    <p class="txt-dark mt-1 bank"><b class="font-weight-bold">Account Name:</b> <span id="accname">Mario</span></p>
                    <p class="txt-dark mt-1 bank"><b class="font-weight-bold">Account Number:</b> <span id="accno">087870</span></p>
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