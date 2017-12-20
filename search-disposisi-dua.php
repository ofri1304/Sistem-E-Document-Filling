<?php
  session_start();
  require_once("database.php");
  $iduser = $_SESSION['iduser'];
  $response = array();
  $responseDua = array();
  $success = false;
  if (isset($_POST["start_date_kepala"]) && isset($_POST["end_date_kepala"])) {
                    // $startDate = "2017-11-03";
                    // $endDate = "2017-11-08";
                    $startDate = $_POST["start_date_kepala"];
                    $endDate = $_POST["end_date_kepala"];
                    $disposisi_array =  get_data_disposisi_file("SELECT * FROM disposisi_file where iduser LIKE'".$iduser."' AND status_dibaca = 1 AND (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."')");
                    $jum = count($disposisi_array);
                    $per_hal=10;
                    $halaman=ceil($jum / $per_hal);
                    $page = isset($_GET['page2'])? (int)$_GET['page2'] : 1;
                    $start = ($page - 1) * $per_hal;
                    $rows_array =get_data_disposisi_file("SELECT * FROM disposisi_file WHERE iduser LIKE'".$iduser."' AND status_dibaca = 1 AND (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."') LIMIT $start, $per_hal");

                    $no = 0;
                    if(count($rows_array) > 0){
                      foreach($rows_array as $row){
                        $no++;
                    $idfile = $row['kode_file'];
                    $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
                    if(count($file_array) > 0){
                      foreach($file_array as $rowfile){
                        $id = $rowfile['idfile'];
                        $nof = $rowfile['no_file'];
                        $file = $rowfile['nama_file'];
                        $asal = $rowfile['asal_file'];
                        $jenis = $rowfile['jenis_file'];
                        $tglupload = $rowfile['tgl_upload'];
                        $tglfile = $rowfile['tgl_asal_file'];
                        $detail = $rowfile['detail_dokumen'];
                        $deadline = $row['tgl_disposisi'];
                        $tgldispo = $row['tgl_deadline'];
                        $success = true;

                    		$response = array(
                    			'no' => $no,
                          'idfile' => $id,
                          'nofile' => $nof,
                          'namafile' => $file,
                          'tgldispo' => $tgldispo,
                          'deadline' => $deadline,
                          'tglupload' => $tglupload,
                          'tglfile' => $tglfile,
                          'asalfile' => $asal,
                          'jenis' => $jenis,
                          'perihal' => $detail,
                          'success' => $success
                    		);
                        array_push($responseDua, $response);
                    }}
                  }}else{
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
// else{
//  echo "erorr";
// }
elseif(isset($_POST["start_date_staf2"]) && isset($_POST["end_date_staf2"])) {
                  // $startDate = "2017-11-03";
                  // $endDate = "2017-11-14";
                  $startDate = $_POST["start_date_staf2"];
                  $endDate = $_POST["end_date_staf2"];
                  $disposisi_array =  get_data_disposisi_kepala("SELECT * FROM kepala where iduser_staf LIKE'".$iduser."'  AND status_dibaca = 1 AND (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."')");
                  $jum = count($disposisi_array);
                  $per_hal = 5;
                  $halaman=ceil($jum / $per_hal);
                  $page = isset($_GET['page2'])? (int)$_GET['page2'] : 1;
                  $start = ($page - 1) * $per_hal;

                  $rows_array = get_data_disposisi_kepala("SELECT * FROM kepala WHERE iduser_staf LIKE'".$iduser."' AND status_dibaca = 1 AND (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."') LIMIT $start, $per_hal");

                  $no = 0;
                  if(count($rows_array) > 0){
                    foreach($rows_array as $row){
                      $no++;
                  $idfile = $row['kode_file_asal'];
                  $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
                  if(count($file_array) > 0){
                    foreach($file_array as $rowfile){
                      $id = $rowfile['idfile'];
                      $nof = $rowfile['no_file'];
                      $file = $rowfile['nama_file'];
                      $asal = $rowfile['asal_file'];
                      $jenis = $rowfile['jenis_file'];
                      $tglupload = $rowfile['tgl_upload'];
                      $tglfile = $rowfile['tgl_asal_file'];
                      $detail = $rowfile['detail_dokumen'];
                      $disposisi = $row['tgl_disposisi'];
                      $success = true;

                      $response = array(
                        'no' => $no,
                        'idfile' => $id,
                        'nofile' => $nof,
                        'namafile' => $file,
                        'tgldispo' => $disposisi,
                        'tglupload' => $tglupload,
                        'tglfile' => $tglfile,
                        'asalfile' => $asal,
                        'jenis' => $jenis,
                        'perihal' => $detail,
                        'success' => $success
                      );
                      array_push($responseDua, $response);
                  }}
                }}
                else{
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
// else{
// echo "erorr";
// }
 ?>
