<!-- New orders -->
<div class="row mt-4 txt-dark">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4>Your Products</h4>
        <!-- <input type="checkbox" class="mchk" /> -->
        <hr class="mt-2" />
        <?php if(isset($products) && count($products)> 0){ ?>
        <div class="table-responsive">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">Product&nbsp;Name</th>
                        <th class="py-2 font-weight-normal">Category</th>
                        <th class="py-2 font-weight-normal">Price&nbsp;(&#8358;)</th>
                        <th class="py-2 font-weight-normal">Date&nbsp;Added</th>
                        <th class="py-2 font-weight-normal">Edit</th>
                        <th class="py-2 font-weight-normal">Availability&nbsp;Status</th>
                        <th class="py-2 font-weight-normal">Status</th>
                        <th class="py-2 font-weight-normal">Special&nbsp;Status</th>
                    </tr>
                </thead>
                <tbody id="tbody" class="lato">
                    <?php for($i=0;$i < count($products);$i++){ ?>
                    <tr class="font-weight-bold">
                        <td><?php echo $count; ?></td>
                        <td><?php echo $products[$i]['pname']; ?></td>
                        <td><?php echo $products[$i]['cat']; ?></td>
                        <td><?php echo $products[$i]['price']; ?></td>
                        <td><?php echo $products[$i]['date']; ?></td>
                        <td><button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-outline-info btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="edit(this);"><i class="fa fa-edit"></i>&nbsp;Edit</button></td>
                        <td>
                            <?php if($products[$i]['avail']==1){ ?>
                                <button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-success btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unavail(this);"><i class="fa fa-check-circle"></i> &nbsp;Yes</button>
                            <?php }else{  ?>
                                <button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-info btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="avail(this);"><i class="fa fa-info-circle"></i> &nbsp;No</button>
                            <?php } ?>
                        </td>
                        <td>
                        <?php if($products[$i]['status']==0){ ?>
                            <button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-danger btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="flag(this);"><i class="fa fa-flag"></i> Flag</button>
                        <?php }else{ ?>
                            <button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-outline-success btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unflag(this);"><i class="fa fa-flag-checkered"></i> Unflag</button>
                        <?php } ?>
                        </td>
                        <td>
                        <?php if($products[$i]['special']==0){ ?>
                            <button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-primary btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:86px;" onclick="mark(this);"><i class="fa fa-check"></i> Mark</button>
                        <?php }else{ ?>
                            <button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-outline-primary btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:86px;" onclick="unmark(this);"><i class="fa fa-times"></i> Unmark</button>
                        <?php } ?>
                        </td>
                    </tr>
                    <?php $count++; } ?>
                    
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
            <div class="myinfo p-3">
                <p class="txet-center txt-sec">No products found!</p>
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
<div class="modal fade" id="eModal">
  <div class="modal-dialog rounded-0">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header bg-morange rounded-0 p-2">
        <h5 class="modal-title pl-3">Edit Product</h5>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <form>
      <div class="modal-body p-3 px-4">
            <input type="hidden" id="rate" value="<?php echo $rate; ?>" />
            <p class="txtlab mt-2">Product Category</p>
			<select class="form-control mtxtbx" id="cat" style="display:block !important;" required>
                <option value="" selected>Select Category</option>
                <?php for($i=0;$i<count($cats);$i++){ ?>
                <option value="<?php echo $cats[$i]['id']; ?>"><?php echo $cats[$i]['cat']; ?></option>
                <?php } ?>
            </select>

            <p class="txtlab mt-2">Product Name</p>
			<input type="text" id="pname" class="form-control mtxtbx" required />

            <p class="txtlab mt-2">Previous Price <span class="txt-sec">(Optional)</span></p>
			<input type="number" max="999999999" min="0" id="pprice" class="form-control mtxtbx" />

            <p class="txtlab mt-2">Current Price</p>
			<input type="number" max="999999999" min="0" id="cprice" class="form-control mtxtbx" required />
            <div class="myinfo p-3 small mt-2">
				<p>Note that you will be charged <?php echo $rate ?>% on each product sold! <br /><b class="font-weight-bold txt-morange">Sale Price: </b>&#8358;<span id="sprice">0</span>
				</p>
			</div>
            
            <p class="txtlab mt-2">Description</p>
			<textarea id="descrip" class="form-control mtxtbx" style="resize:none;" rows="3" required></textarea>

            <p id="err" class="text-center mt-2 err text-danger">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
			</p>
			<script>
				document.getElementById('err').style.display = 'none';
			</script>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer pl-2 pr-2 pt-0 pb-0">
        <button type="submit" id="updatebtn" class="btn btn-sm txt-morange bg-white rbord bg-white rounded-0 pt-1 pb-1 text-capitalize f12">Update</button>
        <button type="button" id="cancelbtn" class="btn btn-sm bg-morange text-white rounded-0 pt-1 pb-1 text-capitalize f12" data-dismiss="modal">Cancel</button>
      </div>
      </form>

    </div>
  </div>
</div>