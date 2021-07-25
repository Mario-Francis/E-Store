<!-- View Merchants -->
<div class="row mt-4">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4 class="txt-dark">Categories</h4>
        <hr class="mt-2" />
        <?php if(count($cats) > 0){ ?>
        <div class="table-responsive txt-dark">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white roboto">
                    <tr>
                        <th class="py-2 font-weight-normal">#</th>
                        <th class="py-2 font-weight-normal">Category Name</th>
                        <th class="py-2 font-weight-normal text-center">Edit</th>
                        <th class="py-2 font-weight-normal text-center">Flag</th>
                    </tr>
                </thead>
                <tbody id="tbody" class="lato">
                <?php for($i=0;$i < count($cats);$i++){ ?>
                    <tr>
                        <td class="f16"><?php echo $count; ?></td>
                        <td class="f16"><?php echo $cats[$i]['cat']; ?></td>
                        <td><button type="button" cid="<?php echo $cats[$i]['id']; ?>" class="btn btn-outline-info btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="edit(this);"><i class="fa fa-edit"></i>&nbsp;Edit</button></td>
                        <?php if($cats[$i]['status']==0){ ?>
                            <td><button type="button" cid="<?php echo $cats[$i]['id']; ?>" class="btn btn-danger btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="flag(this);"><i class="fa fa-flag"></i> Flag</button></td>
                        <?php }else{ ?>
                            <td><button type="button" cid="<?php echo $cats[$i]['id']; ?>" class="btn btn-outline-success btn-sm rounded-0 pl-3 pr-3 pt-2 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unflag(this);"><i class="fa fa-flag"></i> Unflag</button></td>
                        <?php } ?>
                    </tr>
                <?php $count++; } ?>
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
            <div class="myinfo p-3 txt-sec text-center">
                <p>You have not created any categories yet!</p>
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
        <h5 class="modal-title ml-2">Edit Category</h5>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3 px-4">
            <p class="txtlab mt-2">Category Name</p>
            <input type="text" id="cat" class="form-control mtxtbx" />
            <p class="txtlab mt-2">Delivery Fee
				<span class="txt-sec">(Optional)</span>
			</p>
			<input type="number" max="10000" min="0" id="dfee" class="form-control mtxtbx" />

			<p class="txtlab mt-2">Delivery Mode</p>
			<div class="mt-3">

				<div class="form-check radio-orange-gap">
					<input class="form-check-input with-gap" name="rd" type="radio" id="rd1" checked="checked" value="0" />
					<label class="form-check-label txt-dark" style="font-family:hind;" for="rd1">Both pre-payment and post-payment</label>
				</div>

				<div class="form-check radio-orange-gap">
					<input class="form-check-input with-gap" name="rd" type="radio" id="rd2" value="1" />
					<label class="form-check-label txt-dark" style="font-family:hind;" for="rd2">Only pre-payment</label>
				</div>

			</div>
            <p id="err" class="text-center mt-2 err text-danger">
				<i class="fa fa-info-circle"></i>
				<span id="errsp">Error message</span>
			</p>
			<script>
				document.getElementById('err').style.display = 'none';
			</script>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer px-4 pt-0 pb-0">
        <button type="button" id="updatebtn" class="btn btn-sm txt-morange bg-white rounded-0 rbord pt-1 pb-1">Update</button>
        <button type="button" id="cancelbtn" class="btn btn-sm bg-morange text-white rounded-0 pt-1 pb-1" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>