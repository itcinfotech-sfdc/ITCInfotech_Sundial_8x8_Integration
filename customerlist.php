<?php 
//error_reporting(0);
include('header.php'); 
include 'login_session.php';
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
<?php

echo $phonenumber;


if($phonenumber != NULL) {
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
	$checkvalue = $output->total_entries;
	if(isset($checkvalue) && $checkvalue >= 2) {
	?>
	<table class="table table-striped table-bordered responsive">
	<thead>
	<tr>
		<th>Username</th>
		<th>Phone Number</th>
		<th>Email</th>
		<th>Status</th>
		<th>Actions</th>
	</tr>
	</thead>
	<tbody>
<?php			
	foreach($output as $output1) {
		$entries = $output1->entries;
		foreach($entries as $entries1) {
		echo '<tr>
				<td class="center">'.$entries1->display_name.'</td>
				<td class="center">
				<table border="0">';
				$phone_numbers = $entries1->phone_numbers;
				foreach($phone_numbers as $phone_numbers1) {
					echo '<tr><td>'.$phone_numbers1->type.'</td><td>'.$phone_numbers1->value.'</td></tr>';
				}
		echo '</table>
				</td>
				<td class="center">
				<table border="0">';
				$emails = $entries1->emails;
				foreach($emails as $emails1) {
					echo '<tr><td>'.$emails1->type.'</td><td>'.$emails1->value.'</td></tr>';
				}
		echo '</table></td>
				<td class="center">Active</td>
				<td class="center">
				<table border="0">';
				$phone_numbers = $entries1->phone_numbers;
				foreach($phone_numbers as $phone_numbers1) {
					echo '<tr><td><a class="btn btn-success" href="customerdetail.php?phone='.$phone_numbers1->value.'">View</td></tr>';
				}
		echo '</table>
			</td>
			</tr>';
		}
	}
?>	
		</tbody>
		</table>
<?php 
} elseif(isset($checkvalue) && $checkvalue == 1) { 
		//print_r($output);
		foreach($output as $output1) {
			$entries = $output1->entries;
			foreach($entries as $entries1) {
				$customerid = $entries1->id;
			}
		}
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=customerdetail.php">';    
		die;
} else {
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=createcustomer.php">';    
		die;
	}
} else { echo "Please enter a valid URL"; } ?>
		
        </div>
        </div>
    </div>
</div><!--/row-->


<?php include('footer.php'); ?>
