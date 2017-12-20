<?php
session_start();
require_once("database.php");
require_once("assets/nexmo/process.php");
if (!isset($_SESSION['iduser'])){
	 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../index.php">';
	 exit;
}else
{
	$iduser = $_SESSION['iduser'];
	$mailto = array();

  if(!empty($_POST['btnShare'])){
		if (!empty($_POST['check_list']) && !empty($_POST['noDoc'])) {
			$kode_file =  $_POST['noDoc'];
			$sharedate= date("Y-m-d");
			$category = "";
			$nofile = "";
			$asal = "";
			$title ="";
			$emailTujuan ="";
			$to="";
			require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer();

			foreach($_POST['check_list'] as $select) {
				$receiveshare = substr($select,0,8);
				$idfile = $kode_file."_".$receiveshare;
				echo "* ".$select."{".$receiveshare."}";
				insert_share_file($idfile, $iduser, $receiveshare, $sharedate, $kode_file);
				update_status_file("UPDATE file SET status_share = 1 WHERE idfile LIKE '".$kode_file."' ");

				$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$receiveshare."'");
				if(count($get_email) > 0){
					foreach($get_email as $row){
						$to = $row['nama'];
						$nohp_penerima = $row['no_hp'];
						$emailTujuan = $row['email'];
					}
				}

				$file_array= get_data_file("SELECT * FROM file WHERE idfile LIKE '".$kode_file."'");
				if(count($file_array) > 0){
					foreach($file_array as $row){
						$category = $row['jenis_file'];
						$nofile = $row['no_file'];
						$asal = $row['asal_file'];
						$title = $row['nama_file'];
					}
				}

				$mailSub = "[ ".$category." ]";
				$mailMsg = "Sdr. ".$to.", Anda menerima ".$category." pada tanggal ".$sharedate.", berjudul ('".$title."') dengan nomor file ".$nofile.". Dokumen berasal dari ".$asal;
				$mail ->IsSmtp();
				$mail ->SMTPDebug = 0;
				$mail ->SMTPAuth = true;
				$mail ->SMTPSecure = 'ssl';
				$mail ->Host = "smtp.gmail.com";
				$mail ->Port = 465; // or 587
				$mail ->IsHTML(true);
				$mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
				$mail ->Password = "jesus1304";
				$mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
				$mail ->Subject = $mailSub;
				$mail ->Body = $mailMsg;
				$mail ->AddAddress($emailTujuan);
				if(!$mail->Send()){
					echo "email tidak kekirim";
				}else{
					echo "email kekirim";
				}
				sendSMS($nohp_penerima, $mailMsg);
			}
			header("Location: detail-submenu.php?id=".$kode_file."&page1=1&page2=1");
		}
  }

	if(!empty($_POST['btnDispo'])){
		// echo $_POST['deadlinedate'] ;
		if(isset($_POST['noDoc'])){
			date_default_timezone_set('Asia/Jakarta');
			$tgldisposisi = date("Y-m-d");
			$jamdikirim = date("h:i:sa");
			$kodefile = $_POST['noDoc'];
			$category = "";
			$nofile = "";
			$asal = "";
			$title ="";
			$receivedisposisi ="ED014509";
			require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer();

				$idfile = $kodefile."_".$receivedisposisi;
				insert_disposisi_file($idfile, $iduser, $receivedisposisi, $tgldisposisi, $jamdikirim, $kodefile);
				update_status_file("UPDATE file SET status_disposisi = 1 WHERE idfile LIKE '".$kodefile."' ");

				$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$receivedisposisi."'");
				if(count($get_email) > 0){
					foreach($get_email as $row){
						$emailTujuan = $row['email'];
					}
				}

				$file_array= get_data_file("SELECT * FROM file WHERE idfile LIKE '".$kodefile."'");
				if(count($file_array) > 0){
					foreach($file_array as $row){
						$category = $row['jenis_file'];
						$nofile = $row['no_file'];
						$asal = $row['asal_file'];
						$title = $row['nama_file'];
					}
				}

				$userfrom= get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
				if(count($userfrom) > 0){
					foreach($userfrom as $rowfrom){
						$from = $rowfrom['nama'];
					}
				}
				$to_user= get_all_user("SELECT * FROM user WHERE iduser LIKE '".$receivedisposisi."'");
				if(count($to_user) > 0){
					foreach($to_user as $rowto){
						$to = $rowto['nama'];
						$nohp_penerima = $rowto['no_hp'];
					}
				}

				$mailSub = "[ ".$category." ]";
				$mailMsg = "Sdr. ".$to.", Anda menerima disposisi dokumen ".$category." ('".$title."') dengan nomor file ".$nofile.".";
				$mail ->IsSmtp();
				$mail ->SMTPDebug = 0;
				$mail ->SMTPAuth = true;
				$mail ->SMTPSecure = 'ssl';
				$mail ->Host = "smtp.gmail.com";
				$mail ->Port = 465; // or 587
				$mail ->IsHTML(true);
				$mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
				$mail ->Password = "jesus1304";
				$mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
				$mail ->Subject = $mailSub;
				$mail ->Body = $mailMsg;
				$mail ->AddAddress($emailTujuan);
				if(!$mail->Send()){}else{}
				sendSMS($nohp_penerima, $mailMsg);
				header("Location: detail-submenu.php?id=".$kodefile."&page1=1&page2=1");
		}
	}

	if(!empty($_POST['btnDeleteDispo'])){
		if (isset($_POST['id']) && isset($_POST['name'])) {
			$idfile = $_POST['id'];
			$kode_file = substr($idfile,0,28);

			delete_disposisi_file($idfile);
			$jumlahdata = get_data_disposisi_file("SELECT * from disposisi_file where kode_file LIKE '".$kode_file."'");
			if (count($jumlahdata) == 0) {
				update_status_file("UPDATE file SET status_disposisi = 0 WHERE idfile LIKE '".$kode_file."' ");
			}
			delete_general("DELETE FROM kepala where kode_file_asal LIKE '".$kode_file."'");
			header("Location: detail-submenu.php?id=".$kode_file."&page1=1&page2=1");
		}
	}

	if(!empty($_POST['btnDeleteShare'])){
		if (!empty($_POST['id']) && !empty($_POST['name'])) {
			$idfile = $_POST['id'];
			$kode_file = substr($idfile,0,28);

			delete_share_file($idfile);
			$jumlahdata = get_data_share_file("SELECT * from share_file where kode_file LIKE '".$kode_file."'");
			if (count($jumlahdata) == 0) {
				update_status_file("UPDATE file SET status_share = 0 WHERE idfile LIKE '".$kode_file."' ");
			}
			header("Location: detail-submenu.php?id=".$kode_file."&page1=1&page2=1");
		}
	}

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

				if(file_exists($desired_dir.$file_name)){
					unlink("assets/file_dokumen/$idfile/$idfile.pdf");
					$new_dir=$desired_dir.$idfile.".pdf";
					rename($file_tmp,$new_dir);
				}else{									//rename the file if another one exist
					move_uploaded_file($file_tmp,$desired_dir.$idfile.".pdf");
					chmod($desired_dir.$idfile.".pdf", 0777);
				}

			}

			update_file($idfile, $category, $memoby, $nofile, $tglasal, $tglupload,$title,$addinginfo);
			header("Location: detail-submenu.php?id=".$idfile."&page1=1&page2=1");
		}
	}


	//'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''' save disposisi dari kepala ke staf dari file detail-submenu.php

	if(!empty($_POST['btnDispoKepala'])){
		if (!empty($_POST['check_list']) && !empty($_POST['noDoc']) && !empty($_POST['batasakhir'])) {
			date_default_timezone_set('Asia/Jakarta');
			$jamdikirim = date("h:i:sa");
			$category = $_POST['category'];
			$nofile = $_POST['filenumber'];
			$title = $_POST['title'];
			$kode_file_asal = $_POST['noDoc'];
			$idurl = $_POST['noDoc']."_".$iduser;
			$dispodate= date("Ymd");
			$dispotime = date("hms");
			$deadline = $_POST['batasakhir'];
			$emailTujuan = "";
			$from = ""; $to="";
			$tujuan = array();


			require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer();


			foreach($_POST['check_list'] as $select) {
				$iduserstaf = substr($select,0,8);
				$idfile = $kode_file_asal."_".$iduserstaf;
				//echo "data:".$idfile. $iduser. $iduserstaf.$dispodate.$jamdikirim.$kode_file_asal.$deadline;
				insert_disposisi_file_kepala($idfile, $iduser, $iduserstaf, $dispodate,$jamdikirim, $kode_file_asal, $deadline);

				$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduserstaf."'");
				if(count($get_email) > 0){
					foreach($get_email as $row){
						$emailTujuan = $row['email'];
						$to = $row['nama'];
						$nohp_penerima = $row['no_hp'];
					}
				}
				$userfrom= get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
				if(count($userfrom) > 0){
					foreach($userfrom as $rowfrom){
						$from = $rowfrom['nama'];
					}
				}

				$mailSub = "[ ".$category." ]";
				$mailMsg = "Sdr. ".$to.", Anda menerima ".$category." berjudul ('".$title."') dengan nomor file ".$nofile.". Dokumen merupakan disposisi dari kepala an. ".$from.". Batas akhir mengerjakan file ini pada ".$deadline.", terhitung sejak hari ini.";
				$mail ->IsSmtp();
				$mail ->SMTPDebug = 0;
				$mail ->SMTPAuth = true;
				$mail ->SMTPSecure = 'ssl';
				$mail ->Host = "smtp.gmail.com";
				$mail ->Port = 465; // or 587
				$mail ->IsHTML(true);
				$mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
				$mail ->Password = "jesus1304";
				$mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
				$mail ->Subject = $mailSub;
				$mail ->Body = $mailMsg;
				$mail ->AddAddress($emailTujuan);
				if(!$mail->Send()){}else{}
				sendSMS($nohp_penerima, $mailMsg);
			}
			//-----kirim notif ke email-----------------------------

			header("Location: detail-disposisi-file.php?id=$idurl&page=1");
		}else {
			echo "ERROR".$kode_file_asal;
		}
	}
	// else {
	// 	echo "btn kepala kosong";
	// }

	//-----------------------------------------------------------------send email to kepala from detail-disposisi-file.php ---------------------------------------------------------

	if(!empty($_POST['deletedisposisi'])){
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			$file = substr($id,0,28);
			delete_general("DELETE from kepala where idfile LIKE '".$id."' ");
			$jumlahdata = get_data_disposisi_kepala("SELECT * from kepala where kode_file_asal LIKE '".$file."'");
			if (count($jumlahdata) == 0) {
				update_status_file("UPDATE file SET status_disposisi = 0 WHERE idfile LIKE '".$file."' ");
			}
			header("Location: detail-disposisi-file.php?id=$id&page=1");
		}
	}

	if(!empty($_POST['btnDone'])){
		if (isset($_POST['noDoc'])) {
			$id = $_POST['noDoc']."_".$iduser;
			$tglskg = date('y-m-d');
			update_status_file("UPDATE kepala SET tgl_dikerjakan = '$tglskg' WHERE idfile LIKE '".$id."'");
			header("Location: detail-disposisi-file.php?id=$id&page=1");
		}
	}

	if(!empty($_POST['btnEmail'])){
		if (isset($_POST['noDoc']) && isset($_POST['category']) && isset($_POST['filenumber']) && isset($_POST['title']) && isset($_POST['asal'])) {
			$category = $_POST['category'];
			$nofile = $_POST['filenumber'];
			$title = $_POST['title'];
			$asal = $_POST['asal'];
			$idfile = $_POST['noDoc'];

			$emailTujuan = "";
			$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
			if(count($get_email) > 0){
				foreach($get_email as $row){
					$emailTujuan = $row['email'];
					$nama = $row['nama'];
				}
			}
			$mailto = $emailTujuan;
			$mailSub = "[ ".$category." ]";
			$tgldispo ="";
			if (substr($iduser,2,2) == 03) { //email notif untuk staf
				$deadline = $_POST['deadlinedate'];
				if ($deadline < date('Y-m-d')) {
					$mailMsg = "Sdri/a, ".$nama.". Anda memiliki dokumen ".$category." ('".$title."') dengan nomor file ".$nofile.". Batas telah berakhir untuk mengerjakan file ini pada tanggal ".$deadline.".";
				}else{
					$mailMsg = "Sdri/a, ".$nama.". Anda memiliki dokumen ".$category." ('".$title."') dengan nomor file ".$nofile.". Tanggal deadline untuk mengerjakan file ".$deadline.", terhitung sejak hari ini.";
				}
				}else{
				$disposisi = get_data_disposisi_file("SELECT * FROM disposisi_file WHERE idfile LIKE '".$idfile."_".$iduser."'");
				if(count($disposisi) > 0){
					foreach($disposisi as $row){
						$tgldispo = $row['tgl_disposisi'];
					}
				}
				$mailMsg = "Sdri/a, ".$nama.". Anda menerima dokumen disposisi dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". File dikirim pada tanggal ".$tgldispo.".";
			}
			$id = $idfile."_".$iduser;
			require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
	    $mail = new PHPMailer();
	    $mail ->IsSmtp();
	    $mail ->SMTPDebug = 0;
	    $mail ->SMTPAuth = true;
	    $mail ->SMTPSecure = 'ssl';
	    $mail ->Host = "smtp.gmail.com";
	    $mail ->Port = 465; // or 587
	    $mail ->IsHTML(true);
	    $mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
	    $mail ->Password = "jesus1304";
	    $mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
	    $mail ->Subject = $mailSub;
	    $mail ->Body = $mailMsg;
	    $mail ->AddAddress($mailto);

	    if(!$mail->Send()){}else{}
			header("Location: detail-disposisi-file.php?id=$id&page=1");
		}
	}

	if(!empty($_POST['smsme'])){
		if (isset($_POST['noDoc']) && isset($_POST['category']) && isset($_POST['filenumber']) && isset($_POST['title']) && isset($_POST['asal'])) {
			$category = $_POST['category'];
			$nofile = $_POST['filenumber'];
			$title = $_POST['title'];
			$asal = $_POST['asal'];
			$idfile = $_POST['noDoc'];
			$emailTujuan = "";
			$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
			if(count($get_email) > 0){
				foreach($get_email as $row){
					$nohp_tujuan = $row['no_hp'];
					$nama = $row['nama'];
				}
			}
			$mailto = $emailTujuan;
			$mailSub = "[ ".$category." ]";
			$tgldispo ="";
			if (substr($iduser,2,2) == 03) { //email notif untuk staf
				$deadline = $_POST['deadlinedate'];
				if ($deadline < date('Y-m-d')) {
					$mailMsg = "Sdri/a, ".$nama.". Anda memiliki dokumen disposisi dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". Batas telah berakhir untuk mengerjakan file ini pada tanggal ".$deadline.".";
				}else{
					$mailMsg = "Sdri/a, ".$nama.". Anda memiliki dokumen disposisi dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". Tanggal deadline untuk mengerjakan file ".$deadline.", terhitung sejak hari ini.";
				}
				}else{
				$disposisi = get_data_disposisi_file("SELECT * FROM disposisi_file WHERE idfile LIKE '".$idfile."_".$iduser."'");
				if(count($disposisi) > 0){
					foreach($disposisi as $row){
						$tgldispo = $row['tgl_disposisi'];
						$pengirim = $row['id_pengirim'];
					}
				}
				$mailMsg = "Sdri/a, ".$nama.". Anda menerima dokumen disposisi dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". File dikirim pada tanggal ".$tgldispo.".";
			}
			sendSMS($nohp_tujuan, $mailMsg);
			$id = $idfile."_".$iduser;
			header("Location: detail-disposisi-file.php?id=$id&page=1");
		}
	}

	//---------------------------------------------------------------- Delete share file from detail-share-files.php ----------------------------------------------
	if(!empty($_POST['deleteShare'])){
		if (!empty($_POST['id']) && !empty($_POST['name'])) {
			$idfile = $_POST['id'];
			$kode_file = substr($idfile,0,28);

			delete_share_file($idfile);
			$jumlahdata = get_data_share_file("SELECT * from share_file where kode_file LIKE '".$kode_file."'");
			if (count($jumlahdata) == 0) {
				update_status_file("UPDATE file SET status_share = 0 WHERE idfile LIKE '".$kode_file."' ");
			}
			header("Location: detail-share-files.php?id=".$kode_file."_".$iduser."&page1=1");
		}
	}
	if(!empty($_POST['addShare'])){
		if (!empty($_POST['check_list']) && !empty($_POST['noDoc']) && !empty($_POST['category']) && !empty($_POST['nofile']) && !empty($_POST['title']) && !empty($_POST['asalfile'])) {
			$category = $_POST['category'];
			$nofile = $_POST['nofile'];
			$title = $_POST['title'];
			$kode_file =  $_POST['noDoc'];
			$asalfile = $_POST['asalfile'];
			$sharedate= date("Y-m-d");

			require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer();

			foreach($_POST['check_list'] as $select) {
				$receiveshare = substr($select,0,8);
				$idfile = $kode_file."_".$receiveshare;
				insert_share_file($idfile,$iduser, $receiveshare, $sharedate, $kode_file);
				update_status_file("UPDATE file SET status_share = 1 WHERE idfile LIKE '".$kode_file."' ");

				$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$receiveshare."'");
				if(count($get_email) > 0){
					foreach($get_email as $row){
						$to = $row['nama'];
						$nohp_penerima = $row['no_hp'];
						$emailTujuan = $row['email'];
					}
				}
				$userfrom= get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
				if(count($userfrom) > 0){
					foreach($userfrom as $rowfrom){
						$from = $rowfrom['nama'];
					}
				}

				$mailSub = "[ ".$category." ]";
				$mailMsg = "Sdr. ".$to.", Anda menerima ".$category." berjudul ('".$title."') dengan nomor file ".$nofile.". File dishare oleh ".$from." dan file berasal dari ".$asalfile.".";
				$mail ->IsSmtp();
				$mail ->SMTPDebug = 0;
				$mail ->SMTPAuth = true;
				$mail ->SMTPSecure = 'ssl';
				$mail ->Host = "smtp.gmail.com";
				$mail ->Port = 465; // or 587
				$mail ->IsHTML(true);
				$mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
				$mail ->Password = "jesus1304";
				$mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
				$mail ->Subject = $mailSub;
				$mail ->Body = $mailMsg;
				$mail ->AddAddress($emailTujuan);
				if(!$mail->Send()){}else{}
				sendSMS($nohp_penerima, $mailMsg);
			}
			header("Location: detail-share-files.php?id=".$idfile."&page1=1");
		}
  }

	if(!empty($_POST['emailshare'])){
		if (isset($_POST['noDoc']) && isset($_POST['category']) && isset($_POST['nofile']) && isset($_POST['title']) && isset($_POST['asalfile'])) {
			$category = $_POST['category'];
			$nofile = $_POST['nofile'];
			$title = $_POST['title'];
			$asal = $_POST['asalfile'];
			$uploader = $_POST['uploader'];
			$idfile = $_POST['noDoc'];


			$emailTujuan = "";
			$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
			if(count($get_email) > 0){
				foreach($get_email as $row){
					$emailTujuan = $row['email'];
				}
			}
			if (substr($iduser,2,2) == 02) {
			$share = get_data_share_file("SELECT * FROM share_file where kode_file LIKE '".$idfile."'");
			if(count($share) > 0){
				$count = count($share);
				$mailMsg = "Anda memiliki ".$category." ('".$title."') dengan nomor file ".$nofile.". File sudah dishare ".$count." kali. ";
			}else{
				$mailMsg = "Anda memiliki ".$category." ('".$title."') dengan nomor file ".$nofile.". File belum pernah dishare.";
			}
		}else{
				$sharedate = $_POST['sharedate'];
				$mailMsg = "Anda menerima ".$category." ('".$title."') dengan nomor file ".$nofile.". Pada tanggal ".$sharedate.". File berasal dari ".$asal." dan diupload oleh ".$uploader.".";
		}

			$mailto = $emailTujuan;
			$mailSub = "[ ".$category." ]";
			//$mailMsg = "Anda memiliki dokumen ".$category." ('".$title."') dengan nomor file ".$nofile.". Tanggal deadline untuk mendisposisikan file ".$deadline.", terhitung sejak hari ini.";
			$id = $idfile."_".$iduser;
			require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
	    $mail = new PHPMailer();
	    $mail ->IsSmtp();
	    $mail ->SMTPDebug = 0;
	    $mail ->SMTPAuth = true;
	    $mail ->SMTPSecure = 'ssl';
	    $mail ->Host = "smtp.gmail.com";
	    $mail ->Port = 465; // or 587
	    $mail ->IsHTML(true);
	    $mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
	    $mail ->Password = "jesus1304";
	    $mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
	    $mail ->Subject = $mailSub;
	    $mail ->Body = $mailMsg;
	    $mail ->AddAddress($mailto);
	    if(!$mail->Send()){}else{}
			header("Location: detail-share-files.php?id=".$id."&&page1=1");
		} //echo "kosong".$_POST['noDoc'].$_POST['category'].$_POST['nofile'].$_POST['title'].$_POST['asalfile'].$_POST['sharedate'];
	} //echo "btntidak kedetek";

	if(!empty($_POST['smsmeshare'])){
		if (isset($_POST['noDoc']) && isset($_POST['category']) && isset($_POST['nofile']) && isset($_POST['title']) && isset($_POST['asalfile'])) {
			$category = $_POST['category'];
			$nofile = $_POST['nofile'];
			$title = $_POST['title'];
			$asal = $_POST['asalfile'];
			$uploader = $_POST['uploader'];
			$idfile = $_POST['noDoc'];

			$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
			if(count($get_email) > 0){
				foreach($get_email as $row){
					$no_tujuan = $row['no_hp'];
					$nama = $row['nama'];
				}
			}
			if (substr($iduser,2,2) == 02) {
				$share = get_data_share_file("SELECT * FROM share_file where kode_file LIKE '".$idfile."'");
				if(count($share) > 0){
					$count = count($share);
					$mailMsg = "Sdr, ".$nama.". Anda memiliki share file dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". File sudah dishare ".$count." kali. ";
				}else{
					$mailMsg = "Sdr, ".$nama.". Anda memiliki share file dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". File belum pernah dishare.";
				}
		}else{
				$sharedate = $_POST['sharedate'];
				$mailMsg = "Sdr, ".$nama.". Anda menerima share file dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". Pada tanggal ".$sharedate.". File berasal dari ".$asal." dan diupload oleh ".$uploader.".";
		}
			$id = $idfile."_".$iduser;
			sendSMS($no_tujuan, $mailMsg);
			header("Location: detail-share-files.php?id=".$id."&&page1=1");
		} //echo "kosong".$_POST['noDoc'].$_POST['category'].$_POST['nofile'].$_POST['title'].$_POST['asalfile'].$$mailMsg.$no_tujuan;
	}//echo "btnnotdetect";

	if (!empty($_POST['deleteFileMMasuk'])) {
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			delete_general("DELETE FROM file where idfile LIKE '".$id."'");
			delete_general("DELETE FROM disposisi_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM share_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM kepala where kode_file_asal LIKE '".$id."'");
			header("Location: memo-masuk.php?page=1");
		}
	}

	if (!empty($_POST['deleteFileMKeluar'])) {
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			delete_general("DELETE FROM file where idfile LIKE '".$id."'");
			delete_general("DELETE FROM disposisi_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM share_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM kepala where kode_file_asal LIKE '".$id."'");
			header("Location: memo-keluar.php?page=1");
		}
	}

	if (!empty($_POST['deleteFileSMasuk'])) {
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			delete_general("DELETE FROM file where idfile LIKE '".$id."'");
			delete_general("DELETE FROM disposisi_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM share_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM kepala where kode_file_asal LIKE '".$id."'");
			header("Location: surat-masuk.php?page=1");
		}
	}

	if (!empty($_POST['deleteFileSKeluar'])) {
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			delete_general("DELETE FROM file where idfile LIKE '".$id."'");
			delete_general("DELETE FROM disposisi_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM share_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM kepala where kode_file_asal LIKE '".$id."'");
			header("Location: surat-keluar.php?page=1");
		}
	}

	if (!empty($_POST['deleteFileSKeputusan'])) {
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			delete_general("DELETE FROM file where idfile LIKE '".$id."'");
			delete_general("DELETE FROM disposisi_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM share_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM kepala where kode_file_asal LIKE '".$id."'");
			header("Location: surat-keputusan.php?page=1");
		}
	}

	if (!empty($_POST['deleteFilePDifeksi'])) {
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			delete_general("DELETE FROM file where idfile LIKE '".$id."'");
			delete_general("DELETE FROM disposisi_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM share_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM kepala where kode_file_asal LIKE '".$id."'");
			header("Location: peraturan-difeksi.php?page=1");
		}
	}

	if (!empty($_POST['deleteFileSPerintah'])) {
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			delete_general("DELETE FROM file where idfile LIKE '".$id."'");
			delete_general("DELETE FROM disposisi_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM share_file where kode_file LIKE '".$id."'");
			delete_general("DELETE FROM kepala where kode_file_asal LIKE '".$id."'");
			header("Location: surat-perintah.php?page=1");
		}
	}
	//------------------------------------------------------------------------------------- menangani data di detail_file_upload.php--------------------------------------------------------
	if(!empty($_POST['btnDispoSekretaris'])){
		if(isset($_POST['noDoc'])){
			date_default_timezone_set('Asia/Jakarta');
			$tgldisposisi = date("Y-m-d");
			$jamdikirim = date("h:i:sa");
			$kodefile = $_POST['noDoc'];
			$category = "";
			$nofile = "";
			$asal = "";
			$title ="";
			$receivedisposisi = "ED014509";
			require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer();

				$idfile = $kodefile."_".$receivedisposisi;
				insert_disposisi_file($idfile, $iduser, $receivedisposisi, $tgldisposisi, $jamdikirim, $kodefile);
				update_status_file("UPDATE file SET status_disposisi = 1 WHERE idfile LIKE '".$kodefile."' ");

				$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$receivedisposisi."'");
				if(count($get_email) > 0){
					foreach($get_email as $row){
						$to = $row['nama'];
						$nohp_penerima = $row['no_hp'];
						$emailTujuan = $row['email'];
					}
				}

				$file_array= get_data_file("SELECT * FROM file WHERE idfile LIKE '".$kodefile."'");
				if(count($file_array) > 0){
					foreach($file_array as $row){
						$category = $row['jenis_file'];
						$nofile = $row['no_file'];
						$asal = $row['asal_file'];
						$title = $row['nama_file'];
					}
				}

				$userfrom= get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
				if(count($userfrom) > 0){
					foreach($userfrom as $rowfrom){
						$from = $rowfrom['nama'];
					}
				}

				$mailSub = "[ ".$category." ]";
				$mailMsg = "Sdr. ".$to.", Anda menerima dokumen disposisi dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". File berasal dari ".$asal.".";
				$mail ->IsSmtp();
				$mail ->SMTPDebug = 0;
				$mail ->SMTPAuth = true;
				$mail ->SMTPSecure = 'ssl';
				$mail ->Host = "smtp.gmail.com";
				$mail ->Port = 465; // or 587
				$mail ->IsHTML(true);
				$mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
				$mail ->Password = "jesus1304";
				$mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
				$mail ->Subject = $mailSub;
				$mail ->Body = $mailMsg;
				$mail ->AddAddress($emailTujuan);
				if(!$mail->Send()){}else{}
				sendSMS($nohp_penerima, $mailMsg);

			header("Location: detail_file_upload.php?id=".$kodefile."&page1=1&page2=1");
		}//echo " *nodoc empty"." *".$idfile." *".$iduser." *".$receivedisposisi." *".$tgldisposisi." *".$jamdikirim." *".$kodefile;
	}//echo "btnkosong";
	if(!empty($_POST['addShareSekretaris'])){
		if (!empty($_POST['check_list']) && !empty($_POST['noDoc']) && !empty($_POST['category']) && !empty($_POST['nofile']) && !empty($_POST['title']) && !empty($_POST['asalfile'])) {
			$category = $_POST['category'];
			$nofile = $_POST['nofile'];
			$title = $_POST['title'];
			$kode_file =  $_POST['noDoc'];
			$asalfile = $_POST['asalfile'];
			$sharedate= date("Y-m-d");

			require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer();

			foreach($_POST['check_list'] as $select) {
				$receiveshare = substr($select,0,8);
				$idfile = $kode_file."_".$receiveshare;
				insert_share_file($idfile, $iduser, $receiveshare, $sharedate, $kode_file);
				update_status_file("UPDATE file SET status_share = 1 WHERE idfile LIKE '".$kode_file."' ");

				$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$receiveshare."'");
				if(count($get_email) > 0){
					foreach($get_email as $row){
						$nohp_penerima = $row['no_hp'];
						$emailTujuan = $row['email'];
						$to = $row['nama'];
					}
				}

				$userfrom= get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
				if(count($userfrom) > 0){
					foreach($userfrom as $rowfrom){
						$from = $rowfrom['nama'];
					}
				}

				$mailSub = "[ ".$category." ]";
				$mailMsg = "Sdr. ".$to.", Anda menerima share file dengan kategori ".$category." berjudul ('".$title."') dengan nomor file ".$nofile.". File dishare oleh ".$from." dan file berasal dari ".$asalfile.".";
				$mail ->IsSmtp();
				$mail ->SMTPDebug = 0;
				$mail ->SMTPAuth = true;
				$mail ->SMTPSecure = 'ssl';
				$mail ->Host = "smtp.gmail.com";
				$mail ->Port = 465; // or 587
				$mail ->IsHTML(true);
				$mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
				$mail ->Password = "jesus1304";
				$mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
				$mail ->Subject = $mailSub;
				$mail ->Body = $mailMsg;
				$mail ->AddAddress($emailTujuan);
				if(!$mail->Send()){echo "send";}else{echo "send fail";}
				sendSMS($nohp_penerima, $mailMsg);
			}
			header("Location: detail_file_upload.php?id=".$kode_file."&page1=1&page2=1");
		 }
		 //echo "ada yg kosong".$_POST['check_list'].$_POST['noDoc'].$_POST['category'].$_POST['nofile'].$_POST['title'].$_POST['asalfile'];
	}

	if(!empty($_POST['delDispo'])){
		if (isset($_POST['id']) && isset($_POST['name'])) {
			$idfile = $_POST['id'];
			$kode_file = substr($idfile,0,28);

			delete_disposisi_file($idfile);
			$jumlahdata = get_data_disposisi_file("SELECT * from disposisi_file where kode_file LIKE '".$kode_file."'");
			if (count($jumlahdata) == 0) {
				update_status_file("UPDATE file SET status_disposisi = 0 WHERE idfile LIKE '".$kode_file."' ");
			}
			delete_general("DELETE FROM kepala where kode_file_asal LIKE '".$kode_file."'");
			header("Location: detail_file_upload.php?id=".$kode_file."&page1=1&page2=1");
		}
	}

	if(!empty($_POST['delShare'])){
		if (!empty($_POST['id']) && !empty($_POST['name'])) {
			$idfile = $_POST['id'];
			$kode_file = substr($idfile,0,28);

			delete_share_file($idfile);
			$jumlahdata = get_data_share_file("SELECT * from share_file where kode_file LIKE '".$kode_file."' ");
			if (count($jumlahdata) == 0) {
				update_status_file("UPDATE file SET status_share = 0 WHERE idfile LIKE '".$kode_file."' ");
			}
			header("Location: detail_file_upload.php?id=".$kode_file."&page1=1&page2=1");
		}
	}
	//-----------------------------------------------------------------------------------------detail-disposisi.php-----------------------------------------------
	if(!empty($_POST['btnDispoSekre'])){
		// echo $_POST['deadlinedate'] ;
		if(isset($_POST['noDoc'])){
			date_default_timezone_set('Asia/Jakarta');
			$tgldisposisi = date("Y-m-d");
			$jamdikirim = date("h:i:sa");
			$kodefile = $_POST['noDoc'];
			$category = "";
			$nofile = "";
			$asal = "";
			$title ="";
			$receivedisposisi ="ED014509";
			require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer();

				$idfile = $kodefile."_".$receivedisposisi;
				insert_disposisi_file($idfile, $iduser, $receivedisposisi, $tgldisposisi, $jamdikirim, $kodefile);
				update_status_file("UPDATE file SET status_disposisi = 1 WHERE idfile LIKE '".$kodefile."' ");

				$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$receivedisposisi."'");
				if(count($get_email) > 0){
					foreach($get_email as $row){
						$emailTujuan = $row['email'];
					}
				}

				$file_array= get_data_file("SELECT * FROM file WHERE idfile LIKE '".$kodefile."'");
				if(count($file_array) > 0){
					foreach($file_array as $row){
						$category = $row['jenis_file'];
						$nofile = $row['no_file'];
						$asal = $row['asal_file'];
						$title = $row['nama_file'];
					}
				}

				$userfrom= get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
				if(count($userfrom) > 0){
					foreach($userfrom as $rowfrom){
						$from = $rowfrom['nama'];
					}
				}
				$to_user= get_all_user("SELECT * FROM user WHERE iduser LIKE '".$receivedisposisi."'");
				if(count($to_user) > 0){
					foreach($to_user as $rowto){
						$to = $rowto['nama'];
						$nohp_penerima = $rowto['no_hp'];
					}
				}

				$mailSub = "[ ".$category." ]";
				$mailMsg = "Sdr. ".$to.", Anda menerima disposisi dokumen ".$category." ('".$title."') dengan nomor file ".$nofile.".";
				$mail ->IsSmtp();
				$mail ->SMTPDebug = 0;
				$mail ->SMTPAuth = true;
				$mail ->SMTPSecure = 'ssl';
				$mail ->Host = "smtp.gmail.com";
				$mail ->Port = 465; // or 587
				$mail ->IsHTML(true);
				$mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
				$mail ->Password = "jesus1304";
				$mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
				$mail ->Subject = $mailSub;
				$mail ->Body = $mailMsg;
				$mail ->AddAddress($emailTujuan);
				if(!$mail->Send()){}else{}
				sendSMS($nohp_penerima, $mailMsg);
				header("Location: detail-disposisi.php?id=".$idfile."&page=1");
		}
	}
	if(!empty($_POST['deletedisposisisekre'])){
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			$idfile = substr($id,0,28);
			delete_general("DELETE from disposisi_file where kode_file LIKE '".$idfile."' ");
			delete_general("DELETE from kepala where kode_file_asal LIKE '".$idfile."' ");
			update_status_file("UPDATE file SET status_disposisi = 0 WHERE idfile LIKE '".$idfile."' ");
			header("Location: disposisi.php?page=1");
		}
	}
}
//---------------------------------------------------------------disposisi sekretaris---------------------------------------------------------------------
if(!empty($_POST['btnEmailDispoSekre'])){
	if (isset($_POST['noDoc']) && isset($_POST['category']) && isset($_POST['filenumber']) && isset($_POST['title']) && isset($_POST['asal'])) {
		$category = $_POST['category'];
		$nofile = $_POST['filenumber'];
		$title = $_POST['title'];
		$asal = $_POST['asal'];
		$idfile = $_POST['noDoc'];

		$emailTujuan = "";
		$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
		if(count($get_email) > 0){
			foreach($get_email as $row){
				$emailTujuan = $row['email'];
				$nama = $row['nama'];
			}
		}
		$mailto = $emailTujuan;
		$mailSub = "[ ".$category." ]";
		$tgldispo ="";

		$disposisi = get_data_disposisi_file("SELECT * FROM disposisi_file WHERE kode_file LIKE '".$idfile."'");
			if(count($disposisi) > 0){
				foreach($disposisi as $row){
					$tgldispo = $row['tgl_disposisi'];
					$mailMsg = "Sdri/a, ".$nama.". Anda memiliki dokumen disposisi dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". File sudah didisposisikan pada tanggal ".$tgldispo.".";
				}
			}else{
				$mailMsg = "Sdri/a, ".$nama.". Anda memiliki dokumen disposisi dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". File belum didisposisikan.";
			}

		$id = $idfile."_".$iduser;
		require 'assets/phpmailer/PHPMailer-master/PHPMailerAutoload.php';
		$mail = new PHPMailer();
		$mail ->IsSmtp();
		$mail ->SMTPDebug = 0;
		$mail ->SMTPAuth = true;
		$mail ->SMTPSecure = 'ssl';
		$mail ->Host = "smtp.gmail.com";
		$mail ->Port = 465; // or 587
		$mail ->IsHTML(true);
		$mail ->Username = "ofri.cantika@ti.ukdw.ac.id";
		$mail ->Password = "jesus1304";
		$mail ->SetFrom("ofri.cantika@ti.ukdw.ac.id");
		$mail ->Subject = $mailSub;
		$mail ->Body = $mailMsg;
		$mail ->AddAddress($mailto);

		if(!$mail->Send()){}else{}
		header("Location: detail-disposisi.php?id=$id");
	}
}

