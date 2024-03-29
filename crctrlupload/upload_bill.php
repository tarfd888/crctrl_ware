<?php	
	include("../_incs/acunx_metaheader.php");
	include("../_incs/chksession.php"); 
	include("../_incs/config.php");
	include("../_incs/funcServer.php");
	include("../_incs/acunx_cookie_var.php");
	include "../_incs/acunx_csrf_var.php";
	clearstatcache();
	include("../crctrlbof/chkauthcr.php");
	include("../crctrlbof/chkauthcrctrl.php");
	
	if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
		if (!matchToken($csrf_key, $user_login)) {
			echo "System detect CSRF attack!!";
			exit;
		}
	}
	// if($user_role!="ADMIN" and $user_role !="AC_VIEW"){
		// echo "<meta http-equiv=\"refresh\" content=\"0;URL=../logout.php?msg=<font color=red>You are not allowed. Please sign in again.</font>\" />";			
		// exit();
	// }
	$msg = $_REQUEST['msg'];
	$curdate = date("d/m/Y H:i:s");
	$curMonth = date('m'); 
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<!-- <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template.">
		<meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
		<meta name="author" content="PIXINVENT"> -->
		<title><?php echo(TITLE) ?></title>
		<link rel="apple-touch-icon" href="<?php echo BASE_DIR;?>/theme/app-assets/images/ico/apple-icon-120.png">
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_DIR;?>/theme/app-assets/images/ico/favicon.ico">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_DIR;?>/theme/app-assets/css/vendors.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_DIR;?>/theme/app-assets/vendors/css/tables/datatable/datatables.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_DIR;?>/theme/app-assets/css/app.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_DIR;?>/theme/app-assets/css/core/menu/menu-types/vertical-menu.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_DIR;?>/theme/app-assets/css/core/colors/palette-gradient.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_DIR;?>/theme/assets/css/style.css">
	</head>
	<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
		<!-- Head Menu-->
		<?php include("../crctrlmain/menu_header.php"); ?>
		<?php include("../crctrlmain/menu_leftsidebar.php"); ?>
		
		<div class="app-content content">
			<div class="content-wrapper">
				
				<div class="content-body"><!-- Basic example section start -->
					<!-- Card sizing section start -->
					<section id="sizing">
						<!--<div class="row">
							<div class="col-12 mt-3 mb-1">
							<h4 class="text-uppercase">Sizing</h4>
							<p>Constrain the width of cards via custom CSS, our predefined grid classes, or with custom styles using our grid mixins.</p>
							</div>
						</div>-->
						
						<div class="row match-height">
							<div class="col-md-6">
								<div class="card">
									<div class="card-header">
										<h4 class="card-title" id="basic-layout-icons" ><font color="1E90FF">Upload Billing Master</font></h4>
										<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
										<div class="heading-elements">
											<ul class="list-inline mb-0">
												<!--<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
												<li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>-->
												<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
												<!--<li><a data-action="close"><i class="ft-x"></i></a></li>-->
											</ul>
										</div>
									</div>
									<div class="card-content collpase show">
										<div class="card-body">
											<div class="card-block">
												
												<form name="frmimport" id="frmimport"  class="form" action="importdata_bill.php" method="post" enctype="multipart/form-data" onsubmit="return CheckValidFile()">
													<input type="hidden" name="curMonth" id="curMonth" value="<?php echo($curMonth) ?>">
													<div class="form-body">
														<? if($msg!="") echo "<center><h5 style='line-height:40px; border-bottom:1px solid #5E5E5E;'><div class='btn btn-danger active'  style='line-height:30px;'><i class='icon-warning'></i>  ".$msg."</div><br><div class='tag tag-pill tag-warning'>Warning !</div> Some Sheet Name is not Country Name.<br><i class='icon-spell-check'></i> Please Try Again.</h5></center><br>"; ?>
														<!--<div class="form-group">
															<label for="timesheetinput1">Employee Uploader</label>
															<div class="position-relative has-icon-left">
															<input type="text" id="timesheetinput1" class="form-control" placeholder="employee name" name="employeename" value="<? echo $user_scg_emp_id; ?>" disabled>
															<div class="form-control-position">
															<i class="icon-head"></i>
															</div>
															</div>
														</div>-->
														<input type="hidden" name="employeename" value="<? echo $user_code; ?>">
														<div class="form-group">
															<label for="timesheetinput2">Employee Uploader</label>
															<div class="position-relative has-icon-left">
																<input type="text" id="timesheetinput2" class="form-control" placeholder="project name" name="projectname" value="<? echo $user_fullname; ?>" disabled>
																<div class="form-control-position">
																    <i class="icon-user-following"></i>
																</div>
															</div>
														</div>
														<div class="alert alert-warning alert-white rounded">
															<button type="button" data-dismiss="alert" aria-hidden="true" class="close">×</button>
															<i class="icon-info"></i>
															<strong>Warning</strong> 
															กรุณาระบุเดือนที่ต้องการอัพโหลดก่อน !!!
														</div>  
														<div class="form-group">
															<!--<a class="btn btn-success" role="button" href="../download/data1_MCustomer.xlsx" download="crctrldata1_MCustomer.xlsx">
																<i class="icon-download5"></i> Download Template File
															</a>-->
															<!--<select data-placeholder="Select a doc type ..." class="form-control input-sm border-warning font-small-3 select2" id="del_month" name="del_month">
																<option value="" selected>--- เลือกเดือน ---</option>
																<?php
																	$sql_doc = "SELECT TOP 12 tbl_mm_code, tbl_mm_desc, tbl_mm_seq FROM tbl_mm ORDER BY tbl_mm_seq";
																	$result_doc = sqlsrv_query($conn, $sql_doc);
																	while ($r_doc = sqlsrv_fetch_array($result_doc, SQLSRV_FETCH_ASSOC)) {
																	?>
																	<option value="<?php echo $r_doc['tbl_mm_code']; ?>" 
																	<?php if ($del_month == $r_doc['tbl_mm_code']) {
																		echo "selected";
																	} ?>>	
																	<?php echo $r_doc['tbl_mm_code']; ?></option>
																<?php } ?>
															</select>-->
															<div class="form-group">
																<label for="timesheetinput2">ระบุเดือนที่ต้องอัพโหลด</label>
																<input type="text" id="del_month" name="del_month" class="form-control" placeholder="YYYY/MM" >
															</div>
														</div>
														<div class="form-group">
															<label>Select File</label>
															<label id="projectinput7" class="file center-block">
																<!--<input type="file" id="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >-->
																<input type="file" accept=".xlsx, .xls" name="bill_data" id="bill_data" onchange="checkTypeFile(this);">
																<input type="hidden" name="Filetype" value="
															<span class="file-custom"></span>
														</label>
													</div>
												</div>
												
												<div class="form-actions right">
													<!--<button type="button" class="btn btn-warning mr-1">
														<i class="icon-cross2"></i> Cancel
													</button>-->
													<button type="submit" class="btn btn-success" name="submit" id="submit" value="import">
														<i class="fa fa-cloud-upload"></i> Upload
													</button>
												</div>
											</form>
											
										</div>
									</div> 
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="row match-height">
								<div class="card">
									<div class="card-header">
										<a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion1" aria-expanded="true" aria-controls="accordion1" class="card-title lead">HOW TO</a>
									</div>
									<div class="card-content collpase show">
										<div class="card-body">
											
											<div class="card-block">
												<ul>
													<li>ไฟล์ที่อนุญาตสำหรับการ Upload คือ นามสกุลไฟล์ [.xls] หรือ [.xlsx] เท่านั้น</li><br>	
													<li>ก่อนทำการอัพโหลดทุกครั้ง กรุณาระบุเดือนที่ต้องการอัพโหลดก่อนทุกครั้ง !!!</li><br>	
													<li>เป็นการอัพเดทฐานข้อมูล Open Order </li>	
													<!--<li>Format ของแต่ละคมลัมน์ต้องเป็นไปตามที่กำหนด <a href="../download/MCustomber_Template_Structure.xlsx" target="_blank" class="tag tag-success">Download Format</a></li>
													<li>หากมี บาง Sheet Name ที่ตั้งชื่อไม่ตรงกับชื่อประเทศที่มีอยู่ในระบบ ระบบจะไม่นำเข้าข้อมูลทั้งหมดของไฟล์นั้น (ข้อมูลเดิมยังคงอยู่) โปรดตรวจสอบ Sheet Name แล้วทำการ Upload ข้อมูลใหม่อีกครั้ง</li>												
													<li>การอัพโหลด สามารถอัพโหลด 1 ไฟล์ 1 ประเทศ หรืออัพโหลด 1 ไฟล์ รวมประเทศ แยกตาม Sheet Name ได้ <a href="../download/Example_Sourcing_Upload.xlsx" target="_blank" class="tag tag-success">Download Exmaple File</a></li>
													<li>ข้อมูลบรรทัดใดที่ไม่มี <div class="tag tag-pill tag-danger">Actual Month</div> หรือ <div class="tag tag-pill tag-danger">Actual Year</div>  หรือ <div class="tag tag-pill tag-danger"> Actual Loading (M2)</div> จะไม่ถูกนำไปคำนวณในหน้า Dashboard</li>-->										
												</ul>
											</div>
											
										</div>  
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- Card sizing section end -->
			
			
			
		</div>
	</div>
