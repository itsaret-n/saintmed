﻿<?php
include "head.php";
?>
<?php
session_start();
try {
	include "connect.php";  // Using database connection file here


	$item0 = $_GET['ID'];
	$itemset = substr($_POST['itemset'],0,3);
	$item1 = iconv('UTF-8', 'TIS-620',$_POST['item1']);
	$item2 = $_POST['item2'];
	$item3 = $_POST['item3'];
	
	if(!empty($item1) && !empty($item2) && !empty($item3)){
		$query = "INSERT INTO req (project_id_fk, ItemCode, unitnum, price) 
		VALUES ('$item0', '$item1', $item2, $item3) ";
		$stmt = $conn->query( $query );

		$query2 = "INSERT INTO edit_log (project_id_fk,edit_log,date1) VALUES (".$_GET['ID'].", 'เพิ่มสินค้าโดย ".$_SESSION["user"]."',date())";
		$stmt2 = $conn->query( $query2 );
		
		$stmt = null;
		$stmt2 = null;
		$conn = null;

		header("Location: edit_req.php?ID=". $_GET['ID']."&PID=". $_GET['PID']);

	}
	elseif(!empty($item1) && empty($item2) && empty($item3)){
		$query = "INSERT INTO req (project_id_fk, ItemCode, unitnum, price) 
		VALUES ('$item0', '$item1', 1, 0) ";
		$stmt = $conn->query( $query );

		$query2 = "INSERT INTO edit_log (project_id_fk,edit_log,date1) VALUES (".$_GET['ID'].", 'เพิ่มสินค้าโดย ".$_SESSION["user"]."',date())";
		$stmt2 = $conn->query( $query2 );
		
		$stmt = null;
		$stmt2 = null;
		$conn = null;

		header("Location: edit_req.php?ID=". $_GET['ID']."&PID=". $_GET['PID']);

	}
	
	elseif(!empty($item1) && !empty($item2) && empty($item3)){
		$query = "INSERT INTO req (project_id_fk, ItemCode, unitnum, price) 
		VALUES ('$item0', '$item1', $item2, 0) ";
		$stmt = $conn->query( $query );

		$query2 = "INSERT INTO edit_log (project_id_fk,edit_log,date1) VALUES (".$_GET['ID'].", 'เพิ่มสินค้าโดย ".$_SESSION["user"]."',date())";
		$stmt2 = $conn->query( $query2 );
		
		$stmt = null;
		$stmt2 = null;
		$conn = null;

		header("Location: edit_req.php?ID=". $_GET['ID']."&PID=". $_GET['PID']);

	}
	
	elseif(!empty($itemset)){
		$query3 = "SELECT groupcodeitem.groupcode_id_fk, groupcodeitem.itemcode,groupcode.groupname FROM groupcodeitem 
		left join groupcode on  groupcodeitem.groupcode_id_fk = groupcode.id
		where groupcodeitem.groupcode_id_fk = $itemset ";
		$stmt3 = $conn2->query( $query3 );
		while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)){
			$query4 = "INSERT INTO req (project_id_fk, ItemCode, unitnum, price) 
			VALUES ('$item0', '$row[itemcode]', '1', '0') ";
			$stmt4 = $conn->query( $query4 );
		}

		$query2 = "INSERT INTO edit_log (project_id_fk,edit_log,date1) VALUES (".$_GET['ID'].", 'เพิ่ม set สินค้าโดย ".$_SESSION["user"]."',date())";
		$stmt2 = $conn->query( $query2 );
		
		$stmt2 = null;
		$stmt3 = null;
		$stmt4 = null;
		$conn = null;

		header("Location: edit_req.php?ID=". $_GET['ID']."&PID=". $_GET['PID']);
	}

	else{
		$conn = null;
		
		header("Location: edit_req.php?ID=". $_GET['ID']."&PID=". $_GET['PID']);
	}
	
	
}
	catch (PDOException $e){
		echo "Connection failed: ". $e->getMessage();
	}

?>
</body>
</html>