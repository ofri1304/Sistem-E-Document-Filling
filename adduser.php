<?php
session_start();
if (!isset($_SESSION['iduser'])){
	 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../index.php">';
	 exit;
}else{
	if(!empty($_POST['addnewuser'])){
		// var_dump($_FILES);
		// var_dump($_POST);
			$id           = $_POST['iduser'];
			$file_name    = $_FILES['foto']['name'];
			$file_size    = $_FILES['foto']['size'];
			$file_tmp     = $_FILES['foto']['tmp_name'];
			$extension    = pathinfo($file_name, PATHINFO_EXTENSION);
			$desired_dir  = "assets/img/profile/$id/";
			$nama = $_POST['nama'];
			$password = $_POST['password'];
			$password = md5($password);
			$jabatan = $_POST['jabatan'];
			$unitkerja = $_POST['unitkerja'];
			$nohp = $_POST['nohp'];
			$email = $_POST['email'];

			if(is_dir($desired_dir)==false) {
				if (mkdir("$desired_dir", 0777)) {
					echo "bisa add user";
				}else {
					echo "tidak bsa tambah user";
				}
			}
			if(is_dir("$desired_dir".$file_name)==false){
					if (move_uploaded_file($file_tmp,$desired_dir.$id.".png")) {
						chmod($desired_dir.$id.".png", 0777);
						echo "Successfully Add New Photo User";
	          require_once("database.php");
	          $newid = add_user($id, $nama, $password, $jabatan, $unitkerja, $nohp, $email);
					}else{echo "eror uploaded";}
					// header("location: manage-user.php?page=1");
			}
	}
//-------------------------------------------------------------------------------------------Editing User from ManageUser.php ------------------------------------------------
	if(!empty($_POST['edituser'])){
			$id = $_POST['iduser'];
			$file_name    = $_FILES['foto']['name'];
			$file_size    = $_FILES['foto']['size'];
			$file_tmp     = $_FILES['foto']['tmp_name'];
			$extension    = pathinfo($file_name, PATHINFO_EXTENSION);
			$desired_dir  = "assets/img/profile/$id/";
			if (unlink("assets/img/profile/$id/$id.png")) {
				echo "suscces";
			}else {
				echo "eror del";
			}
			if(is_dir($desired_dir.$file_name)==false){
					if (move_uploaded_file($file_tmp,$desired_dir.$id.".png")) {
						echo "Successfully Add New Photo User 2"." ".$id." ".$desired_dir." ".$file_name;
						// header("location: manage-user.php?page=1");
					}else{
						$new_dir=$desired_dir.$file_name.time();
						rename($file_tmp,$new_dir) ;
						echo "Successfully edit Photo User"." ".$id." ".$desired_dir." ".$file_name;
						// header("location: manage-user.php?page=1");
					}
					// header("location: manage-user.php?page=1");
			}

		if (!empty($_POST['nama']) && !empty($_POST['password']) && !empty($_POST['jabatan']) && !empty($_POST['unitkerja']) && !empty($_POST['nohp']) && !empty($_POST['email'])) {

			$username = $_POST['nama'];
			$password = $_POST['password'];
			require_once("database.php");
			$querycheckpassword = get_all_user("SELECT * FROM user where iduser  LIKE'".$id."'");
			if(count($querycheckpassword) > 0){
				foreach($querycheckpassword as $row){
					if ($password  !=  $row['password']) {
						$password = md5($password);
					}else{
						$password = $password;
					}
				}
			}

			$position = $_POST['jabatan'];
			$divisi = $_POST['unitkerja'];
			$nohp = $_POST['nohp'];
			$email = $_POST['email'];
			require_once("database.php");
			update_alldata_user($id, $username, $password, $position, $divisi, $nohp, $email);
			// header("location: manage-user.php?page=1");
		}
	}

	//-------------------------------------------------------------------------------------------Editing User from ManageUser.php ------------------------------------------------
		if(!empty($_POST['deleteuser'])){
			if(!empty($_POST['id'])){
					$id = $_POST['id'];
					require_once("database.php");
					delete_user($id);
					delete_general("DELETE FROM disposisi_file where id_pengirim LIKE '".$id."' or iduser LIKE '".$id."'");
					delete_general("DELETE FROM share_file where id_pengirim LIKE '".$id."' or iduser LIKE '".$id."'");
					delete_general("DELETE FROM kepala where iduser_kepala LIKE '".$id."' or iduser_staf LIKE '".$id."'");
					$desired_dir= "assets/img/profile/$id";
					unlink($desired_dir."/".$id.".png"); //hapus foto saja didalam direktori
					rmdir($desired_dir); //delete folder

					header("location: manage-user.php?page=1");
			}
		}
}
 ?>
