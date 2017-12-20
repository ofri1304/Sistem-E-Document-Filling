<?php
session_start();
if (!isset($_SESSION['iduser'])){
	 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../index.php">';
	 exit;
}else
{
	$id =  $_SESSION['iduser'];
//---------------------------------------------Starting To Editing Data User from profile.php--------------------------------------------------------------------------
if(!empty($_POST['password'])){
		$password = $_POST['password2'];
		require_once("database.php");
		update_pass_user($id, $password);
		header("Location: profile.php");
	}
if(!empty($_POST['btnPhoto'])) {
		// var_dump($_FILES);
		// var_dump($_POST);
		$file_name = $_FILES['photoProfile']['name'];
		$file_size = $_FILES['photoProfile']['size'];
		$file_tmp  = $_FILES['photoProfile']['tmp_name'];
		$extension = pathinfo($file_name, PATHINFO_EXTENSION);

		$desired_dir= "assets/img/profile/$id/";
		if ($extension == "png") {
			if(file_exists($desired_dir.$file_name)){
				unlink("assets/img/profile/$id/$id.png");
				$new_dir=$desired_dir.$id.".png";
				rename($file_tmp,$new_dir) ;
			}else{
					if(move_uploaded_file($file_tmp,$desired_dir.$id.".png")) {
						chmod($desired_dir.$id.".png", 0777);
					}
			}
		}else {
			echo "File must be png type.";
		}

		header("Location: profile.php");
	}else {}


if(!empty($_POST['nama']) && !empty($_POST['jabatan']) && !empty($_POST['divisi']) && !empty($_POST['nohp']) && !empty($_POST['email'])) {
    $username = $_POST['nama'];
    $position = $_POST['jabatan'];
    $divisi = $_POST['divisi'];
    $nohp = $_POST['nohp'];
    $email = $_POST['email'];
    require_once("database.php");
    update_data_user($id, $username, $position, $divisi, $nohp, $email);
		header("Location: profile.php");
	}else {
		header("Location: profile.php");
	}

//-------------------------------------------------------End for Editing Data User from profile.php---------------------------------------------------------------

}
?>
