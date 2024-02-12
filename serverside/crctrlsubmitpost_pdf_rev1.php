<?php
include("../_incs/chksession.php");
include("../_incs/config.php"); 
include("../_incs/funcServer.php");	
include("../_incs/acunx_cookie_var.php");
include "../_incs/acunx_csrf_var.php";
include("../_incs/funcCrform_rev.php");
include("../_incs/funcAppform.php");
date_default_timezone_set('Asia/Bangkok'); 

$today = date("Y-m-d H:i:s"); 
$curr_date = ymd(date("d/m/Y"));
$errortxt = "";
$allow_post = false;

	if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
		if (!matchToken($csrf_key,$user_login)) {
			echo "System detect CSRF attack!!";
			exit;
		}
	}
	
	$action = html_escape($_POST['action']);
	$step_code = html_escape($_GET['step_code']);
	$crstm_step_code = html_escape(decrypt($step_code, $key));
	$crstm_nbr = html_escape($_POST['crstm_nbr']);	

	$params = array($crstm_nbr);
	//$sql_cr = "SELECT * from crstm_mstr where crstm_nbr = ? and (crstm_step_code = '0' or crstrm_step_code = '110')";
	$sql_cr = "SELECT * from crstm_mstr where crstm_nbr = ? ";
	$result_cr = sqlsrv_query($conn, $sql_cr,$params);	
	$r_cr = sqlsrv_fetch_array($result_cr, SQLSRV_FETCH_ASSOC);	
	if ($r_cr) {		
		$rc_curprocessor_check = $r_cr['crstm_curprocessor'];
		if (inlist($rc_curprocessor_check,$user_login)) {
			$allow_post = true;
		}
	}

	if (!$allow_post) {
		$r="0";
		$errortxt ="Error Mail";
		echo '{"r":"'.$r.'","e":"'.$errortxt.'","nb":"'.encrypt($crstm_nbr, $key).'","pg":"'.$pg.'"}';
	}		
	else {
	
		//Detect Mail Server is availbale
		if (isservonline($smtp)) { $can_sendmail=true;}
		else {
			$can_sendmail=false;
			$errortxt .= "<span style='color:red'>** พบปัญหาการส่ง Email ดังนั้นระบบจึงไม่สามารถส่ง Email แจ้งผู้ที่เกี่ยวข้องได้!!**</span><br>";
		}

		if ($action != "") {
		
		$params = array($crstm_nbr);
		$query_detail = "SELECT crstm_mstr.crstm_nbr, crstm_mstr.crstm_date, crstm_mstr.crstm_user, crstm_mstr.crstm_tel, crstm_mstr.crstm_cus_nbr, crstm_mstr.crstm_cus_name, emp_mstr.emp_th_firstname, ".
		"emp_mstr.emp_th_lastname, emp_mstr.emp_email_bus, emp_mstr.emp_prefix_th_name, emp_mstr.emp_th_pos_name, crstm_mstr.crstm_chk_rdo1, crstm_mstr.crstm_chk_rdo2, crstm_mstr.crstm_chk_term, crstm_mstr.crstm_term_add,  ".
		"crstm_mstr.crstm_ch_term, crstm_mstr.crstm_approve, crstm_mstr.crstm_sd_reson, crstm_mstr.crstm_sd_per_mm, crstm_mstr.crstm_cc1_reson, crstm_mstr.crstm_cc2_reson, crstm_mstr.crstm_cus_active,  ".
		"crstm_mstr.crstm_cr_mgr, crstm_mstr.crstm_cc_date_beg, crstm_mstr.crstm_cc_date_end, crstm_mstr.crstm_cc_amt,crstm_mstr.crstm_detail_mail, crstm_mstr.crstm_mgr_reson, crstm_mstr.crstm_reviewer  ".
		"FROM crstm_mstr INNER JOIN  ".
		"emp_mstr ON crstm_mstr.crstm_user = emp_mstr.emp_scg_emp_id  ".
		"WHERE (crstm_mstr.crstm_nbr = ?)";
		
		$result_detail = sqlsrv_query($conn, $query_detail,$params);
		$r_cr = sqlsrv_fetch_array($result_detail, SQLSRV_FETCH_ASSOC);
			if ($r_cr) {
			
				$crstm_nbr = html_clear($r_cr['crstm_nbr']);
				$name_from = trim($r_cr['emp_prefix_th_name']) . trim($r_cr['emp_th_firstname']) . " " . trim($r_cr['emp_th_lastname']);
				$email_sale = strtolower($r_cr['emp_email_bus']);
				$emp_th_pos_name = html_clear($r_cr['emp_th_pos_name']);
				$crstm_cus_name = html_clear($r_cr['crstm_cus_name']);
				$crstm_sd_reson = html_clear($r_cr['crstm_sd_reson']);
				$crstm_chk_rdo2 = html_clear($r_cr['crstm_chk_rdo2']);
				$crstm_approve = html_clear($r_cr['crstm_approve']);
				$crstm_cc1_reson = html_clear($r_cr['crstm_cc1_reson']);
				$crstm_cc2_reson = html_clear($r_cr['crstm_cc2_reson']);
				$crstm_mgr_reson = html_clear($r_cr['crstm_mgr_reson']);
				$crstm_cr_mgr = html_clear(number_format($r_cr['crstm_cr_mgr']));
				$cr_next_curprocessor_email =  html_clear($r_cr['crstm_reviewer']);
				
				$crstm_cus_active = html_clear($r_cr['crstm_cus_active']);
				$crstm_chk_term = html_clear($r_cr['crstm_chk_term']);
				
				$crstm_cc_amt = html_clear($r_cr['crstm_cc_amt']);
				$crstm_cc_date_beg = dmytx(html_clear($r_cr['crstm_cc_date_beg']));
				$crstm_cc_date_end = dmytx(html_clear($r_cr['crstm_cc_date_end']));
				
				$crstm_ch_term =  html_clear($r_cr['crstm_ch_term']);
				$change_term = findsqlval("term_mstr", "term_desc", "term_code", $crstm_ch_term ,$conn);
				
				$crstm_cus_nbr =  html_clear($r_cr['crstm_cus_nbr']);
				
				$reviewName = findsqlval("emp_mstr","emp_prefix_th_name+emp_th_firstname+'  '+emp_th_lastname","emp_email_bus",$cr_next_curprocessor_email,$conn);	
				$cus_term = findsqlval("cus_mstr", "cus_terms_paymnt", "cus_nbr", $crstm_cus_nbr ,$conn);
				$old_term = findsqlval("term_mstr", "term_desc", "term_code", $cus_term,$conn);
				$crstm_step_name = findsqlval("crsta_mstr", "crsta_step_name", "crsta_step_code", $crstm_step_code ,$conn);
				
				if($crstm_chk_term == "old") {  /// เคสเปลี่ยนเงื่อนไขการชำระเงิน
					$txt_term = "<br>";		
				}else if($crstm_chk_term == "change"){
					$txt_term = "และขอเปลี่ยนเงื่อนไขการชำระเงินใหม่ จาก :  $old_term  เป็น  $change_term<br>";
				}
				
					
			}
			else {
				$r="0";
				$errortxt = "ไม่พบเอกสารหมายเลข : ".$crstm_nbr." โปรดตรวจสอบข้อมูลใหม่ ";
				echo '{"r":"'.$r.'","e":"'.$errortxt.'","nb":"'.encrypt($crstm_nbr, $key).'","pg":"'.$pg.'"}';
			}
			
				$params = array($crstm_nbr);
				$sql_cc= "SELECT tbl3_id, tbl3_nbr, tbl3_cus_nbr, tbl3_amt_loc_curr, tbl3_doc_date, tbl3_due_date, tbl3_txt_ref, tbl3_create_by, tbl3_create_date FROM tbl3_mstr where tbl3_nbr = ? order by tbl3_txt_ref desc ";
				$result_cc = sqlsrv_query($conn, $sql_cc,$params);
				while($row_cc = sqlsrv_fetch_array($result_cc, SQLSRV_FETCH_ASSOC))
				{
					$amt = html_clear($row_cc['tbl3_amt_loc_curr']);
					$txt_ref = html_clear($row_cc['tbl3_txt_ref']);
					
					$gr_tot +=  $amt ;
					if ($txt_ref == "C1") {  // เสนอขอปรับเพิ่มวงเงิน
						$tot_c1 += $amt;
						$due_date = dmytx(html_clear($row_cc['tbl3_due_date']));
					} else if ($txt_ref == "C3"){  // เสนอขอต่ออายุวงเงิน
						$tot_cc += $amt;
						$due_date = dmytx(html_clear($row_cc['tbl3_due_date']));
					}else if ($txt_ref == "CC"){  // วงเงินปัจจุบัน
						$tot_cc += $amt;
						$due_date = dmytx(html_clear($row_cc['tbl3_due_date']));
					}	
				}
				
				if($crstm_cus_active=="1") { // เช็คลูกค้าเก่าหรือไม่
					if($crstm_chk_rdo2=="C1"){ // ขอเพิ่มวงเงิน
						$subject = "เพื่อพิจารณาการเสนอขออนุมัติเพิ่มวงเงิน ให้ $crstm_cus_name";		
						$txt_cc = "<span style='color:Blue'><br>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; เพื่อพิจารณาการเสนอขออนุมัติเพิ่มวงเงิน ให้ ". $crstm_cus_name . "  จาก ".number_format($tot_cc )." บาท" ."  เป็น ".number_format($gr_tot)."  บาท "."<br></span> ";																															
					}else {  //ขอต่ออายุวงเงิน
						$subject ="เพื่อพิจารณาการเสนอขออนุมัติต่ออายุวงเงิน ให้ $crstm_cus_name "; 		
						$txt_cc = "<span style='color:Blue'><br>&nbsp;&nbsp;&nbsp;&nbsp;เพื่อพิจารณาการเสนอขออนุมัติต่ออายุวงเงิน ให้ ". $crstm_cus_name ."  ".number_format($tot_cc). "  บาท "." 	จนถึงวันที่ "  .$due_date. "<br></span> ";
					}
				}else{
						// ขอเพิ่มวงเงินลูกค้าใหม่
						$subject = "เพื่อพิจารณาการเสนอขออนุมัติวงเงิน ให้ $crstm_cus_name";	
						$txt_cc = "<span style='color:Blue'><br>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;เพื่อพิจารณาการเสนอขออนุมัติวงเงิน ให้ $crstm_cus_name   เป็น ".number_format($crstm_cc_amt)."  บาท <br><br></span> ";	
				}	
				
				//สร้าง approve code สำหรับใช้ในการ Matching ตอนผู้ใช้กดอนุมัติ
				$crstm_approve_code = md5(gen_uuid());
				$params = array($crstm_nbr);
				$sql_updatestep = "UPDATE crstm_mstr SET" .
				" crstm_approve_code = '$crstm_approve_code'" .
				" WHERE crstm_nbr = ?";						
				$result_updatestep = sqlsrv_query($conn,$sql_updatestep, $params); 
				
				//Create PDF
				
				$fileattach = array();
				$fileattach_mailname = array();
				$output_folder = $downloadpath."SALES/";
				$cr_output_filename1 = $crstm_nbr."-เหตุผลที่เสนอขอวงเงิน.pdf";
				$cr_output_filename = $crstm_nbr."-ใบขออนุมัติ.pdf";
				if($crstm_cus_active=="1") { // เช็คลูกค้าเก่าหรือไม่
					array_push($fileattach,$output_folder.printMailapp_rev1($crstm_nbr,true,$output_folder,$cr_output_filename1,$conn));
					array_push($fileattach_mailname,$crstm_nbr."-เหตุผลที่เสนอขอวงเงิน.pdf");
					array_push($fileattach,$output_folder.printpageform_rev($crstm_nbr,true,$output_folder,$cr_output_filename,$conn));
					array_push($fileattach_mailname,$crstm_nbr."-ใบขออนุมัติ.pdf");
				}else{
					array_push($fileattach,$output_folder.printMailapp_rev1_new($crstm_nbr,true,$output_folder,$cr_output_filename1,$conn));
					array_push($fileattach_mailname,$crstm_nbr."-เหตุผลที่เสนอขอวงเงิน.pdf");
					array_push($fileattach,$output_folder.printpageform_new_rev($crstm_nbr,true,$output_folder,$cr_output_filename,$conn));
					array_push($fileattach_mailname,$crstm_nbr."-ใบขออนุมัติ.pdf");
				}
				
				//SEND EMAIL
			
				if ($crstm_step_code=="110") {  // ส่ง Mail ให้ Reviewer ตรวจสอบและอนุมัติ
					//ส่งหาผู้อนุมัติเลย
					if ($cr_next_curprocessor_email != "") {
					
						$approve_url = "<a href='".$app_url."/crctrlbof/cr_verify_mail_rev1.php?auth=".$crstm_approve_code."&nbr=".encrypt($crstm_nbr, $dbkey)."&id=".encrypt($cr_next_curprocessor_email, $dbkey)."&act=".encrypt('111', $dbkey)."' target='_blank'><font color='green'> Approve</font></a>";
						$revise_url = "<a href='".$app_url."/crctrlbof/cr_verify_mail_rev1.php?auth=".$crstm_approve_code."&nbr=".encrypt($crstm_nbr, $dbkey)."&id=".encrypt($cr_next_curprocessor_email, $dbkey)."&act=".encrypt('112', $dbkey)."' target='_blank'><font color='blue'>Revise</font></a>";
						$reject_url = "<a href='".$app_url."/crctrlbof/cr_verify_mail_rev1.php?auth=".$crstm_approve_code."&nbr=".encrypt($crstm_nbr, $dbkey)."&id=".encrypt($cr_next_curprocessor_email, $dbkey)."&act=".encrypt('113', $dbkey)."' target='_blank'><font color='red'> Reject </font></a>";
						$doc_url  = "<a href='".$app_url."/index.php><img src='_images/spacer.gif'></a>";
						$doc_bot =" <a href='javascript:void(0)'></a>";
						
						$my_files = $fileattach;
						$my_filesname = $fileattach_mailname;
						$mail_from = $mail_from_text_app; //$user_fullname;
						$mail_from_email = $mail_credit_email; //$email_mgr;
						$mail_to = $cr_next_curprocessor_email;
						$mail_subject = $subject;
						//$mail_message = $mail_message;
						
						$mail_message =	"<font style='font-family:Cordia New;font-size:19px'>เรียน $reviewName <br>
							$doc_bot
							$txt_cc
							$txt_term 
										
							ตามอำนาจดำเนินการ : $crstm_approve <br><br>
							รายละเอียดใบขออนุมัติวงเงินเลขที่  $crstm_nbr ตามเอกสารแนบ <br><br>
							
							คลิ๊กเพื่อ  &nbsp;&nbsp;$doc_url $approve_url &nbsp;&nbsp; $revise_url &nbsp;&nbsp; $reject_url <br><br>
							
							<font style='font-family:Cordia New;font-size:19px'>จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ <br>
							$name_from <br>
							$emp_th_pos_name <br></font>"; 
						if ($can_sendmail) {
							if (is_scgemail($mail_to)) {
								$sendstatus = mail_multiattachment($my_files, $my_filesname, $mail_to, $mail_from_email, $mail_from, $mail_subject, $mail_message);
								if (!$sendstatus) {
									$errortxt .= "ไม่สามารถส่ง Email แจ้งผู้อนุมัติได้ค่ะ<br>";
								}
							} else {$errortxt .= "ไม่สามารถส่ง Email แจ้งผู้อนุมัติได้ค่ะ<br>";}
						}
						else {
							
						}
					}
					
					if($email_sale != ""){
						$mail_message = "";
						if (isservonline($smtp)) { $can_sendmail=true;}
						else {
							$can_sendmail=false;
							$errortxt .= "<span style='color:red'>** พบปัญหาการส่ง Email ดังนั้นระบบจึงไม่สามารถส่ง Email แจ้งผู้ที่เกี่ยวข้องได้!!**</span><br>";
						}
						$mail_from = $mail_from_text;
						$mail_from_email = $mail_credit_email;
						$mail_to =  $email_sale;
						$mail_subject = "ใบขออนุมัติวงเงิน :" ." $crstm_nbr ". " ลูกค้า "." $crstm_cus_name ". "ถูกส่งให้ผู้พิจารณา 1 เรียบร้อยแล้ว รอผลการตรวจสอบ";

						$mail_message =	"<font style='font-family:Cordia New;font-size:19px'>เรียน $name_from <br>
						<br>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; ใบขออนุมัติวงเงิน : $crstm_nbr ลูกค้า $crstm_cus_name ถูกส่งให้ผู้พิจารณา 1 เรียบร้อยแล้ว รอผลการตรวจสอบ <br><br>
						ขอบคุณค่ะ</font>";
					
						$mail_message .= "<br>" .$mail_no_reply ;
						if ($mail_to!="") {
							$sendstatus1 = mail_normal($mail_from,$mail_from_email,$mail_to,$mail_subject,$mail_message);
							if (!$sendstatus1) {
								$errortxt .= "ไม่สามารถส่ง Email ได้<br>";
							} else {
								$params_edit = array($crstm_nbr);
								$sql_edit = "UPDATE crstm_mstr SET ".
								" crstm_step_code = '$crstm_step_code' ,".
								" crstm_step_name = '$crstm_step_name' ".
								" WHERE crstm_nbr = ? ";
								$result_edit = sqlsrv_query($conn,$sql_edit,$params_edit);
								if($result_edit) {
										$r="1";
										$errortxt="Upldate success.";
										$nb=encrypt($crstm_nbr, $key);
									}
									else {
										$r="0";
										$nb="";
										$errortxt="Upldate fail.";
									}
							}
							
						} else {$errortxt .= "ไม่สามารถส่ง Email ได้<br>";}
					}	
					echo '{"r":"'.$r.'","e":"'.$errortxt.'","nb":"'.$nb.'","pg":"'.$pg.'"}';
				} 
		 }
	}
?>