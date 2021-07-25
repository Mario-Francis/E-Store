
<div class="row mt-4 txt-dark">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4>Customer Payments Record</h4>
        <hr class="mt-2" />
        <?php if(count($payments) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">#Transaction&nbsp;ID</th>
                        <th class="py-2 font-weight-normal">#Payment&nbsp;ID</th>
                        <th class="py-2 font-weight-normal">Customer</th>
                        <th class="py-2 font-weight-normal">Method</th>
                        <th class="py-2 font-weight-normal">Amount(&#8358;)</th>
                        <th class="py-2 font-weight-normal">&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
                        <th class="py-2 font-weight-normal">Status</th>
                    </tr>
                </thead>
                <tbody class="lato">
                <?php foreach($payments as $p){ ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $p['tid']; ?></td>
                        <td><?php echo $p['payid']; ?></td>
                        <td><?php echo $p['cname']; ?></td>
                        <td><?php echo $p['method']=='paystack'?'Paystack':($p['method']=='transfer'?'Online Transfer':'Pay on Delivery'); ?></td>
                        <td><?php echo $p['amt']; ?></td>
                        <td><?php echo date('M d, Y', $p['pdate']); ?></td>
                        <td>
                        <?php if($p['status']==0){ ?>
                            <span class="badge badge-primary badge-sm f12 rounded-0 px-2 py-1 m-0 text-capitalize font-weight-light" style="min-width:60px;" >Attempt &nbsp;<i class="fa fa-exclamation-circle"></i></span>
                            <?php }else{ ?>
                            <span class="badge badge-success badge-sm f12 rounded-0 px-2 py-1 m-0 text-capitalize font-weight-light" style="min-width:60px;" >Paid &nbsp;<i class="fa fa-check-circle"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php $count++;} ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
            <div class="myinfo p-3 txt-sec text-center">
                <p><i class="fa fa-info-circle"></i><?php echo $cname; ?> No payment records were retrieved</p>
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

