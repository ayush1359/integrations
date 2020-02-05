<?


// if($_SERVER["HTTP_HOST"] == "localhost") {
// 	set_include_path("../");
// } else {
// 	set_include_path("/var/www/html/justcall/");
// }

// include 'api/database.php';
// include 'api/database_write.php';


// $rowid = $_REQUEST['id'];
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

$rowid = 272420395;

if($rowid){

	$select = mysqli_query($conn,"select * from `capsule_activities` where activity_id='$rowid' limit 0,10");
	echo mysqli_error($conn);

}else{

	$select = mysqli_query($conn,"select * from `capsule_activities` where status='0' limit 0,10");
	echo mysqli_error($conn);

}

print_r($select);

$suchrows = $select->{'num_rows'};

if($suchrows==0) {
	echo "no more rows found";
}

while($one = mysqli_fetch_array($select)) {

	$thisid = $one["id"];
	$userid = $one["userid"];
	$managerid = $one["managerid"];
	$callid = $one['callsid'];
	$activity_id = $one['activity_id'];
	$payload = $one['call_info'];
	$capsuleid = $one['capsuleid'];
	echo "capsuleid-------->".$capsuleid;


	$update = mysqli_query($conn," UPDATE `capsule_activities` set status=1 where id='$thisid' ");
	echo mysqli_error($conn);

	$getAccessToken = mysqli_query($conn,"SELECT access_token from `capsule_info` where user_capsuleid='$capsuleid'");
	echo mysqli_error($conn);
	echo "----------------<br>";
	print_r($getAccessToken);

	$getNotes = mysql_query("SELECT Notes, disposition_code from `calls` where id='$callid' ");
	echo mysql_error();


	$gotNotes = mysql_fetch_array($getNotes);
	$call_notes = $gotNotes['Notes'];
	$call_dc = $gotNotes['disposition_code'];

	$notes = "<b>Notes:</b> ".$call_notes."<br><b>Disposition Code:</b> ".$call_dc;
	$notes = $payload."<br>".$notes;


	$access_token1 = mysqli_fetch_array($getAccessToken);
	$access_token = $access_token['access_token'];

exit;


	$jsondata = array(
		'entry' => array(
		"content" => $notes)
	);

	$jsondata = json_encode($jsondata);


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.capsulecrm.com/api/v2/entries/'.$activity_id);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata );

	$headers = array();
	$headers[] = 'Accept: application/json';
	$headers[] = "Authorization: Bearer ".$access_token;
	$headers[] = 'Content-Type: application/json';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);

	echo "<br>Update Notes<pre>";
	print_r(json_decode($result, true));
	echo "</pre>";


}


?>