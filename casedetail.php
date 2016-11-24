<?php include('header.php'); 
error_reporting(0);
include 'login_session.php';
	if(!isset($_GET['caseid'])) {
		$username = "Karthik.matam@itcinfotech.com";
		$password = "Itcinfotech17";
		    
		//$phonenumber = "87879877908";
		$curl = curl_init("https://sheamoisturevccsbox.desk.com/api/v2/customers/search?phone=$phonenumber");
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
		//print_r($output);exit;
		$custdetail = $output->_embedded->entries;
		foreach($custdetail as $custdetail1) {
			$userid = $custdetail1->id;
		}
			
		$curl_post_case = array(
				'type' => "phone",
				'subject' => "",
				'priority' => "",
				'status' => "new",
				'description' => "",
				'message' => array(
					'direction' => "in",
					'body' => "",
				),
				'_links' => array(
					'customer' => array(
						'class' => "customer",
						'href' => "/api/v2/customers/".''.$userid,
					),
				),
		);
				
		$casedata_string = json_encode($curl_post_case); 
		$caseservice_url = 'https://sheamoisturevccsbox.desk.com/api/v2/cases';
		$curlcase = curl_init($caseservice_url);
		curl_setopt($curlcase, CURLOPT_CUSTOMREQUEST, "POST");  
		curl_setopt($curlcase, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($casedata_string))                                                                       
		);    
		//curl_setopt($curl, CURLOPT_PROXY, '10.6.13.77:8080');
		//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
		curl_setopt($curlcase, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($curlcase, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curlcase, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curlcase, CURLOPT_HEADER, false);
		curl_setopt($curlcase, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlcase, CURLOPT_POST, true);
		curl_setopt($curlcase, CURLOPT_POSTFIELDS, $casedata_string);
		$casecurl_response = curl_exec($curlcase);
		if ($casecurl_response == false) {
			$info = curl_getinfo($curlcase);
			curl_close($curlcase);
			die('Error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curlcase);
		$casedecoded = json_decode($casecurl_response);
		//print_r($casedecoded); exit;
		$caseid= $casedecoded->id;
		if(isset($caseid)) {
			$xml = new SimpleXMLElement('<user></user>');
			$xml->addChild('sessionid', $sessionid);
			$xml->addChild('phonenumber', $phonenumber);
			$xml->addChild('caseid', $caseid);
			$xml->asXML('users/' . $sessionid . '.xml');
			if(file_exists('users/' . $sessionid . '.xml')){
				$xml = new SimpleXMLElement('users/' . $sessionid . '.xml', 0, true);
			}
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=casedetail.php?caseid">';    
			die;
		} else {
			echo "Case creation Failed";
		}
	}

if(isset($_POST['createcase'])) {
		$username = "Karthik.matam@itcinfotech.com";
		$password = "Itcinfotech17";
		
		
		$curl = curl_init("https://sheamoisturevccsbox.desk.com/api/v2/customers/search?phone=$phonenumber");
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
		//print_r($output);exit;
		$custdetail = $output->_embedded->entries;
		foreach($custdetail as $custdetail1) {
			$userid = $custdetail1->id;
		}
		$xml = simplexml_load_file('users/' . $sessionid . '.xml');
		$caseid = $xml->caseid;
		$casetype=$_POST['casetype'];
		$casesubject=$_POST['casesubject'];
		$casedescription=$_POST['casedescription'];
		$casestatus=$_POST['casestatus'];
		$casepriority=$_POST['casepriority'];
		$curl_post_case = array(
				'type' => $casetype,
				'subject' => $casesubject,
				'priority' => $casepriority,
				'status' => $casestatus,
				'description' => $casedescription,
				'message' => array(
					'direction' => "in",
					'body' => $casedescription,
				),
				'_links' => array(
					'customer' => array(
						'class' => "customer",
						'href' => "/api/v2/customers/".''.$userid,
					),
				),
		);
				
		$casedata_string = json_encode($curl_post_case); 
		$caseservice_url = 'https://sheamoisturevccsbox.desk.com/api/v2/cases/'.$caseid.'';
		$curlcase = curl_init($caseservice_url);
		curl_setopt($curlcase, CURLOPT_CUSTOMREQUEST, "PUT");  
		curl_setopt($curlcase, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($casedata_string))                                                                       
		);    
		//curl_setopt($curl, CURLOPT_PROXY, '10.6.13.77:8080');
		//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
		curl_setopt($curlcase, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($curlcase, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curlcase, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curlcase, CURLOPT_HEADER, false);
		curl_setopt($curlcase, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlcase, CURLOPT_POST, true);
		curl_setopt($curlcase, CURLOPT_POSTFIELDS, $casedata_string);
		$casecurl_response = curl_exec($curlcase);
		if ($casecurl_response == false) {
			$info = curl_getinfo($curlcase);
			curl_close($curlcase);
			die('Error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curlcase);
		$casedecoded = json_decode($casecurl_response);
		//print_r($casedecoded); exit;
		$casetype= $casedecoded->id;
		if(isset($casetype)) {
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=customerdetail.php">';    
			die;
		} else {
			echo "Case creation Failed";
			die;
		}	
		
}


?>





<?php
	
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
?>
<div>
    <div class=" row">
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
		<div class="col-md-3 col-sm-3 col-xs-6">
			<a data-toggle="tooltip" title="" class="well top-block" href="#" data-original-title="<?php echo $totalcases; ?> Case Available">
				<i class="glyphicon glyphicon-envelope red"></i>
				<div>Cases</div>
				<span class="notification red"><?php echo $totalcases; ?></span>
			</a>
		</div>
	</div>
</div>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>Customers</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
			
				<div class="form-inline">
                    <div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">First Name</label>
                        <input type="text" class="form-control" id="inputSuccess4" value="<?php echo $firstname; ?>" readonly>
                        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    </div>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Last Name</label>
                        <input type="text" class="form-control" id="inputSuccess4" value="<?php echo $lastname; ?>" readonly>
                        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    </div>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Email </label>
                        <input type="text" class="form-control" id="inputSuccess4" value="<?php echo $pre_emails; ?>" readonly>
                        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    </div>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Phone</label>
                        <input type="text" class="form-control" id="inputSuccess4" value="<?php echo $pre_phone_numbers; ?>" readonly>
                        <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    </div>
                </div>
				
				<div style="clear:both">&nbsp;</div>
			
				<form method="POST" class="form-inline" role="form">
                    <div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Type<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> </label>
                      	<select name="casetype" class="form-control" id="inputSuccess4" data-rel="chosen">
								<option>phone</option>
								<option>email</option>
								<option>chat</option>
								<option>twitter</option>
								<option>qna</option>
								<option>facebook</option>
						</select>
                    </div>
					<div class="clearfix"></div></br>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Subject<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> </label>
                        <input name="casesubject" type="text" class="form-control" id="inputSuccess4" value="" >
                    </div>
					<div class="clearfix"></div></br>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Description</label>
                        <input name="casedescription" type="textarea" class="form-control" id="inputSuccess4" >
                    </div>
					<div class="clearfix"></div></br>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Status<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></label>
                        <select name="casestatus" class="form-control" id="inputSuccess4" data-rel="chosen">
								<option>new</option>
								<option>open</option>
								<option>pending</option>
								<option>resolved</option>
								<option>closed</option>
						</select>
                    </div>
					<div class="clearfix"></div></br>
					
					<div class="form-group has-success has-feedback">
                        <label class="control-label" for="inputSuccess4">Priority<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></label>
						<select name="casepriority" class="form-control" id="inputSuccess4" data-rel="chosen">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
								<option>9</option>
								<option>10</option>
						</select>
                    </div>
					<div class="clearfix"></div></br>
					
					<p class="center col-md-5">
								<button type="submit" name="createcase" class="btn btn-primary">Create</button>
							</p>
                </form>			
            </div>
        </div>
    </div>
</div><!--/row-->


<?php include('footer.php'); ?>
