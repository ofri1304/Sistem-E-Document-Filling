<?php
function con_database(){
$hostmysql = "localhost";
$password = "GkDp3zcPer";
$username = "ocantika";
$database = "ocantika";

$con = mysqli_connect($hostmysql, $username, $password, $database);
return $con;
}

function add_user($iduser, $nama, $password, $jabatan, $unitkerja, $nohp, $email, $hakakses){
  $con = con_database();
  $id_user = mysqli_real_escape_string($con, $iduser);
  $username = mysqli_real_escape_string($con, $nama);
  $pswd = mysqli_real_escape_string($con, $password);
  $jabatan_user = mysqli_real_escape_string($con, $jabatan);
  $unit_kerja = mysqli_real_escape_string($con,$unitkerja);
  $no_hp = mysqli_real_escape_string($con, $nohp);
  $email_user = mysqli_real_escape_string($con, $email);

  $sql = "INSERT INTO user (iduser, nama, password, no_hp, email, jabatan, unit_kerja) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_bind_param($stmt, "sssssss", $id_user, $username, $pswd, $no_hp, $email_user, $jabatan_user, $unit_kerja);
  mysqli_stmt_execute($stmt);
	$newid = mysqli_insert_id($con);
	mysqli_stmt_close($stmt);
	mysqli_close();
	return $newid;
}

function get_all_user($query){
  $con = con_database();
  $sql = $query;
	$result = mysqli_query($con, $sql);
	//ubah ke bentuk array
	$user_array = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$single_user = array("iduser" => $row['iduser'], "nama" => $row['nama'], "password" => $row['password'], "no_hp" => $row['no_hp'], "email" => $row['email'], "jabatan" => $row['jabatan'], "unit_kerja" => $row['unit_kerja']);
	$user_array[] = $single_user;
	}
  mysqli_close($con);
  return $user_array;
}

function get_data_user($query){
  $con = con_database();
  $result = mysqli_query($connect, $query);
  $row = mysqli_fetch_array($result);
  mysqli_close($con);
  return "echo json_encode($row)";
}

function update_data_user($id, $username, $position, $divisi, $nohp, $email){
  	$con = con_database();
  	//escape input
  	$name = mysqli_real_escape_string($con, $username);
    $nohp = mysqli_real_escape_string($con, $nohp);
    $email = mysqli_real_escape_string($con, $email);
    $position = mysqli_real_escape_string($con, $position);
    $div = mysqli_real_escape_string($con, $divisi);
  	$sql = "UPDATE user SET nama = '$name', no_hp = '$nohp', email = '$email', jabatan = '$position', unit_kerja = '$div' WHERE iduser LIKE'".$id."'";
    $exe = mysqli_query($con,$sql);
    if(!$exe){
      echo"ERROR";
    }
    else{
      // echo '<META HTTP-EQUIV="Refresh" Content="0; URL=profile.php?scs=2">';
      // $location = "profile.php#".$id;
      // header("Location: $location");
    }
    mysqli_close($con);
}

function update_pass_user($id, $password){
  	$con = con_database();
    $password = mysqli_real_escape_string($con, $password);
    $password = md5($password);
    $sql = "UPDATE user set password='$password' where iduser LIKE '".$id."'";
    $exe = mysqli_query($con,$sql);
		if(!$exe){
			echo"ERROR";
		}
		else{
      $location = "profile.php#".$id;
      header("Location: $location");
    }
    mysqli_close($con);
}

function update_alldata_user($id, $username, $password, $position, $divisi, $nohp, $email){
  	$con = con_database();
  	//escape input
  	$name = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);
    $nohp = mysqli_real_escape_string($con, $nohp);
    $email = mysqli_real_escape_string($con, $email);
    $position = mysqli_real_escape_string($con, $position);
    $div = mysqli_real_escape_string($con, $divisi);
  	$sql = "UPDATE user SET nama = '$name', password = '$password', no_hp = '$nohp', email = '$email', jabatan = '$position', unit_kerja = '$div' WHERE iduser LIKE'".$id."'";
    $exe = mysqli_query($con,$sql);
    if(!$exe){
      echo"ERROR";
    }
    else{
      echo"SUCCESS UPDATE";
    }
    mysqli_close($con);
}

