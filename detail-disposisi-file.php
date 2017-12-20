<?php
	session_start();
		if (!isset($_SESSION['iduser']))
		{
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ../index.php">';
		  exit;
		}else{
			$id = $_GET['id'];
    	$idfile = substr($id, 0, 28);
			$iduser = $_SESSION['iduser'];
			$code =substr($iduser, 2,2);
			$deadlinedate = "";
			require_once("database.php");
			if ($code == 01) { //kepala
				$date_now = date("y-m-d"); $time_now = date("h:i:sa");
				$dispo_file = get_data_disposisi_file("SELECT * FROM disposisi_file WHERE idfile LIKE '".$id."' ");
				if(count($dispo_file) > 0){
					foreach($dispo_file as $row){
						$view = $row['view'] + 1;
						if ($row['status_dibaca'] == 0) {
							$query = update_status_file("UPDATE disposisi_file SET status_dibaca = '1', view='$view' WHERE idfile LIKE '".$id."'");
						}else{
							$query = update_status_file("UPDATE disposisi_file SET view='$view' where idfile LIKE '".$id."'");
						}
					}
				}
			}elseif ($code == 03) { //kepala
				$date_now = date("y-m-d"); $time_now = date("h:i:sa");
				$dispo_file = get_data_disposisi_kepala("SELECT * FROM kepala WHERE idfile LIKE '".$id."' ");
				if(count($dispo_file) > 0){
					foreach($dispo_file as $row){
						$view = $row['view'] + 1;
						if ($row['status_dibaca'] == 0) {
							$query = update_status_file("UPDATE kepala SET status_dibaca = '1',tgl_dibaca = '$date_now', view = '$view' WHERE idfile LIKE '".$id."'");
						}else{
							$query = update_status_file("UPDATE kepala SET view = '$view' WHERE idfile LIKE '".$id."'");
						}
					}
				}
			}

			if ((time() - $_SESSION['last_time']) > 1800) {
			header("Location: logout.php");
			}else {
			$_SESSION['last_time'] = time();
	?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>E-Document Filling - BPJS KETENAGAKERJAAN</title>

    <!-- Custom styles for this template -->
		<link rel="stylesheet"  type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-timepicker/compiled/timepicker.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datetimepicker/datetimepicker.css"/>
		<link rel="stylesheet" href="assets/js/autocomplete/bootstrap-chosen.css">
    <link href="assets/css/custom.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/style-responsive.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/js/pdf/pdfstyle.css"/>


    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"/>
		<style>
			input[type="submit"] {
					font-family: FontAwesome;
			}
			.form-group{
				padding-left:5%;
				padding-right:5%;
			}
			.modal-dialog{
    			overflow-y: initial !important
			}
			.scroll{
			    height: 150px;
			    overflow-y: auto;
			}
			.datepicker{z-index:99999 !important}
		</style>

  </head>

  <body id="disposisifile">

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg" style="background: #737373;">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="home.php" class="logo"><b>BPJSTK E-DOC</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
								<ul class="nav top-menu">
										<!-- inbox dropdown start untuk staf -->
												<?php if($code == 03){ ?>
													<li id="header_inbox_bar" class="dropdown">
															<a data-toggle="dropdown" class="dropdown-toggle" href="index.html#" >
																	<i class="fa fa-envelope-o" style="color:#fff;"></i>
																	<?php $dispo_file = get_data_disposisi_kepala("SELECT * FROM kepala WHERE iduser_staf LIKE '".$iduser."' and status_dibaca = 0");
																	if (count($dispo_file) > 0) { ?>
																		<span class="badge bg-theme" style="background:#3498db;"><?php echo count($dispo_file);?></span>
																	<?php } ?>
															</a>
													<ul class="dropdown-menu extended inbox">
														<div class="notify-arrow notify-arrow-green"></div>
														<li><p class="green" style="font-size:0.8em;">You have <?php echo count($dispo_file);?> new Disposition messages</p></li>
														<?php $dispo_array = get_data_disposisi_kepala("SELECT * FROM kepala WHERE iduser_staf LIKE '".$iduser."' and status_dibaca = 0");
														if (count($dispo_array) > 0) {
															foreach($dispo_array as $row) {
																$kodefile = $row['idfile']; ?>
																	<li>
																		<a href="detail-disposisi-file.php?id=<?php echo $kodefile;?>&page=1">
																			<?php $userkepala = $row['iduser_kepala'];
																			$getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$userkepala."'");
																			if(count($getuserdata_array) > 0){
																				foreach($getuserdata_array as $rowuser){
																					date_default_timezone_set('Asia/Jakarta');
																					$a = $row['tgl_disposisi']." ".$row['jam_disposisi'];
																					$file = date_create($a);
																					$now = date_create(date('Y-m-d h:m:sa'));
																					$diff=date_diff($file,$now); ?>
																					<span class="photo"><img alt="avatar" src="assets/img/profile/<?php echo $userkepala; ?>/<?php echo $userkepala; ?>.png"></span>
																					<span class="subject">
																					<span class="from"><?php echo $rowuser['nama']; ?></span>
																					<?php if (date('Y-m-d') == $row['tgl_disposisi']) { ?>
																										<span class="time" style="font-size:0.8em;"><?php echo $diff->format("%R%h hours"); ?></span>
																					<?php }else{ ?>
																										<span class="time" style="font-size:0.5em;"><?php echo $a; ?></span>
																					<?php } ?>
																				</span>
																				<?php $kodefile = $row['kode_file_asal']; $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$kodefile."'");
																				if(count($file_array) > 0){
																					foreach($file_array as $rowfile){ ?>
																							<span class="message"><?php echo $rowfile['nama_file']; ?></span>
																					<?php }} ?>
																				<?php }}?>
																		</a>
																	</li>
													<?php }}?>
													 <li><a href="disposisi-file.php?page1=1&&page2=1">See all messages</a></li>
												</ul>
											<?php }elseif($code == 01){ ?>
												<li id="header_inbox_bar" class="dropdown">
														<a data-toggle="dropdown" class="dropdown-toggle" href="index.html#" >
																<i class="fa fa-envelope-o" style="color:#fff;"></i>
																<?php $dispo = get_data_disposisi_file("SELECT * FROM disposisi_file WHERE iduser LIKE '".$iduser."' and status_dibaca = 0");
																if (count($dispo) > 0) { ?>
																	<span class="badge bg-theme" style="background:#3498db;"><?php echo count($dispo);?></span>
																<?php } ?>
														</a>
												<ul class="dropdown-menu extended inbox">
													 <div class="notify-arrow notify-arrow-green"></div>
													 <li><p class="green" style="font-size:0.8em;">You have <?php echo count($dispo);?> new disposition messages</p></li>
													 <?php
													 if (count($dispo) > 0) {
														 foreach($dispo as $rows) {
															 $kodefile = $rows['idfile']; ?>
																 <li>
																	 <a href="detail-disposisi-file.php?id=<?php echo $kodefile;?>&page=1">
																		 <?php $sekretaris = $rows['id_pengirim'];
																		 $userdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$sekretaris."'");
																		 if(count($userdata_array) > 0){
																			 foreach($userdata_array as $user){
																				 date_default_timezone_set('Asia/Jakarta');
																				 $a = $rows['tgl_disposisi']." ".$rows['jam_disposisi'];
																				 $file = date_create($a);
																				 $now = date_create(date('Y-m-d h:m:sa'));
																				 $diff=date_diff($file,$now);
																				 $temp = $diff->format("%h");
																				 ?>
																				 <span class="photo"><img alt="avatar" width="10px" src="assets/img/profile/<?php echo $sekretaris; ?>/<?php echo $sekretaris; ?>.png"></span>
																				 <span class="subject">
																				 <span class="from">
																					 <?php if (date('Y-m-d') == $rows['tgl_disposisi']) { ?>
																										<span class="time" style="font-size:0.8em;"><?php echo $diff->format("%R%h hours"); ?></span>
																					<?php }else{ ?>
																										<span class="time" style="font-size:0.7em;"><?php echo $rows['tgl_disposisi']; ?></span>
																					<?php } ?>

																						<?php echo $user['nama']; ?></span>

																			 </span>
																			 <?php $kodefileasal = $rows['kode_file']; $files_array = get_data_file("SELECT * FROM file where idfile LIKE'".$kodefileasal."'");
																			 if(count($files_array) > 0){
																				 foreach($files_array as $row_file){ ?>
																						 <span class="message"><?php echo $row_file['nama_file']; ?></span>
																				 <?php }} ?>
																			 <?php }}?>
																	 </a>
																 </li>
												 <?php }}?>
													<li><a href="disposisi-file.php?page1=1&&page2=1">See all messages</a></li>
											 </ul>
											 </li><!-- inbox dropdown end -->
											<?php } ?>
								</ul>  <!--  notification end -->
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout.php">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->

      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
        <?php include "menu.php"; ?>
      <!--sidebar end-->

      <!-- **********************************************************************************************************************************************************
    MAIN CONTENT
    *********************************************************************************************************************************************************** -->
    <!--main content start-->

    <section id="main-content" style="background:#e6e6e6;">
        <section class="wrapper">
          <!-- <div class="row mt"> -->
          <div class="col-lg-4" style="padding-left:0px; margin-top:2%;">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="disposisi-file.php?page1=1&&page2=1">Disposition File</a></li>
              <li class="breadcrumb-item active">Detail Disposition </li>
            </ol>
          </div><!-- /rowmt -->
					<form action="save-disposisi-share.php" method="post" id="formsubmit">
					<div class="panel panel-default" style="margin-top:6%; margin-left:1%; margin-right:1%;">
						<div class="panel-body">
							<div class="col-lg-12">
								<div class="alert alert-success" id="success" style="display:none;">
									<strong>Notification has been sent to your email.</strong>
								</div>
							</div>

          		<div class="col-lg-12">
                <div class="col-lg-6 col-xs-12" >
									<div style="border: 1px solid black;">
                  <span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-2x" style="float:left;"></i> <h5>Detail File</h5></span>

								 <?php
								 		$file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
								 		if(count($file_array) > 0):
									 		foreach($file_array as $row):?>
												<div class="form-group">
													<label>File From: </label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-user"></i></span>
														<input type="text" class="form-control" id="asal" name="asal" readonly="true" value="<?php echo $row['asal_file']; ?>"/>
													</div>
												</div>

												<div class="form-group">
													<label>File Title: </label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-file-o"></i></span>
														<input type="text" class="form-control" id="title" name="title" readonly="true" value="<?php echo $row['nama_file']; ?>"/>
													</div>
												</div>

												<div class="form-group">
													<label>Number of Document : </label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-file-o"></i></span>
														<input type="text" class="form-control" readonly="true" id="noDoc" name ="noDoc" value="<?php echo $idfile; ?>"/>
													</div>
												</div>

												<div class="form-group">
													<label>File Date: </label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														<input type="text" class="form-control" id="tglfile" name="tglfile" readonly="true" value="<?php echo $row['tgl_asal_file']; ?>"/>
													</div>
												</div>

												<div class="form-group">
													<label>Upload File Date: </label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
														<input type="text" class="form-control" id="tglupload" name="tglupload" readonly="true" value="<?php echo $row['tgl_upload']; ?>"/>
													</div>
												</div>

												<div class="form-group">
													<label>File Number: </label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-file-o"></i></span>
														<input type="text" class="form-control" id="filenumber" name="filenumber" readonly="true" value="<?php echo $row['no_file']; ?>"/>
													</div>
												</div>

												<div class="form-group">
													<label>File Category: </label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-file"></i></span>
														<input type="text" class="form-control" id="category" name="category"  readonly="true" value="<?php echo $row['jenis_file']; ?>"/>
													</div>
												</div>

												<div class="form-group">
													<label>Adding Information : </label>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
														<input type="text" class="form-control" id="perihal" name="perihal"  readonly="true" value="<?php echo strip_tags($row['detail_dokumen']); ?>"/>
													</div>
												</div>

												<?php if ($code == 01) {

												 $dispo_file_array = get_data_disposisi_file("SELECT * FROM disposisi_file where idfile LIKE '".$id."'");
												 if(count($dispo_file_array) > 0):
													foreach($dispo_file_array as $rowdispo): ?>
														<div class="form-group">
						                  <label>Disposisi Date : </label>
															<div class="input-group">
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																	<input type="text" class="form-control" id="dispodate" name="dispodate" readonly="true" value="<?php echo $rowdispo['tgl_disposisi'];?>"/>
															</div>
														</div>

											<?php endforeach;
										 endif;
									  } ?>

												<?php if ($code == 03):
													$dispo_array = get_data_disposisi_kepala("SELECT * FROM kepala where idfile LIKE '".$id."'");
													if(count($dispo_array) > 0):
														foreach($dispo_array as $rowstaf): ?>
														<div class="form-group">
															<label>Deadline Date : </label>
															<div class="input-group"	>
																<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																<input type="text" class="form-control" id="deadlinedate" name="deadlinedate" readonly="true" value="<?php echo $rowstaf['tgl_deadline']; ?>"/>
															</div>
														</div>
														<?php $idkepala = $rowstaf['iduser_kepala'];
														$getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$idkepala."'");
														if(count($getuserdata_array) > 0):
															foreach($getuserdata_array as $rowuser): ?>
															<div class="form-group">
																<label>Disposition From: </label>
																<div class="input-group"	>
																	<span class="input-group-addon"><i class="fa fa-user"></i></span>
																		<input type="text" class="form-control" id="dispofrom" readonly="true" value="<?php echo $rowuser['nama']; ?>"/>
																</div>
															</div>
															<?php endforeach; endif; ?>

															<div class="form-group">
																<label>Disposition Date : </label>
																<div class="input-group">
																	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																		<input type="text" class="form-control" id="dispodate" name="dispodate" readonly="true" value="<?php echo $rowstaf['tgl_disposisi'];?>"/>
																</div>
															</div><br>
															<?php endforeach; endif; ?>
												<?php endif; ?>
											<?php endforeach;  endif;?>
              			</div>
									</div>

    <!-- **********************************************************************************************************************************************************
    RIGHT SIDEBAR CONTENT
    *********************************************************************************************************************************************************** -->
		<div class="col-lg-6 col-xs-12">
			<!-- btn sudah dikerjakan oleh staf -->
			<?php if ($code == 03) {  ?>
				<div class="box" style="text-align:right;">
				 <div class="box-content">

					 <?php
					 	 $cek = false;
						 $disposisi_data_dari_kepala = get_data_disposisi_kepala("SELECT * FROM kepala WHERE idfile LIKE '".$idfile."_".$iduser."'");
						 if(count($disposisi_data_dari_kepala) > 0){
							 foreach($disposisi_data_dari_kepala as $row){
								if ($row['tgl_dikerjakan'] == "0000-00-00") {

									if ($row['tgl_deadline'] < date('Y-m-d')) {
										$cek = false;  ?>
										<style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
										<button type="button" style="color:#FFF;" class="btn btn-danger" disabled>Masa Pengerjaan File Sudah Berakhir.</button>
									<?php }else{
										$cek = true; ?>
										<style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
										<input type="submit" style="color:#FFF;" class="btn btn-danger" name="btnDone" id="btnDone" value="Kerjakan!"/>
								<?php } ?>
					<?php	}else{
									$cek = false; ?>
									<style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
									<button type="button" style="color:#FFF;" class="btn btn-success" disabled>Sudah dikerjakan.</button>
					<?php	}
							 }
						 }
					  ?>

					</div>
			 </div><br>
		  <?php } ?>

      <div class="box">
              <div id="Iframe-Cicis-Menu-To-Go" class="set-margin-cicis-menu-to-go set-padding-cicis-menu-to-go set-border-cicis-menu-to-go set-box-shadow-cicis-menu-to-go center-block-horiz">
                <div class="responsive-wrapper
                  responsive-wrapper-padding-bottom-90pct"
                    style="-webkit-overflow-scrolling: touch;">
                      <iframe src="assets/file_dokumen/<?php echo $idfile;?>/<?php echo $idfile;?>.pdf"></iframe>
                </div>
              </div><br>
      </div>

			<div class="box">
					<div class="box-header">
							<span class="input-group-addon" style="background-color:#595959; color:#fff; height:5%;">
								<span style="background-color:#595959; color:#fff;"><i class="fa fa-file-text fa-2x" style="float:left; margin-left: 1px; margin-top:5px;"></i> <h4 style="float:left;">&nbsp; &nbsp; List Disposition For Staf</h4></span>
							<?php if($code == 01){ ?>
								<button  class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal"style="float:right;"><i class="fa fa-plus"></i> Disposition</button></span>
						 <?php } ?>

					</div>
					<!-- Modal -->
					<div class="modal fade" id="myModal" role="dialog" >
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background: #737373;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Disposition Form</h4>
								</div>

								<div class="modal-body">
									<div class="form-group">
											<label>Deadline Date: </label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar "></i></span>
												<input type="text" class="form-control dpd1" id="batasakhir" name="batasakhir" style="font-size:1.1em;">
												<!-- <input type="text" class="form-control dp1" name="batasakhir" id="batasakhir" style="font-size:1.1em;"> -->
											</div>
									</div>
								<?php if ($deadlinedate < date('y-m-d')) { ?>
										<div class="form-group" style="height:auto; overflow: auto;">
											<label>Disposition to :</label>
											<div class="control-panel col-lg-12 col-xs-12 scroll"><br>
															<ul>
																<?php
																	$user_array = get_all_user("SELECT * FROM user");$perbandingan2 = 0;
																	if(count($user_array) > 0):
																		foreach($user_array as $row):
																			$user = $row['iduser'];
																			$kode = substr($user,2,2);
																			if ($kode == 03) { //kepala disposisi hanya bisa ke staf code user 03
																				$id = $idfile."_".$user;
																				$disposisi_array = get_data_disposisi_kepala("SELECT * FROM kepala where idfile LIKE'".$id."'");
																				if(count($disposisi_array) == 0){
																					$perbandingan2 = $perbandingan2 + 1; ?>
																					<li> <input type="checkbox" name="check_list[]" value="<?php echo $row['iduser']; ?>_<?php echo $row['nama'];?>">   <label> <?php echo $row['iduser']; ?>_<?php echo $row['nama']; ?> </label></li>
																				<?php }
																			 }
																		endforeach; if($perbandingan2 == 0){ ?>
																			<li> Semua User telah mendapat file disposisi. </li>
																		<?php  } endif; ?>
															</ul>
											</div>
										</div>
								</div>
								<div class="modal-footer">
									<input type="submit" class="btn btn-primary" value="Disposisi" name="btnDispoKepala" id ="btnDispoKepala" >
								</div>
							<?php }else{ ?>
								<div class="modal-body">
								<span>Tidak dapat untuk mendisposisikan file, karena telah melebihi batas deadline. </span>
								</div>
							<?php  } ?>
							</div>
							</div>
						</div>
					</div>
					<!-- //---------------------------------------------------------------------modal untuk delete disposisi dari kepala ke staf ------------------------------------------- -->
					<div class="modal fade" id="delete-data-modal" role="dialog" style="text-align:left;">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background:#737373;">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"> <label id="dispo"> <li class="fa fa-exclamation-triangle "></li> DISPOSITION WARNING !</label> </h4>
								</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-xs-12">
												<div class="form-group">
													<label>Do you really to delete the disposition file with this user ?</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12">
												<div class="form-group">
													<label>Id File:</label>
													<input type="text" name="id" id="id" class="form-control" readonly="true">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12">
												<div class="form-group">
													<label>Name:</label>
													<input type="text" name="name" id="name" class="form-control" readonly="true" style= "min-width: 100%">
												</div>
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<input type="submit" name="deletedisposisi" id="deletedisposisi" class="btn btn-danger" style="width:30%;" value="Yes, Delete This Dispo."/>
									</div>

					 		</div>
						</div>
					</div>
					<!-- //---------------------------------------------------------------------modal untuk delete disposisi dari kepala ke staf ------------------------------------------- -->
					<div class="box-content box-content-butt" style="border: 1px solid black;">
						<table class="table table-striped table-bordered bootstrap-datatable datatable" >
						<thead style="background: #808080; color:#fff;">
							<tr>
								<th>No. </th>
								<th>Disposition To</th>
								<th>Disposition Date</th>
								<?php if ($code == 01) { ?>
								<th>Seen</th>
								<th>Seen Date</th>
								<th>Doing Date</th>
								<th>Deadline Date</th>
								<th>Action</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php
							$dispokepala_array =  get_data_disposisi_kepala("SELECT * FROM kepala where kode_file_asal LIKE '".$idfile."'");
							$jum = count($dispokepala_array);
							$per_hal=5;
							$halaman=ceil($jum / $per_hal);
							$page = isset($_GET['page'])? (int)$_GET['page'] : 1;
							$start = ($page - 1) * $per_hal;
							$no = $start+1;

							$dispo_kepala_array = get_data_disposisi_kepala("SELECT * FROM kepala where kode_file_asal LIKE '".$idfile."' LIMIT $start, $per_hal");
							if(count($dispo_kepala_array) > 0):
								foreach($dispo_kepala_array as $rowdispo):?>
									<tr>
										<td><?php echo $no++; ?></td>
										<?php $user = $rowdispo['iduser_staf'];
										$user_array = get_all_user("SELECT * FROM user where iduser LIKE '".$user."'");
										if(count($user_array) > 0):
											foreach($user_array as $row):?>
												<td><?php echo $row['nama']; ?></td>
										<?php endforeach; endif; ?>
										<td><?php echo $rowdispo['tgl_disposisi']; ?></td>
										<?php if ($code == 01) { ?> <!-- //action delete hanya bisa untuk kepala -->
										<?php if ($rowdispo['status_dibaca'] == 1) {?>
											<td><li class="fa fa-eye"></li> <?php echo $rowdispo['view']; ?> times.</td>
										<?php }else{?>
											<td><li class="fa fa-eye-slash"></li> <?php echo $rowdispo['view']; ?> times.</td>
										<?php } ?>
										<td><?php echo $rowdispo['tgl_dibaca']; ?></td>
										<td><?php echo $rowdispo['tgl_dikerjakan']; ?></td>
										<td><?php echo $rowdispo['tgl_deadline']; ?></td>
											<td>
												<button type="button" name="delete" id="<?php echo $rowdispo['idfile']; ?>" class="delete-data-modal btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-data-modal"><li  class='fa fa-trash-o'></li>
													<div class="hidden name"><?php echo $row['nama']; ?></div>
												</button>
											</td>
										<?php } ?>
									</tr>
								<?php endforeach; else: ?>
									<tr style="text-align:center;">
										<!-- <?php if($code == 01){ ?> tampilan kepala -->
											<td colspan="8"> --- No File Disposition --- </td>
										<?php }else{ ?>
											<td colspan="6"> --- No File Disposition --- </td>
										<?php } ?>

									</tr>
								<?php endif; ?>
						</tbody>
					</table>
					<div class="row" style="height:80px;">
						<div class="col-xs-12" style="text-align:center">
							<div class="pagination pagination-centered">
								<ul class="pagination">
									<?php
														if($halaman == 1){}
														elseif($halaman == 0){}
														elseif($_GET['page'] == 1){}
														else{$now = $page-1; echo "<li><a href='detail-disposisi-file.php?id=$idfile&&page=$now'><i class='fa fa-chevron-left'></i></a></li>";}
														for($x=1;$x<=$halaman;$x++){
															if($page == $x){
															echo "<li><a  href='detail-disposisi-file.php?id=$idfile&&page=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
															}else{
															echo "<li><a  href='detail-disposisi-file.php?id=$idfile&&page=$x'>$x</a></li>";
															}
														}
										?>
										<?php
														if($halaman == $page){}
														elseif($_GET['page'] < $halaman) {
															$now = $page+1;
															echo "<li><a href='detail-disposisi-file.php?id=$idfile&&page=$now'><i class='fa fa-chevron-right'></i></a></li>";
														}
										?>
								</ul>
							</div>
						</div>
					</div>
			</div>
		</div>

		<div class="box" style="text-align:right;">
			<div class="box-content">

				 <style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
				 <a class="take_print" href="printDisposisi.php?id=<?php echo $idfile;?>"><button type="button" style="background:#3498db;color:#FFF;" class="btn"><i class="fa fa-print"></i>  Print Data</button></a>
				 <input type="submit" name="btnEmail" id="btnEmail" class="btn btn-success" value="&#xf003; Email Me"/>
				 <input type="submit" style="background:#f4a742;color:#FFF;" class="btn" name="smsme" id="smsme" value="&#xf0e0; SMS Me"/>

			</div>
		</div><br>

		</div>

  </div>
</div>
</div>
		</form>
  </section>
</section>

<!--main content end-->


      <!--footer start-->
      <footer class="site-footer" style="background: #737373;">
          <div class="text-center">
               &copy; 2017 Complaint Handling and Services Division BPJS Ketenagakerjaan.
              <a href="homeKepala.php" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
		<script type="text/javascript" src="assets/jquery3.1.1/jquery.js"></script>
		<script type="text/javascript" src="assets/jquery3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="assets/jquery3.1.1/jquery-ui.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>

    <script src="assets/js/bootstrap-daterangepicker/advanced-form-components.js"></script>
    <script src="assets/js/bootstrap-daterangepicker/date.js"></script>
    <script src="assets/js/bootstrap-daterangepicker/datepicker.js"></script>
    <script src="assets/js/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
    <!-- batas -->
   <script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>
    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>
    <script src="assets/js/zabuto_calendar.js"></script>
		<script>
			$(document).ready(function() {
				$("#btnEmail").click(function(){
					$("#success").show().delay(8000).fadeOut();
					return true;
				});
			});
		</script>
		<script>
			$(".delete-data-modal").click( function(){
				var id = $(this).attr("id");
				name = $(this).find(".name").html();
				$("#delete-data-modal input[name=id]").val(id);
				$("#delete-data-modal input[name=name]").val(name);
			});

			$("#btnDone").click(function(){
				$("#success").hide();
        return true;
				// document.getElementById('btnDone').style.backgroundColor='Red';
				// document.getElementById('btnDone').value = "sudah dikerjakan";
				// document.getElementById('doneform').action = 'save-disposisi-share.php';
			});
		</script>
	</body>
</html>
<?php }
}?>
