<?php
session_start();
require_once("database.php");
$success = false;
$iduser = $_SESSION['iduser'];
$response = array();
$responseDua = array();
if (isset($_POST["start_date"]) && isset($_POST["end_date"])) {
  // $startDate = "2017-11-03";
  // $endDate = "2017-11-08";
  $startDate = $_POST["start_date"];
  $endDate = $_POST["end_date"];

  $rows_array =  get_data_share_file("SELECT * FROM share_file WHERE tgl_share >= '".$startDate."' AND  tgl_share <= '".$endDate."'");
  $jum = count($rows_array);
  $per_hal=5;
  $halaman=ceil($jum / $per_hal);
  $page = isset($_GET['page'])? (int)$_GET['page'] : 1;
  $start = ($page - 1) * $per_hal;

  $rows_array = get_data_share_file("SELECT * FROM share_file WHERE tgl_share >= '".$startDate."' AND  tgl_share <= '".$endDate."' LIMIT $start, $per_hal");

  $no = 0;
  if(count($rows_array) > 0){
    foreach($rows_array as $row){
      $no++;
      $iduser = $row['iduser'];
      $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduser."'");

        if(count($getuserdata_array) > 0){
          foreach($getuserdata_array as $rowusershare){
            $idfile = $row['kode_file'];
            $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");

            if(count($file_array) > 0){
              foreach($file_array as $rowfile){
                $nama = $rowusershare['nama'];
            		$share = $row['tgl_share'];
                $tglbaca = $row["tgl_dibaca"];
                $jam = $row["jam_dibaca"];
                $view = $row["view"];
                $id = $rowfile['idfile'];
                $nof = $rowfile['no_file'];
                $file = $rowfile['nama_file'];
                $jenis = $rowfile['jenis_file'];
                $detail = $rowfile['detail_dokumen'];
                $success = true;

            		$response = array(
            			'no' => $no,
            			'user' => $nama,
                  'tglshare' => $share,
                  'tgldibaca' => $tglbaca,
                  'jamdilihat' => $jam,
                  'dilihat' => $view,
                  'idfile' => $id,
                  'nofile' => $nof,
                  'namafile' => $file,
                  'jenis' => $jenis,
                  'detail' => $detail,
                  'success' => $success
            		);
                array_push($responseDua, $response);
            }}
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
//}else{
//  echo "erorr";
}elseif(isset($_POST["start_date_dibaca"]) && isset($_POST["end_date_dibaca"])) {
  // $startDate = "2017-11-03";
  // $endDate = "2017-11-08";
  $startDate = $_POST["start_date_dibaca"];
  $endDate = $_POST["end_date_dibaca"];

  $share_array = get_data_share_file("SELECT * FROM share_file WHERE (iduser LIKE '".$iduser."') AND (status_dibaca = 1) AND (tgl_share >= '".$startDate."' AND  tgl_share <= '".$endDate."')");
  $jum = count($share_array);
  $per_hal=5;
  $halaman=ceil($jum / $per_hal);
  $page = isset($_GET['page2'])? (int)$_GET['page2'] : 1;
  $start = ($page - 1) * $per_hal;

  $rows_array = get_data_share_file("SELECT * FROM share_file WHERE (iduser LIKE '".$iduser."') AND (status_dibaca = 1) AND (tgl_share >= '".$startDate."' AND  tgl_share <= '".$endDate."') LIMIT $start, $per_hal");

  $no = 0;
  if(count($rows_array) > 0){
    foreach($rows_array as $row){
      $no++;
      $idfile = $row['kode_file'];
      $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
      if(count($file_array) > 0){
        foreach($file_array as $rowfile){

                $nama = $rowfile['asal_file'];
            		$share = $row['tgl_share'];
                $id = $rowfile['idfile'];
                $nof = $rowfile['no_file'];
                $file = $rowfile['nama_file'];
                $jenis = $rowfile['jenis_file'];
                $detail = $rowfile['detail_dokumen'];
                $tglfile = $rowfile['tgl_asal_file'];
                $success = true;

            		$response = array(
            			'no' => $no,
                  'tglshare' => $share,
                  'idfile' => $id,
                  'nofile' => $nof,
                  'file' => $file,
                  'jenis' => $jenis,
                  'perihal' => $detail,
                  'asal' => $nama,
                  'tglfile' => $tglfile,
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
?>
