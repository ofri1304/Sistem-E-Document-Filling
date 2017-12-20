<?php
session_start();
$iduser = $_SESSION['iduser'];
$kode_user= substr($iduser,2,2);

require_once("database.php");
require_once ("assets/fpdf/fpdf.php");

if ($kode_user == 02) {
  $idfile = $_GET['id'];
  class FPDF_Print extends FPDF {
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

      function ChapterBody($pengirim, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
      {
        $this->SetFont('Times','',12);
        $this->Cell(40,10,'INFORMASI FILE',1,0,'C'); // Title
        // Output text in a 6 cm width column
        $this->Ln(15);
        $this->Cell(50, 8, 'No. File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$file,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(50, 8, 'Judul ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$title,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(50, 8, 'Jenis File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$category,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(50, 8, 'Tanggal File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tglfile,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(50, 8, 'Tanggal File Diterima ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tglditerima,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(50, 8, 'Asal File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$asal,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(50, 8, 'Pengirim ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$pengirim,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(50, 8, 'Perihal ', 0, 0, 'L', FALSE);
        $this->MultiCell(150,8,": ".$perihal,0,'L',FALSE);
        $this->Ln(8);
      }

      function PrintChapter($pengirim, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
      {
        $this->AddPage();   // Add chapter
        $this->ChapterBody($pengirim, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal);
      }

      function headerTableDispo(){
        $this->SetFont('Times','',12);
        $this->Cell(40,10,'DISPOSISI FILE',1,0,'C'); // Title
        $this->Ln(15);
        $this->SetFont('Arial','',10);
        $this->SetFillColor(200,200,200);
        $this->Cell(20, 8, 'No', 1,0, 'C');
        $this->Cell(57, 8, 'Tujuan Disposisi', 1,0, 'C');
        $this->Cell(57, 8, 'Tanggal Disposisi', 1,0,'C');
        $this->Ln();
      }

      function viewTableDispo($no, $nama, $tgldispo){
        $this->SetFont('Arial','',10);
        $this->Cell(20, 8, $no, 1,0, 'C');
        $this->Cell(57, 8, $nama, 1,0, 'C');
        $this->Cell(57, 8, $tgldispo, 1,0,'C');
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
  $idfiledispo = $idfile."_".$iduser;
  $file_array = get_data_file("SELECT * FROM file where idfile  LIKE'".$idfile."'");
  if(count($file_array) > 0){
    foreach($file_array as $row){
      $dispofile = get_data_disposisi_file("SELECT * FROM disposisi_file where kode_file LIKE '".$idfile."'");
      if(count($dispofile) > 0){
        foreach($dispofile as $rowdispo){
          $ids = $rowdispo['id_pengirim'];
          $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$ids."'");
           if(count($getuserdata_array) > 0){
              foreach($getuserdata_array as $rowuser){
                $pdf->PrintChapter($rowuser['nama'], $row['no_file'], $row['jenis_file'], $row['nama_file'], $row['tgl_asal_file'], $row['tgl_upload'], $row['asal_file'], strip_tags($row['detail_dokumen']));
              }
           }
        }
      }
    }
  }

  $pdf->headerTableDispo();
    $dispotokepala = get_data_disposisi_file("SELECT * FROM disposisi_file where kode_file LIKE '".$idfile."'");
      if(count($dispotokepala) > 0){
        $no = 0;
        foreach($dispotokepala as $row){
          $user = $row['iduser'];
          $no++;
          $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$user."'");
           if(count($getuserdata_array) > 0){
              foreach($getuserdata_array as $rowuser){
                $pdf->viewTableDispo($no,$rowuser['nama'], $row['tgl_disposisi']);
              }
           }
        }
      }
  $pdf->Output();
}
?>
