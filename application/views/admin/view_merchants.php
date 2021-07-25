<!-- View Merchants -->
<div class="row mt-4">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4 class="txt-dark">Merchants</h4>
        <hr class="mt-2" />
        <?php if(count($merchants) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">Name</th>
                        <th class="py-2 font-weight-normal">Email</th>
                        <th class="py-2 font-weight-normal text-center">View</th>
                        <th class="py-2 font-weight-normal text-center">Flag</th>
                    </tr>
                </thead>
                <tbody class="lato">
                <?php for($i=0;$i < count($merchants);$i++){ ?>
                    <tr>
                        <td class="f16"><?php echo $count; ?></td>
                        <td class="f16"><?php echo $merchants[$i]['mname']; ?></td>
                        <td class="f16"><?php echo $merchants[$i]['email']; ?></td>
                        <td><button type="button" mid="<?php echo $merchants[$i]['id']; ?>" class="btn btn-primary btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="view(this);"><i class="fa fa-eye"></i>&nbsp;View</button></td>
                        <?php if($merchants[$i]['status']==0){ ?>
                            <td><button type="button" mid="<?php echo $merchants[$i]['id']; ?>" class="btn btn-danger btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="flag(this);"><i class="fa fa-flag"></i> Flag</button></td>
                        <?php }else{ ?>
                            <td><button type="button" mid="<?php echo $merchants[$i]['id']; ?>" class="btn btn-outline-success btn-sm rounded-0 pl-3 pr-3 pt-2 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unflag(this);"><i class="fa fa-flag"></i> Unflag</button></td>
                        <?php } ?>
                    </tr>
                <?php $count++; } ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
            <div class="myinfo p-3 txt-sec text-center">
                <p>You have no merchants yet!</p>
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
        <h5 class="modal-title">Merchant Details</h5>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3">
            <div class="myinfo p-3 pl-sm-4 small" style="background-color:#eee !important;">
            <p class="txt-dark"><b class="font-weight-bold">Merchant Name:</b> <span id="mname">DENOBLE</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Address 1:</b> <span id="adres1">Lagos</span></p>
            <p id="adres2p" class="txt-dark mt-1"><b class="font-weight-bold">Address 2:</b> <span id="adres2">Ikorodu</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Phone Number 1:</b> <span id="phno1">09087787676</span></p>
            <p id="phno2p" class="txt-dark mt-1"><b class="font-weight-bold">Phone Number 2:</b> <span id="phno2">798667578</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Email:</b> <span id="email">hello@yahoo.com</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Status:</b> <span id="status">Flagged</span></p>
            </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer pl-2 pr-2 pt-0 pb-0">
        <button type="button" class="btn py-1 bg-morange bg-white rounded-0" data-dismiss="modal">ok</button>
      </div>

    </div>
  </div>
</div>