<?php
	session_start();
	require_once("database.php");
	require('login/conn.php');
		if (!isset($_SESSION['iduser']))
		{
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ../index.php">';
		  exit;
		}else{
			require_once("database.php");
			if ((time() - $_SESSION['last_time']) > 1800) {
			header("Location: logout.php");
			}else {
			$_SESSION['last_time'] = time();

			$sql = "SELECT SUM(jenis_file) as count FROM file GROUP BY MONTH(tgl_asal_file)";
			$data = mysqli_query($con,$sql);
			$data = mysqli_fetch_all($data,MYSQLI_ASSOC);
			$data = json_encode(array_column($data, 'count'),JSON_NUMERIC_CHECK);
			$iduser = $_SESSION['iduser'];
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
    <link href="assets/css/custom.css" type="text/css" rel="stylesheet"/>
    <link href="assets/css/style-responsive.css" type="text/css" rel="stylesheet"/>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"/>
		<link rel="stylesheet"  href="assets/jquery3.1.1/bootstrap.min.css"/>
		<link rel="stylesheet" href="assets/jquery3.1.1/jquery-ui.css"/>
		<style>
			input[type="button"] {
					font-family: FontAwesome;
			}
			.panel-default{
				padding-bottom: 0px;
			}
		</style>

  </head>

  <body id="statistik">
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
      <?php include "menu.php" ?>
      <!--sidebar end-->

      <!-- **********************************************************************************************************************************************************
    MAIN CONTENT
    *********************************************************************************************************************************************************** -->
    <!--main content start-->

    <section id="main-content" style="background:#e6e6e6;">
        <section class="wrapper">
          <div class="row" style="padding:2%;">
              <div class="centered"  style="font-size:1.5em;"><i class="fa fa-bar-chart-o fa-1x"></i>  Statistik E-Doc Filling</div>
          </div>

            <div class="panel panel-default" style="margin-left:1%; margin-right:1%;">
              <div class="panel-body">
								<div class="row" style="text-align:left;">
									<div class="col-lg-12 col-xs-12">
										<div class="col-lg-6">
										<label class="control-label" for="daterange">Periode Document :</label>
											<form class="form-inline">
												 <div class="form-group">
													 	<div class="col-xs-6 row">
															 <div class="input-group " style="font-size:0.5em;">
																	<!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
																	<input type="text" class="form-control dpd1" id="start_date" name="start_date" placeholder="From Date" style="font-size:1.5em;">
																	<span class="input-group-addon" style="font-size:1.4em">To</span>
																	<input type="text" class="form-control dpd2" id="end_date" name="end_date" placeholder="To Date" style="font-size:1.5em;">
															 </div>
														 </div>
														 <div class="col-xs-6">
															 <input type="text" class="form-control col-md-1" id="category" name="category" placeholder="category" style="font-size:0.8em; border-top-right-radius:0px; border-bottom-right-radius:0px;">
															 <input type="button" id="btnStatistik" name="btnStatistik" class="form-control btn btn-primary col-md-1" style="width:60px; border-top-left-radius:0px; border-bottom-left-radius:0px;" value="&#xf002;"/>
															 <!-- <button type="button" id="btnStatistik" name="btnStatistik" class="form-control btn btn-primary col-md-1" style="width:60px; border-top-left-radius:0px; border-bottom-left-radius:0px;"><i class="fa fa-search"></i></button> -->
														 </div>
												</div>
											</form> <br>
										</div>
										<div class="col-lg-6"></div>
									</div>
								</div>

							<div class="col-lg-12">
                <div class="col-lg-7 col-xs-12">
											<div id="chart" style="border: 1px solid black;"></div>
    						</div><!-- /row -->
    <!-- **********************************************************************************************************************************************************
    RIGHT SIDEBAR CONTENT
    *********************************************************************************************************************************************************** -->

    					<div id="file_table" class="col-lg-5 col-xs-12">
            <!-- Table of Memo -->
                <table class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em;">
              	<thead>
                  <tr>
                    <th colspan="2" style="text-align:center; background-color: #666666; color:white;">Category Document</th>
                  </tr>
              		<tr>
              	 	 	<th>Category</th>
              	 	 	<th>Jumlah</th>
              		</tr>
              	</thead>
              	<tbody>
									<?php
										require_once("database.php");
										$category_array = get_count_category("SELECT jenis_file, COUNT(idfile) FROM file GROUP BY jenis_file");
										if(count($category_array) > 0):
											foreach($category_array as $row): ?>
											<tr>
															<td name="category"><?php echo $row['jenis_file']; ?></td>
															<td name="count"><?php echo $row['COUNT(idfile)']; ?></td>
											</tr>
										<?php endforeach; endif; ?>

              		</tbody>
              	</table>
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
              <a href="statistik-chart.php" class="go-top">
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
  	<!-- batas -->
  	<script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>
    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>
    <script src="assets/js/zabuto_calendar.js"></script>
		<script src="assets/highchart/highcharts.js"></script>
		<script src="assets/highchart/exporting.js"></script>
		<!-- highlight menu -->
		<script type="text/javascript" src="assets/js/highlightmenu/highlightmenu.js"></script>
		<script>
			<?php $year = Date('Y'); ?>
			 $(function () {

				$('#chart').highcharts({
						chart: {
								type: 'column'
						},
						title: {
								text: 'Files on One Year (<?php echo $year; ?>)'
						},
						xAxis: {
								categories: ['JAN','FEB','MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC']
						},
						yAxis: {
							min: 0,
							title: {
									text: ''
							}
						},
						tooltip: {
			        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
			            '<td style="padding:0"><b>{point.y:.1f} % </b></td></tr>',
			        footerFormat: '</table>',
			        shared: true,
			        useHTML: true
    				},
						series: [
							<?php $jan= 0; $feb= 0; $mar= 0; $apr= 0; $may= 0; $jun= 0; $jul= 0; $aug= 0; $sep= 0; $oct= 0; $nov= 0; $dec= 0;
								$sql = get_data_file("SELECT * FROM file ");

								if(count($sql) > 0){
									foreach($sql as $row){
										if (substr($row['tgl_asal_file'],0,4) == $year) {

												if (substr($row['tgl_asal_file'],5,2) == '01') {
													$jan +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '02') {
													$feb +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '03'	) {
													$mar +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '04') {
													$apr +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '05') {
													$may +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '06') {
													$jun +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '07') {
													$jul +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '08') {
													$aug +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '09') {
													$sep +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '10') {
													$oct +=1;
												}
												elseif (substr($row['tgl_asal_file'],5,2) == '11') {
													$nov +=1;
												}

												elseif (substr($row['tgl_asal_file'],5,2) == '12') {
													$dec +=1;
												}
											}
										}
									} $a = 100;
									$total =  $jan+$feb+$mar+$apr+$may+$jun+$jul+$aug+ $sep+$oct+$nov+$dec;
									$jan = ($jan / $total) * 100;
									$feb =($feb / $total) * 100;
									$mar =($mar / $total) * 100;
									$apr = ($apr / $total) * 100;
									$may =($may / $total) * 100;
									$jun = ($jun / $total) * 100;
									$jul = ($jul / $total) * 100;
									$aug = ($aug / $total) * 100;
									$sep = ($sep / $total) * 100;
									$oct = ($oct / $total) * 100;
									$nov = ($nov / $total) * 100;
									$dec = ($dec / $total) * 100;
							?>
							{
								name: 'Percentase',
								data: [<?php echo $jan;?>, <?php echo $feb;?>, <?php echo $mar;?>, <?php echo $apr;?>, <?php echo $may;?>, <?php echo $jun;?>, <?php echo $jul;?>, <?php echo $aug;?>, <?php echo $sep;?>, <?php echo $oct;?>, <?php echo $nov;?>,<?php echo $dec;?>]
						}]
				});
			 });
</script>

<script>
$(document).ready(function(){
	function charts(start_date, end_date, category){
		$.ajax({
					url:'search-statistik.php',
					method:'POST',
					data: {start_date:start_date, end_date:end_date, category:category},
					success:function(data){
						//alert(data);
						var JSONObject = JSON.parse(data);
						//alert(JSONObject);
						console.log(data);
						var processed_json = new Array();
						var tgl = new Array();
						for(var key in JSONObject){
							processed_json.push([JSONObject[key]["category"], JSONObject[key]["count"]]);
							tgl.push([JSONObject[key]["tglfile"]]);
						} //end of for

							$('#chart').highcharts({
									chart: {
											type: 'column'
									},
									title: {
											text: 'Files on One Year (<?php echo $year; ?>)'
									},
									xAxis: {
											categories: tgl
									},
									yAxis: {
										min: 0,
										title: {
												text: ''
										}
									},
									tooltip: {
										headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
										pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
												'<td style="padding:0"><b>{point.y:.1f} % </b></td></tr>',
										footerFormat: '</table>',
										shared: true,
										useHTML: true
									},
									series: [{
												data: processed_json
									}]
							});
					}
		});
	}
	function tabel(start_date, end_date){
		$.ajax({
					url:'search-chart.php',
					method:'POST',
					data: {start_date:start_date, end_date:end_date},
					success:function(data){
						//alert(data);
						var JSONObject = JSON.parse(data);
						// alert(JSONObject);
						var temp_ajax = '';
						temp_ajax += '<table class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em;">';
						temp_ajax += '<thead style = "background: #595959; color:#fff;">';
						temp_ajax += '<tr>';
						temp_ajax += '<th>Category</th>';
						temp_ajax += '<th>Jumlah</th>';
						temp_ajax += '</tr>';
						temp_ajax += '</thead>';
						temp_ajax += '<tbody>';
						for(var key in JSONObject){
							if (JSONObject.hasOwnProperty(key)) {if (JSONObject[key]["success"] == true) {
									temp_ajax += '<tr>';
									temp_ajax += '<td>'+JSONObject[key]["category"]+'</td>';
									temp_ajax += '<td>'+JSONObject[key]["count"]+'</td>';
									temp_ajax += '</tr>';
								}else{
									temp_ajax += '<tr>';
									temp_ajax += '<td colspan="2">'+JSONObject[key]["warning"]+'</td>';
									temp_ajax += '</tr>';
								}
							}
						}
						temp_ajax += '</tbody></table>';
						$('#file_table').html(temp_ajax);
					},
					error: function (exception) {
							//alert(exception);
					}
				});
	}
	$('#btnStatistik').click(function(){
		//alert('coba 1');
		var start_date = $('#start_date').val();
		//alert(start_date);
		var end_date = $('#end_date').val();
		//alert(end_date);
		var category = $('#category').val();
		//alert(category);
		//alert('coba 2');
		if (start_date != '' && end_date != '' && category != '') {
			charts(start_date, end_date, category);
			tabel(start_date, end_date);
		}
		else if (start_date != '' && end_date != '') {
			tabel(start_date, end_date);
			}
		else{
				  alert("please select the date and fill the category");
				}
		});
	});
</script>

  </body>
</html>
<?php }
} ?>