function delete_user($id){
    $con = con_database();
    $query="DELETE from user WHERE iduser LIKE'".$id."'";
    $cek=mysqli_query($con,$query);
  	mysqli_close($con);
}
function delete_general($query){
    $con = con_database();
    $cek=mysqli_query($con,$query);
  	mysqli_close($con);
}
function insert_dokumen($nodoc, $id, $asalmemo, $nomemo, $memotitle, $tglmasuk, $tglmemo, $kategori, $file_size, $recordtext){
  $con = con_database();
  $asalmemo = mysqli_real_escape_string($con, $asalmemo);
  $nomemo = mysqli_real_escape_string($con, $nomemo);
  $memotitle = mysqli_real_escape_string($con, $memotitle);
  $tglmasuk = mysqli_real_escape_string($con, $tglmasuk);
  $tglmemo = mysqli_real_escape_string($con, $tglmemo);
  $kategori = mysqli_real_escape_string($con, $kategori);
  $file_size = mysqli_real_escape_string($con, $file_size);
  $record = mysqli_real_escape_string($con, $recordtext);

  $sql = "INSERT INTO file values( '$nodoc', '$id', '$asalmemo', '$nomemo', '$memotitle', '$tglmasuk', '$tglmemo', '$kategori', '$file_size', '0', '0', '1', '$record')";
  $cek = mysqli_query($con,$sql);
  if(!$cek){
	  echo "ERROR".$nodoc."/".$id."/".$asalmemo."/".$nomemo."/".$memotitle."/".$tglmasuk."/".$tglmemo."/".$kategori."/".$file_size."/".$record;
	}else{
    echo "success upload";
  }
}

function get_data_file($query){
  $con = con_database();
  $sql = $query;
  $result = mysqli_query($con, $sql);
  //ubah ke bentuk array
  $user_array = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $single_user = array("idfile" => $row['idfile'], "iduser" => $row['iduser'], "asal_file" => $row['asal_file'], "no_file" => $row['no_file'], "nama_file" => $row['nama_file'], "tgl_asal_file" => $row['tgl_asal_file'], "tgl_upload" => $row['tgl_upload'], "jenis_file" => $row['jenis_file'], "size_file" => $row['size_file'], "status_disposisi" => $row['status_disposisi'],"status_share" => $row['status_share'],"status_simpan" => $row['status_simpan'], "detail_dokumen" => $row['detail_dokumen']);
  $user_array[] = $single_user;
  }
  mysqli_close($con);
  return $user_array;
}

function insert_disposisi_file($idfile, $idpengirim,  $receivedisposisi, $tgldisposisi, $jamdikirim, $kodefile){
  $con = con_database();
  $idfile = mysqli_real_escape_string($con, $idfile);
  $iduser = mysqli_real_escape_string($con, $receivedisposisi);
  $tgldisposisi= mysqli_real_escape_string($con, $tgldisposisi);
  $kodefile= mysqli_real_escape_string($con, $kodefile);

  $sql = "INSERT INTO disposisi_file values( '$idfile','$idpengirim', '$iduser', '$kodefile', '$tgldisposisi', '$jamdikirim', '0', '0','0')";
  $cek = mysqli_query($con,$sql);
  if(!$cek){
    echo "ERROR".$idfile."/".$iduser."/".$tgldisposisi;
  }else{
    echo "success upload disposisi";
  }
  mysqli_close($con);
}

function insert_share_file($idfile, $iduser, $receiveshare, $sharedate, $kode_file){
  $con = con_database();
  $idfile = mysqli_real_escape_string($con, $idfile);
  $idpenerima = mysqli_real_escape_string($con, $receiveshare);
  $tgldisposisi= mysqli_real_escape_string($con, $sharedate);
  $kode_file = mysqli_real_escape_string($con, $kode_file);

  $sql = "INSERT INTO share_file values( '$idfile', '$iduser', '$idpenerima','$kode_file', '$sharedate', '0','','','0')";
  $cek = mysqli_query($con,$sql);
  if(!$cek){
    echo "ERROR".$idfile."/".$iduser."/".$sharedate;
  }else{
    echo "success upload share file";
  }
  mysqli_close($con);
}

function get_data_disposisi_file($query){
  $con = con_database();
  $sql = $query;
	$result = mysqli_query($con, $sql);
	//ubah ke bentuk array
	$disposisi_array = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$single_disposisi = array("idfile" => $row['idfile'], "id_pengirim" => $row['id_pengirim'], "iduser" => $row['iduser'], "kode_file" => $row['kode_file'], "tgl_disposisi" => $row['tgl_disposisi'], "jam_disposisi" => $row['jam_disposisi'], "status_dibaca" => $row['status_dibaca'], "status_dikerjakan" => $row['status_dikerjakan'], "view" => $row['view']);
	$disposisi_array[] = $single_disposisi;
	}
  mysqli_close($con);
  return $disposisi_array;
}

