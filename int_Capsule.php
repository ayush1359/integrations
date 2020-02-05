<?php
include 'integrationlog.php';
$userid="2";
$managerid="2";
$clientnumber="8989898989";
$callernumber="9999999999";
$recordingurl="";
$dialcallstatus="incoming";
$datetime = "";
$calltype=1;
$duration="01:03";
$testnumber="9898989";
$callinfourl="The call was completed";
$origcallid=1;
$callsid=1;


function checkcapsule($userid,$managerid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$datetime,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid){

	//database connectivity
	$server="localhost";
	$user = "root";
	$password = "";
	$db = "cap";

	$conn = mysqli_connect($server,$user,$password,$db);


	if ($conn) {
	    echo "Connected to database!";
	  } else {
	    echo "Connection Failed";
	  }

	//extracting data from database to get the access_token of the caller 
	$sqlcapsule=mysqli_query($conn,"SELECT * FROM capsule_info WHERE userid='$userid' AND managerid='$managerid'");
	print_r($sqlcapsule);

	$no = $sqlcapsule->{'num_rows'};
	if($no>0){
		while($capsule_data=mysqli_fetch_array($sqlcapsule)){
			$capsule_id = $capsule_data['id'];
			$userid = $capsule_data['userid'];
			$managerid = $capsule_data['managerid'];
			$access_token = $capsule_data['access_token'];
			$refreshtoken = $capsule_data['refreshtoken'];
			$token_timestamp = $capsule_data['token_timestamp'];
			$username = $capsule_data['username'];
			$subdomain = $capsule_data['subdomain'];
			$scope = $capsule_data['scope'];
			$user_capsuleid = $capsule_data['user_capsuleid'];
			$status = $capsule_data['status'];
		}
		echo gettype($capsule_id)."---yaha kya aaya--".$userid."--".$managerid."--".$access_token."--".$refreshtoken."--".$token_timestamp."--".$username."--".$subdomain."--".$scope."--".$user_capsuleid;


		$token_time = strtotime($token_timestamp);
		$curtime = time();
		

		if($status==2){
			// integration not connected
			$comments = "Integration not found";
			integration_logs::save_log($conn,'34','2',$origcallid,$calltype,$capsule_id,'0',$comments);

		}

		else{
			//integration connected and thus can proceed
			$comments = $username;
			integration_logs::save_log($conn,'34','1',$origcallid,$calltype,$capsule_id,'0',$comments);
			$ch = curl_init();
			$url = "https://api.capsulecrm.com/api/v2/parties/search";


			curl_setopt($ch, CURLOPT_URL, $url.'?q='.$testnumber);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	

			$headers = array();
			$headers[] = "Accept: application/json";
			$headers[] = "Authorization: Bearer ".$access_token;

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$comments = "Taking info from dynamic search";
			integration_logs::save_log($conn,'34','3',$origcallid,$calltype,$capsule_id,'0',$comments);
			$result = curl_exec($ch);
			echo "<br/>";
			echo "People search result";
			echo "<pre>";
			print_r($result);
			echo "</pre>";
			$err = curl_error($ch);
			curl_close($ch);
			if($err){
				echo "cURL Error #:" . $err;
				$comments = $result;
				integration_logs::save_log($conn,'34','7',$origcallid,$calltype,$capsule_id,'0',$comments);
			}else{

				$response = json_decode($result);
				$data = $response->{'parties'};
				echo("arrey yaar..................................<br>");
				print_r($result);

				if(count($data)==0){
					//the user does not exist. Making a new contact with the name "Justcall New Contact"
					$comments = "";
					integration_logs::save_log($conn,'34','5',$origcallid,$calltype,$capsule_id,'0',$comments);
					$ch = curl_init();
					$urlSaveContact = "https://api.capsulecrm.com/api/v2/parties";
		
							$postData = array(
								'party'=>array(
									'type'=>'person',
									'firstName'=>'Justcall New Contact',
									'phoneNumbers'=> array(array(
										'number'=>$clientnumber))
								)
							);
					$json_data = json_encode($postData);
				
					curl_setopt($ch, CURLOPT_URL, $urlSaveContact);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS,$json_data);
					curl_setopt($ch, CURLOPT_POST, 1);

					$headers = array();
					$headers[] = "Accept: application/json";
					$headers[] = "Authorization: Bearer ".$access_token;
					$headers[] = 'Content-Type: application/json';

					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$result = curl_exec($ch);
					echo "<br/>";
					echo "People search result";
					echo "<pre>";
					print_r($result);
					echo "</pre>";
					$err = curl_error($ch);
					curl_close($ch);
					if($err){
						$comments = $result;
						integration_logs::save_log($conn,'34','8',$origcallid,$calltype,$capsule_id,'0',$comments);

					}
					else{


						//Finding the id of the client to log the details
						$response = json_decode($result);
						$data = $response->{'party'};
		
						$id = $data->{'id'};
						$contactfname = $data->{'firstName'};
						$comments = '<a href="https://api.capsulecrm.com/api/v2/parties/'.$id.'/entries">'.$contactfname.'</a>' ;
						integration_logs::save_log($conn,'34','8',$origcallid,$calltype,$capsule_id,'0',$comments);

					

						saveLog($user_capsuleid,$capsule_id,$conn,$userid,$managerid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$datetime,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id,$contactfname);

						

					}
				}else{
					//user already exist
					echo "ye kitti baar chalega.........<br>".count($data);
					echo("<br>");
					print_r($data);
					for($k=0;$k<count($data);$k++){
						echo "<br>";
						$id = $data[$k]->{'id'};
						$contactfname = $data[$k]->{'firstName'};
						$comments = '<a href="https://api.capsulecrm.com/api/v2/parties/'.$id.'/entries">'.$contactfname.'</a>' ;
						integration_logs::save_log($conn,'34','4',$origcallid,$calltype,$capsule_id,'0',$comments);
						saveLog($user_capsuleid,$capsule_id,$conn,$userid,$managerid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$datetime,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id,$contactfname);
					}
				}

			}
		}

	}
	else{
		//No entry found with the provided userid and managerid
	}

}

