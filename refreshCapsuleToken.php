<?

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

function objectToArray($d) 
{
	if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	};



function refreshToken($conn){
	echo "string";
	$selectquery = mysqli_query($conn,"SELECT userid,managerid,id,access_token,refreshtoken,token_timestamp from capsule_info where status!='2' and refreshed='0' limit 0,1");
	print_r($selectquery);
	$such_rows = $selectquery->{'num_rows'};

	if($such_rows==0){
		$updatequery = mysqli_query($conn,"UPDATE capsule_info set refreshed='0' where status!=2");
		exit;
	}
	else{
		$row=mysqli_fetch_array($selectquery);

		print_r($row);
		$rowid = $row["id"];
		echo "old access token is <br/>";
		$accesstoken = $row["access_token"];

		echo $accesstoken;

		echo "<br/>";

		echo "old refresh token is <br/>";
		$refreshtoken = $row["refreshtoken"];
		$token_timestamp = $row['token_timestamp'];

		echo $refreshtoken;
		echo "<br/>";

		$token_time = strtotime($token_timestamp);
		$curtime = time();
		

		// if($curtime-$token_time>604799){
			//refresh the access_token since now it is expired.

			$userid = $row['userid'];
			$managerid = $row['managerid'];

			$client_id = "1sfpwhte0a9ke";
			$client_secret = "67w4anhorn7xtliar4z8q2hg23yj2vq74olszfimo453q49fep";
			$url = "https://api.capsulecrm.com/oauth/token";
			$fields = array(
				'grant_type' => 'refresh_token',
				'client_id' => $client_id,
				'client_secret' => $client_secret,
				'refresh_token' => $refreshtoken
			);
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');

			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_HTTPHEADER, array(
				"content-type: application/x-www-form-urlencoded;charset=utf-8"
			));
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			//execute post
			$result = curl_exec($ch);

			//close connection
			curl_close($ch);
			// echo "Intercom result";
			// echo "<br/>";


			$origresult = $result;


			$resultarray = json_decode($result);
			$resultarray = objectToArray($resultarray);
			echo "<pre>";
			print_r($result);
			echo "</pre>";
			$newrefreshtoken = $resultarray["refresh_token"];
			$newaccess_token = $resultarray["access_token"];
			$accesstoken = $newaccess_token;
			$refreshtoken = $newrefreshtoken;

			echo "new access token is <br/>";
			echo $newaccess_token;
			echo "<br/>";
			echo "new refresh token is <br/>";
			echo $newrefreshtoken;
			echo "<br/>";
			$datetime = date("Y-m-d H:i:s");

			if($accesstoken){
				$updatequery = mysqli_query($conn,"UPDATE capsule_info set access_token='$newaccess_token', refreshtoken='$newrefreshtoken',refreshed='1',token_timestamp = '$datetime' where id='$rowid'");
			}
			else{
				$message = "Error in getting refresh token";
				header("Location:https://justcall.io/app/integrations.php?capsule=failed");
				exit;				
			}
			
		// }
		
	}	
}

refreshToken($conn);

?>