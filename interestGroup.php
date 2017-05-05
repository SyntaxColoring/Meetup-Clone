<?php
include("meetupConfig.php");
session_start();
	
	#Interest Picked and groups associated with that interest are shown
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['INTEREST'])){ #may want to take out since we getting interests of associated user
			$interName = $_POST['INTEREST'];
			$stat = $db->prepare("SELECT groups.group_name as gname FROM about inner join groups 
									ON about.group_id = groups.group_id
									WHERE about.interest_name = ?");
			
			$stat->bind_param('s', $interName);
			$stat->execute();
			
			$result = $stat->get_result();
			$stat->close();
			
			#div tag echoed.  
			while($row = $result->fetch_assoc()){
			#group name displayed multiple times
				echo $row['gname'];
			
			}
			#end of div tag
			
		}
	
	
	}


?>
