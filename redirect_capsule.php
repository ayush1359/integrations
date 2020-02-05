<?

$code = $_REQUEST['code'];
$client_id = "1btcs628egsm5";
$client_secret = "6aiombtap9vd79b8g3js9llvpvhn7c4ohdm9exzz6rv06we93o";
// $code = "2mvpohi4eaz98drv69hqqwmdvrrzct6qg4hulmn9yiarnd4f2k_259828";
// $userid= "2";
// $managerid = "2";
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

$ch = curl_init();
$url = "https://api.capsulecrm.com/oauth/token";

$tosend = "code=".$code."&client_id=".$client_id."&client_secret=".$client_secret."&grant_type=authorization_code";
				
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$tosend);
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = "Content-Type: application/x-www-form-urlencoded";

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

$response = json_decode($result);
print_r($response->{'access_token'});

if($response->{'access_token'}){
	$refreshtoken = $response->{'refresh_token'};
	$access_token = $response->{'access_token'};
	$scope = $response->{'scope'};
	$subdomain = $response->{'subdomain'};

	echo $refreshtoken."-----".$access_token."-----".$scope."-----".$subdomain;


	$ch = curl_init();
	$url = "https://api.capsulecrm.com/api/v2/users/current";

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	

	$headers = array();
	$headers[] = "Accept: application/json";
	$headers[] = "Authorization: Bearer ".$access_token;

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);

	$err = curl_error($ch);
	curl_close($ch);

	$response = json_decode($result);
	echo "<br>";
	print_r($response);

	$data = $response->{'user'};
	$party = $data->{'party'};
	$user_capsuleid = $party->{'id'};
	$username = $data->{'username'};

	echo $user_capsuleid."---".$username."----";
	$checkauthbig=$_COOKIE["login_pass"];

	$checkauth=mysql_real_escape_string($checkauthbig);
	$brkauth=explode("-",$checkauth);
	$masterhash=mysql_real_escape_string($brkauth[1]);
	$accounttype=mysql_real_escape_string($brkauth[0]);
	$memberHash = $masterhash;

	$parentSql = mysql_query("SELECT userid,managerid,hash,accounttype,stripe_cust_id,subscription_id,base_plan,current_plan,fname,lname,company,email,phonenumber FROM users WHERE hash = '$memberHash' and status!=2",$conn);

	$parent = mysql_fetch_assoc($parentSql);

	$hash = $parent['hash'];
	$managerid = $parent['managerid'];
	$userid = $parent['userid'];
		



	$sql = "insert ignore into capsule_info(userid,managerid,access_token,refreshtoken,username,subdomain,scope,user_capsuleid) values('$userid','$managerid','$access_token','$refreshtoken','$username','$subdomain','$scope','$user_capsuleid')";
	$status = "success";
		$message = "Integration added successfully";
		header("Location:https://justcall.io/app/integrations.php?capsule=success");
		


	if (mysqli_query($conn, $sql)) {
			echo "New record created successfully !";
		 } else {
			echo "Error: " . $sql . "
	" . mysqli_error($conn);
		 }
		 mysqli_close($conn);
	$sqlinsert = mysql_query("update int_connect set capsule=1 where userid='$userid'",$conn_write); echo mysql_error($conn_write);

	
	}
	else{
		$status = "failed";
		$message = "Error while integrating";
		header("Location:https://justcall.io/app/integrations.php?capsule=failed");
	

	}
?>