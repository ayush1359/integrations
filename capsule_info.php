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

$access_token="OtnYbVjgklQBra0DsJLXpaNSMDY7UefM83A2bQMxeQ7UYVGDKlWXQfabMSf35GHr";
$refreshtoken="OtnYbVjgklQBra0DsJLXpcP8R8DL1KMMTLcfdXNO+eI5glPsGQVJOw8ceDL+gOAz";

$userid="abc";
$organizationid="bcd";
$clientnumber="123456789";
$callernumber="9999999999";
$recordingurl="";
$dialcallstatus="";
$calltype="";
$duration="";
$testnumber="";
$callinfourl="";
$origcallid="orig";
$callsid="sid";

$sql = "insert ignore into capsule_info(userid,organizationid,clientnumber,callernumber,recordingurl,dialcallstatus,calltype,duration,testnumber,callinfourl,origcallid,callsid,access_token,refreshtoken) values('$userid','$organizationid','$clientnumber','$callernumber','$recordingurl','$dialcallstatus','$calltype','$duration','$testnumber','$callinfourl','$origcallid','$callsid')";


if (mysqli_query($conn, $sql)) {
		echo "New record created successfully !";
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);

// $conn->exec($sql);

?>