function saveLog($user_capsuleid,$capsule_id,$conn,$userid,$managerid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$datetime,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id,$contactfname){
	$original_datetime=$datetime;


	$content = LogContent($userid,$managerid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$datetime,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id,$contactfname);
	// echo gettype($capsule_id)."//////////////bhaiiiiiiiiiiiiiiiii";
	// echo "bhai yaha kya aagaya bey----------------------<br>";
	// print_r($content);
	$details_without_notes = $content[1];

	$ch = curl_init();
	$urlLogSend = "https://api.capsulecrm.com/api/v2/entries";

	$postData = array(
		'entry' => array('attachements'=> array('token'=>$access_token),
			'party' => array('id'=>$id),
			'activityType'=>-3,
			'type'=>'note',
			'content'=>$content[0])
	);		
	$json_data = json_encode($postData);
				
	curl_setopt($ch, CURLOPT_URL, $urlLogSend);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$json_data);
	curl_setopt($ch, CURLOPT_POST, 1);

	$headers = array();
	$headers[] = "Accept: application/json";
	$headers[] = "Authorization: Bearer ".$access_token;
	$headers[] = 'Content-Type: application/json';

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	echo "<br/>";
	echo "People search result";
	echo "<pre>";
	print_r($result);
	echo "</pre>";
	$err = curl_error($ch);
	curl_close($ch);



	if($err){
		$comments = $result;
		integration_logs::save_log($conn,'34','10',$origcallid,$calltype,$capsule_id,'0',$comments);
	}
	else{
		$response = json_decode($result);
		$data = $response->{'entry'};
		$id= $data->{'id'};
		$comments = '<a href="https://api.capsulecrm.com/api/v2/entries/'.$id.'">Activity Link</a>';
		integration_logs::save_log($conn,'34','5',$origcallid,$calltype,$capsule_id,'0',$comments);

		if($calltype !=2 ) {
			$insert = mysqli_query($conn,"INSERT IGNORE INTO `capsule_activities`( userid, managerid , call_info ,`callsid`,`activity_id`, `status`,`capsuleid`) VALUES ($userid, $managerid, '$details_without_notes', '$origcallid', $id, 0, '$user_capsuleid' ) on duplicate key update `status`=0 ,call_info='$details_without_notes',`activity_id`='$id'");
			echo mysqli_error($conn);

			echo "<br><h1>CAPSULE ACTIVITY LOGGED</h1><br>";
		}

	}

}

