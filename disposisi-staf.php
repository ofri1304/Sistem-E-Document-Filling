<?php $iduser = $_SESSION['iduser'];?>
<div class="col-lg-12 col-xs-12">
  <div class="panel panel-default">
    <div class="panel-body">
    <div class="row">
      <div class="col-xs-12" style="text-align:right">
        <style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
        <a class="take_print" href="cetak_data_disposisi.php"><button type="submit" class="btn btn-primary"><i class="fa fa-print"></i>Print Tabel</button></a>
       </div>
     </div>

     <div class="row" style="margin:1px;">
       <div class="col-xs-12">
         <div style="text-align:left;">
           <h4 class="control-label" for="daterange" style="color:grey;">A. File Belum Dibaca</h4>
         </div>
         <div style="text-align:left;">
         <label class="control-label" for="daterange">Periode Disposisi Document :</label>
         <form class="form-inline">
            <div class="form-group">
             <div class="col-md-10 col-xs-10 row">
                <div class="input-group " style="font-size:0.5em;">
                   <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
                   <input type="text" class="form-control dpd1" id="start_date_staf1" name="start_date_staf1" placeholder="From Date" style="font-size:1.4em;">
                   <span class="input-group-addon" style="font-size:1.4em">To</span>
                   <input type="text" class="form-control dpd2" id="end_date_staf1" name="end_date_staf1" placeholder="To Date" style="font-size:1.4em; border-top-right-radius:0px; border-bottom-right-radius:0px;">
                </div>
             </div>
             <div class="col-md-2 col-xs-2 row">
                 <input type="button" id="filterBelumDibaca3" name="filterBelumDibaca3" class="form-control btn btn-primary col-md-1" value="&#xf002" style="width:60px; border-top-left-radius:0px; border-bottom-left-radius:0px;"/>
             </div>
             <div style="clear:both;"></div>
           </div>
         </form>
         </div>
        </div>
     </div>

   <div class="row" style="border: 1px solid black; margin:1%;">
     <div class="col-md-12 col-xs-12">
       <div id="file_table3" style="padding-top:2%;height:auto; overflow: auto;">
           <table class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em;  overflow-y: scroll;">
               <thead style="background: #595959; color:#fff;">
                 <tr>
                     <th>No</th>
                     <th>File Number</th>
                     <th>File ID</th>
                     <th>Disposisi Date</th>
                     <th>Upload Date</th>
                     <th>File Date</th>
                     <th>File From</th>
                     <th>File Title</th>
                     <th>File Category</th>
                     <th>Adding Information</th>
                     <th>Disposisi From</th>
                     <th>Action</th>
                 </tr>
               </thead>
               <tbody>
                 <?php require_once("database.php");
                 $disposisi_array =  get_data_disposisi_kepala("SELECT * FROM kepala where iduser_staf LIKE'".$iduser."' AND status_dibaca = 0");
                 $jum = count($disposisi_array);
                 $per_hal=10;
                 $halaman=ceil($jum / $per_hal);
                 $page = isset($_GET['page1'])? (int)$_GET['page1'] : 1;
                 $start = ($page - 1) * $per_hal;

                 $rows_array = get_data_disposisi_kepala("SELECT * FROM kepala WHERE iduser_staf LIKE'".$iduser."' AND status_dibaca = 0 LIMIT $start, $per_hal");
                 if(count($rows_array) == 0):?>
                     <tr>
                         <td colspan="12" style="text-align:center;"> --- There is no file in this menu. ---</td>
                     </tr>
                     <?php else:
                       $no = 1;
                       foreach($rows_array as $row): ?>
                         <tr>
                          <td name="no"><?php echo $no++; ?></td>
                         <?php $id = $row['kode_file_asal'];
                         $file_array =get_data_file("SELECT * FROM file WHERE idfile LIKE'".$id."'");
                         if(count($file_array > 0)):
                           foreach($file_array as $rows): ?>
                              <td name="nofile"><?php echo $rows['no_file']; ?></td>
                              <td name="idfile"><?php echo $rows['idfile']; ?></td>
                              <td name="tgldispo"><?php echo $row['tgl_disposisi']; ?></td>
                              <td name="tglupload"><?php echo $rows['tgl_upload']; ?></td>
                              <td name="tglfile"><?php echo $rows['tgl_asal_file']; ?></td>
                              <td name="asalfile"><?php echo $rows['asal_file']; ?></td>
                              <td name="namafile"><?php echo $rows['nama_file']; ?></td>
                              <td name="jenis"><?php echo $rows['jenis_file']; ?></td>
                              <td name="perihal"><?php echo $rows['detail_dokumen']; ?></td>
                        <?php endforeach;  endif;
                        $id = $id."_".$iduser;
                        $dispokepala_array = get_data_disposisi_kepala("SELECT * FROM kepala where idfile LIKE'".$id."'"); $nourutan2 = 0;
                        if(count($dispokepala_array) > 0):?>
                        
                         <?php
                         foreach($dispokepala_array as $rowstaf):
                           $nourutan2 += 1;
                            $iduserkepala = $rowstaf['iduser_kepala'];
                             $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduserkepala."'");
                             if(count($getuserdata_array) > 0):
                               foreach($getuserdata_array as $rowuser): ?>
                                   <td name="dispodari"><?php echo $rowuser['nama']; ?></td>
                            <?php  endforeach;  endif;
                          endforeach; endif;?>
                        <td>  <input type="submit" name="info-mm" onclick="location.href='detail-disposisi-file.php?id=<?php echo $row['idfile'];?>&&page=1'" value="&#xf044;" class="btn btn-xs btn-primary" /></td>
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
                             else{$now = $page-1; echo "<li><a href='disposisi-file.php?page1=$now'><i class='fa fa-chevron-left'></i></a></li>";}
                             for($x=1;$x<=$halaman;$x++){
                               if($page == $x){
                               echo "<li><a  href='disposisi-file.php?page1=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
                               }else{
                               echo "<li><a  href='disposisi-file.php?page1=$x'>$x</a></li>";
                               }
                             }
                     ?>
                     <?php
                             if($halaman == $page){}
                             elseif($_GET['page1'] < $halaman) {
                               $now = $page+1;
                               echo "<li><a href='disposisi-file.php?page1=$now'><i class='fa fa-chevron-right'></i></a></li>";
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

<div class="col-lg-12 col-xs-12">
<div class="panel panel-default">
<div class="panel-body">
<div class="row" style="margin:1px;">
 <div class="col-xs-12">
   <div style="text-align:left;">
     <h4 class="control-label" for="daterange" style="color:grey;">B. File Sudah Dibaca</h4>
   </div>
   <div style="text-align:left;">
   <label class="control-label" for="daterange">Periode Disposisi Document :</label>
   <form class="form-inline">
      <div class="form-group">
       <div class="col-md-10 col-xs-10 row">
          <div class="input-group " style="font-size:0.5em;">
             <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
             <input type="text" class="form-control dpd1" id="start_date_staf2" name="start_date_staf2" placeholder="From Date" style="font-size:1.4em;">
             <span class="input-group-addon" style="font-size:1.4em">To</span>
             <input type="text" class="form-control dpd2" id="end_date_staf2" name="end_date_staf2" placeholder="To Date" style="font-size:1.4em; border-top-right-radius:0px; border-bottom-right-radius:0px;">
          </div>
       </div>
       <div class="col-md-2 col-xs-2 row">
           <input type="button" id="filterDibacaStaf4" name="filterDibacaStaf4" class="form-control btn btn-primary col-md-1" value="&#xf002" style="width:60px; border-top-left-radius:0px; border-bottom-left-radius:0px;"/>
       </div>
       <div style="clear:both;"></div>
     </div>
   </form>
 </div>
</div>
</div>

<div class="row" style="border: 1px solid black; margin:1%;">
<div class="col-md-12 col-xs-12">
 <div id="file_table4" style="padding-top:2%;height:auto; overflow: auto;">
     <table class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em;  overflow-y: scroll;">
         <thead style="background: #595959; color:#fff;">
           <tr>
             <th>No</th>
             <th>File Number</th>
             <th>File ID</th>
             <th>Disposisi Date</th>
             <th>Upload Date</th>
             <th>File Date</th>
             <th>File From</th>
             <th>File Title</th>
             <th>File Category</th>
             <th>Adding Information</th>
             <th>Disposisi From</th>
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
           <?php require_once("database.php");
           $disposisi_array =  get_data_disposisi_kepala("SELECT * FROM kepala where iduser_staf LIKE'".$iduser."' AND status_dibaca = 1");
           $jum = count($disposisi_array);
           $per_hal=10;
           $halaman=ceil($jum / $per_hal);
           $page = isset($_GET['page2'])? (int)$_GET['page2'] : 1;
           $start = ($page - 1) * $per_hal;

           $rows_array = get_data_disposisi_kepala("SELECT * FROM kepala WHERE iduser_staf LIKE'".$iduser."' AND status_dibaca = 1 LIMIT $start, $per_hal");
           if(count($rows_array) == 0):?>
               <tr>
                   <td name = "nofound" colspan="12" style="text-align:center;"> --- There is no file in this menu. ---</td>
               </tr>
               <?php else:
                 $no = 1;
                 foreach($rows_array as $row): ?>
                   <tr>
                    <td name="no"><?php echo $no++; ?></td>
                   <?php $id = $row['kode_file_asal'];
                   $file_array =get_data_file("SELECT * FROM file WHERE idfile LIKE'".$id."'");
                   if(count($file_array > 0)):
                     foreach($file_array as $rows): ?>
                     <td name="nofile"><?php echo $rows['no_file']; ?></td>
                     <td name="idfile"><?php echo $rows['idfile']; ?></td>
                     <td name="tgldispo"><?php echo $row['tgl_disposisi']; ?></td>
                     <td name="tglupload"><?php echo $rows['tgl_upload']; ?></td>
                     <td name="tglfile"><?php echo $rows['tgl_asal_file']; ?></td>
                     <td name="asalfile"><?php echo $rows['asal_file']; ?></td>
                     <td name="namafile"><?php echo $rows['nama_file']; ?></td>
                     <td name="jenis"><?php echo $rows['jenis_file']; ?></td>
                     <td name="perihal"><?php echo $rows['detail_dokumen']; ?></td>
                  <?php endforeach;  endif;
                  $id = $id."_".$iduser;
                  $dispokepala_array = get_data_disposisi_kepala("SELECT * FROM kepala where idfile LIKE'".$id."'"); $nourutan2 = 0;
                  if(count($dispokepala_array > 0)):?>

                   <?php
                   foreach($dispokepala_array as $rowstaf):
                     $nourutan2 += 1;
                      $iduserkepala = $rowstaf['iduser_kepala'];
                       $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduserkepala."'");
                       if(count($getuserdata_array) > 0):
                         foreach($getuserdata_array as $rowuser): ?>
                           <td name="dispodari"><?php echo $rowuser['nama']; ?></td>
                       <?php endforeach;  endif;
                   endforeach; endif;?>
                  <td>  <input type="submit" name="info-mm" onclick="location.href='detail-disposisi-file.php?id=<?php echo $row['idfile'];?>&&page=1'" value="&#xf044;" class="btn btn-xs btn-primary" /></td>
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
                       else{$now = $page-1; echo "<li><a href='disposisi-file.php?page1=1&&page2=$now'><i class='fa fa-chevron-left'></i></a></li>";}
                       for($x=1;$x<=$halaman;$x++){
                         if($page == $x){
                         echo "<li><a  href='disposisi-file.php?page1=1&&page2=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
                         }else{
                         echo "<li><a  href='disposisi-file.php?page1=1&&page2=$x'>$x</a></li>";
                         }
                       }
               ?>
               <?php
                       if($halaman == $page){}
                       elseif($_GET['page2'] < $halaman) {
                         $now = $page+1;
                         echo "<li><a href='disposisi-file.php?page1=1&&page2=$now'><i class='fa fa-chevron-right'></i></a></li>";
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
