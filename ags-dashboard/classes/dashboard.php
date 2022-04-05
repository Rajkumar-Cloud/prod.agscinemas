<?php 
session_start();
include "config.php";
// error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$userLoc = $_SESSION['userData']->locationId;
$userRole = $_SESSION['userData']->user_role;

$requestData = $_REQUEST;
$transHistoryData = [];
$transHistoryData1 = [];
$array = [];

$today = date("Y-m-d");
$yesterday = date('Y-m-d',strtotime("-1 days"));
$thisWeek = date('Y-m-d',strtotime('last sunday'));
$previous_week = strtotime("-1 week +1 day");

$start_week = strtotime("last sunday midnight",$previous_week);
$end_week = strtotime("next saturday",$start_week);

$start_week = date("Y-m-d",$start_week);
$end_week = date("Y-m-d",$end_week);

if(isset($_REQUEST['Salesexcl'])){
	error_reporting(0);
	$todayTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transactionhistory` AS t, `bookingrecords` AS b WHERE t.txnid = b.bookingrecords_txnid AND t.date LIKE '%".$today."%' AND t.date NOT LIKE '%0000-00-00 00:00:00%' AND t.date > '2021-10-10' AND t.status = 'success' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$TodayTransHistory = $todayTransData->fetchAll();

	$yesterdayTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transactionhistory` AS t, `bookingrecords` AS b WHERE t.txnid = b.bookingrecords_txnid AND t.date LIKE '%".$yesterday."%' AND t.date NOT LIKE '%0000-00-00 00:00:00%' AND t.date > '2021-10-10' AND t.status = 'success' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$yesterdayTransHistory = $yesterdayTransData->fetchAll();

	$thisWeekTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transactionhistory` AS t, `bookingrecords` AS b WHERE t.txnid = b.bookingrecords_txnid AND t.date >= '".$thisWeek."' AND t.date NOT LIKE '%0000-00-00 00:00:00%' AND t.date > '2021-10-10' AND t.status = 'success' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$thisWeekTransHistory = $thisWeekTransData->fetchAll();

	$lastWeekTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transactionhistory` AS t, `bookingrecords` AS b WHERE t.txnid = b.bookingrecords_txnid AND t.date > '2021-10-10' AND t.date >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND t.date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND t.status = 'success' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$lastWeekTransHistory = $lastWeekTransData->fetchAll();

	$thisMnthTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transactionhistory` AS t, `bookingrecords` AS b WHERE t.txnid = b.bookingrecords_txnid AND MONTH(t.date) = MONTH(CURRENT_DATE()) AND YEAR(t.date) = YEAR(CURRENT_DATE()) AND t.date NOT LIKE '%0000-00-00 00:00:00%' AND t.date > '2021-10-10' AND t.status = 'success' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$thisMnthTransHistory = $thisMnthTransData->fetchAll();

	$lastMnthTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transactionhistory` AS t, `bookingrecords` AS b WHERE t.txnid = b.bookingrecords_txnid AND YEAR(t.date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(t.date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND t.date NOT LIKE '%0000-00-00 00:00:00%' AND t.date > '2021-10-10' AND t.status = 'success' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$lastMnthTransHistory = $lastMnthTransData->fetchAll();

	$thisYrTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transactionhistory` AS t, `bookingrecords` AS b WHERE t.txnid = b.bookingrecords_txnid AND YEAR(t.date) = YEAR(CURDATE()) AND t.date NOT LIKE '%0000-00-00 00:00:00%' AND t.date > '2021-10-10' AND t.status = 'success' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$thisYrTransHistory = $thisYrTransData->fetchAll();

	$lastYrTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transactionhistory` AS t, `bookingrecords` AS b WHERE t.txnid = b.bookingrecords_txnid AND YEAR(t.date) = YEAR(CURDATE()) - 1 AND t.date NOT LIKE '%0000-00-00 00:00:00%' AND t.date > '2021-10-10' AND t.status = 'success' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$lastYrTransHistory = $lastYrTransData->fetchAll();


	$locationData = $link->query("SELECT Cin_Id, Cin_Loc FROM `cinema`");
	$location = $locationData->fetchAll();

	$obj = [];
	$obj1 = [];
	$obj2 = [];
	$obj3 = [];
	$obj4 = [];
	$obj5 = [];
	$obj6 = [];
	$obj7 = [];
	$i = 0;
	foreach ($location as $key => $loc) {

			if ($loc['Cin_Id'] == isset($TodayTransHistory[$key]['cin_id'])) {
				$obj[$TodayTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'today' => $TodayTransHistory[$key]['total_amt'], 
						'location' => $TodayTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($yesterdayTransHistory[$key]['cin_id'])) {
				$obj1[$yesterdayTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'yesterday' => $yesterdayTransHistory[$key]['total_amt'], 
						'location' => $yesterdayTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($thisWeekTransHistory[$key]['cin_id'])) {
				$obj2[$thisWeekTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'this_week' => $thisWeekTransHistory[$key]['total_amt'], 
						'location' => $thisWeekTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($lastWeekTransHistory[$key]['cin_id'])) {
				$obj3[$lastWeekTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'last_week' => $lastWeekTransHistory[$key]['total_amt'], 
						'location' => $lastWeekTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($thisMnthTransHistory[$key]['cin_id'])) {
				$obj4[$thisMnthTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'this_month' => $thisMnthTransHistory[$key]['total_amt'], 
						'location' => $thisMnthTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($lastMnthTransHistory[$key]['cin_id'])) {
				$obj5[$lastMnthTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'last_month' => $lastMnthTransHistory[$key]['total_amt'], 
						'location' => $lastMnthTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($thisYrTransHistory[$key]['cin_id'])) {
				$obj6[$thisYrTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'this_year' => $thisYrTransHistory[$key]['total_amt'], 
						'location' => $thisYrTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($lastYrTransHistory[$key]['cin_id'])) {
				$obj7[$lastYrTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'last_year' => $lastYrTransHistory[$key]['total_amt'], 
						'location' => $lastYrTransHistory[$key]['cin_id']
					)
				);
			}
		
	}


	$raw = [];
	$j=1;
	foreach ($location as $key => $loc) {

		$obj_fnl = array();
		$obj_fnl['location'] = $loc['Cin_Loc'];
		$obj_fnl['today'] = (int)$obj[$j]['total_amt']['today'];
		$obj_fnl['yesterday'] = (int)$obj1[$j]['total_amt']['yesterday'];
		$obj_fnl['this_week'] = (int)$obj2[$j]['total_amt']['this_week'];
		$obj_fnl['last_week'] = (int)$obj3[$j]['total_amt']['last_week'];
		$obj_fnl['this_month'] = (int)$obj4[$j]['total_amt']['this_month'];
		$obj_fnl['last_month'] = (int)$obj5[$j]['total_amt']['last_month'];
		$obj_fnl['this_year'] = (int)$obj6[$j]['total_amt']['this_year'];
		$obj_fnl['last_year'] = (int)$obj7[$j]['total_amt']['last_year'];

		$raw['data'][$i] = $obj_fnl;

		$i++; $j++;
	}

	echo json_encode($raw);

}


if(isset($_REQUEST['SalesReturn'])){
	error_reporting(0);
	$refund_todayTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transaction_refund` AS tr, `bookingrecords` AS b WHERE tr.txnid = b.bookingrecords_txnid AND tr.created_at LIKE '%".$today."%' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Refund_TodayTransHistory = $refund_todayTransData->fetchAll();

	$refund_yesterdayTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transaction_refund` AS tr, `bookingrecords` AS b WHERE tr.txnid = b.bookingrecords_txnid AND tr.created_at LIKE '%".$yesterday."%' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Refund_yesterdayTransHistory = $refund_yesterdayTransData->fetchAll();

	$refund_thisWeekTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transaction_refund` AS tr, `bookingrecords` AS b WHERE tr.txnid = b.bookingrecords_txnid AND tr.created_at >= '".$thisWeek."' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Refund_thisWeekTransHistory = $refund_thisWeekTransData->fetchAll();

	$refund_lastWeekTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transaction_refund` AS tr, `bookingrecords` AS b WHERE tr.txnid = b.bookingrecords_txnid AND tr.trans_date > '2021-10-10' AND tr.created_at >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND tr.created_at < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND tr.trans_status = 'success' AND tr.trans_status = 'failure' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Refund_lastWeekTransHistory = $refund_lastWeekTransData->fetchAll();

	$refund_thisMnthTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transaction_refund` AS tr, `bookingrecords` AS b WHERE tr.txnid = b.bookingrecords_txnid AND MONTH(tr.created_at) = MONTH(CURRENT_DATE()) AND YEAR(tr.created_at) = YEAR(CURRENT_DATE()) GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Refund_thisMnthTransHistory = $refund_thisMnthTransData->fetchAll();

	$refund_lastMnthTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transaction_refund` AS tr, `bookingrecords` AS b WHERE tr.txnid = b.bookingrecords_txnid AND YEAR(tr.created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(tr.created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND tr.created_at NOT LIKE '%0000-00-00 00:00:00%' AND tr.trans_date > '2021-10-10' AND tr.trans_status = 'success' AND tr.trans_status = 'failure' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Refund_lastMnthTransHistory = $refund_lastMnthTransData->fetchAll();

	$refund_thisYrTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transaction_refund` AS tr, `bookingrecords` AS b WHERE tr.txnid = b.bookingrecords_txnid AND YEAR(tr.created_at) = YEAR(CURDATE()) GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Refund_thisYrTransHistory = $refund_thisYrTransData->fetchAll();

	$refund_lastYrTransData = $link->query("SELECT SUM(b.bookingrecords_amt) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `transaction_refund` AS tr, `bookingrecords` AS b WHERE tr.txnid = b.bookingrecords_txnid AND YEAR(tr.created_at) = YEAR(CURDATE()) - 1 GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Refund_lastYrTransHistory = $refund_lastYrTransData->fetchAll();


	$locationData = $link->query("SELECT Cin_Id, Cin_Loc FROM `cinema`");
	$location = $locationData->fetchAll();

	$refund_obj = [];
	$refund_obj1 = [];
	$refund_obj2 = [];
	$refund_obj3 = [];
	$refund_obj4 = [];
	$refund_obj5 = [];
	$refund_obj6 = [];
	$refund_obj7 = [];
	$i = 0;
	foreach ($location as $key => $loc) {

			if ($loc['Cin_Id'] == isset($Refund_TodayTransHistory[$key]['cin_id'])) {
				$refund_obj[$Refund_TodayTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'today' => $Refund_TodayTransHistory[$key]['total_amt'], 
						'location' => $Refund_TodayTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Refund_yesterdayTransHistory[$key]['cin_id'])) {
				$refund_obj1[$Refund_yesterdayTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'yesterday' => $Refund_yesterdayTransHistory[$key]['total_amt'], 
						'location' => $Refund_yesterdayTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Refund_thisWeekTransHistory[$key]['cin_id'])) {
				$refund_obj2[$Refund_thisWeekTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'this_week' => $Refund_thisWeekTransHistory[$key]['total_amt'], 
						'location' => $Refund_thisWeekTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Refund_lastWeekTransHistory[$key]['cin_id'])) {
				$refund_obj3[$Refund_lastWeekTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'last_week' => $Refund_lastWeekTransHistory[$key]['total_amt'], 
						'location' => $Refund_lastWeekTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Refund_thisMnthTransHistory[$key]['cin_id'])) {
				$refund_obj4[$Refund_thisMnthTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'this_month' => $Refund_thisMnthTransHistory[$key]['total_amt'], 
						'location' => $Refund_thisMnthTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Refund_lastMnthTransHistory[$key]['cin_id'])) {
				$refund_obj5[$Refund_lastMnthTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'last_month' => $Refund_lastMnthTransHistory[$key]['total_amt'], 
						'location' => $Refund_lastMnthTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Refund_thisYrTransHistory[$key]['cin_id'])) {
				$refund_obj6[$Refund_thisYrTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'this_year' => $Refund_thisYrTransHistory[$key]['total_amt'], 
						'location' => $Refund_thisYrTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Refund_lastYrTransHistory[$key]['cin_id'])) {
				$refund_obj7[$Refund_lastYrTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'last_year' => $Refund_lastYrTransHistory[$key]['total_amt'], 
						'location' => $Refund_lastYrTransHistory[$key]['cin_id']
					)
				);
			}
		
	}


	$refund_raw = [];
	$j=1;
	foreach ($location as $key => $loc) {

		$refund_obj_fnl = array();
		$refund_obj_fnl['location'] = $loc['Cin_Loc'];
		$refund_obj_fnl['today'] = (int)$refund_obj[$j]['total_amt']['today'];
		$refund_obj_fnl['yesterday'] = (int)$refund_obj1[$j]['total_amt']['yesterday'];
		$refund_obj_fnl['this_week'] = (int)$refund_obj2[$j]['total_amt']['this_week'];
		$refund_obj_fnl['last_week'] = (int)$refund_obj3[$j]['total_amt']['last_week'];
		$refund_obj_fnl['this_month'] = (int)$refund_obj4[$j]['total_amt']['this_month'];
		$refund_obj_fnl['last_month'] = (int)$refund_obj5[$j]['total_amt']['last_month'];
		$refund_obj_fnl['this_year'] = (int)$refund_obj6[$j]['total_amt']['this_year'];
		$refund_obj_fnl['last_year'] = (int)$refund_obj7[$j]['total_amt']['last_year'];

		$refund_raw['data'][$i] = $refund_obj_fnl;

		$i++; $j++;
	}

	echo json_encode($refund_raw);

}

if(isset($_REQUEST['Purchase'])){
	error_reporting(0);

	$foodorder_todayTransData = $link->query("SELECT SUM(fd.currentfoodamount) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `foodorder` AS fd, `bookingrecords` AS b WHERE fd.transid = b.bookingrecords_txnid AND fd.ordertime LIKE '%".$today."%' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Foodorder_TodayTransHistory = $foodorder_todayTransData->fetchAll();

	$foodorder_yesterdayTransData = $link->query("SELECT SUM(fd.currentfoodamount) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `foodorder` AS fd, `bookingrecords` AS b WHERE fd.transid = b.bookingrecords_txnid AND fd.ordertime LIKE '%".$yesterday."%' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Foodorder_yesterdayTransHistory = $foodorder_yesterdayTransData->fetchAll();

	$foodorder_thisWeekTransData = $link->query("SELECT SUM(fd.currentfoodamount) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `foodorder` AS fd, `bookingrecords` AS b WHERE fd.transid = b.bookingrecords_txnid AND fd.ordertime >= '".$thisWeek."' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Foodorder_thisWeekTransHistory = $foodorder_thisWeekTransData->fetchAll();

	$foodorder_lastWeekTransData = $link->query("SELECT SUM(fd.currentfoodamount) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `foodorder` AS fd, `bookingrecords` AS b WHERE fd.transid = b.bookingrecords_txnid AND fd.ordertime > '2021-12-16' AND fd.ordertime >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY AND fd.ordertime < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY AND fd.paymentstatus = 'success' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Foodorder_lastWeekTransHistory = $foodorder_lastWeekTransData->fetchAll();

	$foodorder_thisMnthTransData = $link->query("SELECT SUM(fd.currentfoodamount) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `foodorder` AS fd, `bookingrecords` AS b WHERE fd.transid = b.bookingrecords_txnid AND MONTH(fd.ordertime) = MONTH(CURRENT_DATE()) AND YEAR(fd.ordertime) = YEAR(CURRENT_DATE()) GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Foodorder_thisMnthTransHistory = $foodorder_thisMnthTransData->fetchAll();

	$foodorder_lastMnthTransData = $link->query("SELECT SUM(fd.currentfoodamount) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `foodorder` AS fd, `bookingrecords` AS b WHERE fd.transid = b.bookingrecords_txnid AND YEAR(fd.ordertime) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(fd.ordertime) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND fd.ordertime NOT LIKE '%0000-00-00 00:00:00%' AND fd.ordertime > '2021-12-16' AND fd.paymentstatus = 'success' AND fd.paymentstatus = 'failure' GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Foodorder_lastMnthTransHistory = $foodorder_lastMnthTransData->fetchAll();

	$foodorder_thisYrTransData = $link->query("SELECT SUM(fd.currentfoodamount) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `foodorder` AS fd, `bookingrecords` AS b WHERE fd.transid = b.bookingrecords_txnid AND fd.ordertime > '2021-12-16' AND YEAR(fd.ordertime) = YEAR(CURDATE()) GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Foodorder_thisYrTransHistory = $foodorder_thisYrTransData->fetchAll();

	$foodorder_lastYrTransData = $link->query("SELECT SUM(fd.currentfoodamount) AS total_amt, b.bookingrecords_cinid AS cin_id FROM `foodorder` AS fd, `bookingrecords` AS b WHERE fd.transid = b.bookingrecords_txnid AND fd.ordertime > '2021-12-16' AND YEAR(fd.ordertime) = YEAR(CURDATE()) - 1 GROUP BY b.bookingrecords_cinid ORDER BY b.bookingrecords_cinid ASC");
	$Foodorder_lastYrTransHistory = $foodorder_lastYrTransData->fetchAll();


	$locationData = $link->query("SELECT Cin_Id, Cin_Loc FROM `cinema`");
	$location = $locationData->fetchAll();

	$foodorder_obj = [];
	$foodorder_obj1 = [];
	$foodorder_obj2 = [];
	$foodorder_obj3 = [];
	$foodorder_obj4 = [];
	$foodorder_obj5 = [];
	$foodorder_obj6 = [];
	$foodorder_obj7 = [];
	$i = 0;
	foreach ($location as $key => $loc) {

			if ($loc['Cin_Id'] == isset($Foodorder_TodayTransHistory[$key]['cin_id'])) {
				$foodorder_obj[$Foodorder_TodayTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'today' => $Foodorder_TodayTransHistory[$key]['total_amt'], 
						'location' => $Foodorder_TodayTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Foodorder_yesterdayTransHistory[$key]['cin_id'])) {
				$foodorder_obj1[$Foodorder_yesterdayTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'yesterday' => $Foodorder_yesterdayTransHistory[$key]['total_amt'], 
						'location' => $Foodorder_yesterdayTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Foodorder_thisWeekTransHistory[$key]['cin_id'])) {
				$foodorder_obj2[$Foodorder_thisWeekTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'this_week' => $Foodorder_thisWeekTransHistory[$key]['total_amt'], 
						'location' => $Foodorder_thisWeekTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Foodorder_lastWeekTransHistory[$key]['cin_id'])) {
				$foodorder_obj3[$Foodorder_lastWeekTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'last_week' => $Foodorder_lastWeekTransHistory[$key]['total_amt'], 
						'location' => $Foodorder_lastWeekTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Foodorder_thisMnthTransHistory[$key]['cin_id'])) {
				$foodorder_obj4[$Foodorder_thisMnthTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'this_month' => $Foodorder_thisMnthTransHistory[$key]['total_amt'], 
						'location' => $Foodorder_thisMnthTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Foodorder_lastMnthTransHistory[$key]['cin_id'])) {
				$foodorder_obj5[$Foodorder_lastMnthTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'last_month' => $Foodorder_lastMnthTransHistory[$key]['total_amt'], 
						'location' => $Foodorder_lastMnthTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Foodorder_thisYrTransHistory[$key]['cin_id'])) {
				$foodorder_obj6[$Foodorder_thisYrTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'this_year' => $Foodorder_thisYrTransHistory[$key]['total_amt'], 
						'location' => $Foodorder_thisYrTransHistory[$key]['cin_id']
					)
				);
			}

			if ($loc['Cin_Id'] == isset($Foodorder_lastYrTransHistory[$key]['cin_id'])) {
				$foodorder_obj7[$Foodorder_lastYrTransHistory[$key]['cin_id']] = array(
					'total_amt' => array(
						'last_year' => $Foodorder_lastYrTransHistory[$key]['total_amt'], 
						'location' => $Foodorder_lastYrTransHistory[$key]['cin_id']
					)
				);
			}
		
	}


	$foodorder_raw = [];
	$j=1;
	foreach ($location as $key => $loc) {

		$foodorder_obj_fnl = array();
		$foodorder_obj_fnl['location'] = $loc['Cin_Loc'];
		$foodorder_obj_fnl['today'] = (int)$foodorder_obj[$j]['total_amt']['today'];
		$foodorder_obj_fnl['yesterday'] = (int)$foodorder_obj1[$j]['total_amt']['yesterday'];
		$foodorder_obj_fnl['this_week'] = (int)$foodorder_obj2[$j]['total_amt']['this_week'];
		$foodorder_obj_fnl['last_week'] = (int)$foodorder_obj3[$j]['total_amt']['last_week'];
		$foodorder_obj_fnl['this_month'] = (int)$foodorder_obj4[$j]['total_amt']['this_month'];
		$foodorder_obj_fnl['last_month'] = (int)$foodorder_obj5[$j]['total_amt']['last_month'];
		$foodorder_obj_fnl['this_year'] = (int)$foodorder_obj6[$j]['total_amt']['this_year'];
		$foodorder_obj_fnl['last_year'] = (int)$foodorder_obj7[$j]['total_amt']['last_year'];

		$foodorder_raw['data'][$i] = $foodorder_obj_fnl;

		$i++; $j++;
	}

	echo json_encode($foodorder_raw);

}














?>