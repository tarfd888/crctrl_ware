
    <fieldset>
        <div class="bs-callout-success callout-border-right callout-bordered callout-transparent mt-1 p-1">   
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cusd_test">ความเห็นของผู้แทนขาย
                                (ใช้สำหรับเสนอขออนุมัติ) :</label>
                            <textarea name="cusd_sale_reason" id="cusd_sale_reason"
                                class="form-control textarea-maxlength input-sm font-small-2 border-info"
                                placeholder="Enter upto 500 characters.." maxlength="500" rows="4"
                                style="line-height:1.5rem;"><?php echo $cusd_sale_reason; ?></textarea>
                        </div>
                    </div>
        
                </div>
        </div>
        
        <div class="bs-callout-success callout-border-left callout-bordered callout-transparent p-1 mt-1">   
            <div class="row ml-1 mr-1 pb-2 mt-n2">
                <div class="col-lg-12 col-md-12  pl-4 pr-4">
                    <div class="row">
                        <div class="col-md-3 pt-1 ">อำนาจดำเนินการ :</div>
                        <div class="col-md-4 pt-1 border-bottom"><?php echo $cusd_op_app; ?></div>
                    </div>
                    <?php if($apprv_id_array_count == 1) { ?>
                        <div class="row">
                            <div class="col-md-3 pt-1 ">ผู้พิจารณา 1 :</div>
                            <div class="col-md-3 pt-1 border-bottom"><?php echo $cusd_review1_name; ?></div>
                            <div class="col-md-2 pt-1 ">วันที่ :</div>
                            <div class="col-md-3 pt-1 border-bottom"><?php echo $cusd_review1_date; ?></div>
                        </div>
                    <?php }  else { ?>
                        <div class="row">
                            <div class="col-md-3 pt-1 ">ผู้พิจารณา 1 :</div>
                            <div class="col-md-4 pt-1 border-bottom"><?php echo $cusd_review1_name; ?></div>
                            <div class="col-md-2 pt-1 ">วันที่ :</div>
                            <div class="col-md-3 pt-1 border-bottom"><?php echo $cusd_review1_date; ?></div>
                            <div class="col-md-3 pt-1 ">ผู้พิจารณา 2 :</div>
                            <div class="col-md-4 pt-1 border-bottom"><?php echo $cusd_review2_name; ?></div>
                            <div class="col-md-2 pt-1 ">วันที่ :</div>
                            <div class="col-md-3 pt-1 border-bottom"><?php echo $cusd_review2_date; ?></div>
                            <div class="col-md-3 pt-1 ">ผู้พิจารณา 3 (CMO) :</div>
                            <div class="col-md-4 pt-1 border-bottom"><?php echo $cusd_review3_name; ?></div>
                            <div class="col-md-2 pt-1 ">วันที่ :</div>
                            <div class="col-md-3 pt-1 border-bottom"><?php echo $cusd_review3_date; ?></div>
                            <div class="col-md-3 pt-1 ">ผู้พิจารณา 4 (CFO) :</div>
                            <div class="col-md-4 pt-1 border-bottom"><?php echo $cusd_review4_name; ?></div>
                            <div class="col-md-2 pt-1 ">วันที่ :</div>
                            <div class="col-md-3 pt-1 border-bottom"><?php echo $cusd_review4_date; ?></div>
                            <div class="col-md-3 pt-1 ">ผู้อนุมัติ (กจก.) :</div>
                            <div class="col-md-4 pt-1 border-bottom"><?php echo $cusd_approve_fin_name; ?></div>
                            <div class="col-md-2 pt-1 ">วันที่ :</div>
                            <div class="col-md-3 pt-1 border-bottom"><?php echo $cusd_approve_fin_date; ?></div>
                        </div>
                    <?php } ?>
                </div>
		    </div>
        </div>
    </fieldset>
