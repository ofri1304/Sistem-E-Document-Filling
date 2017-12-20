
<div class="col-lg-12">
  <div class="panel panel-default">
    <div class="panel-body">
    <div class="row">
      <div class="col-xs-12" style="text-align:right">
        <style>.take_print:hover{color:#FFF;text-decoration:none;}</style>
        <a class="take_print" href="cetak_data_sharefile.php"><button type="submit" class="btn btn-primary"><i class="fa fa-print"></i>Print Tabel</button></a>
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
                   <input type="text" class="form-control dpd1" id="start_date" placeholder="From Date" name="start_date" style="font-size:1.4em;">
                   <span class="input-group-addon" style="font-size:1.4em">To</span>
                   <input type="text" class="form-control dpd2" id="end_date" name="end_date" placeholder="To Date" style="font-size:1.4em; border-top-right-radius:0px; border-bottom-right-radius:0px;">
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
       <div id="file_table" style="padding-top:2%;height:auto; overflow: auto;">
           <table id="tabelData" class="table table-striped table-bordered bootstrap-datatable datatable" style="font-size:0.8em;  overflow-y: scroll;">
               <thead style="background: #595959; color:#fff;">
                 <tr>
                     <th>No</th>
                     <th>File Received By</th>
                     <th>Share Date</th>
                     <th>Seen Date</th>
                     <th>Seen Watch</th>
                     <th>Seen On</th>
                     <th>File ID</th>
                     <th>File Number</th>
                     <th>File Title</th>
                     <th>File Category</th>
                     <th>Adding Information</th>
                     <th>Action</th>
                 </tr>
               </thead>
               <tbody>
                 <?php require_once("database.php");
                 $penerima=""; $idfile="";
                 $rows_array =  get_data_share_file("SELECT * FROM share_file where id_pengirim LIKE '".$iduser."'");
                 $jum = count($rows_array);
                 $per_hal = 5;
                 $halaman=ceil($jum / $per_hal);
                 $page = isset($_GET['page'])? (int)$_GET['page'] : 1;
                 $start = ($page - 1) * $per_hal;

                 $rows_array = get_data_share_file("SELECT * FROM share_file where id_pengirim LIKE '".$iduser."' LIMIT $start, $per_hal");
                 if(count($rows_array) == 0):?>
                     <tr>
                         <td colspan="12" style="text-align:center;"> --- There is no file in this menu. ---</td>
                     </tr>
                   <?php else:
                   $no = $start+1;
                   foreach($rows_array as $row):?>
                   <tr> <td name="no" ><?php echo $no++; ?></td>
                   <?php	$penerima = $row['iduser'];
                     $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$penerima."'");
                       if(count($getuserdata_array) > 0):
                         foreach($getuserdata_array as $rowusershare):?>
                           <td name = "user"><?php echo $rowusershare['nama']; ?></td>
                     <?php endforeach;  endif; ?>
                     <td name="tglshare"><?php echo $row['tgl_share'];?></td>
                     <td name="tgldibaca"><?php echo $row['tgl_dibaca'];?></td>
                     <td name="jamdilihat"><?php echo $row['jam_dibaca'];?></td>
                     <td name="dilihat"><?php echo $row['view'];?> times</td>
                     <td name="nofile"><?php echo $row['idfile'];?></td>

                       <?php $idfile = $row['kode_file'];
                       $file_array = get_data_file("SELECT * FROM file where idfile LIKE'".$idfile."'");
                       if(count($file_array) > 0):
                         foreach($file_array as $rowfile): ?>
                           <td name="nofile"><?php echo $rowfile['no_file'];?></td>
                           <td name="namafile"><?php echo $rowfile['nama_file'];?></td>
                           <td name="jenis"><?php echo $rowfile['jenis_file'];?></td>
                           <td name="detail"><?php echo $rowfile['detail_dokumen'];?></td>
                       <?php
                          endforeach;
                        endif;
                        $id = $idfile."_".$penerima;

                       ?>
                       <td class="center">  <input type="submit" name="info-mm" id="" value="&#xf044;" class="btn btn-xs btn-primary" onclick="location.href='detail-share-files.php?id=<?php echo $id;?>'"/> </td>
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
                             else{$now = $page-1; echo "<li><a href='sharefile.php?page=$now'><i class='fa fa-chevron-left'></i></a></li>";}
                             for($x=1;$x<=$halaman;$x++){
                               if($page == $x){
                               echo "<li><a  href='sharefile.php?page=$x'><b style='color:#FFCA0C'>$x</b></a></li>";
                               }else{
                               echo "<li><a  href='sharefile.php?page=$x'>$x</a></li>";
                               }
                             }
                     ?>
                     <?php
                             if($halaman == $page){}
                             elseif($_GET['page'] < $halaman) {
                               $now = $page+1;
                               echo "<li><a href='sharefile.php?page=$now'><i class='fa fa-chevron-right'></i></a></li>";
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
