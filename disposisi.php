<?php
	session_start();
		if (!isset($_SESSION['iduser']))
		{
		  echo '<META HTTP-EQUIV="Refresh" Content="0; URL= ../index.php">';
		  exit;
		}else{
			require_once("database.php");
      $iduser = $_SESSION['iduser'];
			if ((time() - $_SESSION['last_time']) > 1800) {
			header("Location: logout.php");
			}else {
			$_SESSION['last_time'] = time();
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
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"/>
		<link rel="stylesheet"  type="text/css" href="assets/js/dataTable/dataTables.bootstrap.min.css"/>
		<link rel="stylesheet"  type="text/css" href="assets/js/dataTable/bootstrap.min.css"/>
		<link rel="stylesheet"  href="assets/jquery3.1.1/bootstrap.min.css"/>
		<link rel="stylesheet" href="assets/jquery3.1.1/jquery-ui.css"/>

		<style media="screen">
			input[type="submit"] {
					font-family: FontAwesome;
			}
			input[type="button"] {
					font-family: FontAwesome;
			}
		</style>
  </head>

  <body id="disposisifile">

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
													 <li><a href="disposisi-file.php?page1=1&page2=1">See all messages</a></li>
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
													<li><a href="disposisi-file.php?page1=1&page2=1">See all messages</a></li>
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
          <div class="centered" style="margin-top:2%; margin-bottom:2%; font-size:0.8em;"><i class="fa fa-file-text fa-2x"> Disposisi File</i></div>


          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-body">
              <div class="row">
                <div class="col-xs-12" style="text-align:right">
                  <style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
                  <a class="take_print" href="printDisposisi.php"><button type="submit" class="btn btn-primary"><i class="fa fa-print"></i>Print Tabel</button></a>
                 </div>
               </div>

               <div class="row">
                 <div class="col-xs-12">
                   <label class="control-label" for="daterange">Periode Document :</label>
                   <form class="form-inline">
                      <div class="form-group">
                       <div class="col-md-10 col-xs-10 row">
                          <div class="input-group " style="font-size:0.5em;">
                             <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
                             <input type="text" class="form-control dpd1" id="start_date_sekretaris" placeholder="From Date" name="start_date_sekretaris" style="font-size:1.4em;">
                             <span class="input-group-addon" style="font-size:1.4em">To</span>
                             <input type="text" class="form-control dpd2" id="end_date_sekretaris" name="end_date_sekretaris" placeholder="To Date" style="font-size:1.4em; border-top-right-radius:0px; border-bottom-right-radius:0px;">
                          </div>
                       </div>
                       <div class="col-md-2 col-xs-2 row">
                           <input type="button" id="filter" name="filter" class="form-control btn btn-primary col-md-1" style="width:60px; border-top-left-radius:0px; border-bottom-left-radius:0px;" value="&#xf002;" />
                       </div>
                       <div style="clear:both;"></div>
                     </div>
                   </form>
                  </div>
               </div>

             <div class="row" style="border: 1px solid black; margin:1%;">
               <div class="col-md-12 col-xs-12">
                 <div id="filter_table" style="padding-top:2%;height:auto; overflow: auto;">
                     <table id="tabelData" class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em;  overflow-y: scroll;">
                         <thead style="background: #595959; color:#fff;">
                           <tr>
                               <th>No</th>
                               <th>Sender</th>
                               <th>Disposisi Date</th>
                               <th>Disposisi Watch</th>
                               <th>File ID</th>
                               <th>File Number</th>
                               <th>File Title</th>
                               <th>File Category</th>
                               <th>Adding Information</th>
                               <th>View</th>
                               <th>Action</th>
                           </tr>
                         </thead>
                         <tbody>
                           <?php require_once("database.php");
                           $penerima=""; $idfile="";
                           $rows_array =  get_data_disposisi_file("SELECT * FROM disposisi_file ");
                           $jum = count($rows_array);
                           $per_hal = 5;
                           $halaman=ceil($jum / $per_hal);
                           $page = isset($_GET['page'])? (int)$_GET['page'] : 1;
                           $start = ($page - 1) * $per_hal;

                           $rows_array = get_data_disposisi_file("SELECT * FROM disposisi_file LIMIT $start, $per_hal");
                           if(count($rows_array) == 0):?>
                               <tr><td colspan="11" style="text-align:center;"> --- There is no file in this menu. ---</td> </tr>
                    <?php else:
                             $no = $start+1;
                             foreach($rows_array as $row):?>
                                <tr> <td name="no" ><?php echo $no++; ?></td>
                                <?php	$pengirim = $row['id_pengirim'];
                                $penerima= $row['iduser'];
                                $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$pengirim."'");
                                if(count($getuserdata_array) > 0):
                                   foreach($getuserdata_array as $rowdisposisi):?>
                                     <td name = "user"><?php echo $rowdisposisi['nama']; ?></td>
                                     <?php endforeach;  endif; ?>
                                     <td name="tglshare"><?php echo $row['tgl_disposisi'];?></td>
                                     <td name="tgldibaca"><?php echo $row['jam_disposisi'];?></td>
                                     <td name="jamdilihat"><?php echo $row['kode_file'];?></td>

                                     <?php $idfile = $row['kode_file'];
                                     $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
                                     if(count($file_array) > 0):
                                       foreach($file_array as $rowfile): ?>
                                         <td name="nofile"><?php echo $rowfile['no_file'];?></td>
                                         <td name="namafile"><?php echo $rowfile['nama_file'];?></td>
                                         <td name="jenis"><?php echo $rowfile['jenis_file'];?></td>
                                         <td name="detail"><?php echo $rowfile['detail_dokumen'];?></td>
                                        <td name="jamdilihat"><?php echo $row['view'];?> times.</td>
                                    <?php
                                        endforeach;
                                      endif;
                                      $id = $idfile."_".$penerima;
                                      ?>
                                 <td class="center">  <input type="submit" name="info-mm" id="" value="&#xf044;" class="btn btn-xs btn-primary" onclick="location.href='detail-disposisi.php?id=<?php echo $id;?>'"/> </td>
                               <?php endforeach;  endif; ?>
                             </tr>
                       </tbody>
                     </table>

                     <div class="row" style="height:80px;">
                       <div class="col-xs-12" style="text-align:center">
                         <div class="pagination pagination-centered">
                           <ul class="pagination">
                             <?php
                                       if($halaman == 1){}
                                       elseif($halaman == 0){}
                                       elseif($_GET['page'] == 1){}
                                       else{$now = $page-1; echo "<li><a href='disposisi.php?page=$now'><i class='fa fa-chevron-left'></i></a></li>";}
                                       for($x=1;$x<=$halaman;$x++){
                                         if($page == $x){
                                         echo "<li><a  href='disposisi.php?page=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
                                         }else{
                                         echo "<li><a  href='disposisi.php?page=$x'>$x</a></li>";
                                         }
                                       }
                               ?>
                               <?php
                                       if($halaman == $page){}
                                       elseif($_GET['page'] < $halaman) {
                                         $now = $page+1;
                                         echo "<li><a href='disposisi.php?page=$now'><i class='fa fa-chevron-right'></i></a></li>";
                                       }
                               ?>
                           </ul>
                         </div>
                       </div>
                     </div>
          <!-- ''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''pagination''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''' -->
                  </div>
              </div>
            </div>
          </div>
          </div>
          </div>
          <!-- ---- delete tujuan disposisi------- -->
          <div class="modal fade" id="delete-data-modal" role="dialog">
          <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background:#737373;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"> <label id="dispo"> <li class="fa fa-exclamation-triangle "></li> SHARE FILE WARNING !</label></h4>
            </div>
                <form action="save-disposisi-share.php" method="post" >
                  <div class="modal-body">

                    <div class="form-group">
                        <label>Do you really to delete share file to this user?</label>
                    </div>

                    <div class="form-group ">
                        <label>ID File:</label><br>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-key "></i></span>
                          <input type="text" name="idDelete" class="form-control" readonly="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Title File:</label><br>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-book "></i></span>
                          <input type="text" name="title" class="form-control" readonly="true">
                        </div>
                    </div>

                    <div class="form-group" style="display:block;">
                        <label>Name:</label><br>
                        <div class="input-group" >
                          <span class="input-group-addon"><i class="fa fa-user "></i></span>
                          <input type="text" name="name" class="form-control" readonly="true" >
                        </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <input type="submit" name="btnDelete" id = "btnDelete" class="btn btn-danger" style="width:30%;" value="Yes, Delete This Share."/>
                  </div>
                </form>
           </div>
          </div>
          </div>
          <!-- ---- delete tujuan disposisi ------- -->

        	</div>
      </section>
    </section>
<!--main content end-->

      <!--footer start-->
      <footer class="site-footer" style="border-bottom: 1px solid #999;background: #737373;">
          <div class="text-center">
               &copy; 2017 Complaint Handling and Services Division BPJS Ketenagakerjaan.
              <a href="disposisi-file.php?page1=1&page2=1" class="go-top">
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

    <script>
    $(".delete-share").click( function(){
      var id = $(this).attr("id");
      title = $(this).find(".title").html();
      name = $(this).find(".name").html();
      $("#delete-data-modal input[name=idDelete]").val(id);
      $("#delete-data-modal input[name=title]").val(title);
      $("#delete-data-modal input[name=name]").val(name);

    });

    </script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#tabelData').DataTable({
					"sDom": "lfrti"
				});
			});
		</script>
		<script type="text/javascript">
		$(document).ready(function() {
			$('#fileUnreaded').DataTable({
				"sDom": "lfrti"
			});
		});
		</script>
		<script>
		$(document).ready(function(){
			$.datepicker.setDefaults({
			dateFormat:'yyyy-mm-dd'
			});

			$('#filter').click(function(){
				 // alert('coba 1');
				var start_date_sekretaris = $('#start_date_sekretaris').val();
				// alert(start_date);
				var end_date_sekretaris = $('#end_date_sekretaris').val();
				// alert(end_date);
				if (start_date_sekretaris != '' && end_date_sekretaris != '') {
				// alert('coba 2');
			    $.ajax({
						url:'search-disposisi-satu.php',
						method:'POST',
						data: {start_date_sekretaris:start_date_sekretaris, end_date_sekretaris:end_date_sekretaris},
						success:function(data){
							// alert(data);
							var JSONObject = JSON.parse(data);
							// alert(JSONObject);
							var temp_ajax = '';
							temp_ajax += '<table class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em;  overflow-y: scroll;">';
							temp_ajax += '<thead style = "background: #595959; color:#fff;">';
							temp_ajax += '<tr>';
							temp_ajax += '<th>No</th>';
							temp_ajax += '<th>Sender</th>';
							temp_ajax += '<th>Disposisi Date</th>';
							temp_ajax += '<th>Disposisi Watch</th>';
							temp_ajax += '<th>File ID</th>';
              temp_ajax += '<th>File Number</th>';
							temp_ajax += '<th>File Title</th>';
							temp_ajax += '<th>File Category</th>';
							temp_ajax += '<th>Adding Information</th>';
              	temp_ajax += '<th>View</th>';
							temp_ajax += '<th>Action</th>';
							temp_ajax += '</tr>';
							temp_ajax += '</thead>';
							temp_ajax += '<tbody>';
							for(var key in JSONObject){
								if (JSONObject.hasOwnProperty(key)) {
					    	// console.log(JSONObject[key]["no"] + ", " + JSONObject[key]["user"]+ ", " + JSONObject[key]["tglshare"]+ ", " + JSONObject[key]["tgldibaca"]+ ", " + JSONObject[key]["jamdilihat"]+ ", " + JSONObject[key]["dilihat"]+ ", " + JSONObject[key]["nofile"]+ ", " + JSONObject[key]["namafile"]+ ", " + JSONObject[key]["jenis"]+ ", " + JSONObject[key]["detail"]);
								console.log(JSONObject['no']);
								// options += '<option value="'+JSONObject[key]["kotakode"]+'">'+JSONObject[key]["kotanama"]+'</option>';
									if (JSONObject[key]["success"] == true) {
										temp_ajax += '<tr>';
										temp_ajax += '<td>'+JSONObject[key]["no"]+'</td>';
										temp_ajax += '<td>'+JSONObject[key]["sender"]+'</td>';
										temp_ajax += '<td>'+JSONObject[key]["dispo"]+'</td>';
										temp_ajax += '<td>'+JSONObject[key]["jam"]+'</td>';
										temp_ajax += '<td>'+JSONObject[key]["idfile"]+'</td>';
										temp_ajax += '<td>'+JSONObject[key]["nofile"]+'</td>';
										temp_ajax += '<td>'+JSONObject[key]["title"]+'</td>';
										temp_ajax += '<td>'+JSONObject[key]["jenis"]+'</td>';
										temp_ajax += '<td>'+JSONObject[key]["perihal"]+'</td>';
                    temp_ajax += '<td>'+JSONObject[key]["view"]+'</td>';
										temp_ajax += '<td class="center">  <a href="detail-share-files.php?id='+JSONObject[key]["idfile"]+'"><input type="button" name="info-mm" value="&#xf044;" class="btn btn-xs btn-primary"/></a> </td>';
										temp_ajax += '</tr>';
									}else{
										temp_ajax += '<tr>';
										temp_ajax += '<td colspan="11">'+JSONObject[key]["warning"]+'</td>';
										temp_ajax += '</tr>';
									}
					    	}
							}
							temp_ajax += '</tbody></table>';
							$('#filter_table').html(temp_ajax);
		      	},
		      	error: function (exception) {
				        alert(exception);
				    }
			    });
				}else{
				  alert("please select the date");
				}
			});
		});
		</script>

  </body>
</html>

<?php }
}?>
