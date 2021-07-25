<!-- View Merchants -->
<div class="row mt-4 txt-dark">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4>Customers</h4>
        <hr class="mt-2" />
        <?php if(count($customers) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">Name</th>
                        <th class="py-2 font-weight-normal">Email</th>
                        <th class="py-2 font-weight-normal">Profile</th>
                        <th class="py-2 font-weight-normal">Flag</th>
                        <th class="py-2 font-weight-normal">Orders</th>
                    </tr>
                </thead>
                <tbody class="lato">
                <?php for($i=0;$i < count($customers);$i++){ ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $customers[$i]['fname'].' '.$customers[$i]['lname']; ?></td>
                        <td><?php echo $customers[$i]['email']; ?></td>
                        <td><button type="button" cid="<?php echo $customers[$i]['id']; ?>" class="btn btn-info btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="view(this);"><i class="fa fa-eye"></i>&nbsp;View</button></td>
                        <?php if($customers[$i]['status']==0){ ?>
                            <td><button type="button" cid="<?php echo $customers[$i]['id']; ?>" class="btn btn-danger btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="flag(this);"><i class="fa fa-flag"></i> Flag</button></td>
                        <?php }else{ ?>
                            <td><button type="button" cid="<?php echo $customers[$i]['id']; ?>" class="btn btn-outline-success btn-sm rounded-0 pl-3 pr-3 pt-2 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unflag(this);"><i class="fa fa-flag"></i> Unflag</button></td>
                        <?php } ?>
                        <td><a href="<?php echo base_url('admin/customer_records/'.$customers[$i]['id']); ?>" class="btn btn-info btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;"><i class="fa fa-eye"></i>&nbsp;View</a></td>
                    </tr>
                <?php $count++;} ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
            <div class="myinfo p-3 txt-sec text-center">
                <p>You have no customers yet!</p>
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
      <div class="modal-body p-3">
            <div class="myinfo p-3 px-4 pl-sm-4 small" style="background-color:#eee !important;">
            <p class="txt-dark"><b class="font-weight-bold">Customer Name:</b> <span id="cname">DENOBLE</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Gender:</b> <span id="gender">Male</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Address:</b> <span id="adres">Ikorodu</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Phone Number:</b> <span id="phno">09087787676</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Email:</b> <span id="email">hello@yahoo.com</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Reg. Date:</b> <span id="rdate">May 5, 2018</span></p>
            <p class="txt-dark mt-1"><b class="font-weight-bold">Status:</b> <span id="status">Flagged</span></p>
            </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer pl-2 pr-2 pt-0 pb-0">
        <button type="button" class="btn btn-sm bg-morange bg-white rounded-0 py-1 rbord" data-dismiss="modal">ok</button>
      </div>

    </div>
  </div>
</div>