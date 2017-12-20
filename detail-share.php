<?php
	session_start();
		if (!isset($_SESSION['iduser']))
		{
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ../index.php">';
		  exit;
		}else{
			if ((time() - $_SESSION['last_time']) > 1800) {
			header("Location: logout.php");
			}else {
			$_SESSION['last_time'] = time();
			$kodeuser = substr($_SESSION['iduser'],2,2);
			require_once("database.php");
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

    <link rel="stylesheet" type="text/css" href="assets/js/pdf/pdfstyle.css"/>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"/>

    <script src="assets/js/chart-master/Chart.js"></script>
    <script type="text/javascript" src="assets/js/daterangepicker.min.js"></script>
    <script type="text/javascript" src="assets/js/moment.min.js"></script>
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg" style="background:#999999;">
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
												<?php if($kodeuser == 03){ ?>
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
          <!-- <div class="row mt"> -->
          <div class="row col-xs-3">
            <ol class="breadcrumb" style="padding-top:-10px;">
              <li class="breadcrumb-item"><a href="share-file.php">Share File</a></li>
              <li class="breadcrumb-item active">Detail File</li>
            </ol>
          </div>
          <div class="col-lg-12">
            <div class="content-panel">
              <div class="row">

                <div class="col-xs-12" style="float:left;">
                    <div class="col-xs-4 col-xs-offset-8">
                     <style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
                     <a class="take_print" href="#"><button type="submit" style="background:#3498db;color:#FFF;" class="btn"><i class="fa fa-print"></i>  Print Data</button></a>
                     <a class="take_print" href="#"><button type="button" data-toggle="modal" data-target="#myModal" style="color:#FFF;" class="btn btn-warning"><i class="fa fa-envelope"></i>  Email Me</button></a>

                    <!-- Modal -->
                     <div class="modal fade" id="myModal" role="dialog">
                       <div class="modal-dialog">
                         <!-- Modal content-->
                         <div class="modal-content">
                           <div class="modal-header" style="background:#ff8000;">
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                             <h4 class="modal-title">E-mail Form</h4>
                           </div>
                           <div class="modal-body">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="form_name">To *</label>
                                         <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter email address *" required="required" data-error="Firstname is required.">
                                         <div class="help-block with-errors"></div>
                                     </div>
                                 </div>
                             </div>

                             <div class="row">
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label for="form_email">Subject *</label>
                                       <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter the subject matter *" required="required" data-error="Valid email is required.">
                                       <div class="help-block with-errors"></div>
                                   </div>
                               </div>
                             </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="form_message">Message *</label>
                                        <textarea id="form_message" name="message" class="form-control" placeholder="Please enter your message*" rows="4" required="required" data-error="Please,leave us a message."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-muted"><strong>*</strong> These fields are required.</p>
                                </div>
                            </div>

                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">Send Message</button>
                           </div>
                           </div>
                         </div>
                       </div>

                     <!-- sms blast form  -->
                                         <a class="take_print" href="#"><button type="button" data-toggle="modal" data-target="#myModalSms"  style="color:#FFF;" class="btn btn-success"><i class="fa fa-envelope"></i>  SMS Me</button></a>
                     </div>
                     <!-- Modal -->
                     <div class="modal fade" id="myModalSms" role="dialog">
                       <div class="modal-dialog">
                         <!-- Modal content-->
                         <div class="modal-content">
                           <div class="modal-header" style="background:#339933;">
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                             <h4 class="modal-title">SMS Form</h4>
                           </div>
                           <div class="modal-body">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="form_name">Phone Numbers *</label>
                                         <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter phone numbers *" required="required" data-error="Firstname is required.">
                                         <div class="help-block with-errors"></div>
                                     </div>
                                 </div>
                             </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="form_message">Message *</label>
                                        <textarea id="form_message" name="message" class="form-control" placeholder="Please enter your message*" rows="4" required="required" data-error="Please,leave us a message."></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-muted"><strong>*</strong> These fields are required.</p>
                                </div>
                            </div>

                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalSms">Send Message</button>
                           </div>
                         </div>
                       </div>
                     </div>
                  </div>

            <div class="row col-xs-12">

                <div class="col-xs-6">
                  <div class="box" >
                    <div class="form-panel">
                      <div class="white-header-group" >
                          <span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-2x" style="float:left; margin-left: 10px; margin-top:6px;"></i> <h5>Detail File</h5></span>
                      </div> <br>

                      <label style="color:#666666; float:left; margin-left: 10px;" onloadeddata="">Tanggal Share : </label>
    									<div class="input-group date col-sm-11" style="margin-left: 15px; margin-top:25px;">
    										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    										<input type="text" class="form-control disabled" id="disabledInput" disabled="" value=""/>
    									</div> <br>

                      <label style="color:#666666; float:left; margin-left: 10px;" onloadeddata="">Nama Petugas Yang Share : </label>
                      <div class="input-group date col-sm-11" style="margin-left: 15px; margin-top:25px;">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control disabled" id="disabledInput" disabled="" value=""/>
                      </div> <br>

                      <label style="color:#666666; float:left; margin-left: 10px;" onloadeddata="">Perihal : </label>
                      <div class="input-group date col-sm-11" style="margin-left: 15px; margin-top:25px;">
                        <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
                        <input type="text" class="form-control disabled" id="disabledInput" disabled="" value=""/>
                      </div> <br>

                      <label style="color:#666666; float:left; margin-left: 10px;" onloadeddata="">File Dari : </label>
                      <div class="input-group date col-sm-11" style="margin-left: 15px; margin-top:25px;">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control disabled" id="disabledInput" disabled="" value=""/>
                      </div> <br>

                      <label style="color:#666666; float:left; margin-left: 10px;" onloadeddata="">Tanggal File : </label>
                      <div class="input-group date col-sm-11" style="margin-left: 15px; margin-top:25px;">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control disabled" id="disabledInput" disabled="" value=""/>
                      </div> <br>

            	      </div><! --/grey-panel -->
                  </div>
                </div><!-- /col-md-4-->



    <!-- **********************************************************************************************************************************************************
    RIGHT SIDEBAR CONTENT
    *********************************************************************************************************************************************************** -->
          <div class="col-xs-6">
            <div id="Iframe-Cicis-Menu-To-Go" class="set-margin-cicis-menu-to-go set-padding-cicis-menu-to-go set-border-cicis-menu-to-go set-box-shadow-cicis-menu-to-go center-block-horiz">
              <div class="responsive-wrapper
                responsive-wrapper-padding-bottom-90pct"
                  style="-webkit-overflow-scrolling: touch; overflow: auto;">
                    <iframe src="assets/js/pdf/pdf-sample.pdf">
                    </iframe>
              </div>
            </div>
          </div><!-- /col-lg-3 -->
        </div>
      </div>
    </div>
   </div>
  </section>
</section>

<!--main content end-->

      <!--footer start-->
      <footer class="site-footer" style="background:#999999;">
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
    <script type="text/javascript" src="assets/js/daterangepicker.min.js"></script>
    <script type="text/javascript" src="assets/js/moment.min.js"></script>
    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>
    <script src="assets/js/zabuto_calendar.js"></script>


  </body>
</html>
<?php }
}?>
