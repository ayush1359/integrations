<?

function checkCapsule($userid,$managerid,$phonenumber,$conn,$conn_write,$sleep){
	
	$cbase_value = cbase($userid,$conn);
	$linkarray = array();


	$imageUrl = "https://justcall.io/app/assets/img/search/capsule_image.png";
	  //extracting data from database to get the access_token of the caller 
	$sqlcapsule=mysql_query("SELECT * FROM capsule_info WHERE userid='$userid' AND managerid='$managerid' and status=0",$conn);
	// print_r($sqlcapsule);

	$no = mysql_num_rows($sqlcapsule);
	// $no = $sqlcapsule->{'num_rows'};
	if($no>0){
		while($capsule_data=mysql_fetch_array($sqlcapsule)){
			$capsule_id = $capsule_data['id'];
			$userid = $capsule_data['userid'];
			$managerid = $capsule_data['managerid'];
			$access_token = $capsule_data['access_token'];
			$refreshtoken = $capsule_data['refreshtoken'];
			$token_timestamp = $capsule_data['token_timestamp'];
			$username = $capsule_data['username'];
			$user_capsuleid = $capsule_data['user_capsuleid'];
				
			$url = "https://api.capsulecrm.com/api/v2/parties/search";
			$testnumber = substr($phonenumber, 3);
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url.'?q='.$testnumber);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		

			$headers = array();
			$headers[] = "Accept: application/json";
			$headers[] = "Authorization: Bearer ".$access_token;

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			

			$result = curl_exec($ch);
			$err = curl_error($ch);
			curl_close($ch);
			if($err){
				//error occured
				// echo "cURL Error #:" . $err;
			}else{

				$response = json_decode($result,true);
				$data = $response['parties'];
				// echo "-------<br>------------------------";
				// for($k=0;$k<count($data);$k++){
					$id = $data[0]['id'];
					$name = $data[0]['firstName']." ".$data[0]['lastName'];
					// echo $name;
					$profileUrl = "https://justcal.capsulecrm.com/party/".$id;
					array_push($linkarray, array('name'=>$name,'profileUrl'=>$profileUrl,'image'=>$imageUrl));
				// }
			}
			if($managerid>0) {
				$manid = $managerid;
			} else {
				$manid = $userid;
			}
			if(count($linkarray)==0){
				$phonenumber = preg_replace('/[^0-9]/', '',$phonenumber);
				$testnumber = substr($phonenumber,3);

				$testnumber1 = substr($phonenumber, 1);
				$testnumber2 = substr($phonenumber, 2);
				$testnumber3 = substr($phonenumber, 3);

				$getsuers = mysql_query("select userid from users where managerid='$manid' and status=0"); 
				// echo mysql_error();
				$useridarray = array();
				while($ekuser = mysql_fetch_array($getsuers)) {
					array_push($useridarray, $ekuser["userid"]);
				}

				array_push($useridarray, $manid);
				$implodedstring = implode(",", $useridarray);
				$sqlgetpersonid=mysql_query("SELECT id,fname,lname FROM contacts".$cbase_value." WHERE userid in (".$implodedstring.") AND `number` IN ('".$number."','".$testnumber1."','".$testnumber2."','".$testnumber3."') AND status='0'");
				$n_getpersonid = mysql_num_rows($sqlgetpersonid);
				$contactidarray = array();

				if ($n_getpersonid>0){

					$customername = '';

					while($personiddata = mysql_fetch_array($sqlgetpersonid)) {
						$contact_id = $personiddata["id"];
						array_push($contactidarray, $contact_id);

						$contactfname = $personiddata["fname"];
						$contactlname = $personiddata["lname"];
						$customername = $contactfname." ".$contactlname;
					}

					$contactcheckstring = implode(",",$contactidarray);

							// echo $contactcheckstring;

					if($contactcheckstring!=""){
						$sql = mysql_query("SELECT capsuleid,type from contacts_capsule where contactid in ($contactcheckstring) and capsule_rowId='$capsule_id'");
						// echo mysql_error();
						if(mysql_num_rows($sql)>0) {

							$gotdbcontact = mysql_fetch_array($sql);

							$profileUrl = "https://justcal.capsulecrm.com/party/".$gotdbcontact['capsuleid'];
							array_push($linkarray, array('name'=>$customername,'profileUrl'=>$profileUrl,'image'=>$imageUrl));
						}

					}
				}
			}
		
		}
	}
	return $linkarray;
}
?>