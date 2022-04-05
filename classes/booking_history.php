<?php 
	include ('config.php');
	if(isset($_REQUEST['userBookinghistory'])) {		
		$userId = $_COOKIE['userid'];
		if($userId != '') {    				
			$statement = $link->prepare("SELECT user.name, t.id, t.txnid, t.userid, t.food, t.created_date FROM `transactionhistory` AS t LEFT OUTER JOIN `users` AS user ON(t.userid = user.id) WHERE t.userid = '$userId' ORDER BY t.id ASC");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			$data = array();	
			$filtered_rows = $statement->rowCount();	
			$number_of_rows = $statement->fetchColumn(); 
			foreach($result as $row) {
				$ticketArr = array();
				$ticketArr[] = $row['id'];
				$ticketArr[] = $row['name'];
				$ticketArr[] = $row['txnid'];
				$ticketArr[] = $row['created_date'];
				$ticketArr[] = '<button class="btn btn-sm btn-outline-primary" title="View Ticket" data-toggle="modal" data-target="#mivieTicket_model"><i class="fas fa-eye"></i></button><button class="btn btn-sm btn-outline-danger" title="Download Ticket" onClick="download_ticket();"><i class="fas fa-cloud-download-alt"></i></button>';
				$data[] = $ticketArr;
			}
			$output = array(
				'data'                 => $data,
				'recordsTotal'		   => $filtered_rows,
				'recordsFiltered'	   => $filtered_rows,

			);			
			if($filtered_rows > 0) {
				echo json_encode($output);
			} else {
				
			}
		
		} else {
			
		}
	}
?>