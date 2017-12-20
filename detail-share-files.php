 <?php
	session_start();
		if (!isset($_SESSION['iduser']))
		{
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ../index.php">';
		  exit;
		}else{
      require_once("database.php");
      $iduser = $_SESSION['iduser'];
			$id= $_GET['id'];
    	$idfile = substr($id, 0, 28);
      $tujuanuser = substr($id, -8);
      $getcodeuser = substr($_SESSION['iduser'], 2, 2);

			if ($getcodeuser == 01 || $getcodeuser == 03 ) {
				$date_now = date("y-m-d"); $time_now = date("h:i:sa");
				$share_file = get_data_share_file("SELECT * FROM share_file WHERE idfile LIKE '".$id."' ");
				if(count($share_file) > 0){
					foreach($share_file as $row){
						$view = $row['view'] + 1;
						if ($row['status_dibaca'] == 0) {
							$query = update_status_file("UPDATE share_file SET status_dibaca = '1', tgl_dibaca='$date_now', jam_dibaca='$time_now',view='$view' WHERE idfile LIKE '".$id."'");
						}else{
							$query = update_status_file("UPDATE share_file SET view='$view' where idfile LIKE '".$id."'");
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

    <script src="assets/js/chart-master/Chart.js"></script>
		<style media="screen">
			input[type="submit"] {
					font-family: FontAwesome;
			}
      #Iframe-Cicis-Menu-To-Go {
        max-width: 900px;
        max-height: 857px;
      }

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
                        <?php if($getcodeuser == 03){ ?>
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
                            <li><p class="green" style="font-size:0.8em;">You have <?php echo count($dispo_file);?> new disposisi messages</p></li>
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
                      <?php }elseif($getcodeuser == 01){ ?>
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
                           <li><p class="green" style="font-size:0.8em;">You have <?php echo count($dispo);?> new disposisi messages</p></li>
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
          <div class="col-md-3 col-xs-12" style="margin-top:1%">
            <ol class="breadcrumb">

              <li class="breadcrumb-item"><a href="sharefile.php?page=1">Back</a></li>
              <li class="breadcrumb-item"><b>Detail Share File</b></li>
            </ol>
          </div><!-- /rowmt -->
          <form action="save-disposisi-share.php" method="post" id="formsubmit">
          <div class="panel panel-body" style="margin-top:5%">
              <div class="row">
								<div class="col-lg-12">
                    <div class="alert alert-success" id="success" style="display:none;">
  									  <strong>File has been sent to share.</strong>
  								  </div>
                  <div class="col-lg-6 col-xs-12">
                      <div class="box">
                        <div class="form" style="border:1px solid black;">
                        <div class="white-header-group" >
													<span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-2x" style="float:left; margin-left: 10px; margin-top:6px;"></i> <h4 style="float:left;">&nbsp; &nbsp; Detail Document</h4></span>
                        </div>
												<?php
													require_once("database.php");
													$file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
													if(count($file_array) > 0):
														foreach($file_array as $row): ?>
				                      <div style=" margin: 4% 3%;">

                                <div class="form-group">
                                  <label>Sharing File To : </label>
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <?php
                                      $userdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$tujuanuser."'");
                                      if(count($userdata_array) > 0):
                                        foreach($userdata_array as $tujuan): ?>
                                          <input type="text" class="form-control" id="uploader" name="uploader" readonly="true" value="<?php echo $tujuan['nama'];?>"/>
                                    <?php endforeach;  endif; ?>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-lg-12 col-xs-12">
                                    <div class="form-group col-lg-6 col-xs-12" style="padding-left:0px;">
    				                          <label>File Uploaded By: </label>
    				                          <div class="input-group">
    				                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
    																		<?php
    																			$iduserupload = $row['iduser'];
    																			$userdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduserupload."'");
    																			if(count($userdata_array) > 0):
    																				foreach($userdata_array as $rowuserupload): ?>
    				                            			<input type="text" class="form-control" id="uploader" name="uploader" readonly="true" value="<?php echo $rowuserupload['nama'];?>"/>
    																		<?php endforeach;  endif; ?>
    																	</div>
    				                        </div>

                                    <div class="form-group col-lg-6 col-xs-12" style="padding-right:0px;">
    				                          <label>File By : </label>
    				                          <div class="input-group">
    				                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
    				                              <input type="text" class="form-control display" id="asalfile" name="asalfile" readonly="true"  value="<?php echo $row['asal_file'];?>"/>
    				                          </div>
    				                        </div>

                                  </div>
                                </div>


				                        <div class="form-group">
				                          <label>File ID : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
				                            <input type="text" class="form-control" id="noDoc" name="noDoc" readonly="true"; value="<?php echo $row['idfile'];?>" />
				                          </div>
				                        </div>

				                        <div class="form-group">
				                          <label>File Category : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
				                            <input type="text" class="form-control display" id="category" name="category" readonly="true" value="<?php echo $row['jenis_file'];?>" style="display:;"/>
                                    <!-- <select class="form-control" id="category2" name="category2" readonly="false"; style="display:none;">
																			<option><?php echo $row['jenis_file'];?></option>
																			<option>Memo Masuk</option>
																			<option>Memo Keluar</option>
																			<option>Surat Masuk</option>
																			<option>Surat Keluar</option>
																			<option>Surat Edaran</option>
																			<option>Surat Keputusan</option>
																			<option>Peraturan Difeksi</option>
																			<option>Surat Perintah</option>
																		</select> -->
				                          </div>
				                        </div>

				                        <div class="form-group">
				                          <label>File Number : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-file-text-o "></i></span>
				                            <input type="text" class="form-control display" id="nofile" name="nofile" readonly="true" value="<?php echo $row['no_file'];?>" />
				                          </div>
				                        </div>

                                <div class="row">
                                  <div class="col-lg-12 col-xs-12">
                                    <div class="form-group col-lg-4 col-xs-12" style="padding-left:0px;">
                                     <label>Date of File: </label>
                                     <div class="input-group">
                                       <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
                                       <input type="text" class="form-control dpd1 display" id="tglasal" readonly="true" name="tglasal" value="<?php echo $row['tgl_asal_file'];?>">
                                     </div>
                                   </div>

                                    <div class="form-group col-lg-4 col-xs-12" style="padding-left:0px;">
                                     <label>Date of File Received: </label>
                                     <div class="input-group">
                                       <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
                                       <input type="text" class="form-control dpd1 display" id="tglasal" readonly="true" name="tglasal" value="<?php echo $row['tgl_upload'];?>">
                                     </div>
                                   </div>

                                  <?php if($getcodeuser != 02){ ?>
                                     <div class="form-group col-lg-4 col-xs-12" style="padding-left:0px;">
                                       <label >Date of Share File : </label>
                                       <div class="input-group">
                                         <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
                                         <?php
                                          // $kodefile = $idfile."_".$iduser;
                                           $share_file_array = get_data_share_file("SELECT * FROM share_file where idfile LIKE '".$id."'");
                                           if(count($share_file_array) > 0):
                                             foreach($share_file_array as $rowshare): ?>
                                               <input type="text" class="form-control dpd1 display" id="sharedate" name="sharedate" readonly="true" value="<?php echo $rowshare['tgl_share'];?>"/>
                                         <?php endforeach;  endif; ?>
                                       </div>
                                      </div>
                                  <?php  } ?>
                                  </div>
                                </div>

				                        <div class="form-group">
				                          <label>File Title : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-file-text "></i></span>
																		  <input type="text" class="form-control display" id="title"  name="title" readonly="true" value="<?php echo $row['nama_file'];?>">
				                          </div>
				                        </div>

																<div class="form-group">
				                          <label>Adding Information : </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-file-text "></i></span>
																		  <textarea name="name" class="form-control display" id="perihal" name"perihal" readonly="true"><?php echo $row['nama_file'];?></textarea>
				                          </div>
				                        </div>

																<!-- <?php
																	if ($kodeuser == 02) {?>
                                    <div style="text-align:right; ">
																			 <button type="button" name="edit" id="edit" class="btn btn-primary" onclick="showButtons();" style="width:100px;">Edit</button>
																		</div>
													          <div class="col-xs-12 row">
													            <div class="col-xs-6" style="text-align:right; ">
													              <input type="submit" name="savedetail" id="savedetail" value="Submit" class="btn btn-success" style="width:80px; display:none;">
													            </div>
													            <div class="col-xs-6" style="text-align:left;">
													              <button type="button" name="canceldetail" id="canceldetail" class="btn btn-danger" style="width:80px; display:none;" onclick="back();">Cancel</button>
													            </div>
													          </div> <br>
																<?php } ?> -->

				                      </div>
													<?php endforeach;  endif; ?>
                      </div>
                    </div><! --/grey-panel --> <br>
                    <div class="modal fade" id="delete-data-modal" role="dialog" style="text-align:left;">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header" style="background:#737373;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> <label id="share"><li class="fa fa-exclamation-triangle "></li>  SHARE WARNING !</label> </h4>
                          </div>
                           <form action="save-disposisi-share.php" method="post">
                            <div class="modal-body">

                              <div class="row">
                                <div class="col-xs-12">
                                  <div class="form-group">
                                    <label>Do you really to delete the file with this user?</label>
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
                              <input type="submit" name="deleteShare" id="deleteShare" class="btn btn-danger" style="width:30%;" value="Yes, Delete This Share."/>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                      <div class="box">
                        <div class="box-header">
                            <span class="input-group-addon" style="background-color:#595959; color:#fff;">
                              <span style="background-color:#595959; color:#fff;"><i class="fa fa-link fa-2x" style="float:left; margin-left: 1px; margin-top:5px;"></i> <h4 style="float:left;">&nbsp; &nbsp; Detail Share File</h4></span>
                							<?php if($getcodeuser == 02){ ?>
                              	<button  class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal2" style="float:right;"><i class="fa fa-plus"></i> Share</button></span>
                							<?php } ?>
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
                															foreach($user_array as $row):
                                                $user = $row['iduser']; $kodeusr = substr($user,2,2);
                																if ($kodeusr == 01 || $kodeusr == 03) {
                																	$disposisi_array = get_data_share_file("SELECT * FROM share_file where kode_file LIKE'".$idfile."' AND iduser LIKE'".$user."'");
                																	if(count($disposisi_array) == 0){
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
                                    <input type="submit" class="btn btn-primary" value="Share" name="addShare" id="addShare">
                                  </div>

                                </div>

                              </div>
                            </div>
                        </div>

                      <div class="box-content box-content-butt" style="border: 1px solid black; padding-left:0.2%;">
                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                        <thead style="background: #808080; color:#fff;">
                          <tr>
                            <th>Share File To</th>
                						<th>Share Date</th>
                						<?php if($getcodeuser == 02){ ?>
                							<th>Action</th>
                						<?php } ?>
                          </tr>
                        </thead>
                				<tbody>
                					<?php
                					$share_array =  get_data_share_file("SELECT * FROM share_file where kode_file LIKE'".$idfile ."'");
                					$jum = count($share_array);
                					$per_hal=5;
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
                												<?php if($getcodeuser == 02){ ?>
                													<td>
                														<button type="button" name="delete" id="<?php echo $rowshare['idfile']; ?>" class="delete-data-share btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-data-modal"><li  class='fa fa-trash-o'></li>
                															<div class="hidden name"><?php echo $rowuser['nama']; ?></div>
                															<div class="hidden type"><?php echo "[Share]: "; ?></div>
                														</button>
                													</td>
                												<?php } ?>
                									</tr>
                								<?php endforeach;  else: ?>
                		 						 <?php if($getcodeuser == 02){ ?>
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
                			<div class="row" style="height:80px;">
                				<div class="col-xs-12" style="text-align:center">
                					<div class="pagination pagination-centered">
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
    </div><!-- /col-md-4-->



 <!-- </div><!-- /col-lg-9 END SECTION MIDDLE -->

    <!-- **********************************************************************************************************************************************************
    RIGHT SIDEBAR CONTENT
    *********************************************************************************************************************************************************** -->
    <div class="col-md-6 col-xs-12">
      <div class="box">
              <div id="Iframe-Cicis-Menu-To-Go" class="set-margin-cicis-menu-to-go set-padding-cicis-menu-to-go set-border-cicis-menu-to-go set-box-shadow-cicis-menu-to-go center-block-horiz">
                <div class="responsive-wrapper responsive-wrapper-padding-bottom-90pct" style="-webkit-overflow-scrolling: touch;">
                      <iframe src="assets/file_dokumen/<?php echo $idfile;?>/<?php echo $idfile;?>.pdf"></iframe>
                </div>
              </div><br>
      </div>
      <div class="box" style="text-align:right;">
  			<div class="box-content">

  				 <style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
  				 <a class="take_print" href="printShare.php?id=<?php echo $idfile;?>"><button type="button" style="background:#3498db;color:#FFF;" class="btn"><i class="fa fa-print"></i>  Print Data</button></a>
  				 <input type="submit" name="emailshare" id="emailshare" class="btn btn-success" value="&#xf003; Email Me"/>
  				 <input type="submit" style="background:#f4a742;color:#FFF;" name ="smsmeshare" id="smsmeshare" class="btn" value="&#xf0e0; SMS Me"/>
  			</div>
  		</div><br>

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
          <a href="detail-share-files.php" class="go-top">
              <i class="fa fa-angle-up"></i>
          </a>
      </div>
  </footer><!--footer end-->
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
    <script src="assets/js/zabuto_calendar.js"></script>
    <script>
			$(document).ready(function() {
				$("#formsubmit").submit(function(e) {
					$("#success").show().delay(8000).fadeOut();
					return true;
				});
			});
		</script>
    <script>
      $(".delete-data-share").click( function(){
        var id = $(this).attr("id");
        name = $(this).find(".name").html();
        $("#delete-data-modal input[name=id]").val(id);
        $("#delete-data-modal input[name=name]").val(name);
      });

      // function showButtons () { $('#category2').show(); $('#category').hide(); $('.display').prop("readonly", false); }
      // function back() { $(' #category2').hide(); $('#category').show(); $('.display').prop("readonly", true);}
    </script>
  </body>
</html>
<?php }
}?>