function LogContent($userid,$manager,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$datetime,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id,$contactfname){
	$senddialcallstatus = "";
	$notes = "";

	if ($calltype == '0')
	{ 
		if($dialcallstatus=="completed")
		{
			$senddialcallstatus = "Outbound Call (".$duration.")";
			if ($recordingurl == "" || $recordingurl==null)
			{
				$notes = "Called via: +".$callernumber."\nCalled to: +".$clientnumber."\nNotes - ".$callinfourl;
				$details_without_notes = "Called via: +".$callernumber."\nCalled to: +".$clientnumber;
			} else
			{
				$shorturl = "";
				// $shorturl = get_bitly_short_url($recordingurl,'o_2hclvnrj13','R_c2fa279b59e34cbda91273a7b6cdf485');
				if($shorturl=="") 
				{
					$shorturl = $recordingurl;
				}
				$recordingurl = $shorturl;
				$notes = "Called via: +".$callernumber."\nCalled to: +".$clientnumber."\nPlay Recording - ".$recordingurl."\nNotes - ".$callinfourl;
				$details_without_notes = "Called via: +".$callernumber."\nCalled to: +".$clientnumber." Play Recording - ".$recordingurl;
			}
		}else
		{
			//outbound call was either no-answer, cancelled or busy
			$senddialcallstatus = "Outbound Call to ".$contactfname." (".$dialcallstatus.")";
			$dialerurl = "https://justcall.io/app/macapp/dialpad_app.php?numbers=".$clientnumber."&utm_source=prosperworks&utm_medium=".$id;
			$shorturl = "";
			// $shorturl = get_bitly_short_url($dialerurl,'o_2hclvnrj13','R_c2fa279b59e34cbda91273a7b6cdf485');
			if($shorturl=="") 
			{
				$shorturl = $dialerurl;
			}
			$dialerurl = $shorturl;
			$notes = "Called via: +".$callernumber."\nCalled to: +".$clientnumber."\nCall again - ".$dialerurl."\nNotes - ".$callinfourl;
			$details_without_notes = "Called via: +".$callernumber."\nCalled to: +".$clientnumber." Call again - ".$dialerurl;
		}//Outbound Call
	} else if($calltype == '1')
	{ 		
		if($dialcallstatus=="queued"||$dialcallstatus=="busy"||$dialcallstatus=="no-answer"||$dialcallstatus=="")
		{
			$senddialcallstatus = "Missed call from ".$contactfname;
			$dialerurl = "https://justcall.io/app/macapp/dialpad_app.php?numbers=".$clientnumber."&utm_source=prosperworks&utm_medium=".$id;
			$shorturl = "";
			// $shorturl = get_bitly_short_url($dialerurl,'o_2hclvnrj13','R_c2fa279b59e34cbda91273a7b6cdf485');
			if($shorturl=="") 
			{
						//agar google ki taraf se koi kami reh gayi ho toh ya google ne apni maa behen krwayi ho
				$shorturl = $dialerurl;
			}
			$dialerurl = $shorturl;
			$notes = "Received on: +".$callernumber."\nReceived from: +".$clientnumber."\nCall back - ".$dialerurl."\nNotes - ".$callinfourl;
			$details_without_notes = "Received on: +".$callernumber."\nReceived from: +".$clientnumber." Call back - ".$dialerurl;
		} else
		{
					//incoming call completed
			$senddialcallstatus = "Incoming Call from ".$contactfname." (".$duration.")";
			$dialerurl = "https://justcall.io/app/macapp/dialpad_app.php?numbers=".$clientnumber."&utm_source=prosperworks&utm_medium=".$id;
			$shorturl = "";
			// $shorturl = get_bitly_short_url($dialerurl,'o_2hclvnrj13','R_c2fa279b59e34cbda91273a7b6cdf485');
			if($shorturl=="")
			{
				$shorturl = $dialerurl;
			}
			$dialerurl = $shorturl;
			if ($recordingurl == "" || $recordingurl==null)
			{
				$notes = "Received on: +".$callernumber."\nReceived from: +".$clientnumber."\nCall again - ".$dialerurl."\nNotes - ".$callinfourl;
				$details_without_notes = "Received on: +".$callernumber."\nReceived from: +".$clientnumber." Call again - ".$dialerurl;
			} else
			{
				$shorturl = "";
				// $shorturl = get_bitly_short_url($recordingurl,'o_2hclvnrj13','R_c2fa279b59e34cbda91273a7b6cdf485');
				if($shorturl=="")
				{
					$shorturl = $recordingurl;
				}
				$recordingurl = $shorturl;
				$notes="Received on: +".$callernumber."\nReceived from: +".$clientnumber."\nPlay recording - ".$recordingurl."\nNotes - ".$callinfourl;
				$details_without_notes = "Received on: +".$callernumber." Play recording - ".$recordingurl;
			}
		}	
	}else if ($calltype == '2')
	{	//Voicemail
		$senddialcallstatus = $dialcallstatus;
		$dialerurl = "https://justcall.io/app/macapp/dialpad_app.php?numbers=".$clientnumber."&utm_source=prosperworks&utm_medium=".$id;
		$shorturl = "";
		// $shorturl = get_bitly_short_url($dialerurl,'o_2hclvnrj13','R_c2fa279b59e34cbda91273a7b6cdf485');
		if($shorturl=="")
		{
			$shorturl = $dialerurl;
		}
		$dialerurl = $shorturl;
		$shorturl = "";
		// $shorturl = get_bitly_short_url($recordingurl,'o_2hclvnrj13','R_c2fa279b59e34cbda91273a7b6cdf485');
		if($shorturl=="")
		{
			$shorturl = $recordingurl;
		}
		$recordingurl = $shorturl;
		$notes = "Received on: +".$callernumber."\nReceived from: +".$clientnumber."\nPlay voicemail - ".$recordingurl."\nNotes - ".$callinfourl;
		$details_without_notes = "Received on: +".$callernumber."\nReceived from: +".$clientnumber." Play voicemail - ".$recordingurl;
	}
	$data = array();

	$final_Content = $senddialcallstatus."\n".$notes;
	$data[0] = $final_Content;
	$data[1] = $details_without_notes;
	return $data;
}


