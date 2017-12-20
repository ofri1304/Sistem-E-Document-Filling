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

  <body id="manageuser">
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
    ********************************************************************************************************************************************************** -->
    <!--main content start-->

    <section id="main-content" style="background:#e6e6e6;">
        <section class="wrapper">
					<div class="row" style="padding:2%;">
						  <div class="centered" style="font-size:1.5em;"><i class="fa fa-user fa-1x"> </i> Manage User</div>
					</div>

						<div class="col-xs-12">
             <div class="content-panel">
              <div class="row">
                  <div class="col-lg-12">
												 <!-- <div class="col-xs-5">
													 <div class="container-1 form-group">
															 <input type="search" id="search" class="form-control" value="&#xf002; Search.."  />
													 </div>
												 </div> -->
												 <div class="col-lg-12 col-xs-12" style="text-align:right;">
													  <button type="button" id="add-user" data-toggle="modal" data-target="#insert-data-modal" style="height:40px;background:#3498db;color:#FFF;" class="btn"><i class="fa fa-user"></i>  Tambah User</button>
														  <div class="modal fade" id="insert-data-modal" role="dialog" style="text-align:left;">
									              <div class="modal-dialog">
									                <div class="modal-content">
									                  <div class="modal-header" style="background:#737373;">
									                    <button type="button" class="close" data-dismiss="modal">&times;</button>
									                    <h4 class="modal-title">Add User Form</h4>
									                  </div>
																		<form action="adduser.php" method="post" enctype="multipart/form-data">
																			<div class="modal-body">

																				<div class="row">
																					<div class="col-xs-12">
																						<div class="form-group">
																							<label>Photo Profile</label>
																							<input type="file" name="foto" id="foto" class="form-control" style="height:2%;">
																						</div>
																					</div>
																				</div>

																				<div class="row">
																					<div class="col-xs-12">
																						<div class="form-group">
																							<label>ID User: </label>
																							<div class="input-group">
																								 <span class="input-group-addon"><i class="fa fa-user"></i></span>
																								 <input type="text" name="iduser" id="iduser" class="form-control" readonly="true">
																							</div>
																						</div>
																					</div>
																				</div>

																				<div class="row">
																					<div class="col-xs-12">
																						<div class="form-group">
																							<label>Nama: </label>
																							<div class="input-group">
																								<span class="input-group-addon"><i class="fa fa-user"></i></span>
																								<input type="text" name="nama" id="nama" class="form-control" >
																						 </div>
																						</div>
																					</div>
																				</div>

																				<div class="row">
																					<div class="col-xs-12">
																						<div class="form-group">
																							<label>Password: </label>
																							<div class="input-group">
																								<span class="input-group-addon"><i class="fa fa-key"></i></span>
																								<input type="password" name="password" id="password" class="form-control"/>
																						 </div>
																						</div>
																					</div>
																				</div>

																				<div class="row">
																					<div class="col-xs-12">
																						<div class="col-xs-6" style="padding-left:0px;">
																							<div class="form-group">
																								<label>Jabatan: </label>
																								<div class="input-group">
																									 <span class="input-group-addon"><i class="fa fa-suitcase"></i></span>
																									 <input type="text" name="jabatan" id="jabatan" class="form-control"/>
																								</div>
																							</div>
																						</div>

																						<div class="col-xs-6" style="padding-right:0px;">
																							<div class="form-group">
																								<label>Unit Kerja:</label>
																								<div class="input-group">
																									 <span class="input-group-addon"><i class="fa fa-suitcase"></i></span>
																									 <input type="text" name="unitkerja" id="unitkerja" class="form-control"/>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>

																				<div class="row">
																					<div class="col-xs-12">
																						<div class="col-xs-6" style="padding-left:0px;">
																							<div class="form-group">
																								<label>No. Hp: </label>
																								<div class="input-group">
																									<span class="input-group-addon"><i class="fa fa-phone"></i></span>
																									<input type="text" name="nohp" id="nohp" class="form-control"/>
																							 </div>
																							</div>
																						</div>

																						<div class="col-xs-6" style="padding-right:0px;">
																							<div class="form-group">
																								<label>Email: </label>
																								<div class="input-group">
																										<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
																										<input type="text" name="email" id="email" class="form-control"/>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>

																			</div>
																			<div class="modal-footer">
																				<input type="submit" name="addnewuser" id = "addnewuser"  style="display:none; background:#666; width:20%;" class="btn btn-primary" value="Add"/>
																				<input type="submit" id = "edituser" name = "edituser"  style="display:none;  background:#666;" class="btn btn-primary" value="Edit"/>
																			</div>
																		</form>

									             </div>
									           </div>
									          </div>
			<!-- '''''''''''''''''''''''''''''''''''''''''''''''Modal to Show Delete User''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''' -->
														<div class="modal fade" id="delete-data-modal" role="dialog" style="text-align:left;">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header" style="background:#737373;">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title"><li class="fa fa-exclamation-triangle "></li>  Warning</h4>
																	</div>
																	<form action="adduser.php" method="post" enctype="multipart/form-data" class="form-inline">
																		<div class="modal-body">

																			<div class="row">
																				<div class="col-xs-12">
																					<div class="form-group">
																						<label>Do you really to delete this user ?</label>
																					</div>
																				</div>
																			</div>

																			<div class="row">
																				<div class="col-xs-12">
																					<div class="form-group" style="padding:3%;">
																						<label>Id user:</label>
																						<input type="text" name="id" class="form-control" readonly="true">
																						<label>Nama: </label>
																						<input type="text" name="name" class="form-control" readonly="true">
																					</div>
																				</div>
																			</div>

																		</div>
																		<div class="modal-footer">
																			<input type="submit" name="deleteuser" id = "deleteuser" class="btn btn-primary" style="background:#666; width:20%;" value="Delete"/>
																		</div>
																	</form>

														 </div>
													 </div>
													</div>



									</div>
                </div><!-- /row -->
							</div>

							<div class="row" style="margin: 2%; border:1px solid black;">
                <div class="col-md-12 col-xs-12">
									<div class="content-panel" style="height:auto; overflow: auto;">
										<section id="unseen">
                    <table id="tabelData" class="table table-bordered table-striped table-condensed" style="font-size:0.8em; overflow-y: scroll;">
                      <thead style="background: #595959; color:#fff;">
                        <tr>
														<th>No</th>
                            <th>User ID</th>
                            <th>Nama</th>
														<th>Password</th>
                            <th>No Handphone</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Unit Kerja</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
												<?php
													require_once("database.php");
													$quote_array = get_all_user("SELECT * FROM user");
													$jum = count($quote_array);
													$per_hal=5;
													$halaman=ceil($jum / $per_hal);
													$page = isset($_GET['page'])? (int)$_GET['page'] : 1;
													$start = ($page - 1) * $per_hal;

													$quote_array = get_all_user("SELECT * FROM user limit $start, $per_hal");
													if(count($quote_array) > 0):
														$no = $start+1;
														foreach($quote_array as $row): ?>
				                        <tr>
																		<td class="center"><?php echo $no++; ?></td>
				                            <td class="center"><?php echo $row['iduser']; ?></td>
				                            <td class="center"><?php echo $row['nama']; ?></td>
																		<td class="center"><?php echo  $row['password']; ?></td>
				                            <td><?php echo $row['no_hp']; ?></td>
				                            <td class="center"><?php echo $row['email']; ?></td>
				                            <td class="center"><?php echo $row['jabatan']; ?></td>
				                            <td class="center"><?php echo $row['unit_kerja']; ?></td>
				                            <td class="center">
																		 <button type="submit" name="edit" id="<?php echo $row["iduser"]; ?>"  class="edit-data-user btn btn-xs btn-success" data-toggle="modal" data-target="#insert-data-modal"><li  class='fa fa-edit'></li>
																			 <div class="hidden name"><?php echo $row['nama']; ?></div>
																			 <div class="hidden pswd"><?php echo $row['password']; ?></div>
																			 <div class="hidden nhp"><?php echo $row['no_hp']; ?></div>
																			 <div class="hidden eml"><?php echo $row['email']; ?></div>
																			 <div class="hidden jbtn"><?php echo $row['jabatan']; ?></div>
																			 <div class="hidden uk"><?php echo $row['unit_kerja']; ?></div>
																		 </button>
				                             <button type="button" name="delete" id="<?php echo $row["iduser"]; ?>" class="delete-data-user btn btn-xs btn-danger" data-toggle="modal" data-target="#delete-data-modal"><li  class='fa fa-trash-o'></li>
																			 <div class="hidden name"><?php echo $row['nama']; ?></div>
																		 </button>
				                            </td>
				                        </tr>
														<?php endforeach; endif; ?>
                    </tbody>
                  </table>
								</section>
								</div>
									<div class="row">
										<div class="col-xs-12" style="text-align:center">
											<div class="pagination pagination-centered">
												<ul class="pagination">
													<?php
																		if($halaman == 1){}
																		elseif($halaman == 0){}
																		elseif($_GET['page'] == 1){}
																		else{$now = $page-1; echo "<li><a href='manage-user.php?page=$now'><i class='fa fa-chevron-left'></i></a></li>";}
																		for($x=1;$x<=$halaman;$x++){
																			if($page == $x){
																			echo "<li><a  href='manage-user.php?page=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
																			}else{
																			echo "<li><a  href='manage-user.php?page=$x'>$x</a></li>";
																			}
																		}
														?>
														<?php
																		if($halaman == $page){}
																		elseif($_GET['page'] < $halaman) {
																			$now = $page+1;
																			echo "<li><a href='manage-user.php?page=$now'><i class='fa fa-chevron-right'></i></a></li>";
																		}
														?>
												</ul>
											</div>
										</div>
									</div>
								</div>
					 		</div><!-- /col-md-4-->

				</div>
      </div>
    </section>
  </section>

