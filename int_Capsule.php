<?php
$access_token="OtnYbVjgklQBra0DsJLXpaNSMDY7UefM83A2bQMxeQ7UYVGDKlWXQfabMSf35GHr";
$refreshtoken="OtnYbVjgklQBra0DsJLXpcP8R8DL1KMMTLcfdXNO+eI5glPsGQVJOw8ceDL+gOAz";
$userid="abc";
$organizationid="bcd";
$clientnumber="8989898989";
$callernumber="9999999999";
$recordingurl="";
$dialcallstatus="incoming";
$calltype="1";
$duration="01:03";
$testnumber="";
$callinfourl="Call Info Url";
$origcallid="orig";
$callsid="sid";


function checkcapsule($userid,$managerid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token){
	
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

			$response = json_decode($result);
			$data = $response->{'party'};
		
			$id = $data->{'id'};
			$contactfname = $data->{'firstName'};
			saveLog($userid,$managerid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id);

		}else{

			for($k=0;$k<count($data);$k++){
				echo "<br>";
				$id = $data[$k]->{'id'};
				$contactfname = $data[$k]->{'firstName'};
				saveLog($userid,$managerid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id,$contactfname);
			}
		}
		
	}
}

function saveLog($userid,$organizationid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id,$contactfname){


	$content = LogContent($userid,$organizationid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id,$contactfname);
	


	$ch = curl_init();
	$urlLogSend = "https://api.capsulecrm.com/api/v2/entries";

	$postData = array(
		'entry' => array('attachements'=> array('token'=>$access_token),
			'party' => array('id'=>$id),
			'activityType'=>-3,
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

function LogContent($userid,$organizationid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token,$id,$contactfname){
	$senddialcallstatus = "";
	$notes = "";

	if ($calltype == '0')
	{ 
		if($dialcallstatus=="completed")
		{
			$senddialcallstatus = "Outbound Call (".$duration.")";
			if ($recordingurl == "" || $recordingurl==null)
			{
				$notes = "Called via: +".$callernumber." Notes - ".$callinfourl;
				$details_without_notes = "Called via: +".$callernumber;
			} else
			{
				$shorturl = "";
				if($shorturl=="") 
				{
					$shorturl = $recordingurl;
				}
				$recordingurl = $shorturl;
				$notes = "Called via: +".$callernumber."\nPlay Recording - ".$recordingurl."\nNotes - ".$callinfourl;
				$details_without_notes = "Called via: +".$callernumber." Play Recording - ".$recordingurl;
			}
		}else
		{
			//outbound call was either no-answer, cancelled or busy
			$senddialcallstatus = "Outbound Call to ".$contactfname." (".$dialcallstatus.")";
			$dialerurl = "https://justcall.io/app/macapp/dialpad_app.php?numbers=".$clientnumber."&utm_source=prosperworks&utm_medium=".$id;
			$shorturl = "";
			if($shorturl=="") 
			{
				$shorturl = $dialerurl;
			}
			$dialerurl = $shorturl;
			$notes = "Called via: +".$callernumber."\nCall again - ".$dialerurl."\nNotes - ".$callinfourl;
			$details_without_notes = "Called via: +".$callernumber." Call again - ".$dialerurl;
		}//Outbound Call
	} else if($calltype == '1')
	{ 		
		if($dialcallstatus=="queued"||$dialcallstatus=="busy"||$dialcallstatus=="no-answer"||$dialcallstatus=="")
		{
			$senddialcallstatus = "Missed call from ".$contactfname;
			$dialerurl = "https://justcall.io/app/macapp/dialpad_app.php?numbers=".$clientnumber."&utm_source=prosperworks&utm_medium=".$id;
			$shorturl = "";
			if($shorturl=="") 
			{
						//agar google ki taraf se koi kami reh gayi ho toh ya google ne apni maa behen krwayi ho
				$shorturl = $dialerurl;
			}
			$dialerurl = $shorturl;
			$notes = "Received on: +".$callernumber."\nCall back - ".$dialerurl."\nNotes - ".$callinfourl;
			$details_without_notes = "Received on: +".$callernumber." Call back - ".$dialerurl;
		} else
		{
					//incoming call completed
			$senddialcallstatus = "Incoming Call from ".$contactfname." (".$duration.")";
			$dialerurl = "https://justcall.io/app/macapp/dialpad_app.php?numbers=".$clientnumber."&utm_source=prosperworks&utm_medium=".$id;
			$shorturl = "";
			if($shorturl=="")
			{
				$shorturl = $dialerurl;
			}
			$dialerurl = $shorturl;
			if ($recordingurl == "" || $recordingurl==null)
			{
				$notes = "Received on: +".$callernumber."\nCall again - ".$dialerurl."\nNotes - ".$callinfourl;
				$details_without_notes = "Received on: +".$callernumber." Call again - ".$dialerurl;
			} else
			{
				$shorturl = "";
				if($shorturl=="")
				{
					$shorturl = $recordingurl;
				}
				$recordingurl = $shorturl;
				$notes="Received on: +".$callernumber."\nPlay recording - ".$recordingurl."\nNotes - ".$callinfourl;
				$details_without_notes = "Received on: +".$callernumber." Play recording - ".$recordingurl;
			}
		}	
	}else if ($calltype == '2')
	{	//Voicemail
		$senddialcallstatus = $dialcallstatus;
		$dialerurl = "https://justcall.io/app/macapp/dialpad_app.php?numbers=".$clientnumber."&utm_source=prosperworks&utm_medium=".$id;
		$shorturl = "";
		if($shorturl=="")
		{
			$shorturl = $dialerurl;
		}
		$dialerurl = $shorturl;
		$shorturl = "";
		if($shorturl=="")
		{
			$shorturl = $recordingurl;
		}
		$recordingurl = $shorturl;
		$notes = "Received on: +".$callernumber."\nPlay voicemail - ".$recordingurl."\nNotes - ".$callinfourl;
		$details_without_notes = "Received on: +".$callernumber." Play voicemail - ".$recordingurl;
	}
	$final_Content = $senddialcallstatus."\n".$notes;
	return $final_Content;
}

checkcapsule($userid,$organizationid,$clientnumber,$callernumber,$recordingurl,$dialcallstatus,$calltype,$duration,$testnumber,$callinfourl,$origcallid,$callsid,$access_token);
?>