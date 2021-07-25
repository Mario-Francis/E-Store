<!-- New orders -->
<div class="row mt-4">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4>New Orders</h4>
        <hr class="mt-2" />
        <?php if(count($orders) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">#Transaction&nbsp;ID</th>
                        <th class="py-2 font-weight-normal">No.&nbsp;of&nbsp;Items</th>
                        <th class="py-2 font-weight-normal">Total&nbsp;Amount&nbsp;(&#8358;)</th>
                        <th class="py-2 font-weight-normal">&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="lato">
                    <?php foreach($orders as $o){ ?>
                    <tr>
                        <td><?php echo (int)array_search($o, $orders) +1; ?></td>
                        <td><?php echo $o['tid']; ?></td>
                        <td><?php echo $o['qty']; ?></td>
                        <td><?php echo number_format($o['total'], 2); ?></td>
                        <td><?php echo date('M d, Y', $o['date']); ?></td>
                    </tr>
                    <?php } ?>
                    <!-- <tr>
                        <td>2</td>
                        <td>Peter Okeke</td>
                        <td>41, Catholic Mission Street, Lagos Island, Lagos</td>
                        <td>3</td>
                        <tD>13,000.00</td>
                        <td>May 9, 2018</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
        <div class="p-3 myinfo mt-2">
            <p class="text-center txt-sec"><i class="fa fa-info-circle"></i> No recently placed orders</p>
        </div>
        <?php } ?>
    </div>
</div>