function checkcapsulesms($userid,$managerid,$sendfrom,$sendto,$body,$type,$origsmsid,$sentby){
	if ($type == '0')
	{ 
		$clientnumber = $sendto;

	} 
	else
	{
		$clientnumber = $sendfrom;

	}
	$server="localhost";
	$user = "root";
	$password = "";
	$db = "cap";

	$conn = mysqli_connect($server,$user,$password,$db);


	if ($conn) {
	    echo "Connected to database!";
	  } else {
	    echo "Connection Failed";
	  }

	if($sentby!=0){
		$sqlcapsule=mysqli_query($conn,"SELECT * FROM capsule_info WHERE userid='$sentby'");


	}
	else{
		$sqlcapsule=mysqli_query($conn,"SELECT * FROM capsule_info WHERE userid='$userid' AND managerid='$managerid'");
	

	}
	//database connectivity
	

	//extracting data from database to get the access_token of the caller 
	// $sqlcapsule=mysqli_query($conn,"SELECT * FROM capsule_info WHERE userid='$userid' AND managerid='$managerid'");
	// print_r($sqlcapsule);

	$no = $sqlcapsule->{'num_rows'};
	if($no>0){
		while($capsule_data=mysqli_fetch_array($sqlcapsule)){
			$userid = $capsule_data['userid'];
			$managerid = $capsule_data['managerid'];
			$access_token = $capsule_data['access_token'];
			$refreshtoken = $capsule_data['refreshtoken'];
			$token_timestamp = $capsule_data['token_timestamp'];
			$username = $capsule_data['username'];
			$subdomain = $capsule_data['subdomain'];
			$scope = $capsule_data['scope'];
			$user_capsuleid = $capsule_data['user_capsuleid'];
		}
		echo $userid."--".$managerid."--".$access_token."--".$refreshtoken."--".$token_timestamp."--".$username."--".$subdomain."--".$scope."--".$user_capsuleid;
		$token_time = strtotime($token_timestamp);
		$curtime = time();
		

		if($curtime-$token_time>604799){
			//refresh the access_token using CRON
		}

		else{
			//the access_token is valid and thus can proceed further
			$ch = curl_init();
			$url = "https://api.capsulecrm.com/api/v2/parties/search";


			curl_setopt($ch, CURLOPT_URL, $url.'?q='.$clientnumber);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	

			$headers = array();
			$headers[] = "Accept: application/json";
			$headers[] = "Authorization: Bearer ".$access_token;

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result = curl_exec($ch);
			echo "<br/>";
			echo "People search result";
			echo "<pre>";
			print_r($result);
			echo "</pre>";
			$err = curl_error($ch);
			curl_close($ch);
			if($err){
				echo "cURL Error #:" . $err;
			}else{

				$response = json_decode($result);
				$data = $response->{'parties'};

				if(count($data)==0){
					//the user does not exist. Making a new contact with the name "Justcall New Contact"
					$ch = curl_init();
					$urlSaveContact = "https://api.capsulecrm.com/api/v2/parties";
		
							$postData = array(
								'party'=>array(
									'type'=>'person',
									'firstName'=>'Justcall New Contact',
									'phoneNumbers'=> array(array(
										'number'=>$clientnumber))
								)
							);
					$json_data = json_encode($postData);
				
					curl_setopt($ch, CURLOPT_URL, $urlSaveContact);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS,$json_data);
					curl_setopt($ch, CURLOPT_POST, 1);

					$headers = array();
					$headers[] = "Accept: application/json";
					$headers[] = "Authorization: Bearer ".$access_token;
					$headers[] = 'Content-Type: application/json';

					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$result = curl_exec($ch);
					echo "<br/>";
					echo "People search result";
					echo "<pre>";
					print_r($result);
					echo "</pre>";
					$err = curl_error($ch);
					curl_close($ch);

					//Finding the id of the client to log the details
					$response = json_decode($result);
					$data = $response->{'party'};
		
					$id = $data->{'id'};
					$contactfname = $data->{'firstName'};
					saveSmsLog($userid,$managerid,$sendfrom,$sendto,$body,$type,$origsmsid,$sentby,$access_token,$id,$contactfname);

				}else{
					//user already exist

					for($k=0;$k<count($data);$k++){
						echo "<br>";
						$id = $data[$k]->{'id'};
						$contactfname = $data[$k]->{'firstName'};
						saveSmsLog($userid,$managerid,$sendfrom,$sendto,$body,$type,$origsmsid,$sentby,$access_token,$id,$contactfname);
					}
				}
			}
		}

	}
	else{
		//No entry found with the provided userid and managerid
	}
}

