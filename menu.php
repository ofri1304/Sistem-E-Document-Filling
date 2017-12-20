<aside>
		<?php $iduser = $_SESSION['iduser'];?>
    <div id="sidebar"  class="nav-collapse navbar" style="background: #737373;">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <br><p class="centered"><a href="profile.html"><img src="assets/img/profile/<?php echo $iduser; ?>/<?php echo $iduser; ?>.png" class="img-circle" width="140px"></a></p>
						<?php
							require_once("database.php");
							$quote_array = get_all_user("SELECT * FROM user where iduser  LIKE'".$iduser."'");
							if(count($quote_array) > 0):
								foreach($quote_array as $row): ?>
								<h5 class="centered" style="color:#55ccb8; font-size: 0.8em;"><b><?php echo $row['iduser']; ?> </b> </h5>
								<h5 class="centered" style="font-size: 0.8em;"><?php echo $row['nama']; ?></h5>
		            <h5 class="centered" style="font-size: 0.8em;"><?php echo $row['jabatan']; ?></h5>
								<hr style=" border-style: inset; border-width: 1px;">
						<?php endforeach; endif; ?>

            <?php

              $codeAccess = substr($iduser,2,2);
              if($codeAccess == 01 ||  $codeAccess == 03){
             ?>
             <li class="mt"><a href="home.php"><i class="fa fa-home"></i><span class="hidden-sm" style="font-size:13px;">Home</span></a></li>
             <li class="sub-menu"><a href="statistik-chart.php" ><i class="fa fa-bar-chart-o"></i><span class="hidden-sm" style="font-size:13px;">Statistik</span></a></li>
             <li class="sub-menu"><a href="sharefile.php?page1=1&page2=1" ><i class="fa fa-link"></i><span class="hidden-sm" style="font-size:13px;">Share File</span></a></li>
             <li class="sub-menu"><a href="disposisi-file.php?page1=1&&page2=1" ><i class="fa fa-file-text"></i><span class="hidden-sm" style="font-size:13px;">Disposisi File</span></a></li>
             <li class="sub-menu"><a href="profile.php" ><i class="fa fa-user"></i><span class="hidden-sm" style="font-size:13px;">Profile</span></a></li>
						 <!-- <hr style=" border-style: inset; border-width: 1px;"> -->

            <?php } elseif( $codeAccess == 04){ ?>
              <li class="mt"><a href="home.php" ><i class="fa fa-home"></i><span class="hidden-sm" style="font-size:13px;">Home</span></a></li>
              <li class="sub-menu"><a href="statistik-chart.php" ><i class="fa fa-bar-chart-o"></i><span class="hidden-sm" style="font-size:13px;">Statistik</span></a></li>
              <li class="sub-menu"><a href="profile.php" ><i class="fa fa-user"></i><span class="hidden-sm" style="font-size:13px;">Profile</span></a></li>
              <li class="sub-menu"><a href="manage-user.php?page=1" ><i class="fa fa-cog"></i><span class="hidden-sm" style="font-size:13px;">Manage User</span></a></li>
							<!-- <hr style=" border-style: inset; border-width: 1px;"> -->

            <?php } elseif( $codeAccess == 02){ ?>
              <li class="mt"><a href="home.php"><i class="fa fa-home"></i><span class="hidden-sm" style="font-size:13px;">Home</span></a></li>
              <li class="sub-menu"><a href="upload-file.php" ><i class="fa fa-upload"></i><span class="hidden-sm" style="font-size:13px;">Upload File</span></a></li>
              <li class="sub-menu"><a href="statistik-chart.php" ><i class="fa fa-bar-chart-o"></i><span class="hidden-sm" style="font-size:13px;">Statistik</span></a></li>
              <li class="sub-menu"><a href="sharefile.php?page=1" ><i class="fa fa-link"></i><span class="hidden-sm" style="font-size:13px;">Share File</span></a></li>
							 <li class="sub-menu"><a href="disposisi.php?page=1" ><i class="fa fa-file-text"></i><span class="hidden-sm" style="font-size:13px;">Disposisi File</span></a></li>
							<li class="sub-menu"><a href="profile.php" ><i class="fa fa-user"></i><span class="hidden-sm" style="font-size:13px;">Profile</span></a></li>
							<!-- <hr style=" border-style: inset; border-width: 1px;"> -->

            <?php } ?>
         </ul>
            <!-- sidebar menu end-->
       </div>
     </aside>
