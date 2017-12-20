
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-body">
		<div class="row">
			<div class="col-xs-12" style="text-align:right">
				<style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
				<a class="take_print" href="cetak_data_sharefile.php"><button type="submit" class="btn btn-primary"><i class="fa fa-print"></i>Print Tabel</button></a>
			 </div>
		 </div>

		 <div class="row" style="margin:1px;">
			 <div class="col-xs-12">
				 <div style="text-align:left;">
					 <h4 class="control-label" for="daterange" style="color:grey;">A. File Belum Dibaca</h4>
				 </div>
				 <div style="text-align:left;">
				<label class="control-label" for="daterange">Periode File :</label>
				<form class="form-inline">
					 <div class="form-group">
						<div class="col-md-10 col-xs-10 row">
							 <div class="input-group " style="font-size:0.5em;">
									<!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
									<input type="text" class="form-control dpd1" id="start_date_belum_dibaca" placeholder="From Date" name="start_date_belum_dibaca" style="font-size:1.4em;">
									<span class="input-group-addon" style="font-size:1.4em">To</span>
									<input type="text" class="form-control dpd2" id="end_date_belum_dibaca" placeholder="To Date" name="end_date_belum_dibaca" style="font-size:1.4em; border-top-right-radius:0px; border-bottom-right-radius:0px;">
							 </div>
						</div>
						<div class="col-md-2 col-xs-2 row">
								<input type="button" id="filterBelumDibaca" name="filterBelumDibaca" class="form-control btn btn-primary col-md-1" value="&#xf002" style="width:60px; border-top-left-radius:0px; border-bottom-left-radius:0px;"/>
						</div>
					</div>
				</form>
			 </div>
		 </div>
	 </div>

	 <div class="row" style="border: 1px solid black; margin: 1%;">
		 <div class="content-panel col-lg-12 col-xs-12">
			 <div id="file_table1" style="height:auto; overflow: auto;">
					 <table id="fileUnreaded" class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em;  overflow-y: scroll;">
							 <thead style="background: #595959; color:#fff;">
								 <tr>
										 <th>No</th>
										 <th>Share Date</th>
										 <th>File Number</th>
										 <th>ID File</th>
										 <th>File Title</th>
										 <th>File Category</th>
										 <th>Adding Information</th>
										 <th>File By</th>
										 <th>Date of File</th>
										 <th>Action</th>
								 </tr>
							 </thead>
							 <tbody>
								 <?php require_once("database.php");
								 $share_array = get_data_share_file("SELECT * FROM share_file WHERE iduser LIKE '".$iduser."' AND status_dibaca = 0");
								 $jum = count($share_array);
								 $per_hal=5;
								 $halaman=ceil($jum / $per_hal);
								 $page = isset($_GET['page1'])? (int)$_GET['page1'] : 1;
								 $start = ($page - 1) * $per_hal;


								 $rows_array =get_data_share_file("SELECT * FROM share_file WHERE iduser LIKE '".$iduser."' AND status_dibaca = 0 LIMIT $start, $per_hal");
								 if(count($rows_array) == 0):?>
										 <tr>
												 <td colspan="10" style="text-align:center;"> --- There is no file in this menu. ---</td>
										 </tr>
									 <?php else:
										 $no = 1;
										 foreach($rows_array as $row):?>
											 <tr>
												 <td name="no"><?php echo $no++; ?></td>
												 <td name="tglshare"><?php echo $row['tgl_share'];?></td>
												 <?php $idfile = $row['kode_file'];
												 $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
												 if(count($file_array) > 0):
													 foreach($file_array as $rowfile): ?>
													 	 <td name="nofile"><?php echo $rowfile['no_file'];?></td>
														 <td name="idfile"><?php echo $row['idfile'];?></td>
														 <td name="file"><?php echo $rowfile['nama_file'];?></td>
														 <td name="jenis"><?php echo $rowfile['jenis_file'];?></td>
														 <td name="perihal"><?php echo $rowfile['detail_dokumen'];?></td>
														 <td name="asal"><?php echo $rowfile['asal_file'];?></td>
														 <td name="tglfile"><?php echo $rowfile['tgl_asal_file'];?></td>
													 <?php endforeach;  endif; $id = $idfile."_".$iduser;?>
											 <td>  <input type="submit" name="info-mm" onclick="location.href='detail-share-files.php?id=<?php echo $id;?>'" value="&#xf044;" class="btn btn-xs btn-primary" /></td>
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
														 elseif($_GET['page1'] == 1){}
														 else{$now = $page-1; echo "<li><a href='sharefile.php?page1=$now&&page2=1'><i class='fa fa-chevron-left'></i></a></li>";}
														 for($x=1;$x<=$halaman;$x++){
															 if($page == $x){
															 echo "<li><a  href='sharefile.php?page1=$x&&page2=1'><b style='color:#FFCA0C'>$x</b></a></li>";
															 }else{
															 echo "<li><a  href='sharefile.php?page1=$x&&page2=1'>$x</a></li>";
															 }
														 }
										 ?>
										 <?php
														 if($halaman == $page){}
														 elseif($_GET['page1'] < $halaman) {
															 $now = $page+1;
															 echo "<li><a href='sharefile.php?page1=$now&&page2=1'><i class='fa fa-chevron-right'></i></a></li>";
														 }
										 ?>
								 </ul>
							 </div>
						 </div>
					 </div>
		 	 		</div>
 				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="row" style="margin:1px;">
 				<div class="col-xs-12">
				 <div style="text-align:left;">
					 <h4 class="control-label" for="daterange" style="color:grey;">B. File Sudah Dibaca</h4>
				 </div>
				 <div style="text-align:left;">
				 <label class="control-label" for="daterange">Periode File :</label>
				 <form class="form-inline">
						<div class="form-group">
						 <div class="col-md-10 col-xs-10 row">
								<div class="input-group " style="font-size:0.5em;">
									 <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
									 <input type="text" class="form-control dpd1" id="start_date_dibaca" placeholder="From Date" name="start_date_dibaca" style="font-size:1.4em;">
									 <span class="input-group-addon" style="font-size:1.4em">To</span>
									 <input type="text" class="form-control dpd2" placeholder="To Date" id="end_date_dibaca" name="end_date_dibaca" style="font-size:1.4em; border-top-right-radius:0px; border-bottom-right-radius:0px;">
								</div>
						 </div>
						 <div class="col-md-2 col-xs-2 row">
								 <input type="button" id="filterSudahDibaca" name="filterSudahDibaca" class="form-control btn btn-primary col-md-1" value="&#xf002" style="width:60px; border-top-left-radius:0px; border-bottom-left-radius:0px;"/>
						 </div>
					 </div>
				 </form>
				</div>
 		</div>
