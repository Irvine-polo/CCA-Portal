<?php 
Class Action {
	private $db;

	public function __construct() {
		ob_start();
	$baseUrl = "../../../";
   	include $baseUrl . "assets/includes/dbh.inc.php";
  
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function action_update_qsort(){
		extract($_POST);
		$i = 0;

		foreach($qid as $k => $v){
			$i++;
			$update[] = $this->db->query("UPDATE title_question set order_by = '$i' where id = '$v'");
			
		}
		if(isset($update))
			return 1;
		

	}
	function action_update_qsort_q(){
		extract($_POST);
		$i = 0;

		foreach($qid as $k => $v){
			$i++;
			$update[] = $this->db->query("UPDATE questions set q_order_by = '$i' where id_question = '$v'");
			
		}
		if(isset($update))
			return 1;
		

	}

}

ob_start();
$action = $_GET['action'];

//section sort
$crud = new Action();
if($action == "action_update_qsort"){
	$save = $crud->action_update_qsort();
	
	if($save)
		echo $save;

}

if($action == "action_update_qsort_q"){
	$save = $crud->action_update_qsort_q();
	
	if($save)
		echo $save;

}



 ?>