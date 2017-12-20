<?php
	session_start();
		if (!isset($_SESSION['iduser']))
		{
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ../index.php">';
		  exit;
		}else{
			require_once("database.php");
			if ((time() - $_SESSION['last_time']) > 1800) {
			header("Location: logout.php");
		}else {
			$iduser = $_SESSION['iduser'];
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
    <link rel="stylesheet"  type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-timepicker/compiled/timepicker.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datetimepicker/datetimepicker.css"/>
    <link rel="stylesheet" href="assets/js/autocomplete/bootstrap-chosen.css">
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-timepicker/js/wickedpicker.min.css"/>
    <link href="assets/css/custom.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/style-responsive.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet"  type="text/css" href="assets/js/dataTable/dataTables.bootstrap.min.css"/>
		<link rel="stylesheet"  type="text/css" href="assets/js/dataTable/bootstrap.min.css"/>


    <style>
				input[type="submit"] {
						font-family: FontAwesome;
				}
				input[type="search"] {
						font-family: FontAwesome;
				}
				.container-1{
					width: 100%;
					vertical-align: middle;
					white-space: nowrap;
					position: relative;
				}
				.container-1 input#search{
					/*width: 400px;*/
					height: 40px;
					background: #a6a6a6;
					border: none;
					font-size: 10pt;
					float:  right;
					color: #000;
					/*padding-left: 45px;*/
					-webkit-border-radius: 5px;
					-moz-border-radius: 5px;
					border-radius: 5px;

					-webkit-transition: background .55s ease;
					-moz-transition: background .55s ease;
					-ms-transition: background .55s ease;
					-o-transition: background .55s ease;
					transition: background .55s ease;
				}
				.container-1 input#search::-webkit-input-placeholder {
					 color: #404040;
				}

				.container-1 input#search:-moz-placeholder { /* Firefox 18- */
					 color: #404040;
				}

				.container-1 input#search::-moz-placeholder {  /* Firefox 19+ */
					 color: #404040;
				}

				.container-1 input#search:-ms-input-placeholder {
					 color:##404040;
				}
				.container-1 .icon{
					position: absolute;
					top: 50%;
					margin-left: 17px;
					margin-top: 10px;
					z-index: 1;
					color: #4f5b66;
				}
				.container-1 input#search:hover, .container-1 input#search:focus, .container-1 input#search:active{
						outline:none;
						background: #e6e6e6;
				}

    </style>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"/>

    <script src="assets/js/chart-master/Chart.js"></script>

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
          <div class="col-md-3 col-xs-12" style="margin-top:1%;">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            	<li class="breadcrumb-item active">Surat Keputusan</li>
            </ol>
          </div><!-- /rowmt -->

          <div class="col-xs-12">
            <div class="content-panel">
              <div class="row">
								<div class="row mt" style="margin: 3%;">
                  <div class="col-lg-12 col-xs-12">
										<div class="content-panel" style="height:auto; overflow: auto;">

											<div class="modal fade" id="delete-data-modal" role="dialog" style="text-align:left;">
	                      <div class="modal-dialog">
	                        <div class="modal-content">
	                          <div class="modal-header" style="background:#737373;">
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>
	                            <h4 class="modal-title"> <label id="share"><li class="fa fa-exclamation-triangle "></li>  DELETE WARNING !</label> </h4>
	                          </div>
	                           <form action="save-disposisi-share.php" method="post">
	                            <div class="modal-body">

	                              <div class="row">
	                                <div class="col-xs-12">
	                                  <div class="form-group">
	                                    <label>Do you really to delete this file ?</label>
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

	                            </div>
	                            <div class="modal-footer">
	                              <input type="submit" name="deleteFileSKeputusan" id="deleteFileSKeputusan" class="btn btn-danger" style="width:30%;" value="Yes, Delete."/>
	                            </div>
	                          </form>
	                        </div>
	                      </div>
	                    </div>

											<div class="modal fade" id="delete-data-modal" role="dialog" style="text-align:left;">
	                      <div class="modal-dialog">
	                        <div class="modal-content">
	                          <div class="modal-header" style="background:#737373;">
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>
	                            <h4 class="modal-title"> <label id="share"><li class="fa fa-exclamation-triangle "></li>  DELETE WARNING !</label> </h4>
	                          </div>
	                           <form action="save-disposisi-share.php" method="post">
	                            <div class="modal-body">

	                              <div class="row">
	                                <div class="col-xs-12">
	                                  <div class="form-group">
	                                    <label>Do you really to delete this file ?</label>
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

	                            </div>
	                            <div class="modal-footer">
	                              <input type="submit" name="deleteFileSKeputusan" id="deleteFileSKeputusan" class="btn btn-danger" style="width:30%;" value="Yes, Delete."/>
	                            </div>
	                          </form>
	                        </div>
	                      </div>
	                    </div>

                    <table id="tabelData" class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em; overflow-y: scroll;">
                      <thead style="background: #595959; color:#fff;">
                        <tr>
													<th>No</th>
													<th>File ID</th>
													<th>File Uploaded By</th>
													<th>File Category</th>
													<th>File Received by</th>
													<th>File Number</th>
													<th>File Title</th>
													<th>Adding Information</th>
													<th>Date of File Received</th>
													<th>Date of File</th>
													<th>Disposisi To</th>
													<th>Share To</th>
													<th>Status</th>
													<th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

												<?php
													$category = "Surat Keputusan";
													require_once("database.php");
													$file_array = get_data_file("SELECT * FROM file where jenis_file LIKE'".$category."'");

													$jum = count($file_array);
													$per_hal=5;
													$halaman=ceil($jum / $per_hal);
													$page = isset($_GET['page'])? (int)$_GET['page'] : 1;
													$start = ($page - 1) * $per_hal;

													$rows_array = get_data_file("SELECT * FROM file  where jenis_file LIKE'".$category."' limit $start, $per_hal");
													if(count($rows_array) == 0):?>
															<tr>
																	<td colspan="16" style="text-align:center;"> --- There is no document in this menu. ---</td>

															</tr>
														<?php else:
														$no = $start+1;
														foreach($rows_array as $row): ?>
				                        <tr>
				                            <td><?php echo $no++; ?></td>
				                            <td class="center"><?php echo $row['idfile']; ?></td>

																		<?php $iduserupload = $row['iduser'];
																			$user_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduserupload."'");
																			if(count($user_array) > 0):

																				foreach($user_array as $rowuser): ?>
																					 <td class="center"><?php echo $rowuser['iduser']; ?></td>
																		<?php endforeach;  endif; ?>

				                            <td class="center"><?php echo $row['jenis_file']; ?></td>
				                            <td><?php echo $row['asal_file']; ?></td>
				                            <td class="center"><?php echo $row['no_file']; ?></td>
																		<td class="center"><?php echo $row['nama_file']; ?></td>
				                            <td><?php echo $row['detail_dokumen']; ?></td>
				                            <td class="center"><?php echo $row['tgl_asal_file']; ?></td>
				                            <td class="center"><?php echo $row['tgl_upload']; ?></td>

																		<?php $idfile = $row['idfile']; $nourutan1 = 0;
																			$disposisi_array = get_data_disposisi_file("SELECT * FROM disposisi_file where kode_file LIKE'".$idfile ."'");
																			if(count($disposisi_array) > 0):?>
																				<td>
																					<?php
																						foreach($disposisi_array as $rowshare):
																							 $iduserdisposisi =$rowshare['iduser'];
																								$userdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduserdisposisi."'");
																								if(count($userdata_array) > 0):
																									foreach($userdata_array as $rowuserdispo):
																									 echo $rowuserdispo['nama'];
																						 	 		endforeach;  endif;
																						endforeach;?>
																				</td>
																		<?php else: ?>
																		 <td class="center">-</td>
																	 <?php endif;?>

																		<?php $idfile = $row['idfile']; $nourutan2 = 0;
																			$share_array = get_data_share_file("SELECT * FROM share_file where kode_file LIKE'".$idfile."'");
																			if(count($share_array) > 0):?>

																				<td>
																				<?php
																				foreach($share_array as $rowshare):
																					$nourutan2 += 1;
																					 $idusershare =$rowshare['iduser'];
																						$getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$idusershare."'");
																						if(count($getuserdata_array) > 0):
																							foreach($getuserdata_array as $rowusershare): ?>
																								<?php
																									if(count($share_array) > 1){?>(<?php echo $nourutan2; ?>) <?php }
																									echo $rowusershare['nama'];
																						endforeach;  endif; ?>
																				<br> <?php endforeach;?> </td>

																		 <?php else: ?>
																			<td class="center">-</td>
																		<?php endif;?>

																		<td>
																			<?php

																				if ( $row['status_disposisi'] == 1) {
																							echo "Disposisi, ";
																				}if ($row['status_share'] == 1) {
																							echo "Share, ";
																				}if ($row['status_simpan'] == 1) {
																							echo "Simpan";
																				}
																				else {
																							echo "-";
																				} ?>
																	</td>
				                          <td class="center">
																		<input type="submit" name="info-mm" id="<?php?>" value="&#xf044;" class="btn btn-xs btn-primary" onclick="location.href='detail-submenu.php?id=<?php echo $idfile;?>&&page1=1&&page2=1'"/>
																		<?php if ($kodeuser == 02) { ?>
																			<button type="button" name="delete" id="<?php echo $row['idfile']; ?>" class="delete-data-share btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-data-modal"><li  class='fa fa-trash-o'></li>
																			</button>
																		<?php }?>
																	</td>
				                        </tr>
													<?php endforeach;endif;?>

                    </tbody>
                  </table>
								</div>
							</div>
							</div>
									<div class="col-xs-12" style="text-align:center;">
	                  <div class="pagination pagination-centered">
	                      <ul class="pagination">
													<?php
																	 if($halaman == 1){}
																	 elseif($halaman == 0){}
																	 elseif($_GET['page'] == 1){}
																	 else{$now = $page-1; echo "<li><a href='memo-keluar.php?page=$now'><i class='fa fa-chevron-left'></i></a></li>";}
																	 for($x=1;$x<=$halaman;$x++){
																		 if($page == $x){
																		 echo "<li><a  href='memo-keluar.php?page=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
																		 }else{
																		 echo "<li><a  href=memo-keluar.php?page=$x'>$x</a></li>";
																		 }
																	 }
													 ?>
													 <?php
																	 if($halaman == $page){}
																	 elseif($_GET['page'] < $halaman) {
																		 $now = $page+1;
																		 echo "<li><a href='memo-keluar.php?page=$now'><i class='fa fa-chevron-right'></i></a></li>";
																	 }
													 ?>
	                      </ul>
	                  </div>
									</div>
          			</div>
        			</div>
						</div>
    		</section>
  		</section>

<!--main content end-->


      <!--footer start-->
      <footer class="site-footer" style="background: #737373;">
          <div class="text-center">
               &copy; 2017 Complaint Handling and Services Division BPJS Ketenagakerjaan.
              <a href="surat-keputusan.php" class="go-top">
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

		<script src="assets/js/dataTable/jquery-1.12.4.js"></script>
		<script src="assets/js/dataTable/dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTable/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="assets/js/autocomplete/chosen.jquery.js"></script>
    <script>
      $('.chosen-select').chosen();
    </script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabelData').DataTable({
					"sDom": "lfrti"
				});
			});
		</script>
		<script>
			$(".delete-data-share").click( function(){
				var id = $(this).attr("id");
				name = $(this).find(".name").html();
				$("#delete-data-modal input[name=id]").val(id);
			});
		</script>
    <!-- batas -->
   <script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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
