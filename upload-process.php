<?php
session_start();
if (!isset($_SESSION['iduser'])){
	 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../index.php">';
	 exit;
}else
{
	$id =  $_SESSION['iduser'];
  if(!empty($_POST['save'])) {
    // var_dump($_FILES);
		var_dump($_POST);
    $user = $_POST['user'];
    $nodoc = $_POST['noDoc'];
    $kategori = $_POST['category'];
    $asalmemo = $_POST['memoby'];
    $nomemo = $_POST['nomemo'];
    $memotitle = $_POST['title'];
    $tglmasuk = $_POST['receivedate'];
    $tglmemo = $_POST['memodate'];
    $recordtext = $_POST['data'];

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size =$_FILES['fileToUpload']['size'];
    $file_tmp =$_FILES['fileToUpload']['tmp_name'];
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    $desired_dir= "assets/file_dokumen/$nodoc/";

    if (isset($_POST['user']) && isset($_POST['category']) && isset($_POST['memoby']) && isset($_POST['nomemo']) && isset($_POST['receivedate']) && isset($_POST['memodate']) && isset($_POST['data'])) {
        if(is_dir($desired_dir)==false){
          mkdir($desired_dir, 0777);		// Create directory if it does not exist
            echo "success folder";
        }
        if(is_dir($desired_dir.$file_name)==false){
          if(move_uploaded_file($file_tmp,$desired_dir.$nodoc.".".$extension)) {
						chmod($desired_dir.$nodoc.".".$extension, 0777);
						echo "success move";
            require_once("database.php");
            insert_dokumen($nodoc, $id, $asalmemo, $nomemo, $memotitle, $tglmasuk, $tglmemo, $kategori, $file_size, $recordtext);
            header("Location: detail_file_upload.php?id=".$nodoc."&page1=1&page2=1");
          }
        }else{									//rename the file if another one exist
          $new_dir="$desired_dir".$file_name.time();
           rename($file_tmp,$new_dir) ;
             echo "success change";
        }
				//header("Location: detail_file_upload.php?id=".$nodoc."&page1=1&page2=1");
      }
  }

	// '''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''update file from detail-submenu.php''''''''''''''''''''''''''''''''''''
	if(!empty($_POST['savedetail'])){

		if (!empty($_POST['noDoc']) && !empty($_POST['category']) && !empty($_POST['memoby']) && !empty($_POST['nofile']) && !empty($_POST['tglasal'])&& !empty($_POST['tglupload']) && !empty($_POST['title']) && !empty($_POST['addinginfo'])) {
			$idfile = $_POST['noDoc'];
			$category = $_POST['category'];
			$memoby = $_POST['memoby'];
			$nofile = $_POST['nofile'];
			$tglasal = $_POST['tglasal'];
			$tglupload = $_POST['tglupload'];
			$title = $_POST['title'];
			$addinginfo = $_POST['addinginfo'];

			if (!empty($_FILES['uploadNewFile'])) {
				$idfile = $_POST['noDoc'];
				$file_name = $_FILES['uploadNewFile']['name'];
				$file_size =$_FILES['uploadNewFile']['size'];
				$file_tmp =$_FILES['uploadNewFile']['tmp_name'];
				$extension = pathinfo($file_name, PATHINFO_EXTENSION);
				$desired_dir= "assets/file_dokumen/$idfile/";
				if(is_dir("$desired_dir".$file_name)==false){
					if(move_uploaded_file($file_tmp,"$desired_dir".$idfile.".".$extension)) {
						echo "success move";
					}
				}else{									//rename the file if another one exist
					$new_dir="$desired_dir".$file_name.time();
					 rename($file_tmp,$new_dir) ;
						 echo "success change";
				}
			}else {
				echo "fail to moved";
			}

			require_once("database.php");
			update_file($idfile, $category, $memoby, $nofile, $tglasal, $tglupload,$title,$addinginfo);
			header("Location: detail-submenu.php?id=".$idfile."&&page1=1&&page2=1");
		}else {
			var_dump($_POST);
			echo "field empty";
		}
	}
}

 ?>