</div>

<div class="row" style="border: 1px solid black; margin:1%;">
 <div class="content-panel col-md-12 col-xs-12">
	 <div id="file_table2" style="height:auto; overflow: auto;">
		 <table id="tabelData" class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em;  overflow-y: scroll;">
				 <thead style="background: #595959; color:#fff;">
					 <tr>
							 <th>No</th>
							 <th>Share Date</th>
							 <th>File Number</th>
							 <th>ID File</th>
							 <th>File Title</th>
							 <th>File Category</th>
							 <th>Adding Information</th>
							 <th>File From</th>
							 <th>Date of Memo</th>
							 <th>Action</th>
					 </tr>
				 </thead>
				 <tbody>
					 <?php require_once("database.php");
					 $share_array = get_data_share_file("SELECT * FROM share_file WHERE iduser LIKE '".$iduser."' AND status_dibaca = 0");
					 $jum = count($share_array);
					 $per_hal=5;
					 $halaman=ceil($jum / $per_hal);
					 $page = isset($_GET['page2'])? (int)$_GET['page2'] : 1;
					 $start = ($page - 1) * $per_hal;

					 $rows_array =get_data_share_file("SELECT * FROM share_file WHERE iduser LIKE '".$iduser."' AND status_dibaca = 1 LIMIT $start, $per_hal");
					 if(count($rows_array) == 0):?>
							 <tr>
									 <td colspan="9" style="text-align:center;"> --- There is no document in this menu. ---</td>
							 </tr>
						 <?php else:
							 $no = 1;
							 foreach($rows_array as $row):?>
								 <tr>
									 <td name="no"><?php echo $no++; ?></td>
									 <td name="tglshare"><?php echo $row['tgl_share'];?></td>

									 <?php $idfile = $row['kode_file'];
									 $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
									 if(count($file_array) > 0):
										 foreach($file_array as $rowfile): ?>
										   <td name="file"><?php echo $rowfile['no_file'];?></td>
										 	 <td name="idfile"><?php echo $row['idfile'];?></td>
											 <td name="file"><?php echo $rowfile['nama_file'];?></td>
											 <td name="jenis"><?php echo $rowfile['jenis_file'];?></td>
											 <td name="perihal"><?php echo $rowfile['detail_dokumen'];?></td>
											 <td name="asal"><?php echo $rowfile['asal_file'];?></td>
											 <td name="tglfile"><?php echo $rowfile['tgl_asal_file'];?></td>
										 <?php endforeach;  endif;
										 $id = $idfile."_".$iduser;?>
								 <td>  <input type="submit" name="info-mm" onclick="location.href='detail-share-files.php?id=<?php echo $id;?>'" value="&#xf044;" class="btn btn-xs btn-primary" /></td>
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
														 elseif($_GET['page2'] == 1){}
														 else{$now = $page-2; echo "<li><a href='sharefile.php?page1=1&&page2=$now'><i class='fa fa-chevron-left'></i></a></li>";}
														 for($x=1;$x<=$halaman;$x++){
															 if($page == $x){
															 echo "<li><a  href='sharefile.php?page1=1&&page2=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
															 }else{
															 echo "<li><a  href='sharefile.php?page1=1&&page2=$x'>$x</a></li>";
															 }
														 }
										 ?>
										 <?php
														 if($halaman == $page){}
														 elseif($_GET['page2'] < $halaman) {
															 $now = $page+1;
															 echo "<li><a href='sharefile.php?page1=1&&page2=$now'><i class='fa fa-chevron-right'></i></a></li>";
														 }
										 ?>
								 </ul>
				 				</div>
			 				</div>
		 				</div>
 					</div>
				</div>
			</div>
		</div>
	</div>
</div>
  </body>
</html>
