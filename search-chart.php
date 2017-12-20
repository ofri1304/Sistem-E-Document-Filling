<?php
require_once("database.php");
$success = false;
$response = array();
$responseDua = array();
if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
  $startDate = $_POST["start_date"];
  $endDate = $_POST["end_date"];

  $file_array = get_count_category("SELECT jenis_file, COUNT(idfile) FROM file where (tgl_asal_file >= '".$startDate."' AND  tgl_asal_file <= '".$endDate."') GROUP BY jenis_file");
  if(count($file_array) > 0){
    foreach($file_array as $row){
      $jenis_file = $row['jenis_file'];
      $count = $row['COUNT(idfile)'];
      $success = true;

      $response = array(
            			'category' => $jenis_file,
            			'count' => $count,
                  'success' => $success
      );
      array_push($responseDua, $response);
    }
  }else{
    $nofound = "No Data Found.";
    $success = false;
    $response = array(
      'warning' => $nofound,
      'success' => $success
    );
  array_push($responseDua, $response);
  }
  echo json_encode($responseDua);

}
 ?>
