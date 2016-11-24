<?php include('header.php');
error_reporting(0);
include 'login_session.php';

	$curl = curl_init("https://sheamoisturevccsbox.desk.com/api/v2/customers/search?phone=$phonenumber");
	$username = "Karthik.matam@itcinfotech.com";
	$password = "Itcinfotech17";
	// In oauth_callback.php
	//curl_setopt($curl, CURLOPT_PROXY, '10.6.13.77:8080');
	//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$json_response = curl_exec($curl);
	//print_r($json_response);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

	if ( $status != 200 ) {
		die("Error: call to token URL $curl failed with status $status, curl_errno() "
				.curl_errno($curl).", curl_error() ".curl_error($curl).", response $json_response");
	}

	//echo "Looks like everything worked ok - got status $status, response:<br/>".htmlspecialchars($json_response);
	
	$output = json_decode($json_response);
	//print_r($output);
	$custdetail = $output->_embedded->entries;
	
	
	
	foreach($custdetail as $custdetail1) {
		$firstname = $custdetail1->first_name;
		$lastname = $custdetail1->last_name;
		$dispname = $custdetail1->display_name;
		$userid = $custdetail1->id;
		$phone_numbers = $custdetail1->phone_numbers;
		$emails = $custdetail1->emails;
		$pre_phone_numbers = $custdetail1->phone_numbers[0]->value;
		$pre_emails = $emails[0]->value;
	}
if(isset($firstname) && $firstname != "") {	
?>
<div>
    <div class=" row">
		<div class="col-md-3 col-sm-3 col-xs-6">
			<a data-toggle="tooltip" title="" class="well top-block" href="#" data-original-title="<?php echo $dispname; ?>">
				<div>Customer Details</div>
			</a>
		</div>

		<?php
							
							$curl = curl_init("https://sheamoisturevccsbox.desk.com/api/v2/cases/search?phone=$phonenumber");
							$username = "Karthik.matam@itcinfotech.com";
							$password = "Itcinfotech17";
							// In oauth_callback.php
							//curl_setopt($curl, CURLOPT_PROXY, '10.6.13.77:8080');
							//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
							curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
							curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
							curl_setopt($curl, CURLOPT_HEADER, false);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

							$json_response = curl_exec($curl);
							//print_r($json_response);
							$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

							if ( $status != 200 ) {
								die("Error: call to token URL $curl failed with status $status, curl_errno() "
										.curl_errno($curl).", curl_error() ".curl_error($curl).", response $json_response");
							}

							//echo "Looks like everything worked ok - got status $status, response:<br/>".htmlspecialchars($json_response);
							
							$output = json_decode($json_response);
							//print_r($output);
							$casedetail = $output->_embedded->entries;
							$totalcases = $output->total_entries;
							//print_r($casedetail);
						?>	
		
	</div>
</div>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Customers Details</h2>

               
            </div>
            <div class="box-content">
			
				<div class="box col-md-5">
                    <div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">First Name</label>
                        <input type="text" class="form-control" id="inputSuccess4" value="<?php echo $firstname; ?>" readonly>
                        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    </div>
					<div class="clearfix"></div></br>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Last Name</label>
                        <input type="text" class="form-control" id="inputSuccess4" value="<?php echo $lastname; ?>" readonly>
                        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    </div>
					<div class="clearfix"></div></br>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Email<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> </label>
                        <input type="text" class="form-control" id="inputSuccess4" value="<?php echo $pre_emails; ?>" readonly>
                        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    </div>
					<div class="clearfix"></div></br>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Phone<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></label>
                        <input type="text" class="form-control" id="inputSuccess4" value="<?php echo $pre_phone_numbers; ?>" readonly>
                        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    </div>
                </div>

				<div class="box col-md-7">
                    <table class="table table-striped table-bordered responsive">
                        <thead>
                        <tr>
                            <th>Case ID</th>
                            <th>Type</th>
                            <th>Subject</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php	
							foreach($casedetail as $casedetail1) {
								//print_r($casedetail1);
								$caseid=$casedetail1->id;
								$casetype=$casedetail1->type;
								$casestatus=$casedetail1->status;
								$casesubject=$casedetail1->subject;
								
						?>
                        <tr>
                            <td><?php echo $caseid; ?></td>
                            <td class="center"><?php echo $casetype; ?></td>
                            <td class="center"><?php echo $casesubject; ?></td>
							<td class="center"><span class="label-warning label label-default"><?php echo $casestatus; ?></span></td>
                        </tr>
							<?php } ?>
                        </tbody>
                    </table>
                </div>				
            </div>
        </div>
    </div>
</div><!--/row-->
<?php } else {
	//$phonenumber = $_GET['phone'];	
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=customerdetail.php?phone='.$phonenumber.'">';    
	die;
}
?>
<?php include('footer.php'); ?>
