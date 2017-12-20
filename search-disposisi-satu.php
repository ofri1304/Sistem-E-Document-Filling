<?php
  session_start();
  require_once("database.php");
  $iduser = $_SESSION['iduser'];
  $response = array();
  $responseDua = array();
  $success = false;
  if (isset($_POST["start_date"]) && isset($_POST["end_date"])) {
                    // $startDate = "2017-11-03";
                    // $endDate = "2017-11-08";
                    $startDate = $_POST["start_date"];
                    $endDate = $_POST["end_date"];
                    $disposisi_array =  get_data_disposisi_file("SELECT * FROM disposisi_file where iduser LIKE'".$iduser."' AND status_dibaca = 0 AND (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."')");
                    $jum = count($disposisi_array);
                    $per_hal=10;
                    $halaman=ceil($jum / $per_hal);
                    $page = isset($_GET['page1'])? (int)$_GET['page1'] : 1;
                    $start = ($page - 1) * $per_hal;
                    $rows_array =get_data_disposisi_file("SELECT * FROM disposisi_file WHERE iduser LIKE'".$iduser."' AND status_dibaca = 0 AND (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."') LIMIT $start, $per_hal");

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
// }else{
//  echo "erorr";
// }
}elseif(isset($_POST["start_date_staf1"]) && isset($_POST["end_date_staf1"])) {
                  // $startDate = "2017-11-03";
                  // $endDate = "2017-11-08";
                  $startDate = $_POST["start_date_staf1"];
                  $endDate = $_POST["end_date_staf1"];
                  $disposisi_array =  get_data_disposisi_kepala("SELECT * FROM kepala where iduser_staf LIKE'".$iduser."'  AND status_dibaca = 0 AND (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."')");
                  $jum = count($disposisi_array);
                  $per_hal = 5;
                  $halaman=ceil($jum / $per_hal);
                  $page = isset($_GET['page1'])? (int)$_GET['page1'] : 1;
                  $start = ($page - 1) * $per_hal;

                  $rows_array = get_data_disposisi_kepala("SELECT * FROM kepala WHERE iduser_staf LIKE'".$iduser."' AND status_dibaca = 0 AND (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."') LIMIT $start, $per_hal");
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
}elseif(isset($_POST["start_date_sekretaris"]) && isset($_POST["end_date_sekretaris"])) {
                  // $startDate = "2017-11-03";
                  // $endDate = "2017-11-08";
                  $startDate = $_POST["start_date_sekretaris"];
                  $endDate = $_POST["end_date_sekretaris"];
                  $disposisi_array =  get_data_disposisi_file("SELECT * FROM disposisi_file where  (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."')");
                  $jum = count($disposisi_array);
                  $per_hal = 5;
                  $halaman=ceil($jum / $per_hal);
                  $page = isset($_GET['page1'])? (int)$_GET['page1'] : 1;
                  $start = ($page - 1) * $per_hal;

                  $rows_array = get_data_disposisi_file("SELECT * FROM disposisi_file where  (tgl_disposisi >= '".$startDate."' AND  tgl_disposisi <= '".$endDate."') LIMIT $start, $per_hal");
                  $no = 0;
                  if(count($rows_array) > 0){
                    foreach($rows_array as $row){
                      $no++; $idfile = $row['kode_file']; $idpengirim = $row['id_pengirim'];
                      $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
                      if(count($file_array) > 0){
                        foreach($file_array as $rowfile){
                          $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$idpengirim."'");
												  if(count($getuserdata_array) > 0){
													  foreach($getuserdata_array as $rowuser){

                              $id = $rowfile['idfile'];
                              $nof = $rowfile['no_file'];
                              $file = $rowfile['nama_file'];
                              $jenis = $rowfile['jenis_file'];
                              $detail = $rowfile['detail_dokumen'];
                              $disposisi = $row['tgl_disposisi'];
                              $jam = $row['jam_disposisi'];
                              $sender = $rowuser['nama'];
                              $view = $row['view'];
                              $success = true;

                              $response = array(
                                'no' => $no,
                                'sender' => $sender,
                                'dispo' => $disposisi,
                                'jam' => $jam,
                                'idfile' => $id,
                                'nofile' => $nof,
                                'title' => $file,
                                'jenis' => $jenis,
                                'perihal' => $detail,
                                'view' => $view,
                                'success' => $success
                              );
                              array_push($responseDua, $response);
                            }
                          }
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
}else{
echo "erorr";
}
 ?>
