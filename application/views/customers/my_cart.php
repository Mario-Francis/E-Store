<div class="row mt-4">
    <div class="offset-sm-1 col-sm-10 offset-md-2 col-md-8 offset-lg-3 col-lg-6 bg-white mcard">
        <?php if(isset($_SESSION['c_err'])){ ?>
        <div class="myinfo p-3 txt-morange" style="margin:0px -15px;">
            <h6 class="m-0 text-center"><i class="fa fa-exclamation-circle"></i> Error: <?php echo $_SESSION['c_err']; ?></h6>
        </div>
        <?php } ?>
        <h4 class="text-dark p-2 mt-3" style="font-family:open_sans;"><span class="p-1 pr-2 pl-2 rounded-circle bg-dark text-white"><i class="fa fa-shopping-cart"></i></span> &nbsp;My Cart</h4>
        <hr class="mt-2" />

        <?php if($mcart['qty'] > 0){ ?>
        <div class="row" id="mcart">
            <div class="col-12">
                <div class="table-responsive text-dark">
                    <table class="table">
                        <thead style="background-color:#ddd;">
                            <tr>
                                <th colspan="3">Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="mt-3" style="font-family:'hind';">
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <?php foreach($mcart['cart'] as $p){ ?>
                            <tr id="<?php echo $p['rowid']; ?>">
                                <td><img src="<?php echo base_url($p['fpath']); ?>" class="img-fluid" style="max-width:70px;" /></td>
                                <td colspan="2"><?php echo $p['pname']; ?></td>
                                <td><input type="number" rid="<?php echo $p['rowid']; ?>" class="float-right ml-1 mr-2 text-dark p-0 qty mtxtbx" value="<?php echo $p['qty']; ?>" min="1" max="500" style="width:40px"/></td>
                                <td>&#8358;<span><?php echo $p['fsub']; ?></span></td>
                                <td rid="<?php echo $p['rowid']; ?>" class="tab-rem"></td>
                            </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>
                </div>
                <hr class="mt-2 mb-3" />
                <div class="row text-dark">
                    <div class="col-6 pl-5">
                        <h5 class="">Total Price:</h5>
                    </div>
                    <div class="col-6 pr-5">
                        <h5 class="text-right txt-shd">&#8358;<span id="gtotal"><?php echo $mcart['total']; ?></span></h5>
                    </div>
                </div>
                <hr class="mt-2 mb-2" />
                <p class="text-right mb-3"><button type="button" id="checkout" login="<?php echo isset($_SESSION['c_det'])?'true':'false'; ?>" class="btn mcard bg-morange rounded-0 pl-sm-4 pr-sm-4 roboto">Checkout &nbsp;<i class="fa fa-arrow-right"></i></button></p>
                
            </div>
        </div>
        <?php } ?>
        <div class="row" id="empty">
            <div class="col-12 p-3">
                <div class="myinfo p-3 mb-4 mt-4">
                    <p class="text-center text-secondary">Your cart is empty!</p>
                </div>
            </div>
        </div>
        <?php if($mcart['qty'] > 0){ ?>
            <script>
                document.getElementById('empty').style.display='none';
            </script>
        <?php } ?>

    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="cModal">
  <div class="modal-dialog rounded-0">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header bg-morange rounded-0 p-2">
        <h6 class="modal-title text-center">Confirm Remove</h6>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3">
			<p class="text-center p-2"><i class="fa fa-exclamation-triangle txt-sec" style="font-size:30px;"></i></p>
			<h6 class="text-center txt-dark">Are you sure you want to remove this item from cart?</h5>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer pl-2 pr-2 pt-1 pb-1">
        <button type="button" id="ryesbtn" class="btn btn-sm txt-morange bg-white rounded-0 rbord pt-0 pb-0 pl-3 pr-3">Yes</button>
        <button type="button" id="rnobtn" class="btn btn-sm bg-morange text-white rounded-0 pt-0 pb-0 pl-3 pr-3" data-dismiss="modal">No</button>
      </div>

    </div>
  </div>
</div>