<?php include('header.php'); 
include 'login_session.php';
if(isset($_POST['createcustomer'])) {
		$username = "Karthik.matam@itcinfotech.com";
		$password = "Itcinfotech17";
		
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$emailvalue=$_POST['emailid'];
		$phonenumber=$_POST['phonenumber'];
		
		$curl_post_data = array(
				'first_name' => $firstname,
				'last_name' => $lastname,
				'phone_numbers' => array(
					'type' => "home",
					'value' => $phonenumber,
				),
				'emails' => array(
					'type' => "work",
					'value' => $emailvalue,
				),
		);
				
		$data_string = json_encode($curl_post_data); 
		$service_url = 'https://sheamoisturevccsbox.desk.com/api/v2/customers';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");  
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);    
		//curl_setopt($curl, CURLOPT_PROXY, '10.6.13.77:8080');
		//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
		curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		$curl_response = curl_exec($curl);
		if ($curl_response == false) {
			$info = curl_getinfo($curl);
			curl_close($curl);
			die('Error occured during curl exec. Additioanl info: ' . var_export($info));
		}
		curl_close($curl);
		$decoded = json_decode($curl_response);
		//print_r($decoded); exit;
		$id = $decoded->id;
		if(isset($id) && $id != "") {
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=customerdetail.php">';    
			die;
		}
}


?>


<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Customer</a>
        </li>
    </ul>
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
					 <form class="form-horizontal" method="POST">
						<fieldset>
							<div class="input-group input-group-lg">
								<input name="firstname" type="text" class="form-control" placeholder="First Name">
							</div>
							<div class="clearfix"></div></br>

							<div class="input-group input-group-lg">
								<input name="lastname" type="text" class="form-control" placeholder="Last Name">
							</div>
							<div class="clearfix"></div></br>
							
							<div class="input-group input-group-lg">
								<input name="phonenumber" type="text" class="form-control" value="<?php echo $phonenumber; ?>" placeholder="Phone Number">
							</div>
							<div class="clearfix"></div></br>
							
							<div class="input-group input-group-lg">
								<input name="emailid" type="email" class="form-control" placeholder="Email">
							</div>
							<div class="clearfix"></div></br>

							<p class="center col-md-5">
								<button type="submit" name="createcustomer" class="btn btn-primary">Create</button>
							</p>
						</fieldset>
					</form>
            </div>
        </div>
    </div>
</div><!--/row-->


<?php include('footer.php'); ?>
