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
			require_once("database.php");
			$_SESSION['last_time'] = time();
			$iduser = $_SESSION['iduser'];
			$kodeuser = substr($iduser,2,2);
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
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet"

    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"/>

    <script src="assets/js/chart-master/Chart.js"></script>

  </head>

  <body id="home">
  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg" style="background:#737373;">
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
      <?php include"menu.php"; ?>
      <!--sidebar end-->

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
		  <!--main content start-->
      <section id="main-content"  style="background:#e6e6e6;">
          <section class="wrapper">
						<div class="row"  style="padding:2%;">
							<div class="centered" style="font-size:1.5em;"><i class="fa fa-home fa-1x"></i> MENU HOME</div>
						</div>
							<div class="panel panel-default" style="margin-left:1%; margin-right:1%;">
								<div class="panel-body">
              		<div class="row">
                  <div class="col-lg-12">

                      <div class="row mt" style="color:black;">
                      <!-- SERVER STATUS PANELS -->
                      <div class="col-sm-3 mb">
                        <a href="memo-masuk.php?page=1">
                          <div class="box0" >
                      		<div class="white-panel pn">
                      			<div class="white-header">
						  			          <h5 style="color:grey;">MEMO MASUK</h5>
                      			</div>
								            <div class="row">
									           <div class="col-lg-6 col-xs-6 goleft">
										           <p style="color:blue;"><i class="fa fa-files-o" style="color:blue;"></i>
																 <?php $category = "Memo Masuk";
																 require_once("database.php");
																 $file_array = get_data_file("SELECT * FROM file where jenis_file LIKE'".$category."'");
																		echo count($file_array);
																  ?>
															 </p>
									           </div>
                             <div class="col-sm-6 col-xs-6"></div>
 	                      	 </div>
 	                      	 <div class="centered">
 										         <!-- <span class="glyphicon glyphicon-envelope" style="font-size:90px; color:Grey"></span> -->
														 <span style="font-size:90px; color:Grey"><img src="assets/img/icon/email.png"></span>
 	                      		</div>
            	            </div><! --/grey-panel -->
                            </div>
                          </a>
                       </div><!-- /col-md-4-->


                      <div class="col-sm-3 mb">
                        <a href="memo-keluar.php?page=1">
                          <div class="box0">
                      		<div class="white-panel pn">
                      			<div class="white-header">
						  			          <h5 style="color:grey;">MEMO KELUAR</h5>
                      			</div>
								            <div class="row">
									           <div class="col-sm-6 col-xs-6 goleft">
															 <p style="color:blue;"><i class="fa fa-files-o" style="color:blue;"></i>
																 <?php $category = "Memo Keluar";
																 require_once("database.php");
																 $file_array = get_data_file("SELECT * FROM file where jenis_file LIKE'".$category."'");
																		echo count($file_array);
																  ?>
															 </p>
									          </div>
									          <div class="col-sm-6 col-xs-6"></div>
	                      	 </div>
	                      	 <div class="centered">
										         <span style="font-size:90px;"><img src="assets/img/icon/letter.png"></span>
	                      		</div>
                      		</div>
                        </div>
                       </a>
                      </div><!-- /col-md-4 -->

                      <div class="col-sm-3 mb">
                        <a href="surat-masuk.php?page=1">
                          <div class="box0">
                          <div class="white-panel pn">
                            <div class="white-header">
                              <h5 style="color:grey;">SURAT MASUK</h5>
                            </div>
                            <div class="row">
                             <div class="col-sm-6 col-xs-6 goleft">
															 <p style="color:blue;"><i class="fa fa-files-o" style="color:blue;"></i>
																 <?php $category = "Surat Masuk";
																 require_once("database.php");
																 $file_array = get_data_file("SELECT * FROM file where jenis_file LIKE'".$category."'");
																		echo count($file_array);
																	?>
															 </p>
                            </div>
                            <div class="col-sm-6 col-xs-6"></div>
                           </div>
                           <div class="centered">
                          	<span style="font-size:90px;"><img src="assets/img/icon/email.png"></span>
                           </div>
                          </div>
                        </div>
                       </a>
                      </div><!-- /col-md-4 -->

                      <div class=" col-sm-3 mb">
                        <a href="surat-keluar.php?page=1">
                          <div class="box0">
                          <div class="white-panel pn">
                            <div class="white-header">
                              <h5 style="color:grey;">SURAT KELUAR</h5>
                            </div>
                            <div class="row">
                             <div class="col-sm-6 col-xs-6 goleft">
															 <p style="color:blue;"><i class="fa fa-files-o" style="color:blue;"></i>
																<?php $category = "Surat Keluar";
																require_once("database.php");
																$file_array = get_data_file("SELECT * FROM file where jenis_file LIKE'".$category."'");
																	 echo count($file_array);
																 ?>
															</p>
                            </div>
                            <div class="col-sm-6 col-xs-6"></div>
                           </div>
                           <div class="centered">
                             <span style="font-size:90px;"><img src="assets/img/icon/contact.png"></span>
                            </div>
                          </div>
                        </div>
                       </a>
                      </div><!-- /col-md-4 -->

                      <div class=" col-sm-3 mb">
                        <a href="surat-edaran.php?page=1">
                          <div class="box0">
                          <div class="white-panel pn">
                            <div class="white-header">
                              <h5 style="color:grey;">SURAT EDARAN</h5>
                            </div>
                            <div class="row">
                             <div class="col-sm-6 col-xs-6 goleft">
															 <p style="color:blue;"><i class="fa fa-files-o" style="color:blue;"></i>
																 <?php $category = "Surat Edaran";
																 require_once("database.php");
																 $file_array = get_data_file("SELECT * FROM file where jenis_file LIKE'".$category."'");
																		echo count($file_array);
																  ?>
															 </p>
                            </div>
                            <div class="col-sm-6 col-xs-6"></div>
                           </div>
                           <div class="centered">
                             <span  style="font-size:90px; "><img src="assets/img/icon/edaran.png"></span>
                            </div>
                          </div>
                        </div>
                       </a>
                      </div><!-- /col-md-4 -->

                      <div class=" col-sm-3 mb">
                        <a href="surat-keputusan.php?page=1">
                          <div class="box0">
                          <div class="white-panel pn">
                            <div class="white-header">
                              <h5 style="color:grey;">SURAT KEPUTUSAN</h5>
                            </div>
                            <div class="row">
                             <div class="col-sm-6 col-xs-6 goleft">
															 <p style="color:blue;"><i class="fa fa-files-o" style="color:blue;"></i>
																<?php $category = "Surat Keputusan";
																require_once("database.php");
																$file_array = get_data_file("SELECT * FROM file where jenis_file LIKE'".$category."'");
																	 echo count($file_array);
																 ?>
															</p>
                            </div>
                            <div class="col-sm-6 col-xs-6"></div>
                           </div>
                           <div class="centered">
                             <span  style="font-size:90px;"><img src="assets/img/icon/keputusan.png"></span>
                            </div>
                          </div>
                        </div>
                       </a>
                      </div><!-- /col-md-4 -->

                      <div class=" col-sm-3 mb">
                          <a href="peraturan-difeksi.php?page=1">
                            <div class="box0">
                          <div class="white-panel pn">
                            <div class="white-header">
                              <h5 style="color:grey;">PERATURAN DIFEKSI</h5>
                            </div>
                            <div class="row">
                             <div class="col-sm-6 col-xs-6 goleft">
															 <p style="color:blue;"><i class="fa fa-files-o" style="color:blue;"></i>
																<?php $category = "Peraturan Difeksi";
																require_once("database.php");
																$file_array = get_data_file("SELECT * FROM file where jenis_file LIKE'".$category."'");
																	 echo count($file_array);
																 ?>
															</p>
                            </div>
                            <div class="col-sm-6 col-xs-6"></div>
                           </div>
                           <div class="centered">
                             <span style="font-size:90px;"><img src="assets/img/icon/agenda.png"></span>
                            </div>
                          </div>
                        </div>
                       </a>
                      </div><!-- /col-md-4 -->

                      <div class=" col-sm-3 mb" >
                        <a href="surat-perintah.php?page=1">
                          <div class="box0">
                          <div class="white-panel pn">
                            <div class="white-header">
                              <h5 style="color:grey;">SURAT PERINTAH</h5>
                            </div>
                            <div class="row">
                             <div class="col-sm-6 col-xs-6 goleft">
															 <p style="color:blue;"><i class="fa fa-files-o" style="color:blue;"></i>
																<?php $category = "Surat Perintah";
																require_once("database.php");
																$file_array = get_data_file("SELECT * FROM file where jenis_file LIKE'".$category."'");
																	 echo count($file_array);
																 ?>
															</p>
                            </div>
                            <div class="col-sm-6 col-xs-6"></div>
                           </div>
                           <div class="centered">
                             <span style="font-size:90px;"><img src="assets/img/icon/perintah.png"></span>
                            </div>
                          </div>
                        </div>
                       </a>
                      </div><!-- /col-md-4 -->
                    </div><!-- /row -->
                  </div><!-- /col-lg-9 END SECTION MIDDLE -->

              </div><! --/row -->
						</div>
					</div>
          </section>
      </section>

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer" style="background: #737373;">
          <div class="text-center">
               &copy; 2017 Complaint Handling and Services Division BPJS Ketenagakerjaan.
              <a href="home.php" class="go-top">
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
    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>
    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>
		<script src="assets/js/zabuto_calendar.js"></script>
		<!-- highlight menu -->
		<script type="text/javascript" src="assets/js/highlightmenu/highlightmenu.js"></script>


		<script type="text/javascript">
        $(document).ready(function () {
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: '<?php echo $_SESSION['nama']; ?>',
            // (string | mandatory) the text inside the notification
            text: 'Welcome, to E-Doc Filling! ',
            // (string | optional) the image to display on the left
            image: 'assets/img/profile/<?php echo $iduser; ?>/<?php echo $iduser; ?>.png',
            // (bool | optional) if you want it to fade out on its own or just sit there
            sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
            time: '',
            // (string | optional) the class name you want to apply to that specific message
            class_name: 'my-sticky-class'
        });

        return false;
        });
	</script>

	<script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });

            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });


        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>


  </body>
</html>
<?php }
} ?>