function get_data_share_file($query){
  $con = con_database();
  $sql = $query;
	$result = mysqli_query($con, $sql);
	//ubah ke bentuk array
	$share_array = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$single_share = array("idfile" => $row['idfile'], "id_pengirim" => $row['id_pengirim'],"iduser" => $row['iduser'], "tgl_share" => $row['tgl_share'],  "status_dibaca" => $row['status_dibaca'],  "tgl_dibaca" => $row['tgl_dibaca'],  "jam_dibaca" => $row['jam_dibaca'], "view" => $row['view'], "kode_file" => $row['kode_file']);
	$share_array[] = $single_share;
	}
  mysqli_close($con);
  return $share_array;
}
function update_status_file($query){
  $con = con_database();
  $sql = $query;
  $result = mysqli_query($con, $sql);
  mysqli_close($con);
}

function delete_disposisi_file($id){
    $con = con_database();
    $query="DELETE from disposisi_file WHERE idfile LIKE'".$id."'";
    $cek=mysqli_query($con,$query);
  	mysqli_close($con);
}
function delete_share_file($id){
    $con = con_database();
    $query="DELETE from share_file WHERE idfile LIKE'".$id."'";
    $cek=mysqli_query($con,$query);
  	mysqli_close($con);
}

function update_file($idfile, $category, $memoby, $nofile, $tglasal, $tglupload, $title, $addinginfo){
  	$con = con_database();
    $iduser = $_SESSION['iduser'];
  	$idfile = mysqli_real_escape_string($con, $idfile);
    $category = mysqli_real_escape_string($con, $category);
    $memoby = mysqli_real_escape_string($con, $memoby);
    $nofile = mysqli_real_escape_string($con, $nofile);
    $tglasal = mysqli_real_escape_string($con, $tglasal);
    $tglupload = mysqli_real_escape_string($con, $tglupload);
    $title = mysqli_real_escape_string($con, $title);
    $addinginfo = mysqli_real_escape_string($con, $addinginfo);
  	$sql = "UPDATE file SET asal_file = '$memoby', no_file = '$nofile', nama_file = '$title', tgl_asal_file = '$tglasal', tgl_upload = '$tglupload', jenis_file = '$category', detail_dokumen = '$addinginfo' WHERE idfile LIKE '".$idfile."' AND iduser LIKE '".$iduser."' ";
    $exe = mysqli_query($con,$sql);
    if(!$exe){
      echo "ERROR ".$idfile."/".$iduser."/".$category."/".$memoby."/".$nofile."/".$tglasal."/".$tglupload."/".$title."/".$addinginfo;
    }
    else{
      echo"SUCCESS UPDATE";
    }
    mysqli_close($con);
}

function get_count_category($query){
  $con = con_database();
  $sql = $query;
	$result = mysqli_query($con, $sql);
	//ubah ke bentuk array
	$category_array = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  	$single_user = array("jenis_file" => $row['jenis_file'], "COUNT(idfile)" => $row['COUNT(idfile)']);
  	$category_array[] = $single_user;
	}
  mysqli_close($con);
  return $category_array;
}

function insert_disposisi_file_kepala($idfile, $iduserkepala, $iduserstaf, $dispodate, $jamdikirim, $kode_file_asal, $deadline){
  $con = con_database();
  $idfile = mysqli_real_escape_string($con, $idfile);
  $iduserkepala = mysqli_real_escape_string($con, $iduserkepala);
  $iduserstaf= mysqli_real_escape_string($con, $iduserstaf);
  $kode_file_asal= mysqli_real_escape_string($con, $kode_file_asal);
  $dispodate= mysqli_real_escape_string($con, $dispodate);

  $sql = "INSERT INTO kepala values( '$idfile', '$iduserkepala', '$iduserstaf', '$kode_file_asal', '$deadline', '$dispodate', '$jamdikirim', '0', '','','0')";
  $cek = mysqli_query($con,$sql);
  if(!$cek){
  //  echo "ERROR".$idfile."/".$iduser."/".$tgldisposisi."/".$deadlinedate;
  }else{
  //  echo "success upload disposisi";
  }
  mysqli_close($con);
}

function get_data_disposisi_kepala($query){
  $con = con_database();
  $sql = $query;
	$result = mysqli_query($con, $sql);
	//ubah ke bentuk array
	$dispokepala_array = array();
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$single_disposisi = array("idfile" => $row['idfile'], "iduser_kepala" => $row['iduser_kepala'], "iduser_staf" => $row['iduser_staf'], "kode_file_asal" => $row['kode_file_asal'], "tgl_deadline" => $row['tgl_deadline'], "tgl_disposisi" => $row['tgl_disposisi'], "jam_disposisi" => $row['jam_disposisi'], "status_dibaca" => $row['status_dibaca'], "tgl_dibaca" => $row['tgl_dibaca'], "tgl_dikerjakan" => $row['tgl_dikerjakan'], "view" => $row['view']);
	$dispokepala_array[] = $single_disposisi;
	}
  mysqli_close($con);
  return $dispokepala_array;
}
 ?>