</div>

<? include("../crctrlmain/menu_footer.php"); ?>

<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/vendors.min.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/js/core/app-menu.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/js/core/app.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/js/scripts/ui/jquery-ui/date-pickers.min.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/pickers/daterange/daterangepicker.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/forms/extended/typeahead/typeahead.bundle.min.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/forms/extended/typeahead/bloodhound.min.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/forms/extended/typeahead/handlebars.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/forms/extended/maxlength/bootstrap-maxlength.js"></script>
<script src="<?php echo BASE_DIR;?>/theme/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>

<script type="text/javascript" language="javascript">
	function checkTypeFile(sender) {
			var validExts = new Array(".xlsx", ".xls");
			var fileExt = sender.value;
			fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
			if (validExts.indexOf(fileExt) < 0) {
			  alert("Invalid file selected, valid files are of " +
					   validExts.toString() + " types.");
			  return false;
			}
			else {
				return true;
			}
		}
		function CheckValidFile() {
			var validExts = new Array(".xlsx", ".xls");
			var fileVal = document.getElementById('bill_data').value;
			var fileExt = fileVal.substring(fileVal.lastIndexOf('.'));
			
			var del_month = document.forms["frmimport"]["del_month"].value;
			var curMonth = document.forms["frmimport"]["curMonth"].value;
			
			$del_month = del_month;
			//$del_month = str_pad($del_month); // เติม 0 ข้างหน้า 1-9
			//alert($del_month);
			//if ($del_month == "" || $del_month == null || $del_month < curMonth) {
			if ($del_month == "" || $del_month == null || $del_month=="") {
				alert("กรุณาระบุเดือนที่ต้องการอัพโหลดข้อมูลใหม่ เดือนปัจจุบัน "+curMonth);
				return false;
			}
			
			if(fileVal == "")
			{
				alert("Please Upload Some Files are of " +  validExts.toString() + " types.");
				return false;
			}
			
			else if (validExts.indexOf(fileExt) < 0) {
				alert("Please Upload Files are of " +  validExts.toString() + " types.");
				return false;
			}
			 
		    var txt;
			var r = confirm("คุณต้องการยืนยันการอัพโหลดข้อมูล");
				if (r == true) {
					//txt = "You pressed OK!";
					return true;
				} else {
					//txt = "You pressed Cancel!";
					return false;
				} 
			 
			//return true;
		}
		function str_pad(n) {
		return String("00" + n).slice(-2);
	}
	
</script>

</body>
</html>