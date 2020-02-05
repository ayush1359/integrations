<?
$server="localhost";
$user = "root";
$password = "";
$db = "cap";
$access_token="OtnYbVjgklQBra0DsJLXpaNSMDY7UefM83A2bQMxeQ7UYVGDKlWXQfabMSf35GHr";
$refreshtoken="OtnYbVjgklQBra0DsJLXpcP8R8DL1KMMTLcfdXNO+eI5glPsGQVJOw8ceDL+gOAz";
$userid="abc";
$organizationid="bcd";
$clientnumber="8989898989";
$callernumber="9999999999";
$recordingurl="";
$dialcallstatus="";
$calltype="";
$duration="";
$testnumber="";
$callinfourl="";
$origcallid="orig";
$callsid="sid";

$conn = mysqli_connect($server,$user,$password,$db);

if ($conn) {
    echo "Connected to database!";
  } else {
    echo "Connection Failed";
  }
?>