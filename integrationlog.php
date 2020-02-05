<?

class integration_logs{
	


		public function save_log($conn,$crm,$actionid,$callid,$type,$crm_rowid,$showcomments,$comments=NULL){

				echo '<h1>Comming here save_log</h1>';



			// echo "INSERT INTO `int_logs` (crmid,actionid,callid,type,crm_rowid,show_comments,comments) VALUES ('$crm','$actionid','$callid','$type','$crm_rowid','$showcomments','$comments')";
			echo "<br/>";


			$save_log = mysqli_query($conn,"INSERT INTO `int_logs` (crmid,actionid,callid,type,crm_rowid,show_comments,comments) VALUES ('$crm','$actionid','$callid','$type','$crm_rowid','$showcomments','$comments')"); echo mysqli_error($conn);
			

		}    

	}
?>