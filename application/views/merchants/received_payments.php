<div class="row mt-4 txt-dark">
    <div class="offset-sm-2 col-sm-8 bg-white p-3 mcard">
        <h4>Received Payments</h4>
        <hr class="mt-2" />
        <?php if(count($records) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">#Transaction&nbsp;ID</th>
                        <th class="py-2 font-weight-normal">Amount&nbsp;(&#8358;)</th>
                        <th class="py-2 font-weight-normal">&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                <tbody class="lato">
                <?php foreach($records as $r){ ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $r['tid']; ?></td>
                        <td><?php echo number_format($r['amt'], 2); ?></td>
                        <td><?php echo date('M d, Y', $r['date']); ?></td>
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