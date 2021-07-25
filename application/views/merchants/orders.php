<!-- New orders -->
<div class="row mt-4">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4>Orders</h4>
        <hr class="mt-2" />
        <?php if(count($orders) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">#Transaction&nbsp;ID</th>
                        <th class="py-2 font-weight-normal">Items</th>
                        <th class="py-2 font-weight-normal">Total(&#8358;)</th>
                        <th class="py-2 font-weight-normal">&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
                        <th class="py-2 font-weight-normal">&nbsp;&nbsp;Paid?&nbsp;&nbsp;</th>
                        <th class="py-2 font-weight-normal">Del.&nbsp;Status</th>
                        <th class="py-2 font-weight-normal">Status</th>
                    </tr>
                </thead>
                <tbody class="lato">
                    <?php foreach($orders as $o){ ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $o['tid']; ?></td>
                        <td class="p-0">
                            <table class="table table-sm m-0 text-left">
                                <tr>
                                    <th class="f12">#</th>
                                    <th class="f12">Product&nbsp;Name</th>
                                    <th class="f12">Price</th>
                                    <th class="f12">Qty</th>
                                    <th class="f12">Sub.&nbsp;Total(&#8358;)</th>
                                </tr>
                                <?php foreach($o['cart'] as $p){ ?>
                                <tr>
                                    <td class="f13"><?php echo array_search($p, $o['cart'])+1; ?></td>
                                    <td class="f13"><?php echo $p['pname']; ?></td>
                                    <td class="f13"><?php echo number_format($p['mprice'], 2); ?></td>
                                    <td class="f13"><?php echo $p['qty']; ?></td>
                                    <td class="f13"><?php echo number_format($p['stotal'], 2); ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td><?php echo number_format($o['total'], 2); ?></td>
                        <td><?php echo date('M d, Y', $o['odate']); ?></td>
                        <td>
                            <?php if($o['pstatus']==0){ ?>
                                <span class="badge badge-info badge-sm px-3 py-1 f12 font-weight-light rounded-0">No &nbsp;<i class="fa fa-exclamation-circle"></i></span>
                            <?php }else{ ?>
                                <span class="badge badge-success badge-sm px-3 py-1 f12 font-weight-light rounded-0">Yes &nbsp;<i class="fa fa-check-circle"></i></span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if($o['dstatus']==0){ ?>
                                <span class="badge btn-sec badge-sm px-3 py-1 f12 font-weight-light rounded-0">Pending</span>
                            <?php }else if($o['dstatus']==1){ ?>
                                <span class="badge badge-info badge-sm px-3 py-1 f12 font-weight-light rounded-0">Transit</span>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if($o['status']==0){ ?>
                                <span class="badge btn-success badge-sm px-3 py-1 f12 font-weight-light rounded-0" style="min-width:84px;">Active</span>
                            <?php }else{ ?>
                                <span class="badge badge-danger badge-sm px-3 py-1 f12 font-weight-light rounded-0">Cancelled</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $count++;} ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
        <div class="p-3 myinfo mt-2">
            <p class="text-center txt-sec"><i class="fa fa-info-circle"></i> You have no orders</p>
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