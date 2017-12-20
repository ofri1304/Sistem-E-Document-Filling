<?php
require_once("database.php");
$success = false;
$response = array();
$responseDua = array();
if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['category'])) {
  $startDate = $_POST["start_date"];
  $endDate = $_POST["end_date"];
  $category = $_POST["category"];
  // $startDate = "2017-09-22";
  // $endDate = "2017-09-27";
  // $category = "Memo Masuk";
  $tgl = "( ".$startDate." )"." s/d "."( ".$endDate." )";

  $file_array = get_count_category("SELECT jenis_file, COUNT(idfile) FROM file where (tgl_asal_file >= '".$startDate."' AND  tgl_asal_file <= '".$endDate."') AND jenis_file LIKE '".$category."' GROUP BY jenis_file");
  if(count($file_array) > 0){
    foreach($file_array as $row){
      $jenis_file = $row['jenis_file'];
      $count = $row['COUNT(idfile)'];

      $count_array = get_count_category("SELECT jenis_file, COUNT(idfile) FROM file where (tgl_asal_file >= '".$startDate."' AND  tgl_asal_file <= '".$endDate."')");
      if(count($count_array) > 0){
        foreach($count_array as $rows){
          $total = $rows['COUNT(idfile)'];
          $count = ($count / $total) * 100;
          $response = array(
                			'category' => $jenis_file,
                			'count' => $count,
                      'tglfile' => $tgl
          );
          array_push($responseDua, $response);
        }
      }
    }
  }
  echo json_encode($responseDua);
}
