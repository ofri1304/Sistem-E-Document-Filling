<?php
	session_start();
		if (!isset($_SESSION['iduser']))
		{
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ../index.php">';
		  exit;
		}else{
			require_once("database.php");
			$id = $_SESSION['iduser'];
			if ((time() - $_SESSION['last_time']) > 1800) {
			header("Location: logout.php");
			}else {
			$_SESSION['last_time'] = time();
			$kodeuser = substr($_SESSION['iduser'],2,2);
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
    <link href="assets/css/custom.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/style-responsive.css" type="text/css" rel="stylesheet"/>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"/>
    <script src="assets/js/chart-master/Chart.js"></script>
  </head>

  <body id="profileuser">

      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->

      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>BPJSTK E-DOC</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
								<ul class="nav top-menu">
										<!-- inbox dropdown start untuk staf -->
												<?php if($kodeuser == 03){ ?>
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
											<?php }elseif($kodeuser == 01){ ?>
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
          <div class="row" style="padding:2%;"><div class="centered" style="font-size:1.5em;"><i class="fa fa-user fa-1x"></i> Profile User </div></div>
          <div class="panel panel-default" style="margin-left:1%; margin-right:1%;">
					 <div class="panel-body">
						<div class="col-md-6 col-xs-12">
					        <div class="white-header-group">
					          <span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-2x" style="margin-left: 10px; margin-top:6px; float:left; "></i> <h4 style="float:left;"> &nbsp; &nbsp; Change Photo Profile</h4></span>
					        </div>
					        <div style=" margin: 2% 2%;">
										<div class="alert alert-success" id="successpp" style="display:none;">
	 								    <strong>Photo profile is successfully changed.</strong>
	 								  </div>
	 									<div class="alert alert-danger" id="failpp"  style="display:none;">
	 										<strong>Warning! Please select photo to change profile.</strong>
	 									</div>
										<form  action="edit-user.php" method="post" enctype="multipart/form-data" id="changepp">
											<p class="centered"><a href="profile.html"><img src="assets/img/profile/<?php echo $id; ?>/<?php echo $id; ?>.png" class="img-circle" width="130"></a></p><br>
											<div class="col-xs-12">
												<input type="file" name="photoProfile" id="photoProfile" class="form-control" style="height:2%;"> <br>
											</div>
											<div class="centered">
												<input type="submit" name="btnPhoto" id="btnPhoto" value="Change Photo" class="btn btn-primary">
											</div>
										</form>
					          <div class="box-content box-content-butt">
											<h6>Format file upload harus .png</h5>
											<h6>Max size file upload : 2 MB </h5>
										</div>
					      </div><br>

							 <div class="form">
								 <div class="white-header-group" >
										 <span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-2x" style="float:left; margin-left: 10px; margin-top:6px;"></i> <h4 style="float:left;">&nbsp; &nbsp; Change Password User</h4></span>
								 </div>
								 <div style=" margin: 3% 2%;">
								 <div class="alert alert-success" id="success"  style="display:none;">
								    <strong>Password is successfully changed.</strong>
								  </div>
									<div class="alert alert-danger" id="failnotmatch"  style="display:none;">
										<strong>Warning! Password does not match.</strong>
									</div>
									<div class="alert alert-danger" id="failempty"  style="display:none;">
										<strong>Warning! Password cannot be empty.</strong>
									</div>
								 <!-- <form method="post" name="changePass" id="changePass"> -->
								 <form method="post" id="formsubmit" action="edit-user.php">
								 <div class="form-group">
									 <label>Type your new password: </label>
									 <div class="input-group">
										 <span class="input-group-addon"><i class="fa fa-key"></i></span>
										 <input type="password" name="password1" id="password1" class="form-control"/>
									 </div>
								 </div>

								 <div class="form-group">
									 <label>Retype your new password: </label>
									 <div class="input-group">
										 <span class="input-group-addon"><i class="fa fa-key"></i></span>
										 <input type="password" name="password2" id="password2" class="form-control"/>
									 </div>
								 </div>
								 <div class="centered">
								 	<input type="submit" name="password" id ="password" class="btn btn-primary" value="Change Password" />
								 </div>
								 <!-- <button type="button" class="btn btn-primary">Change Password</button> -->
							 </div>
							 </form>
						 </div><! --/grey-panel -->
					  </div>


						<div class="col-md-6 col-xs-12">
						    <div class="form">
						      <div class="white-header-group" >
						          <span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-2x" style="float:left; margin-left: 10px; margin-top:6px;"></i> <h4 style="float:left;"> &nbsp; &nbsp; Detail Profile</h4></span>
						      </div>
						      <div class=" clearfix" style=" margin: 4% 2%;">
										<div class="alert alert-success" id="successprofile" style="display:none;">
	 								    <strong>Data profile is successfully changed.</strong>
	 								  </div>
	 									<div class="alert alert-danger" id="failprofile"  style="display:none;">
	 										<strong>Warning! Please fill the blank fields</strong>
	 									</div>
						      	<form method="post" id="updateData" name="formData" action="edit-user.php">
						          <div class="form-group">
						            <label>User ID: </label>
						            <div class="input-group">
						              <span class="input-group-addon"><i class="fa fa-user"></i></span>
						              <input type="text" name="iduser" id="iduser" class="form-control" disabled="" value="<?php echo $id;?>"/>
						            </div>
						          </div>

						          <div class="form-group">
						            <label>Username: </label>
						            <div class="input-group">
						              <span class="input-group-addon"><i class="fa fa-user"></i></span>
						              <?php
						                require_once("database.php");
						                $quote_array = get_all_user("SELECT * FROM user where iduser  LIKE'".$id."'");
						                if(count($quote_array) > 0):
						                  foreach($quote_array as $row): ?>
						              <input type="text" name="nama" id="nama" class="form-control disabled" disabled="" value="<?php echo $row['nama']; ?>"/>
						            </div>
						          </div>

						          <div class="form-group">
						            <label>Position: </label>
						            <div class="input-group">
						              <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
						              <input type="text" name="jabatan" id="jabatan" class="form-control disabled" disabled="" value="<?php echo $row['jabatan']; ?>"/>
						            </div>
						          </div>

						          <div class="form-group">
						              <label>Work Unit: </label>
						              <div class="input-group">
						                  <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
						                  <input type="text" name="divisi" id="divisi" class="form-control disabled" disabled="" value="<?php echo $row['unit_kerja']; ?>"/>
						              </div>
						          </div>

						          <div class="form-group">
						              <label>Phone Number: </label>
						              <div class="input-group">
						                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
						                <input type="text" name="nohp" id="nohp" class="form-control disabled" disabled="" value="<?php echo $row['no_hp']; ?>"/>
						              </div>
						          </div>

						          <div class="form-group">
						              <label>Email: </label>
						              <div class="input-group">
						                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						                <input type="text" name="email" id="email" class="form-control disabled" disabled="" value="<?php echo $row['email']; ?>"/>
						                <?php endforeach; endif; ?>
						              </div>
						          </div>
											<div class="centered">
												 <br><button type="button" id="edit" class="btn btn-primary" style="height:5%;"onclick="showButtons();">Edit Data User</button>
											</div>
						          <div class="col-xs-12 row">
						            <div class="col-xs-6" style="text-align:right; ">
						              <input type="submit" name="edit2" id="edit2" class="btn btn-success" style="display:none;" value="Submit" />
						            </div>
						            <div class="col-xs-6" style="text-align:left;">
						              <button type="button" id ="cancel" class="btn btn-primary" style="display:none;" onclick="back();">Cancel</button>
						            </div>
						          </div>
							      </form>
							    </div>
						  	</div><! --/grey-panel -->
						</div><!-- /col-lg-9 END SECTION MIDDLE -->
</div>
</div>
</section>
</section>
<!-- ----------------------------------------------------------------------------------------------------------------------------------->


<!-- ---------------------------------------------------------------------------------------------------------------------------------------------->
  <footer class="site-footer" style="background: #737373;">
      <div class="text-center">
           &copy; 2017 Complaint Handling and Services Division BPJS Ketenagakerjaan.
          <a href="profile.php" class="go-top">
              <i class="fa fa-angle-up"></i>
          </a>
      </div>
  </footer>


    <!-- js placed at the end of the document so the pages load faster -->
		<script type="text/javascript" src="assets/jquery3.1.1/jquery.js"></script>
		<script type="text/javascript" src="assets/jquery3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="assets/jquery3.1.1/jquery-ui.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>
    <script type="text/javascript" src="assets/js/highlightmenu/highlightmenu.js"></script>
		<script type="text/javascript">
			function showButtons () { $('#edit2, #cancel').show(); $('#edit').hide(); $('.disabled').prop("disabled", false); }
			function back() { $('#edit2, #cancel').hide(); $('#edit').show(); $('.disabled').prop("disabled", true); }
		</script>
		<script>
			$(document).ready(function() {
				$("#changepp").submit(function(e) {

					if ($('#photoProfile').val() != "") {

							$("#successpp").show().delay(8000).fadeOut();
							$("#failpp").hide();
							return true;

					}else{
								$("#failpp").show().delay(5000).fadeOut();
								$("#successpp").hide();
								return false;
  				}

				});
			});
		</script>
		<script>
			$(document).ready(function() {
				$("#updateData").submit(function(e) {
							if ($('#nama').val() == "" || $('#jabatan').val() == "" || $('#divisi').val() == "" || $('#nohp').val() == "" || $('#email').val() == "") {
								$("#failprofile").show().delay(5000).fadeOut();
	 						 	$("#successprofile").hide();
	 						 	return false;
						 } else{
							 	$("#successprofile").show().delay(8000).fadeOut();
								$("#failprofile").hide();
								return true;
						 }
				});
			});
		</script>
		<script>
		$(document).ready(function() {
			$("#formsubmit").submit(function(e) {
				if ($('#password1').val() != "" || $('#password2').val() != "") {
					if ($('#password1').val() == $('#password2').val()) {
						 $("#success").show().delay(8000).fadeOut();
						 // $("#fail").hide();
						 return true;
					 }else{
						 $("#failnotmatch").show().delay(5000).fadeOut();
						 // $("#success").hide();
						 return false;
					 }
 				} else{
					 $("#failempty").show().delay(5000).fadeOut();
					 // $("#success").hide();
					 return false;
				 }
			});
		});
		</script>
  </body>
</html>
<?php }
} ?>