<!--main content end-->
<!--footer start-->
	<footer class="site-footer" style="background: #737373;">
          <div class="text-center">
               &copy; 2017 Complaint Handling and Services Division BPJS Ketenagakerjaan.
              <a href="manage-user.php" class="go-top">
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

    <script type="text/javascript" src="assets/js/autocomplete/chosen.jquery.js"></script>
    <script>
      $('.chosen-select').chosen();
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
		<!-- highlight menu -->
		<script type="text/javascript" src="assets/js/highlightmenu/highlightmenu.js"></script>

		<script src="assets/js/dataTable/dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTable/jquery.dataTables.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabelData').DataTable({
					"sDom": "lfrti"
				});
			});
		</script>
		<script type="text/javascript">

			$("#add-user").click( function(){
				$("#insert-data-modal .modal-title").html('Add New User Form');
				$('#addnewuser').show(); $('#edituser').hide();
				document.getElementById('iduser').readOnly = false;
				var empty = $(this).val();

				$("#insert-data-modal input[name=iduser]").val(empty);
				$("#insert-data-modal input[name=nama]").val(empty);
				$("#insert-data-modal input[name=password]").val(empty);
				$("#insert-data-modal input[name=jabatan]").val(empty);
				$("#insert-data-modal input[name=unitkerja]").val(empty);
				$("#insert-data-modal input[name=nohp]").val(empty);
				$("#insert-data-modal input[name=email]").val(empty);
			});

			$(".edit-data-user").click( function(){
				$("#insert-data-modal .modal-title").html('Editing User Data');
				$('#edituser').show(); $('#addnewuser').hide();
				document.getElementById('iduser').readOnly = true;
				var idusr = $(this).attr("id");
				nama = $(this).find(".name").html();
				pass = $(this).find(".pswd").html();
				nohp   = $(this).find(".nhp").html();
				email  = $(this).find(".eml").html();
				jbtn = $(this).find(".jbtn").html();
				unitkerja = $(this).find(".uk").html();

				$("#insert-data-modal input[name=iduser]").val(idusr);
				$("#insert-data-modal input[name=nama]").val(nama);
				$("#insert-data-modal input[name=password]").val(pass);
				$("#insert-data-modal input[name=jabatan]").val(jbtn);
				$("#insert-data-modal input[name=unitkerja]").val(unitkerja);
				$("#insert-data-modal input[name=nohp]").val(nohp);
				$("#insert-data-modal input[name=email]").val(email);
			});

			$(".delete-data-user").click( function(){
				var id = $(this).attr("id");
				nama = $(this).find(".name").html();
				$("#delete-data-modal input[name=id]").val(id);
				$("#delete-data-modal input[name=name]").val(nama);
			});


	</script>

  </body>
</html>
<?php }
} ?>
