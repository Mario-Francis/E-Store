<!-- Signup Modal -->
<div class="modal fade text-dark" id="sModal">
  <div class="modal-dialog modal-lg rounded-0">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header rounded-0 p-2">
        <h5 class="modal-title pl-2">Create Account</h5>
        <button type="button" class="close p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3">
      <form id="signupForm">
          <div class="row">
              <div class="offset-sm-1 col-sm-10">
                  <center>
                        <div class="p-1 pt-3 txt-dark bord" style="width:130px;height:130px;border-radius:50%;">
                            <p class="text-center text-secondary" style="font-size:60px;"><i class="fa fa-user-plus"></i></p>
                        </div>
                  </center>

                <p class="txtlab mt-2">First Name</p>
                <input type="text" id="fname" class="form-control mtxtbx rounded-0" required />
                
                <p class="txtlab mt-2">Last Name</p>
                <input type="text" id="lname" class="form-control mtxtbx rounded-0" required />
                
                <p class="txtlab mt-2">Gender</p>
			    <select id="gender" class="form-control mtxtbx rounded-0" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <p class="txtlab mt-2">Address</p>
                <textarea id="adres" class="form-control mtxtbx rounded-0" style="resize:none;" row="2" required></textarea>

                <p class="txtlab mt-2">Phone Number</p>
                <input type="text" id="phno" class="form-control mtxtbx rounded-0" required />

                <p class="txtlab mt-2">Email</p>
                <input type="text" id="email" class="form-control mtxtbx rounded-0" required />

                <p class="txtlab mt-2">Password</p>
                <input type="password" id="pswd" class="form-control mtxtbx rounded-0" required />

                <p class="txtlab mt-2">Confirm Password</p>
                <input type="password" id="cpswd" class="form-control mtxtbx rounded-0" required />
                
                <p id="err1" class="text-center mt-2 err text-danger">
				    <i class="fa fa-info-circle"></i>
				    <span id="err1sp">Error message</span>
                </p>
                <script>
				    document.getElementById('err1').style.display = 'none';
			    </script>
              </div>
          </div>
          <div class="row mt-3">
              <div class="offset-sm-1 col-sm-10">
                <p class="text-center"><button type="submit" id="cbtn" class="btn txt-morange bg-white rounded-0 vbtn pt-1 pb-1 pl-sm-4 pr-sm-4">Submit</button></p> 
                <p class="text-center small mt-2"><a id="slog" href="javascript:void(0)" class="txt-morange">Already have an account? Login</a></p>
              </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- login Modal -->
<div class="modal fade text-dark" id="lModal">
  <div class="modal-dialog rounded-0">
    <div class="modal-content rounded-0">

      <!-- Modal Header -->
      <div class="modal-header rounded-0 p-2">
        <h5 class="modal-title pl-2">Login</h5>
        <button type="button" class="close p-0 pr-2 m-0" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body p-3">
            <div class="row">
                <div class="col-12 pl-sm-5 pr-sm-5 pl-3 pr-3 pb-2 pt-3">
                    <form id="loginForm">
                    <center>
                        <div class="p-1 pt-3 txt-dark bord" style="width:130px;height:130px;border-radius:50%;">
                            <p class="text-center text-secondary" style="font-size:60px;"><i class="fa fa-user"></i></p>
                        </div>
                    </center>
                    <p class="txtlab mt-3">Email</p>
                    <input type="text" id="lemail" class="form-control mtxtbx rounded-0" required />

                    <p class="txtlab mt-2">Password</p>
                    <input type="password" id="lpswd" class="form-control mtxtbx rounded-0" required />

                    <div class="mt-2 form-check form-check-inline">
                        <center>
                            <label class="form-check-label txtlab font-weight-normal">
                                <input type="checkbox" id="keep" class="form-check-input" /><span style="font-size:16px;">Keep me logged in</span>
                            </label>
                        </center>
                    </div>

                    <p id="err2" class="text-center mt-2 err text-danger">
				        <i class="fa fa-info-circle"></i>
				        <span id="err2sp">Error message</span>
                     </p>
                    <script>
				        document.getElementById('err2').style.display = 'none';
                    </script>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <p class="text-center"><button type="submit" id="lbtn" class="btn txt-morange bg-white rounded-0 vbtn pt-1 pb-1 pl-sm-4 pr-sm-4">Submit</button></p>          
                            <p class="small mt-2"><a id="lcreate" href="javascript:void(0)" class="txt-morange">Don't have an account? Sign Up</a> <a href="javascript:void(0)" class="float-right txt-morange">Forgot Password?</a></p>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
      </div>

    </div>
  </div>
</div>