<?php
	session_start();
		if (!isset($_SESSION['iduser']))
		{
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ../index.php">';
		  exit;
		}else{
			require_once("database.php");
			$id = $_SESSION['iduser'];
			$idfile= $_GET['id'];
			$code = substr($id, 2, 2);
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

    <link rel="stylesheet" type="text/css" href="assets/js/pdf/pdfstyle.css"/>

    <link rel="stylesheet" href="assets/js/autocomplete/bootstrap-chosen.css">
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-timepicker/js/wickedpicker.min.css"/>

    <link href="assets/css/custom.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/style-responsive.css" type="text/css" rel="stylesheet"/>
<!-- loading indicator -->

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"/>

		<style media="screen">
			input[type="submit"] {
					font-family: FontAwesome;
			}
			.modal-dialog{
    			overflow-y: initial !important
			}
			.scroll{
			    height: 150px;
			    overflow-y: auto;
			}
			.datepicker{z-index:9999 !important}

			<?php if ($code != 02) {?>
				#Iframe-Cicis-Menu-To-Go {
					max-width: 900px;
					max-height: 794px;
				}
				.responsive-wrapper {
				  position: relative;
				  height: 794px;
				  overflow: hidden;
				}
			<?php }else{ ?>
				#Iframe-Cicis-Menu-To-Go {
					max-width: 900px;
					max-height: 887px;
				}
				.responsive-wrapper {
				  position: relative;
				  height: 887px;
				  overflow: hidden;
				}
		<?php	} ?>

		</style>

  </head>

  <body>

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
																	<?php $dispo_file = get_data_disposisi_kepala("SELECT * FROM kepala WHERE iduser_staf LIKE '".$id."' and status_dibaca = 0");
																	if (count($dispo_file) > 0) { ?>
																		<span class="badge bg-theme" style="background:#3498db;"><?php echo count($dispo_file);?></span>
																	<?php } ?>
															</a>
													<ul class="dropdown-menu extended inbox">
														<div class="notify-arrow notify-arrow-green"></div>
														<li><p class="green" style="font-size:0.8em;">You have <?php echo count($dispo_file);?> new disposisi messages</p></li>
														<?php $dispo_array = get_data_disposisi_kepala("SELECT * FROM kepala WHERE iduser_staf LIKE '".$id."' and status_dibaca = 0");
														if (count($dispo_array) > 0) {
															foreach($dispo_array as $row) {
																$idfile = $row['idfile']; ?>
																	<li>
																		<a href="detail-disposisi-file.php?id=<?php echo $idfile;?>&page=1">
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
																<?php $dispo = get_data_disposisi_file("SELECT * FROM disposisi_file WHERE iduser LIKE '".$id."' and status_dibaca = 0");
																if (count($dispo) > 0) { ?>
																	<span class="badge bg-theme" style="background:#3498db;"><?php echo count($dispo);?></span>
																<?php } ?>
														</a>
												<ul class="dropdown-menu extended inbox">
													 <div class="notify-arrow notify-arrow-green"></div>
													 <li><p class="green" style="font-size:0.8em;">You have <?php echo count($dispo);?> new disposisi messages</p></li>
													 <?php
													 if (count($dispo) > 0) {
														 foreach($dispo as $rows) {
															 $idfile = $rows['idfile']; ?>
																 <li>
																	 <a href="detail-disposisi-file.php?id=<?php echo $idfile;?>&page=1">
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
					<?php
						$idfile = $_GET['id'];
						require_once("database.php");
						$file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
						if(count($file_array) > 0){
							foreach($file_array as $row){ ?>
          <div class="col-md-3 col-xs-12" style="margin-top:1%">
            <ol class="breadcrumb">
							<?php if ($row['jenis_file'] == "Memo Masuk"): ?>
											<li class="breadcrumb-item"><a href="memo-masuk.php">Back</a></li>
							<?php elseif ($row['jenis_file'] == "Memo Keluar"): ?>
											<li class="breadcrumb-item"><a href="memo-keluar.php">Back</a></li>
							<?php elseif ($row['jenis_file'] == "Surat Masuk"): ?>
											<li class="breadcrumb-item"><a href="surat-masuk.php">Back</a></li>
							<?php elseif ($row['jenis_file'] == "Surat Keluar"): ?>
											<li class="breadcrumb-item"><a href="surat-keluar.php">Back</a></li>
							<?php elseif ($row['jenis_file'] == "Surat Edaran"): ?>
											<li class="breadcrumb-item"><a href="surat-edaran.php">Back</a></li>
							<?php elseif ($row['jenis_file'] == "Surat Keputusan"): ?>
											<li class="breadcrumb-item"><a href="surat-keputusan.php">Back</a></li>
							<?php elseif ($row['jenis_file'] == "Peraturan Difeksi"): ?>
											<li class="breadcrumb-item"><a href="peraturan-difeksi.php">Back</a></li>
							<?php elseif ($row['jenis_file'] == "Surat Perintah"): ?>
											<li class="breadcrumb-item"><a href="surat-perintah.php">Back</a></li>
							<?php endif; ?>

              <li class="breadcrumb-item"><b>Detail File "<?php echo  $row['jenis_file']; ?>"</b></li>
            </ol>
          </div><!-- /rowmt -->

					<div class="panel panel-default" style="margin-left:1%; margin-right:1%; margin-top:6%;">
						<div class="panel-body">
							<form action="save-disposisi-share.php" enctype="multipart/form-data"  method="post" id="fileform">
						<!-- ----------------------------------------------------------------------- Batas Detail File ----------------------------------------------------------------------- -->
							<div class="row">
								<div class="col-lg-12">
									<style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
			   				 <a class="take_print" href="printDetailFile.php?id=<?php echo $idfile;?>"><button type="button" style="margin-right:1%; float:right; background:#3498db;color:#FFF;" class="btn"><i class="fa fa-print"></i>  Print Data</button></a>
							 </div><br>
							</div>
								<div class="row" style="padding-top:1%;">
									<div class="col-lg-12">
										<div class="col-lg-6 col-xs-12">
											<div class="box">
												<div id="Iframe-Cicis-Menu-To-Go" class="set-margin-cicis-menu-to-go set-padding-cicis-menu-to-go set-border-cicis-menu-to-go set-box-shadow-cicis-menu-to-go center-block-horiz">
													<div class="responsive-wrapper responsive-wrapper-padding-bottom-90pct" style="-webkit-overflow-scrolling: touch;">
																<iframe src="assets/file_dokumen/<?php echo $idfile;?>/<?php echo $idfile;?>.pdf"></iframe>
													</div>
												</div>
											</div>
										</div>
                  	<div class="col-lg-6 col-xs-12">
                      <div class="box" style="background:white;" >
                      	<div class="form" style="border: 1px solid black;">
                        	<div class= "white-header-group" >
														<span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-2x" style="float:left; margin-left: 10px; margin-top:6px;"></i> <h4 style="float:left;"> &nbsp; &nbsp; Detail Document</h4></span>
                        	</div>
				                      <div style=" margin: 4% 3%;">
																<div class="alert alert-success" id="success" style="display:none;">
							 								    <strong>Successfully, file updated.</strong>
							 								  </div>
							 									<div class="alert alert-danger" id="fail"  style="display:none;">
							 										<strong>Warning, field cannot empty!.</strong>
							 									</div>
				                        <div class="form-group">
				                          <label>File Uploaded by: </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
																		<?php
																			$iduserupload = $row['iduser'];
																			$userdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduserupload."'");
																			if(count($userdata_array) > 0){
																				foreach($userdata_array as $rowuserupload){ ?>
				                            			<input type="text" class="form-control" id="filefrom" readonly="true" value="<?php echo $rowuserupload['nama'];?>"/>
																		<?php }}?>
																	</div>
				                        </div>

				                        <div class="form-group">
				                          <label>File ID : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                            <input type="text" class="form-control" name="noDoc" id="noDoc" readonly="true" value="<?php echo $row['idfile'];?>" />
				                          </div>
				                        </div>

				                        <div class="form-group">
				                          <label>File Category : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
				                            <!-- <input type="text" class="form-control disabled" disabled="" value="" /> -->

																		<select class="form-control disabled" disabled="" id="category" name="category">
																			<option><?php echo $row['jenis_file'];?></option>
																			<option>Memo Masuk</option>
																			<option>Memo Keluar</option>
																			<option>Surat Masuk</option>
																			<option>Surat Keluar</option>
																			<option>Surat Edaran</option>
																			<option>Surat Keputusan</option>
																			<option>Peraturan Difeksi</option>
																			<option>Surat Perintah</option>
																		</select>
				                          </div>
				                        </div>

				                        <div class="form-group">
				                          <label>File Received by : </label>
				                          <div class="input-group">
				                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
				                              <!-- <input type="text" class="form-control disabled" disabled="" value=""/> -->
																			<select class="form-control disabled" disabled="" id="memoby" name="memoby">
																				<option><?php echo $row['asal_file'];?></option>
																				<?php
																					require_once("database.php");
																					$quote_array = get_all_user("SELECT * FROM user");
																					if(count($quote_array) > 0){
																						foreach($quote_array as $rows){ ?>
																						<option><?php echo $rows['nama']; ?></option>
																				<?php }} ?>
																			</select>
				                          </div>
				                        </div>

				                        <div class="form-group">
				                          <label>File Number : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-file-text-o "></i></span>
				                            <input type="text" name="nofile" id="nofile" class="form-control disabled" disabled="" value="<?php echo $row['no_file'];?>" />
				                          </div>
				                        </div>

				                        <div class="form-group">
				                          <label>Date of File Received: </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
				                            <input type="text" class="form-control dpd1 disabled" disabled="" name="tglasal" id="tglasal" value="<?php echo $row['tgl_asal_file'];?>">
				                          </div>
				                        </div>

				                        <div class="form-group">
				                          <label >Date of File : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
				                            <input type="text" class="form-control dpd1 disabled" disabled="" name="tglupload" id="tglupload" value="<?php echo $row['tgl_upload'];?>">
				                          </div>
				                        </div>

				                        <div class="form-group">
				                          <label>File Title : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-file-text "></i></span>
																		  <input type="text" class="form-control disabled" disabled="" name="title" id="title" value="<?php echo $row['nama_file'];?>">
				                          </div>
				                        </div>

																<div class="form-group">
				                          <label>Adding Information : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-file-text "></i></span>
																		  <textarea name="addinginfo" class="form-control disabled" disabled="" name="addinginfo" id="addinginfo" ><?php echo strip_tags($row['detail_dokumen']);?></textarea>
				                          </div>

																 <!-- <div class="box-content box-content-butt mceNonEditable">
																	 <script type="text/javascript" src="assets/tinymce/tinymce.min.js"></script>
																	 <script>
																	 tinymce.init({

																		 selector: "textarea#elm1",
																		 theme : "modern",
																		 height: 300,
																		 resize: false,
																		 plugins: [
																				"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
																				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
																				"save table contextmenu directionality emoticons template paste textcolor"
																			],
																			content_css: "css/content.css",
																			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
																			style_formats: [
																			 {title: 'Bold text', inline: 'b'},
																			 {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
																			 {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
																			 {title: 'Example 1', inline: 'span', classes: 'example1'},
																			 {title: 'Example 2', inline: 'span', classes: 'example2'},
																			 {title: 'Table styles'},
																			 {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
																		 ]
																	 });


																	 </script>
																	 <textarea id="elm1" name="data" style="width:100%;resize:none;overflow-y:hidden" readonly="true"><?php echo $row['detail_dokumen'];?></textarea><br/>
																 </div> -->
				                        </div>

																<label id="label" style="display:none;">Update File : </label>
																<div class="form-group form-control" id="block" style="display:none; height:40%;">
																	<input type="file" id="uploadNewFile" class="btn" name="uploadNewFile">
																</div> <br>

																<?php
																	if ($code == 02) {?>
																		<div style="text-align:right; ">
																			 <button type="button" name="edit" id="edit" class="btn btn-primary" onclick="showButtons();" style="width:100px;">Edit</button>
																		</div>
													          <div class="col-xs-12 row">
													            <div class="col-xs-6" style="text-align:right; ">
													              <input type="submit" name="savedetail" id="savedetail" value="Submit" class="btn btn-success" style="width:80px; display:none;">
													            </div>
													            <div class="col-xs-6" style="text-align:left;">
													              <button type="button" name="canceldetail" id="canceldetail" class="btn btn-danger" style="width:80px; display:none;" onclick="location.href='detail-submenu.php?id=<?php echo $idfile;?>&&page1=1&&page2=1'">Cancel</button>
													            </div>
													          </div> <br>
				                      </div>
													<?php } }} ?>
                      </div>
										</div> <br>
									</div>

								</div>
							</div>

	<!-- ----------------------------------------------------------------------- Batas Detail File ----------------------------------------------------------------------- -->
	<!-- ----------------------------------------------------------------------- Disposisi sekretaris to Kepala ---------------------------------------------------------- -->
<div class="row" style="padding:1%;">
	<div class="col-lg-12">
		<div class="col-lg-6 col-xs-12">
			<div class="box">
				<div class="box-header">
					<span class="input-group-addon" style="background-color:#595959; color:#fff; height:5%;">
						<span style="background-color:#595959; color:#fff;"><i class="fa fa-file-text fa-2x" style="float:left; margin-left: 1px; margin-top:5px;"></i> <h4 style="float:left;">&nbsp; &nbsp; List Disposition For Head</h4></span>
						<?php if($code == 02){ ?>
							<button  class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal"style="float:right;"><i class="fa fa-plus"></i> Disposisi</button>
					  <?php } ?>
			 		</span>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="myModal" role="dialog" >
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header" style="background: #737373;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Success Disposisi</h4>
						</div>
						<form action="save-disposisi-share.php" method="post">
						<div class="modal-body">
							<?php
							$disposisi = get_data_disposisi_file("SELECT * FROM disposisi_file WHERE kode_file LIKE '".$idfile."'");
							if(count($disposisi) > 0){
								foreach($disposisi as $row){
									$tgldispo = $row['tgl_disposisi']; ?>
									<span>File sudah didisposisikan kepada kepala pada tanggal <?php echo $tgldispo;?>.</span>
									<div class="modal-footer">
										<button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
									</div>
								<?php }
							}else{ ?>
								<span>File berhasil didisposisikan kepada kepala.</span>
								<div class="modal-footer">
									<input type="submit" class="btn btn-primary" value="OK" name="btnDispo" id="btnDispo" />
								</div>
						<?php } ?>
						</div>

						</form>
					</div>
				</div>
			</div>
	<!-- ----------------------------------------------------------------------- Disposisi sekretaris to Kepala ---------------------------------------------------------- -->
	<!-- ---------------------------------------------------------------------- delete tujuan disposisi------------------------------------------------------------- -->
			<div class="modal fade" id="delete-data-modal" role="dialog" style="text-align:left;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background:#737373;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"> <label id="dispo"> <li class="fa fa-exclamation-triangle "></li> DISPOSISI WARNING !</label> <label id="share"><li class="fa fa-exclamation-triangle "></li>  SHARE WARNING !</label> </h4>
						</div>

							<div class="modal-body">
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group">
											<label>Do you really to delete this share with this user?</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-xs-12">
										<label>Id File:</label>
										<div class="form-group">
											<input type="text" name="id" id="id" class="form-control" readonly="true">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12">
										<label>Name:</label>
										<div class="form-group">
											<input type="text" name="name" id="name" class="form-control" readonly="true" style= "min-width: 100%">
										</div>
									</div>
								</div>

							</div>
							<div class="modal-footer">
								<input type="submit" name="btnDeleteDispo" id="btnDeleteDispo" class="btn btn-danger" style="width:30%;" value="Yes, Delete This Dispo."/>
								<input type="submit" name="btnDeleteShare" id="btnDeleteShare" class="btn btn-danger" style="width:30%;" value="Yes, Delete This Share."/>
							</div>

			 </div>
			</div>
			</div>
<!-- ---------------------------------------------------------------------- delete tujuan disposisi------------------------------------------------------------- -->
<!-- ---------------------------------------------------------------------- tabel hasil disposisi ------------------------------------------------------------- -->

			<div class="box-content box-content-butt" style="border: 1px solid black;">
				<table class="table table-striped table-bordered bootstrap-datatable datatable" >
				<thead style="background: #808080; color:#fff;">
					<tr>
						<th>Disposisi To</th>
						<th>Disposisi Date</th>
						<?php if($code == 02){ ?>
							<th>Action</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
					$disposisi_array =  get_data_disposisi_file("SELECT * FROM disposisi_file where kode_file LIKE'".$idfile ."'");
					$jum = count($disposisi_array);
					$per_hal = 3;
					$halaman=ceil($jum / $per_hal);
					$page = isset($_GET['page1'])? (int)$_GET['page1'] : 1;
					$start = ($page - 1) * $per_hal;

						$disposisi_array = get_data_disposisi_file("SELECT * FROM disposisi_file where kode_file LIKE'".$idfile ."' LIMIT $start, $per_hal");
						if(count($disposisi_array) > 0):
								foreach($disposisi_array as $rowdispo):
									$iduser = $rowdispo['iduser']; ?>
									<tr>
									<?php $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduser."'");
										if(count($getuserdata_array) > 0):
											foreach($getuserdata_array as $rowuser): ?>
												<td scope="row"><?php echo $rowuser['nama'];?></td>
									<?php endforeach;  endif; ?>
												<td><?php echo $rowdispo['tgl_disposisi'];?></td>
												<?php if($code == 02){ ?>
													<!-- <td><input type="submit" value="&#xf014;" class="btn btn-xs btn-danger"></td> -->
												<td>
													<button type="button" name="delete" id="<?php echo $rowdispo['idfile']; ?>" class="delete-data-dispo btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-data-modal"><li  class='fa fa-trash-o'></li>
														<div class="hidden name"><?php echo $rowuser['nama']; ?></div>
													</button>
												</td>
												<?php } ?>
									</tr>
					 <?php endforeach;  else: ?>
								<?php if($code == 02){ ?>
									<tr style="text-align:center;">
										<td colspan="4"> --- Has never been to disposition --- </td>
									</tr>
								<?php }else{ ?>
									<tr style="text-align:center;">
										<td colspan="3"> --- Has never been to disposition --- </td>
									</tr>
					 <?php } endif; ?>
				</tbody>
			</table>

			<div class="row" >
				<div class="col-xs-12" style="text-align:center">
					<div class="pagination pagination-centered"  style="margin-top:0px; margin-bottom:0px;">
						<ul class="pagination">
							<?php
												if($halaman == 1){}
												elseif($halaman == 0){}
												elseif($_GET['page1'] == 1){}
												else{$now = $page-1; echo "<li><a href='detail-submenu.php?id=$idfile&&page1=$now&&page2=1'><i class='fa fa-chevron-left'></i></a></li>";}
												for($x=1;$x<=$halaman;$x++){
													if($page == $x){
													echo "<li><a  href='detail-submenu.php?id=$idfile&&page1=$x&&page2=1'><b style='color:#FFCA0C'>$x</b></a></li>";
													}else{
													echo "<li><a  href='detail-submenu.php?id=$idfile&&page1=$x&&page2=1'>$x</a></li>";
													}
												}
								?>
								<?php
												if($halaman == $page){}
												elseif($_GET['page1'] < $halaman) {
													$now = $page+1;
													echo "<li><a href='detail-submenu.php?id=$idfile&&page1=$now&&page2=1'><i class='fa fa-chevron-right'></i></a></li>";
												}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
<!-- ---------------------------------------------------------------------- tabel hasil disposisi ------------------------------------------------------------- -->
		</div><br>
	</div>

  <div class="col-lg-6 col-xs-12">
	  <div class="box">
        <div class="box-header" style="">
            <span class="input-group-addon" style="background-color:#595959; color:#fff;">

							<span style="background-color:#595959; color:#fff;"><i class="fa fa-link fa-2x" style="float:left; margin-left: 1px; margin-top:5px;"></i> <h4 style="float:left;">&nbsp; &nbsp; List File Sharing</h4></span>
							<?php if($code == 02){ ?>
              	<button  class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal2" style="float:right;"><i class="fa fa-plus"></i> Share</button>
							<?php } ?>
						</span>
            <!-- Modal -->
            <div class="modal fade" id="myModal2" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header" style="background: #737373;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Share Form</h4>
                  </div>

                  <div class="modal-body">
										<div class="form-group" style="height:auto; overflow: auto;">
											<label>Share to :</label>
											<div class="control-panel col-lg-12 col-xs-12 scroll"><br>
												<ul>
													<?php
														require_once("database.php");
														$user_array = get_all_user("SELECT * FROM user");$perbandingan2 = 0;
														if(count($user_array) > 0):
															foreach($user_array as $row): $id = $row['iduser'];
																$kode = substr($id,2,2);
																if ($kode != 04 && $kode != 02) {
																	$share_array = get_data_share_file("SELECT * FROM share_file where kode_file LIKE'".$idfile."' AND iduser LIKE'".$id ."'");
																	if(count($share_array) == 0){
																		$perbandingan2 = $perbandingan2 + 1; ?>
																		<li> <input type="checkbox" name="check_list[]" value="<?php echo $row['iduser']; ?>_<?php echo $row['nama']; ?>">   <label><?php echo $row['iduser']; ?>_<?php echo $row['nama']; ?></label></li>
																	<?php }
																 }
															endforeach; if($perbandingan2 == 0){ ?>
																<li> All users have been got share file. </li>
															<?php  } endif; ?>
												</ul>
											</div>
										</div>
                  </div><br>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Share" name="btnShare">
                  </div>

                </div>

              </div>
            </div>
        </div>

      <div class="box-content box-content-butt" style="border: 1px solid black;">
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead style="background: #808080; color:#fff;">
          <tr>
            <th>Share File To</th>
						<th>Share Date</th>
						<?php if($code == 02){ ?>
							<th>Action</th>
						<?php } ?>
          </tr>
        </thead>
				<tbody>
					<?php
					$share_array =  get_data_share_file("SELECT * FROM share_file where kode_file LIKE'".$idfile ."'");
					$jum = count($share_array);
					$per_hal = 3;
					$halaman=ceil($jum / $per_hal);
					$page = isset($_GET['page2'])? (int)$_GET['page2'] : 1;
					$start = ($page - 1) * $per_hal;

						$share_array = get_data_share_file("SELECT * FROM share_file where kode_file LIKE'".$idfile ."'  LIMIT $start, $per_hal");
						if(count($share_array) > 0):
								foreach($share_array as $rowshare):
									$iduser = $rowshare['iduser']; ?>
									<tr>
									<?php $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduser."'");
										if(count($getuserdata_array) > 0):
											foreach($getuserdata_array as $rowuser): ?>
												<td scope="row"><?php echo $rowuser['nama'];?></td>
									<?php endforeach;  endif; ?>
												<td><?php echo $rowshare['tgl_share'];?></td>
												<?php if($code == 02){ ?>
													<td>
														<button type="button" name="delete" id="<?php echo $rowshare['idfile']; ?>" class="delete-data-share btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-data-modal"><li  class='fa fa-trash-o'></li>
															<div class="hidden name"><?php echo $rowuser['nama']; ?></div>
															<div class="hidden type"><?php echo "[Share]: "; ?></div>
														</button>
													</td>
												<?php } ?>
									</tr>
								<?php endforeach;  else: ?>
		 						 <?php if($code == 02){ ?>
		 									<tr style="text-align:center;">
		 										<td colspan="3"> --- Has never been to share --- </td>
		 									</tr>
		 						<?php }else{ ?>
		 							<tr style="text-align:center;">
		 								<td colspan="2"> --- Has never been to share --- </td>
		 							</tr>
		 					 <?php } endif; ?>
				</tbody>
      </table>
			<div class="row">
				<div class="col-xs-12 row" style="text-align:center">
					<div class="pagination pagination-centered" style="margin-top:0px; margin-bottom:0px;">
						<ul class="pagination">
							<?php
												if($halaman == 1){}
												elseif($halaman == 0){}
												elseif($_GET['page2'] == 1){}
												else{$now = $page-1; echo "<li><a href='detail-submenu.php?id=$idfile&&page1=1&&page2=$now'><i class='fa fa-chevron-left'></i></a></li>";}
												for($x=1;$x<=$halaman;$x++){
													if($page == $x){
													echo "<li><a  href='detail-submenu.php?id=$idfile&&page1=1&&page2=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
													}else{
													echo "<li><a  href='detail-submenu.php?id=$idfile&&page1=1&&page2=$x'>$x</a></li>";
													}
												}
								?>
								<?php
												if($halaman == $page){}
												elseif($_GET['page2'] < $halaman) {
													$now = $page+1;
													echo "<li><a href='detail-submenu.php?id=$idfile&&page1=1&&page2=$now'><i class='fa fa-chevron-right'></i></a></li>";
												}
								?>
						</ul>
					</div>
				</div>
			</div>
    </div>
  </div>
</div>
</div>
</div>

					</form>
			</div>
		</div>
	</section>
</section>
<!--main content end-->


  <!--footer start-->
  <footer class="site-footer" style="background: #737373;">
      <div class="text-center">
           &copy; 2017 Complaint Handling and Services Division BPJS Ketenagakerjaan.
          <a href="detail-submenu.php?id=<?php echo $idfile;?>&&page1=1&&page2=1" class="go-top">
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

		<!-- <script>
			// tinymce.activeEditor.getBody().setAttribute('contenteditable', false);
			// tinymce.activeEditor.setMode('readonly');

			$(document).ready(function() {
				$("#fileform").submit(function(e) {
							if ($('#category').val() == "" || $('#memoby').val() == "" || $('#nofile').val() == "" || $('#tglasal').val() == "" || $('#tglupload').val() == "" || $('#title').val() == "" || $('#addinginfo').val() == "" || $('#uploadNewFile').val() == "") {
								$("#fail").show().delay(5000).fadeOut();
	 						 	$("#success").hide();
	 						 	return false;
						 } else{
							 	$("#success").show().delay(8000).fadeOut();
								$("#fail").hide();
								return true;
						 }
				});
			});
		</script> -->

		<script type="text/javascript">
		$(".delete-data-dispo").click( function(){
			var id = $(this).attr("id");
			name = $(this).find(".name").html();
			$("#delete-data-modal input[name=id]").val(id);
			$("#delete-data-modal input[name=name]").val(name);

			document.getElementById("share").style.display = "none";
			document.getElementById("btnDeleteShare").style.display = "none";
			document.getElementById("dispo").style.display = "block";
			document.getElementById("btnDeleteDispo").style.display = "block";
		});

		$(".delete-data-share").click( function(){
			var id = $(this).attr("id");
			name = $(this).find(".name").html();
			$("#delete-data-modal input[name=id]").val(id);
			$("#delete-data-modal input[name=name]").val(name);

			document.getElementById("dispo").style.display = "none";
			document.getElementById("btnDeleteDispo").style.display = "none";
			document.getElementById("share").style.display = "block";
			document.getElementById("btnDeleteShare").style.display = "block";
		});

		function showButtons () { $('#label, #block, #savedetail, #canceldetail').show(); $('#edit').hide(); $('.disabled').prop("disabled", false); }

		// function back() { $('#label, #block, #savedetail, #canceldetail').hide(); $('#edit').show(); $('.disabled').prop("disabled", true); document.getElementById('canceldetail').action = 'detail-submenu.php?id=$idfile&&page1=1&&page2=1';}

		</script>
  </body>
</html>
<?php }
}?>
