<?php
session_start();
$iduser = $_SESSION['iduser'];
$kode_user= substr($iduser,2,2);
$idfile = $_GET['id'];
require_once("database.php");
require_once ("assets/fpdf/fpdf.php");

if ($kode_user == 02) {
  class FPDF_Print extends FPDF {
      function __construct($data = array(), $options = array()) {
        parent::__construct();
        $this->data = $data;
        $this->options = $options;
      }
      function Header()
      {

        $date = date('d F Y');
        $this->Image('login/img/LogoBPJSTK.png',10,5,55);
        $this->SetFont('Arial','B',10);

        $this->Cell(70); // Move to the right
        $this->Cell(55,30,'DETAIL FILE KANTOR PUSAT',0,0,'C'); // Title
        $this->Ln(9); // Line break

        $this->SetFont('Arial','B',8);
        $this->Cell(140); // Move to the right
        $this->Cell(55,30,$date,0,0,'C'); // Title
        $this->Ln(25); // Line break
      }

      function ChapterBody($file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
      {
        $this->SetFont('Times','',12);
        $this->Cell(40,10,'INFORMASI FILE',1,0,'C'); // Title
        // Output text in a 6 cm width column
        $this->Ln(15);
        $this->Cell(40, 8, 'No. File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$file,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(40, 8, 'Title ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$title,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(40, 8, 'Jenis File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$category,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(40, 8, 'Tanggal File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tglfile,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(40, 8, 'Tanggal File Diterima ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tglditerima,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(40, 8, 'Asal File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$asal,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(40, 8, 'Perihal ', 0, 0, 'L', FALSE);
        $this->MultiCell(150,8,": ".$perihal,0,'L',FALSE);
        $this->Ln(8);
      }

      function PrintChapter($file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
      {
        $this->AddPage();   // Add chapter
        $this->ChapterBody($file, $category, $title, $tglfile, $tglditerima, $asal, $perihal);
      }

      function headerTableShare(){
        $this->Ln(8);
        $this->SetFont('Times','',12);
        $this->Cell(40,10,'SHARE FILE',1,0,'C'); // Title
        $this->Ln(15);
        $this->SetFont('Arial','',10);
        $this->SetFillColor(200,200,200);
        $this->Cell(20, 8, 'No', 1,0, 'C');
        $this->Cell(57, 8, 'Tujuan Share', 1,0, 'C');
        $this->Cell(57, 8, 'Tanggal Share', 1,0,'C');
        $this->Ln();
      }
      function viewTableShare($no, $nama, $tglshare){
        $this->SetFont('Arial','',10);
        $this->Cell(20, 8, $no, 1,0, 'C');
        $this->Cell(57, 8, $nama, 1,0, 'C');
        $this->Cell(57, 8, $tglshare, 1,0,'C');
        $this->Ln();
      }

      function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial', '',8);
        $this->Cell(0, -0.9, " ", "B");
        $this->Ln(0);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
      }


  }

  $pdf = new FPDF_Print('P','mm','A4');
  $pdf->AliasNbPages();
  $file_array = get_data_file("SELECT * FROM file where idfile  LIKE'".$idfile."'");
  if(count($file_array) > 0){
    foreach($file_array as $row){
      $pdf->PrintChapter($row['no_file'], $row['jenis_file'], $row['nama_file'], $row['tgl_asal_file'], $row['tgl_upload'], $row['asal_file'], strip_tags($row['detail_dokumen']));
    }
  }

  $pdf->headerTableShare();
      $share_array = get_data_share_file("SELECT * FROM share_file where kode_file LIKE'".$idfile ."' ");
      if(count($share_array) > 0){
        $no = 0;
        foreach($share_array as $rowshare){
          $iduser = $rowshare['iduser'];
          $no++;
          $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduser."'");
            if(count($getuserdata_array) > 0){
              foreach($getuserdata_array as $rowuser){
                $pdf->viewTableShare($no, $rowuser['nama'], $rowshare['tgl_share']);
              }
            }
        }
      }
  $pdf->Output();
}else{

  class FPDF_Print extends FPDF {
      function __construct($data = array(), $options = array()) {
        parent::__construct();
        $this->data = $data;
        $this->options = $options;
      }
      function Header()
      {

        $date = date('d F Y');
        $this->Image('login/img/LogoBPJSTK.png',10,5,55);
        $this->SetFont('Arial','B',10);

        $this->Cell(70); // Move to the right
        $this->Cell(55,30,'DETAIL FILE KANTOR PUSAT',0,0,'C'); // Title
        $this->Ln(9); // Line break

        $this->SetFont('Arial','B',8);
        $this->Cell(140); // Move to the right
        $this->Cell(55,30,$date,0,0,'C'); // Title
        $this->Ln(25); // Line break
      }

      function ChapterBody($tglshare, $tujuan, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
      {
        $this->SetFont('Times','',12);
        $this->Cell(40,10,'INFORMASI FILE',1,0,'C'); // Title
        // Output text in a 6 cm width column
        $this->Ln(15);
        $this->Cell(40, 8, 'Kepada ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tujuan,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'No. File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$file,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Judul ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$title,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Jenis File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$category,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Tanggal File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tglfile,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Tanggal File Diterima ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tglditerima,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Tanggal Sharing File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tglshare,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Asal File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$asal,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Perihal ', 0, 0, 'L', FALSE);
        $this->MultiCell(150,8,": ".$perihal,0,'L',FALSE);
        $this->Ln(10);
      }

      function PrintChapter($tglshare,$tujuan, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
      {
        $this->AddPage();   // Add chapter
        $this->ChapterBody($tglshare,$tujuan, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal);
      }

      function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial', '',8);
        $this->Cell(0, -0.9, " ", "B");
        $this->Ln(0);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
      }


  }

  $pdf = new FPDF_Print('P','mm','A4');
  $pdf->AliasNbPages();
  $idfileuser = $idfile."_".$iduser;
  $file_array = get_data_file("SELECT * FROM file where idfile  LIKE'".$idfile."'");
  if(count($file_array) > 0){
    foreach($file_array as $row){
      $file_array = get_data_share_file("SELECT * FROM share_file where idfile  LIKE'".$idfileuser."'");
      if(count($file_array) > 0){
        foreach($file_array as $rowshare){
          $userdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduser."'");
          if(count($userdata_array) > 0){
            foreach($userdata_array as $tujuan){
              $pdf->PrintChapter($rowshare['tgl_share'],$tujuan['nama'],$row['no_file'], $row['jenis_file'], $row['nama_file'], $row['tgl_asal_file'], $row['tgl_upload'], $row['asal_file'], strip_tags($row['detail_dokumen']));
            }
          }
        }
      }
    }
  }

  $pdf->Output();
}

 ?>
