<?php

function pdo(){
	//Connection to the server and database
	try{
		$pdo = new PDO('mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DBNAME . ';charset=utf8;', USERNAME, PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(Exception $e) {
		echo $e->getMessage() . '\n';
		return;
	}
	 return $pdo;
}

function executeQuery($query) {
  $pdo = pdo();
  $stmt = $pdo->query($query);
  return $stmt;
}

function array_result($results){
	while($row = $results->fetch(PDO::FETCH_ASSOC)) $result[] = $row;
	return $result;
}

function array_result_no_null($result_query){
	if($result_query){
		$data = [];
	// if(mysqli_num_rows($result_query) > 0) {
		while($row = $result_query->fetch(PDO::FETCH_ASSOC)){
			foreach ($row as $key => $val) {
				if (is_null($val)) {
					$row[$key] = 0;
				}
			}
			$data [] = $row;
		}
	// }
	return $data;
	}
}
?>