if(!empty($_POST['smssekre'])){
	if (isset($_POST['noDoc']) && isset($_POST['category']) && isset($_POST['filenumber']) && isset($_POST['title']) && isset($_POST['asal'])){
		$category = $_POST['category'];
		$nofile = $_POST['filenumber'];
		$title = $_POST['title'];
		$asal = $_POST['asal'];
		$idfile = $_POST['noDoc'];

		$get_email = get_all_user("SELECT * FROM user WHERE iduser LIKE '".$iduser."'");
		if(count($get_email) > 0){
			foreach($get_email as $row){
				$no_tujuan = $row['no_hp'];
				$nama = $row['nama'];
			}
		}

		$disposisi = get_data_disposisi_file("SELECT * FROM disposisi_file WHERE kode_file LIKE '".$idfile."'");
			if(count($disposisi) > 0){
				foreach($disposisi as $row){
					$tgldispo = $row['tgl_disposisi'];
					$mailMsg = "Sdri/a, ".$nama.". Anda memiliki dokumen disposisi dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". File sudah didisposisikan pada tanggal ".$tgldispo.".";
				}
			}else{
				$mailMsg = "Sdri/a, ".$nama.". Anda memiliki dokumen disposisi dengan kategori ".$category." ('".$title."') dengan nomor file ".$nofile.". File belum didisposisikan.";
			}
		$id = $idfile."_".$iduser;
		sendSMS($no_tujuan, $mailMsg);
		header("Location: detail-disposisi.php?id=$id");
	} //echo "kosong".$_POST['noDoc'].$_POST['category'].$_POST['nofile'].$_POST['title'].$_POST['asalfile'].$_POST['sharedate'];
}//echo "btnnotdetect";

?>
