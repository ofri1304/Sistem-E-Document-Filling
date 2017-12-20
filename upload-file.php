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

<!-- loading indicator -->
    <style>
			input[type="submit"] {
					font-family: FontAwesome;
			}
			input[type="button"] {
					font-family: FontAwesome;
			}
      .preload{
       z-index:2147483640;
       top:0px;
       left:0px;
       width:100%;
       height:100%;
       position:fixed;
       overflow: hidden;
       background: rgba(13, 13, 13,0.8);
       opacity: 0.6;
       zoom:1;
       display:none;
    }
    .loader-frame{
      width: 70px;
      height: 70px;
      margin: auto;
      position: relative;
    }

    .loader1, .loader2{
      position: absolute;
      border: 5px solid transparent;
      border-radius: 50%;
    }
    .loader1{
      width: 70px;
      height: 70px;
      border-top: 5px solid azure;
      border-bottom: 5px solid azure;
      animation: clockwisespin 2s linear 3;
      /*animation: bouncy 1s ease-in infinite;*/
    }
    .loader2{
      width: 60px;
      height: 60px;
      border-left: 5px solid darkturquoise;
      border-right: 5px solid darkturquoise;
      top: 5px; left: 5px;
      animation: anticlockwisespin 2s linear 3;
      /*animation: bouncy 1s ease-in infinite;*/
    }


    @keyframes clockwisespin {
      from{transform: rotate(0deg);}
      to{transform: rotate(360deg);}
    }
    @keyframes anticlockwisespin {
      from{transform: rotate(0deg);}
      to{transform: rotate(-360deg);}
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

  <body id="uploadfile">

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
          <div class="row" style="padding:2%;">
            <div class="centered" style="font-size:1.5em;"><i class="fa fa-upload fa-1x"></i> Upload Document </div>
          </div>

          	<div class="row">
						 <div class="col-lg-12">
							<div class="panel panel-default" style="margin-left:1%; margin-right:1%;">
								<div class="panel-body">
							   <form action="upload-process.php" method="post" id="uploadForm" name="uploadForm" enctype="multipart/form-data">
                  <div class="col-lg-6">
                      <div class="form" style=" border: 1px solid black;">
                        <div class="white-header-group" >
                            <span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-1x" style="float:left; margin-left: 10px; margin-top:6px;"></i> <h5>Record Document</h5></span>
                        </div>
                        <div style=" margin:4% 3%">

													<div class="alert alert-success" id="success" style="display:none;">
														<strong> Data profile is successfully uploaded. </strong>
													</div>
													<div class="alert alert-danger" id="fail" style="display:none;">
														<strong> Warning! Please fill the blank fields. </strong>
													</div>

	                        <div class="form-group">
														<?php
															require_once("database.php");
															$quote_array = get_all_user("SELECT * FROM user where iduser  LIKE'".$iduser."'");
															if(count($quote_array) > 0):
																foreach($quote_array as $row): ?>
				                          <label>User Input: <strong><?php echo $_SESSION['iduser'];?></strong> </label>
				                          <div class="input-group">
				                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
				                            <input type="text" name="user" class="form-control" readonly ="true" value="<?php echo $row['nama']; ?>"/>
				                          </div>
														<?php endforeach; endif; ?>
	                        </div>

	                        <div class="form-group">
	                          <label>Upload Number: </label>
	                          <div class="input-group">
	                            <span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
															<input type="text" class="form-control" name="noDoc" readonly="true" value="EDF_<?php echo $_SESSION['iduser'];?>_<?php echo date("Ymd");?>_<?php echo date("his");?>"/>
														</div>
	                        </div>

	                        <div class="form-group">
	                          <label>Category: </label>
	                          <div class="input-group">
	                            <span class="input-group-addon"><i class="fa fa-tags"></i></span>
	                            <!-- <input type="text" name="kategori" class="form-control" autocomplete="off" /> -->
															<select class="form-control" id="category" name="category">
																<option></option>
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
	                            <label>Document Received by : </label>
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
				                                <select class="form-control" id="memoby" name="memoby">
																					<option></option>
																					<?php
																						require_once("database.php");
																						$quote_array = get_all_user("SELECT * FROM user");
																						if(count($quote_array) > 0):
																							foreach($quote_array as $row): ?>
				                                      <option><?php echo $row['nama']; ?></option>
																					<?php endforeach; endif; ?>
				                                </select>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label>Document Number: </label>
	                            <div class="input-group">
	                              <span class="input-group-addon"><i class="fa fa-file-text-o "></i></span>
	                              <input type="text" id="nomemo" name="nomemo" class="form-control" autocomplete="off" />
	                            </div>
	                        </div>

													<div class="form-group">
	                            <label>Document Title: </label>
	                            <div class="input-group">
	                              <span class="input-group-addon"><i class="fa fa-file-text-o "></i></span>
	                              <input type="text" id="title" name="title" class="form-control" autocomplete="off" />
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label>Document Date Received: </label>
	                            <div class="input-group">
	                              <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
	                              <input type="text" class="form-control dpd1" id="receivedate"  name="receivedate" style="font-size:1.1em;">
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label>Document Date: </label>
	                            <div class="input-group">
	                              <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
	                              <input type="text" class="form-control dpd1" id="memodate" name="memodate" value=""  style="font-size:1.1em;">
	                            </div>
	                        </div> <br><br>

                      </div>
                    </div><! --/grey-panel -->
                </div><!-- /col-lg-9 END SECTION MIDDLE -->

    <!-- **********************************************************************************************************************************************************
    RIGHT SIDEBAR CONTENT
    *********************************************************************************************************************************************************** -->

  						<div class="col-lg-6">
					      <div class="box-header">
					          <span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-list fa-1x" style="float:left; margin-left: 10px; margin-top:6px;"></i> <h5>Adding Infomation Document</h5></span>
					      </div>
						    <div class="box-content box-content-butt">
						      <script type="text/javascript" src="assets/tinymce/tinymce.min.js"></script>
						      <script>
						        tinymce.init({
						          selector: "textarea#elm1",
						          theme: "modern",
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
						      <textarea id="elm1" name="data" style="width:100%;resize:none;overflow-y:hidden"></textarea><br/>
						    </div>

					      <div class="box-header">
					          <span class="input-group-addon" style="background-color:#595959; color:#fff;"><i class="fa fa-file fa-1x" style="float:left; margin-left: 10px; margin-top:6px;"></i> <h5>Document Attachment : </h5></span>
					      </div>
								<div class="box-content box-content-butt" style="border: 1px solid black;">
									<input type="file" class="btn" name="fileToUpload" id="fileToUpload">
								</div> <br>
								<div class="box-content">
								  <input type="submit" name="save" value="&#xf0c7; Save" class="btn btn-success">
									</form>
								  <input type="button" id="retry" name="retry" onclick="resetform()" value="&#xf0e2; Retry" class="btn btn-danger">
								</div>
	 						</div>
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
			          <a href="upload-file.php" class="go-top">
			              <i class="fa fa-angle-up"></i>
			          </a>
			      </div>
			  </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->

    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.
		nicescroll.js" type="text/javascript"></script>
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
		<script type="text/javascript">
			function resetform() {
				document.getElementById("uploadForm").reset();
			}
		</script>
		<script>
			$(document).ready(function() {
				$("#uploadForm").submit(function(e) {
						var content = tinyMCE.get('elm1').getContent();
							if ((content == "" || content == null) || $('#category').val() == "" || $('#memoby').val() == "" || $('#nomemo').val() == "" || $('#title').val() == "" || $('#receivedate').val() == "" || $('#memodate').val() == "" ||  $('#fileToUpload').val() == "") {

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
		</script>
  </body>
</html>
<?php }
}?>
