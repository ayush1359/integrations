<?
// $access_token = "OtnYbVjgklQBra0DsJLXpaNSMDY7UefM83A2bQMxeQ7UYVGDKlWXQfabMSf35GHr";
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

function sync_Contacts($conn){
	$sql=mysqli_query($conn,"SELECT * FROM capsule_info WHERE contacts_fetched='0' AND status='0' limit 0,20");
	print_r($sql);
	$no = $sql->{'num_rows'};
	if($no==0){
		echo "ye chala tha";
		$update = mysqli_query($conn,"UPDATE capsule_info SET contacts_fetched='0', current_page='0' WHERE status='0'");
	}
	
	for($k=0;$k<$no;$k++){
		while($data=mysqli_fetch_array($sql)){
			print_r($data);
			$capsule_rowId = $data['id'];
			$userid = $data['userid'];
			$managerid = $data['managerid'];
			$access_token = $data['access_token'];
			

			echo "<br>---------------";
			$current_page = $data['current_page'];
			$pageNo = $current_page+1;
			$ch = curl_init();
			$url = "https://api.capsulecrm.com/api/v2/parties?page=".$pageNo."&perPage=5";

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$headers = array();
			$headers[] = "Accept: application/json";
			$headers[] = "Authorization: Bearer ".$access_token;

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result = curl_exec($ch);
			$response = json_decode($result);
			print_r($response);
			$data = $response->{'parties'};

			if(count($data)==0){
				//no more contacts found
				$setStatus = mysqli_query($conn,"UPDATE capsule_info set contacts_fetched='1' where userid='$userid'");
				// break;

			}
			else{
				for($j=0;$j<count($data);$j++){
					$contacts = $data[$j]->{'phoneNumbers'};
					$capsuleid = $data[$j]->{'id'};
					echo "<br><br>yaha capsule id aayi kya $capsuleid<br>";
					$type = $data[$j]->{'type'};
					if($type=="organisation"){
						$fname = $data[$j]->{'name'};
						// $fname = mysql_real_escape_string($fname);
						$lname = "";
					}else{

						$fname = $data[$j]->{'firstName'};
						// $fname = mysql_real_escape_string($fname);
						$lname = $data[$j]->{'lastName'};
						// $lname = mysql_real_escape_string($lname);
					}
					echo("<br>-----$fname-------$lname------$capsuleid");
					if(count($contacts)>0){
						for($i=0;$i<count($contacts);$i++){
							echo("<br>".gettype($contacts)."<br>");
							print_r($contacts[$i]->{'number'});
							$phone = $contacts[$i]->{'number'};						
		  					$formattednumber = str_replace("+","",$phone);
		  					$formattednumber = str_replace("-","",$formattednumber);
		  					$formattednumber = str_replace("(","",$formattednumber);
		  					$formattednumber = str_replace(")","",$formattednumber);
		  					$formattednumber = str_replace(" ","",$formattednumber);
		  					$formattednumber = str_replace(".","",$formattednumber);
		  					echo "<br> userid=$userid------ managerid=$managerid------ phone = $formattednumber ";
		  					$ifexists = mysqli_query($conn,"SELECT id FROM contacts WHERE userid='$userid' AND managerid='$managerid' AND phone='$formattednumber'");
		  					if($ifexists->{'num_rows'}!=0){
		  						//update existing query
		  						$id = mysqli_fetch_array($ifexists);
		  						$contact_id = $id['id'];
		  						$update_contact = mysqli_query($conn,"UPDATE contacts SET fname='$fname',lname='$lname' WHERE id='$contact_id'");		  				
		  					}
		  					else{
		  						//make a new entry

		  						$contact_sync = mysqli_query($conn,"INSERT ignore INTO contacts(userid,managerid,fname,lname,phone) values('$userid','$managerid','$fname','$lname','$formattednumber')");

		  						$findId =  mysqli_query($conn,"SELECT id from contacts WHERE userid='$userid' AND managerid='$managerid' AND phone='$formattednumber'");
		  					
		  						$idContacts = mysqli_fetch_array($findId);
		  						echo "<br>----------------------==========";
		  						print_r($idContacts['id']);
		  						$contact_id = $idContacts['id'];
		  						echo "---------------------============<br>";

		  						echo "<br>===contact_id->$contact_id========capsule_rowId->$capsule_rowId========capsuleid->$capsuleid<br>";
		  					

		  						$contactIntoCapsule = mysqli_query($conn,"INSERT ignore INTO contacts_capsule(contact_id,capsule_rowId,capsuleid, type) values('$contact_id','$capsule_rowId','$capsuleid','$type')");
		  					}
						}
					}
				}
				
		  		$updatePageNo = mysqli_query($conn,"UPDATE capsule_info set current_page='$pageNo' WHERE userid='$userid' AND managerid='$managerid'");
			}



		}
	}

}

sync_Contacts($conn);
?>