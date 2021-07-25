<!-- New orders -->
<div class="row mt-4">
    <div class="offset-sm-1 col-sm-10 bg-white p-3 mcard">
        <h4 class="txt-dark">Products</h4>
        <!-- <input type="checkbox" class="mchk" /> -->
        <hr class="mt-2" />
        <div class="row">
            <div class="col-sm-6 py-2 px-4">
                <p class="txtlab">Category</p>
                <select id="cat" class="form-control mtxtbx rounded-0" style="display:block !important;">
                    <option value="0">All</option>
                    <?php foreach($cats as $c){ ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['cat']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-6 py-2 px-4">
                <form>
                <p class="txtlab">Search</p>
                <div class="input-group">
                    <input id="stxt" type="text" class="form-control p-2 mtxtbx rounded-0" placeholder="Search by product name or merchant name" required />
                    <input type="hidden" id="shd" />
                    <button id="sbtn" type="submit" class="input-group-addon btn m-0 rounded-0 btn-sm py-0 pt-1 px-2 bg-light txt-dark bord" style="box-shadow:none;margin-bottom:2px;"><i class="fa fa-search" style="font-size:16px;"></i></button>
                </div>
                <p class="text-danger small mt-2" id="err" style="display:none;"><i class="fa fa-info-circle"></i> <span id="errsp">Error</span></p>
                </form>
            </div>
        </div>
        <div class="row" style="overflow-x:hidden;">
            <div class="col-12 py-1">	
				<div class="mspinner" id="loader1" style="display:none;">
  					<div class="bg-morange mcard"></div>
  					<div class="mcard"></div>
  					<div class="bg-morange mcard"></div>
  					<div class="mcard"></div>
				</div>
			</div>
        </div>
        <div id="tabdiv">
        <?php if(isset($products) && count($products)> 0){ ?>
        <div class="table-responsive mt-2">
            <table class="table border mtable table-striped text-center">
                <thead class="bg-morange text-white">
                    <tr style="font-size:14px;">
                        <th class="py-2 pt-3 font-weight-normal">#</th>
                        <th class="py-2 pt-3 font-weight-normal">Product&nbsp;Name</th>
                        <th class="py-2 pt-3 font-weight-normal">Category</th>
                        <th class="py-2 pt-3 font-weight-normal">Price&nbsp;(&#8358;)</th>
                        <th class="py-2 pt-3 font-weight-normal">Sale&nbsp;Price&nbsp;(&#8358;)</th>
                        <th class="py-2 pt-3 font-weight-normal">Add&nbsp;Date</th>
                        <th class="py-2 pt-3 font-weight-normal">View</th>
                        <th class="py-2 pt-3 font-weight-normal">Status</th>
                    </tr>
                </thead>
                <tbody id="tbody" class="lato txt-dark">
                    <?php for($i=0;$i < count($products);$i++){ ?>
                    <tr class="font-weight-bold">
                        <td><?php echo $count; ?></td>
                        <td><?php echo $products[$i]['pname']; ?></td>
                        <td><?php echo $products[$i]['cat']; ?></td>
                        <td><?php echo $products[$i]['price']; ?></td>
                        <td><?php echo $products[$i]['sprice']; ?></td>
                        <td><?php echo $products[$i]['date']; ?></td>
                        <td><button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-primary btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="view(this);"><i class="fa fa-eye"></i>&nbsp;&nbsp; View</button></td>
                        <td>
                        <?php if($products[$i]['status']==0){ ?>
                            <button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-danger btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="flag(this);"><i class="fa fa-flag"></i>&nbsp;&nbsp; Flag</button>
                        <?php }else{ ?>
                            <button type="button" pid="<?php echo $products[$i]['id']; ?>" class="btn btn-outline-success btn-sm rounded-0 pl-3 pr-3 pt-1 pb-1 m-0 text-capitalize" style="font-size:11px;min-width:82px;" onclick="unflag(this);"><i class="fa fa-flag-checkered"></i>&nbsp; Unflag</button>
                        <?php } ?>
                        </td>
                    </tr>
                    <?php $count++; } ?>
                    
                </tbody>
            </table>
        </div>
        <?php }else{ ?>
            <div class="myinfo p-3">
                <p class="text-center txt-sec">No products found!</p>
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
        <div class="row" style="overflow-x:hidden;">
            <div class="col-12 py-1">	
				<div class="mspinner" id="loader2" style="display:none;">
  					<div class="bg-morange mcard"></div>
  					<div class="mcard"></div>
  					<div class="bg-morange mcard"></div>
  					<div class="mcard"></div>
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
        <h5 class="modal-title pl-2">Details</h5>
        <button type="button" class="close mclose p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body py-3 px-4">
          <h6 class="font-weight-bold open-sans txt-morange">Product Information</h6>
          <hr class="mt-1 mb-2" />
          <div class="row lato txt-dark" style="font-size:13px;">
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Product Name: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="pname">Women's wear </p>
              </div>
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Category: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="dcat">Fashion </p>
              </div>
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Price: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p>&#8358;<span id="price">45, 000.00</span></p>
              </div>
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Description: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="descrip">It's cool </p>
              </div>
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Available: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="avail">Yes </p>
              </div>
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Add Date: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="date">May 4, 2014 </p>
              </div>
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Status: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="status">Flagged </p>
              </div>
          </div>
          <h6 class="font-weight-bold open-sans txt-morange mt-3">Merchant Information</h6>
          <hr class="mt-1 mb-2" />
          <div class="row lato txt-dark mb-3" style="font-size:13px;">
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Name: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="mname">Dee Noble </p>
              </div>
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Address: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="adres">Ayonuga Street, Fadeyi, Lagos. </p>
              </div>
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Email: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="email">le@yahoo.com</p>
              </div>
              <div class="col-sm-4 col-5 pl-0">
                  <p class="text-right font-weight-bold">Phone Number: </p>
              </div>
              <div class="col-sm-8 col-7 px-0">
                <p id="phno">08045678765 </p>
              </div>
          </div>
      </div>

    </div>
  </div>
</div>