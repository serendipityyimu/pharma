<?php 
require_once("../includes/includes.php");
//  
if(isset($_POST['MaxDate'])) {

	$query = "INSERT INTO SALES (SALES_DATE,SALESREP_ID, CODE_TVA, SALES, MARGIN, SALES_COUNT, SALESREP_OBJ) VALUES (" . $_POST['MaxDate'] . ", " . $_POST['SalesrepId'] . " , 1, ". $_POST['caHt210'] . ", " . $_POST['MargeHt210'] . ", " . $_POST['NbVentes'] . ", " . $_POST['ObjVentes'] . ");";
	$query .= "INSERT INTO SALES (SALES_DATE,SALESREP_ID, CODE_TVA, SALES, MARGIN, SALES_COUNT, SALESREP_OBJ) VALUES (" . $_POST['MaxDate'] . ", " . $_POST['SalesrepId'] . " , 2, ". $_POST['caHtTva550'] . ", " . $_POST['MargeHt550'] . ", 0, 0);";
	$query .= "INSERT INTO SALES (SALES_DATE,SALESREP_ID, CODE_TVA, SALES, MARGIN, SALES_COUNT, SALESREP_OBJ) VALUES (" . $_POST['MaxDate'] . ", " . $_POST['SalesrepId'] . " , 3, ". $_POST['caHtTva10'] . ", " . $_POST['MargeHt10'] . ", 0, 0);";
	$query .= "INSERT INTO SALES (SALES_DATE,SALESREP_ID, CODE_TVA, SALES, MARGIN, SALES_COUNT, SALESREP_OBJ) VALUES (" . $_POST['MaxDate'] . ", " . $_POST['SalesrepId'] . " , 4, ". $_POST['caHtTva20'] . ", " . $_POST['MargeHt20'] . ", 0, 0);";

	echo $query;
	 $result = execute_multiquery($query);



	// $result = execute_query($query);

	// if($result){
	// 	//Array avec id et nom des salaries $table[$i]['SALESREP']
	// 	echo json_encode(array_result($result));
	// }
	// else return 0;
}
else {
	// $arrayResult[];
	$query = "SELECT TD.ID, TD.MONTH_YEAR, S.SALESREP_ID FROM (SELECT MAX(SALES_DATE) AS MAX_DATE, SALESREP_ID FROM SALES  GROUP BY SALESREP_ID) S, time_dimension TD WHERE TD.DB_DATE= (SELECT DATE_ADD(db_date, interval 1 month) FROM time_dimension where id=S.MAX_DATE)";

	$result = execute_query($query);
	$arrayResult[] = array_result($result);

	$query = "SELECT SALESREP_ID, SALESREP FROM SALESDEPT WHERE ACTIF=1";
	$result = execute_query($query);
	$arrayResult[] = array_result($result);
	if($result){
		//Array avec id et nom des salaries $table[$i]['SALESREP']
		echo json_encode($arrayResult);
	}
	else return 0;
}	
	
?>