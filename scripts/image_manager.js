$(document).ready(function () {
	//alert('hello');
	//initialize dropzone
	Dropzone.autoDiscover = false;
	$dzone = new Dropzone('#dzone', {
		url: $BASE + 'merchants/api_upload_pimage',
		dictDefaultMessage: 'Drag and drop your file or click here to upload file',
		previewTemplate: $('#template').html(),
		acceptedFiles: 'image/*,.jpg,.png,.gif,.jpeg',
		clickable: '.dz-clickable',
		thumbnailMethod: 'contain',
		resizeWidth: 300,
		autoProcessQueue: false,
		uploadMultiple: false,
		maxFilesize: 5,
		maxFiles: 1,
		maxfilesexceeded: (file) => {
			if ($dzone.getAcceptedFiles().length != 0) {
				$('#errsp').html('Only one file can be uploaded at a time');
				$('#err').show();
				$dzone.removeFile(file);
			}
		},
		resize: function (file, w, h) {
			//alert(w+'-'+h);
			w = file.width;
			h = file.height;
			return {
				srcWidth: w,
				srcHeight: h,
				trgWidth: w,
				trgHeight: h
			};
		},
		init: function () {
			this.on('addedfile', function (file) {
				$('#def').hide();
				//($('.dzone .img-fluid')).attr('src', file.dataURL);
			});
			this.on('removedfile', function (file) {
				$files = this.getAcceptedFiles();
				if ($files.length == 0) {
					$('#def').show();
				}
			});
			this.on('removedfile', function (file) {
				if ($dzone.getAcceptedFiles().length == 0) {
					$('#err').hide();
				}
			});
			this.on("sending", function (file, xhr, formData) {
				// Will send the product id along with the file as POST data.
				formData.append('pid', $('#catdd').val());
			});
			this.on('success', function (file, resp) {
				//console.log(file);
				//console.log(resp);
				$obj = JSON.parse(resp);
				if ($obj.res == 'false') {
					$('#errsp').html('Error: ' + $obj.err);
					$('#err').show();
					$('#upbtn').prop('disabled', false);
					$('#upbtn').html('<i class="fa fa-upload"></i> Upload');
				} else {
					$('#upbtn').html('<i class="fa fa-check-circle"></i> Uploaded successfully');

					setTimeout(function () {
						$('#catdd').val('');
						$dzone.removeAllFiles();
						$('#upbtn').prop('disabled', false);
						$('#upbtn').html('<i class="fa fa-upload"></i> Upload');
						$('#cat').change();
						$('#nModal').modal('hide');
					}, 3500);
				}
			});
			this.on('error', function (file, er, err) {
				if (er != null) {
					alert('Error: ' + er);
					$dzone.removeFile(file);
				}
				if (err != null) {
					alert('Poor/No network connection. Check your network settings and try again!');
					console.log(err.responseText);
					$('#upbtn').prop('disabled', false);
					$('#upbtn').html('<i class="fa fa-upload"></i> Upload');
				}
			});
		}
	});
	$('#upbtn').click(function (e) {
		e.preventDefault();
		$cat = $('#catdd').val();
		if ($cat == '' || $dzone.getAcceptedFiles().length == 0) {
			$('#errsp').html('All fields are required!');
			$('#err').show();
		} else {
			$('#errsp').html('');
			$('#err').hide();
			$('#upbtn').prop('disabled', true);
			$('#upbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Uploading data...');
			$dzone.processQueue();
		}
	});

	//$('.col').matchHeight();


	//on dropdown change
	$('#cat').change(function () {
		$pid = $(this).val();

		$url = $BASE + 'merchants/api_fetch_pimages';
		$data = {
			pid: $pid
		};

		$('#loader').show();
		$.ajax({
			type: 'GET',
			url: $url,
			data: $data,
			success: function (data) {
				//console.log(data);
				$obj = JSON.parse(data);
				// console.log($obj);
				load_data($obj);
				$('#loader').hide();
			},
			error: function (err) {
				alert('Poor/No network connection. Check your network settings and try again!');
				console.log(err.responseText);
				$('#loader').hide();
			}
		});
	});

	//load data
	function load_data(data) {
		//console.log(data);
		$imagdiv = '';
		$imgs = data.data;
		if (Object.keys($imgs).length > 0) {
			for (x in $imgs) {
				$imagdiv += '<div class="col-lg-2 col-md-3 col-sm-4 col-6 p-1 col"><div class="bg-morange p-2 mcard" style="padding-bottom:0 !important;"><div class="bg-white" style="height:auto;overflow:hidden;"><img src="' + $BASE + $imgs[x].fpath + '" class="img-fluid pimg" alt="' + $imgs[x].pname + '" /></div><p class="text-center cap mt-1" title="' + $imgs[x].pname + '">' + $imgs[x].pname + '</p><p class="text-center mt-auto"><button type="button" img-id="' + $imgs[x].id + '" class="btn btn-outline-white pt-1 pb-1 btn-sm text-capitalize rounded-0 ' + (($imgs[x].status == 1) ? 'disabled' : '') + '" onclick="delImage(this);" style="font-size:12px;"><i class="fa fa-times"></i> &nbsp;Delete</button></p></div></div>';
			}
		} else {
			$imagdiv = '<div class="offset-sm-2 col-sm-8"><div class="myinfo p-3"><p class="text-center txt-sec">No images found!</p></div></div>';
		}
		$('#imagediv').fadeOut(500, function () {
			$('#imagediv').html($imagdiv);
			$('#imagediv').fadeIn(500);
		});

		$('#pagdiv').fadeOut(500, function () {
			$('#pagdiv').html(data.links);
			$('#pagdiv').fadeIn(500);
			setPageLinkClickEvent();
			setImageClickEvent();
		});

	}


	//on pagination item click
	setPageLinkClickEvent();
	setImageClickEvent();

	function setPageLinkClickEvent() {
		$('.jclick').click(function (e) {
			e.preventDefault();
			$url = $(this).attr('href');

			$arr = $url.split('/');
			$n = $arr[$arr.length - 1];
			$page = $.isNumeric($n) ? $n : 1;

			$url = $BASE + 'merchants/api_get_page/' + $page;
			//alert($url);

			$('#loader').show();
			$.ajax({
				type: 'GET',
				url: $url,
				success: function (data) {
					//console.log(data);
					$obj = JSON.parse(data);
					//console.log($obj);
					load_data($obj);
					$('#loader').hide();
				},
				error: function (err) {
					alert('Poor/No network connection. Check your network settings and try again!');
					console.log(err.responseText);
					$('#loader').hide();
				}
			});
		});
	}

	//on image click
	function setImageClickEvent() {
		$('.pimg').click(function () {
			$('#vimg').attr('src', $(this).attr('src'));
			$('#vcap').html($(this).attr('alt'));
			$('#vModal').modal('show');
		});
	}

	//delete yes btn click
	$('#yesbtn').click(function () {
		$img_id = $(this).attr('img-id');

		$('#nobtn').prop('disabled', true);
		$('#yesbtn').prop('disabled', true);
		$('#yesbtn').html('<i class="fa fa-circle-o-notch fa-spin"></i> Deleting...');

		$url = $BASE + 'merchants/api_del_image';
		$data = {
			id: $img_id
		};
		$.ajax({
			type: 'GET',
			url: $url,
			data: $data,
			success: function (data) {
                //console.log(data);
				$obj = JSON.parse(data);
				if ($obj.res == 'false') {
					alert('Error: ' + $obj.err);
					$('#nobtn').prop('disabled', false);
					$('#yesbtn').prop('disabled', false);
					$('#yesbtn').html('Yes');
					$('#cModal').modal('hide');
				} else {
					$('#yesbtn').html('<i class="fa fa-check-circle"></i> Deleted successfully');
					setTimeout(function () {
						$('#nobtn').prop('disabled', false);
						$('#yesbtn').prop('disabled', false);
						$('#yesbtn').html('Yes');

						//load products
						$('#cat').change();

						$('#cModal').modal('hide');
					}, 3500);
				}
			},
			error: function (err) {
				alert('Poor/No network connection. Check your network settings and try again!');
				console.log(err.responseText);
				$('#nobtn').prop('disabled', false);
				$('#yesbtn').prop('disabled', false);
				$('#yesbtn').html('Yes');
				$('#cModal').modal('hide');
			}
		});

	});
});

function delImage(btn) {
	$img_id = $(btn).attr('img-id');
	$('#yesbtn').attr('img-id', $img_id);
	$('#cModal').modal('show');
}
