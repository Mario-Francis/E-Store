<!-- Recently registered customers -->
<div class="row">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h5>Recently Registered Customers</h5>
        <hr class="mt-2" />
        <?php if(count($crecent) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">Name</th>
                        <th class="py-2 font-weight-normal">Email</th>
                        <th class="py-2 font-weight-normal">Date</th>
                    </tr>
                </thead>
                <tbody class="lato">
                    <?php foreach($crecent as $r){ ?>
                    <tr>
                        <td><?php echo (int)array_search($r, $crecent) +1; ?></td>
                        <td><?php echo $r['fname'].' '.$r['lname']; ?></td>
                        <td><?php echo $r['email']; ?></td>
                        <td><?php echo date('M d, Y'); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
        <div class="p-3 myinfo mt-2">
            <p class="text-center txt-sec"><i class="fa fa-info-circle"></i> No registered customers yet</p>
        </div>
        <?php } ?>
    </div>
</div>

<!-- Recently added products -->
<div class="row mt-4">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h5>Recently Added Products</h5>
        <hr class="mt-2" />
        <?php if(count($precent) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">Category</th>
                        <th class="py-2 font-weight-normal">Product</th>
                        <th class="py-2 font-weight-normal">Price (&#8358;)</th>
                        <th class="py-2 font-weight-normal">Merchant</th>
                        <th class="py-2 font-weight-normal">Date</th>
                    </tr>
                </thead>
                <tbody class="lato">
                    <?php foreach($precent as $p){ ?>
                    <tr>
                        <td><?php echo (int)array_search($p, $precent) +1; ?></td>
                        <td><?php echo $p['cat']; ?></td>
                        <td><?php echo $p['pname']; ?></td>
                        <td><?php echo number_format($p['cprice'], 2); ?></td>
                        <td><?php echo $p['merchant']; ?></td>
                        <td><?php echo date('M d, Y', $p['adate']); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
        <div class="p-3 myinfo mt-2">
            <p class="text-center txt-sec"><i class="fa fa-info-circle"></i> No added products yet</p>
        </div>
        <?php } ?>
    </div>
</div>

<!-- New orders -->
<div class="row mt-4">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h5>New Orders</h5>
        <hr class="mt-2" />
        <?php if(count($orders) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">Customer</th>
                        <th class="py-2 font-weight-normal">Destination</th>
                        <th class="py-2 font-weight-normal">No.&nbsp;of&nbsp;Items</th>
                        <th class="py-2 font-weight-normal">Total&nbsp;Amt(&#8358;)</th>
                        <th class="py-2 font-weight-normal">Date&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="lato">
                    <?php foreach($orders as $o){ ?>
                    <tr>
                        <td><?php echo (int)array_search($o, $orders) +1; ?></td>
                        <td><?php echo $o['cname']; ?></td>
                        <td><?php echo $o['adres']; ?></td>
                        <td><?php echo $o['qty']; ?></td>
                        <tD><?php echo number_format($o['total'], 2); ?></td>
                        <td><?php echo date('M d, Y', $o['odate']); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
        <div class="p-3 myinfo mt-2">
            <p class="text-center txt-sec"><i class="fa fa-info-circle"></i> No recently placed orders yet</p>
        </div>
        <?php } ?>
    </div>
</div>