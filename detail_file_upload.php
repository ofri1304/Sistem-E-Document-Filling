<?php
	session_start();
		if (!isset($_SESSION['iduser']))
		{
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ../index.php">';
		  exit;
		}else{
			require_once("database.php");
      $idfile = $_GET['id'];
			$id = $_SESSION['iduser'];
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

    <script src="assets/js/chart-master/Chart.js"></script>
		<style media="screen">
			.modal-dialog{
					overflow-y: initial !important
			}
			.scroll{
					height: 150px;
					overflow-y: auto;
			}
			.datepicker{z-index:9999 !important}
			#Iframe-Cicis-Menu-To-Go {
				max-width: 900px;
				max-height: 535px;
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
              <!-- <li class="breadcrumb-item"><a href="detail-menu.php">Back</a></li> -->
              <li class="breadcrumb-item"><b>Detail File Uploaded</b></li>
            </ol>
          </div><!-- /rowmt -->

					<div class="panel panel-default" style="margin-left:1%; margin-right:1%; margin-top:5%;">
           <div class="row" style="margin-top:2%;">
						<div class="col-lg-12">
              <form action="save-disposisi-share.php" method="post">
                  <div class="col-lg-6 col-xs-12">
                      <div class="box" style="background:white;">
                        <div class="form" style="border:1px solid black;">
                          <div class="white-header-group" >
  													 <span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-2x" style="float:left; margin-left: 10px; margin-top:6px;"></i> <h4 style="float:left;">&nbsp; &nbsp; Detail File Uploaded</h4></span>
                          </div>

                        <div style=" margin: 4% 3%;">
	                        <div class="form-group">
														<?php
															$quote_array = get_data_file("SELECT * FROM file where idfile  LIKE'".$idfile."'");
															if(count($quote_array) > 0):
																foreach($quote_array as $row): ?>
				                          <label>User Input: </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
				                            <input type="text" name="user" class="form-control" readonly ="true" value="<?php echo $row['iduser']; ?>"/>
				                          </div>
	                        </div>

	                        <div class="form-group">
	                          <label>File Number: </label>
	                          <div class="input-group">
	                            <span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
															<input type="text" class="form-control" name="noDoc" readonly="true" value="<?php echo $row['idfile'];?>"/>
														</div>
													</div>

	                        <div class="form-group">
	                          <label>Category: </label>
	                          <div class="input-group">
	                            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
	                            <input type="text" name="category" class="form-control" readonly="true" value="<?php echo $row['jenis_file']; ?>"/>
	                          </div>
	                        </div>

	                        <div class="form-group">
	                            <label>File Received by : </label>
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                     <input type="text" name="asalfile" class="form-control" readonly="true" value="<?php echo $row['asal_file']; ?>"/>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label>File Number : </label>
	                            <div class="input-group">
	                              <span class="input-group-addon"><i class="fa fa-file-text-o "></i></span>
	                              <input type="text" name="nofile" class="form-control" readonly="true" value="<?php echo $row['no_file']; ?>"/>
	                            </div>
	                        </div>

													<div class="form-group">
	                            <label>File Title : </label>
	                            <div class="input-group">
	                              <span class="input-group-addon"><i class="fa fa-file-text-o "></i></span>
	                              <input type="text" name="title" class="form-control" readonly="true" value="<?php echo $row['nama_file']; ?>"/>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label>File Date Received: </label>
	                            <div class="input-group">
	                              <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
	                              <input type="text" class="form-control dpd1" name="receivedate" readonly="true" value="<?php echo $row['tgl_upload']; ?>" style="font-size:1.1em;">
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label>File Date: </label>
	                            <div class="input-group">
	                              <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
	                              <input type="text" class="form-control dpd1" name="memodate" value="<?php echo $row['tgl_asal_file']; ?>"  readonly="true" style="font-size:1.1em;">
	                            </div>
	                        </div>
                      </div>


                  	<div class="box-content box-content-butt" style="padding-left:3%; padding-right:3%;">
											<label>Adding Information : </label>
                       <script type="text/javascript" src="assets/tinymce/tinymce.min.js"></script>
                       <script>
                         tinymce.init({
                           selector: "textarea#elm1",
                           theme: "modern",
													 readonly : 1,
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
                       <textarea id="elm1" readonly="true" name="data" style="width:100%;resize:none;overflow-y:hidden"><?php echo $row['detail_dokumen']; ?></textarea><br/>
											   <?php endforeach; endif; ?>
											</div>
                </div><!-- /col-md-4-->
								</div>
							</div><! --/grey-panel -->
 <!-- </div><!-- /col-lg-9 END SECTION MIDDLE -->
    <!-- **********************************************************************************************************************************************************
    RIGHT SIDEBAR CONTENT
    *********************************************************************************************************************************************************** -->
    <div class="col-lg-6 col-xs-12">

			<div class="box">
							<div id="Iframe-Cicis-Menu-To-Go" class="set-margin-cicis-menu-to-go set-padding-cicis-menu-to-go set-border-cicis-menu-to-go set-box-shadow-cicis-menu-to-go center-block-horiz">
								<div class="responsive-wrapper
									responsive-wrapper-padding-bottom-90pct"
										style="-webkit-overflow-scrolling: touch;">
											<iframe src="assets/file_dokumen/<?php echo $idfile;?>/<?php echo $idfile;?>.pdf"></iframe>
								</div>
							</div><br>
			</div><br>

      <div class="box">
				<div class="box-header">
					<span class="input-group-addon" style="background-color:#595959; color:#fff; height:5%;">
						<span style="background-color:#595959; color:#fff;"><i class="fa fa-file-text fa-2x" style="float:left; margin-left: 1px; margin-top:5px;"></i> <h4 style="float:left;">&nbsp; &nbsp; List Disposisi For Head</h4></span>
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
								 <input type="submit" class="btn btn-primary" value="OK" name="btnDispoSekretaris" id="btnDispoSekretaris" />
							 </div>
					 <?php } ?>
					 </div>

					 </form>
				 </div>
			 </div>
		 </div>

      <div class="box-content box-content-butt" style="border: 1px solid black;">
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
          <thead style="background: #808080; color:#fff;">
            <tr>
              <th>Tujuan Disposisi</th>
              <th>Tanggal Disposisi</th>
							<th>Action</th>
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

						$quote_array = get_data_disposisi_file("SELECT * FROM disposisi_file where kode_file LIKE '".$idfile."'");
								if(count($quote_array) > 0):
									foreach($quote_array as $row):
										$iduser = $row['iduser']; ?>
										<tr>
											<?php $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduser."'");
												if(count($getuserdata_array) > 0):
													foreach($getuserdata_array as $rowuser): ?>
														<td scope="row"><?php echo $rowuser['nama'];?></td>
											<?php endforeach;  endif; ?>
											<td scope="row"><?php echo $row['tgl_disposisi']; ?></td>
											<td>
												<button type="button" name="delete" id="<?php echo $row['idfile']; ?>" class="delete-data-dispo btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-data-modal"><li  class='fa fa-trash-o'></li>
													<div class="hidden name"><?php echo $rowuser['nama']; ?></div>
													<div class="hidden type"><?php echo "[Share]: "; ?></div>
												</button>
											</td>
										</tr>
									<?php endforeach; else:?>
										<tr> <td colspan="3" style="text-align:center;"> --- Not peoples get sharing. ---</td> </tr>
									<?php endif; ?>
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
													else{$now = $page-1; echo "<li><a href='detail_file_upload.php?id=$idfile&&page1=$now&&page2=1'><i class='fa fa-chevron-left'></i></a></li>";}
													for($x=1;$x<=$halaman;$x++){
														if($page == $x){
														echo "<li><a  href='detail_file_upload.php?id=$idfile&&page1=$x&&page2=1'><b style='color:#FFCA0C'>$x</b></a></li>";
														}else{
														echo "<li><a  href='detail_file_upload.php?id=$idfile&&page1=$x&&page2=1'>$x</a></li>";
														}
													}
									?>
									<?php
													if($halaman == $page){}
													elseif($_GET['page1'] < $halaman) {
														$now = $page+1;
														echo "<li><a href='detail_file_upload.php?id=$idfile&&page1=$now&&page2=1'><i class='fa fa-chevron-right'></i></a></li>";
													}
									?>
								</ul>
							</div>
						</div>
					</div>
      </div>
    </div><br>

    <div class="box">
			<div class="box-header">
					<span class="input-group-addon" style="background-color:#595959; color:#fff;">
						<span style="background-color:#595959; color:#fff;"><i class="fa fa-link fa-2x" style="float:left; margin-left: 1px; margin-top:5px;"></i> <h4 style="float:left;">&nbsp; &nbsp; Detail Share File</h4></span>
						<?php if($code == 02){ ?>
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
									<input type="submit" class="btn btn-primary" value="Share" name="addShareSekretaris" id="addShareSekretaris">
								</div>
							</div>
						</div>
					</div>
			</div>

			<!-- --- delete -->
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
								<input type="submit" name="delDispo" id="btnDeleteDispo" class="btn btn-danger" style="width:30%;" value="Yes, Delete This Dispo."/>
								<input type="submit" name="delShare" id="btnDeleteShare" class="btn btn-danger" style="width:30%;" value="Yes, Delete This Share."/>
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
						<th>Action</th>

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
												else{$now = $page-1; echo "<li><a href='detail_file_upload.php?id=$idfile&&page1=1&&page2=$now'><i class='fa fa-chevron-left'></i></a></li>";}
												for($x=1;$x<=$halaman;$x++){
													if($page == $x){
													echo "<li><a  href='detail_file_upload.php?id=$idfile&&page1=1&&page2=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
													}else{
													echo "<li><a  href='detail_file_upload.php?id=$idfile&&page1=1&&page2=$x'>$x</a></li>";
													}
												}
								?>
								<?php
												if($halaman == $page){}
												elseif($_GET['page2'] < $halaman) {
													$now = $page+1;
													echo "<li><a href='detail_file_upload.php?id=$idfile&&page1=1&&page2=$now'><i class='fa fa-chevron-right'></i></a></li>";
												}
								?>
									</ul>
								</div>
							</div>
						</div>
			    </div><br>
					<div class="box" style="text-align:right;">
						<div class="box-content">
							 <style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
							 <a class="take_print" href="printDetailFile.php?id=<?php echo $idfile;?>"><button type="button" style="background:#3498db;color:#FFF;" class="btn"><i class="fa fa-print"></i>  Print Data</button></a>
						</div>
					</div><br>

        </form>
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
          <a href="detail_file_upload.php" class="go-top">
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
    <script type="text/javascript">
        $(document).on("focus keyup", "input.autocomplete", function() {
      // Cache useful selectors
      var $input = $(this);
      var $dropdown = $input.next("ul.dropdown-menu");

      // Create the no matches entry if it does not exists yet
      if (!$dropdown.data("containsNoMatchesEntry")) {
          $("input.autocomplete + ul.dropdown-menu").append('<li class="no-matches hidden"><a>No matches</a></li>');
          $dropdown.data("containsNoMatchesEntry", true);
      }

      // Show only matching values
      $dropdown.find("li:not(.no-matches)").each(function(key, li) {
          var $li = $(li);
          $li[new RegExp($input.val(), "i").exec($li.text()) ? "removeClass" : "addClass"]("hidden");
      });

      // Show a specific entry if we have no matches
      $dropdown.find("li.no-matches")[$dropdown.find("li:not(.no-matches):not(.hidden)").length > 0 ? "addClass" : "removeClass"]("hidden");
    });
    $(document).on("click", "input.autocomplete + ul.dropdown-menu li", function(e) {
      // Prevent any action on the window location
      e.preventDefault();

      // Cache useful selectors
      $li = $(this);
      $input = $li.parent("ul").prev("input");

      // Update input text with selected entry
      if (!$li.is(".no-matches")) {
          $input.val($li.text());
      }
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
		<script>
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
		</script>
  </body>
</html>
<?php }
}?>