function saveSmsLog($userid,$managerid,$sendfrom,$sendto,$body,$type,$origsmsid,$sentby,$access_token,$id,$contactfname){
	if ($type == '0')
	{ 
		$clientnumber = $sendto;

	} 
	else
	{
		$clientnumber = $sendfrom;

	}



	$content = LogSmsContent($userid,$managerid,$sendfrom,$sendto,$body,$type,$origsmsid,$sentby,$access_token,$id,$contactfname);


	$ch = curl_init();
	$urlLogSend = "https://api.capsulecrm.com/api/v2/entries";

	$postData = array(
		'entry' => array('attachements'=> array('token'=>$access_token),
			'party' => array('id'=>$id),
			'activityType'=>-1,
			'type'=>'note',
			'content'=>$content)
	);		
	$json_data = json_encode($postData);
				
	curl_setopt($ch, CURLOPT_URL, $urlLogSend);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$json_data);
	curl_setopt($ch, CURLOPT_POST, 1);

	$headers = array();
	$headers[] = "Accept: application/json";
	$headers[] = "Authorization: Bearer ".$access_token;
	$headers[] = 'Content-Type: application/json';

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	echo "<br/>";
	echo "People search result";
	echo "<pre>";
	print_r($result);
	echo "</pre>";
	$err = curl_error($ch);
	curl_close($ch);

}

function LogSmsContent($userid,$managerid,$sendfrom,$sendto,$body,$type,$origsmsid,$sentby,$access_token,$id,$contactfname){
		if ($type == '0')
	{ 
		$clientnumber = $sendto;

	} 
	else
	{
		$clientnumber = $sendfrom;

	}
	if ($type == '0')
	{                     //Outbound Call
		$dialcallstatus = "SMS sent to ".$contactfname."\nSMS sent from ".$sendfrom;
	} else if ($type == '1')
	{                    //Outbound Call
		$dialcallstatus = "New SMS from ".$contactfname."\nSMS sent to ".$sendto;
	}
	$notes=$dialcallstatus."\nMessage - <b>".$body."</b>";
	return $notes;
		            
}




checkcapsule($userid,$managerid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$datetime,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid);

checkcapsulesms($userid,$managerid,"9045454500","9976655789","There is a meeting tomorrow at 8:00am",'0','orig',"me");

?>