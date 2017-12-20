<?php
session_start();
$iduser = $_SESSION['iduser'];
$kode_user= substr($iduser,2,2);

require_once("database.php");
require_once ("assets/fpdf/fpdf.php");

if ($kode_user == 01) {
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

      function ChapterBody($tgldispo, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
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
        $this->Cell(50, 8, 'Tanggal Disposisi ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tgldispo,0,'L',FALSE);

        $this->Ln(8);
        $this->Cell(50, 8, 'Perihal ', 0, 0, 'L', FALSE);
        $this->MultiCell(150,8,": ".$perihal,0,'L',FALSE);
        $this->Ln(8);
      }

      function PrintChapter($tgldispo, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
      {
        $this->AddPage();   // Add chapter
        $this->ChapterBody($tgldispo, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal);
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
      $dispofile = get_data_disposisi_file("SELECT * FROM disposisi_file where idfile LIKE '".$idfiledispo."'");
      if(count($dispofile) > 0){
        foreach($dispofile as $rowdispo){
          $pdf->PrintChapter($rowdispo['tgl_disposisi'], $row['no_file'], $row['jenis_file'], $row['nama_file'], $row['tgl_asal_file'], $row['tgl_upload'], $row['asal_file'], strip_tags($row['detail_dokumen']));

        }
      }
    }
  }

  $pdf->headerTableDispo();
    $dispokepala = get_data_disposisi_kepala("SELECT * FROM kepala where kode_file_asal LIKE '".$idfile."'");
      if(count($dispokepala) > 0){
        $no = 0;
        foreach($dispokepala as $row){
          $user = $row['iduser_staf'];
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
}elseif($kode_user == 03){
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

      function ChapterBody($tgldispo, $tgldikerjakan, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
      {
        $this->SetFont('Times','',12);
        $this->Cell(40,10,'INFORMASI FILE',1,0,'C'); // Title
        // Output text in a 6 cm width column
        $this->Ln(20);
        $this->Cell(40, 8, 'No. File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$file,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Title ', 0, 0, 'L', FALSE);
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
        $this->Cell(40, 8, 'Asal File ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$asal,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Tanggal Disposisi ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tgldispo,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Tanggal Dikerjakan ', 0, 0, 'L', FALSE);
        $this->Cell(60,8,": ".$tgldikerjakan,0,'L',FALSE);

        $this->Ln(10);
        $this->Cell(40, 8, 'Perihal ', 0, 0, 'L', FALSE);
        $this->MultiCell(150,8,": ".$perihal,0,'L',FALSE);
        $this->Ln(10);
      }

      function PrintChapter($tgldispo, $tgldikerjakan, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal)
      {
        $this->AddPage();   // Add chapter
        $this->ChapterBody($tgldispo, $tgldikerjakan, $file, $category, $title, $tglfile, $tglditerima, $asal, $perihal);
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
      $dispokepala = get_data_disposisi_kepala("SELECT * FROM kepala where idfile LIKE '".$idfileuser."'");
        if(count($dispokepala) > 0){
          foreach($dispokepala as $rowdispo){
            $pdf->PrintChapter($rowdispo['tgl_disposisi'], $rowdispo['tgl_dikerjakan'], $row['no_file'], $row['jenis_file'], $row['nama_file'], $row['tgl_asal_file'], $row['tgl_upload'], $row['asal_file'], strip_tags($row['detail_dokumen']));
          }
        }
      }
  }

  $pdf->Output();
}elseif($kode_user == 02){
  class FPDF_AutoWrapTable extends FPDF {
      private $data = array();
      private $options = array(
        'filename' => '',
        'destinationfile' => '',
        'paper_size'=>'A4',
        'orientation'=>'L'
      );

      function __construct($data = array(), $options = array()) {
        parent::__construct();
        $this->data = $data;
        $this->options = $options;
    }
    function Header()
    {

      $date = date('d F Y');
      $this->Image('login/img/LogoBPJSTK.png',25,14,100);
      $this->SetFont('Arial','B',10);
      $this->SetX(380);$this->Cell(0, 1, 'LAPORAN DISPOSISI DATA KANTOR PUSAT','C');

      $this->SetFont('Arial','B',8);
      $this->SetX(25);$this->Cell(0, 10, " ", "B");
      $this->Ln(15);
      $this->SetFont('Arial','B',7);
      $this->SetX(780);$this->Cell(0, 10, 'Tanggal Hari Ini: '.$date, 'R');
      $this->Ln(20);

      $h = 15;
      $top = 50;

      $this->SetFont('Arial','',8);
      $this->SetFillColor(200,200,200);
      $left = $this->GetX();
      $this->Cell(30,$h,'NO',1,0,'C',true);
      $this->SetX($left += 30); $this->Cell(100, $h, 'NO. FILE', 1, 0, 'C',true);
      $this->SetX($left += 100); $this->Cell(80, $h, 'PENGIRIM', 1, 0, 'C',true);
      $this->SetX($left += 80); $this->Cell(80, $h, 'PENERIMA', 1, 0, 'C',true);
      $this->SetX($left += 80); $this->Cell(80, $h, 'JUDUL', 1, 0, 'C',true);
      $this->SetX($left += 80); $this->Cell(80, $h, 'KATEGORI', 1, 0, 'C',true);
      $this->SetX($left += 80); $this->Cell(70, $h, 'TGL FILE', 1, 0, 'C',true);
      $this->SetX($left += 70); $this->Cell(70, $h, 'FILE DITERIMA', 1, 0, 'C',true);
      $this->SetX($left += 70); $this->Cell(70, $h, 'DISPOSISI', 1, 0, 'C',true);
      $this->SetX($left += 70); $this->Cell(80, $h, 'PUKUL DISPOSISI', 1, 0, 'C',true);
      $this->SetX($left += 80); $this->Cell(100, $h, 'PERIHAL', 1, 0, 'C',true);
      $this->Ln(15);
    }

    function footer(){
      $this->SetY(-15);
      $this->SetFont('Arial', '',8);
      $this->Cell(0, -0.9, " ", "B");
      $this->Ln(0);
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    public function rptDetailData ($valign='M') {
      //
      $border = 0;
      $this->AddPage();
      $this->SetAutoPageBreak(true,60);
      $this->AliasNbPages();
      $left = -5;

      $this->SetFont('Arial','',10);
      $this->SetWidths(array(30, 100, 80, 80, 80, 80, 70, 70, 70, 80, 100));
      $this->SetAligns(array('C','C','L','C','C','L','L','L', 'L','L','L'));
      $no = 1; $this->SetFillColor(255);
      foreach ($this->data as $baris) {
        $this->Row(
          array($no++,
          $baris['nofile'],
          $baris['pengirim'],
          $baris['penerima'],
          $baris['judul'],
          $baris['jenis'],
          $baris['tglfile'],
          $baris['tglupld'],
          $baris['tgldispo'],
          $baris['jamdispo'],
          $baris['perihal']
        ));
      }

    }

    public function printPDF () {

      if ($this->options['paper_size'] == "A4") {
        $a = 8.3 * 72; //1 inch = 72 pt
        $b = 13.0 * 72;
        $this->FPDF($this->options['orientation'], "pt", array($a,$b));
      } else {
        $this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
      }

        $this->SetAutoPageBreak(false);
        $this->AliasNbPages();
        $this->SetFont("helvetica", "B", 10);
        //$this->AddPage();

        $this->rptDetailData();

        $this->Output($this->options['filename'],$this->options['destinationfile']);
      }

      private $widths;
    private $aligns;

    function SetWidths($w)
    {
      //Set the array of column widths
      $this->widths=$w;
    }

    function SetAligns($a)
    {
      //Set the array of column alignments
      $this->aligns=$a;
    }

    function Row($data)
    {
      //Calculate the height of the row
      $nb=0;
      for($i=0;$i<count($data);$i++){
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));}
      $h=15*$nb;
      //Issue a page break first if needed
      $this->CheckPageBreak($h);
      //Draw the cells of the row
      for($i=0;$i<count($data);$i++)
      {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,15,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
      }
      //Go to the next line
      $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
      //If the height h would cause an overflow, add a new page immediately
      if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
      //Computes the number of lines a MultiCell of width w will take
      $cw=&$this->CurrentFont['cw'];
      if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
      $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
      $s=str_replace("\r",'',$txt);
      $nb=strlen($s);
      if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
      $sep=-1;
      $i=0;
      $j=0;
      $l=0;
      $nl=1;
      while($i<$nb)
      {
        $c=$s[$i];
        if($c=="\n")
        {
          $i++;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
          continue;
        }
        if($c==' ')
          $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
          if($sep==-1)
          {
            if($i==$j)
              $i++;
          }
          else
            $i=$sep+1;
          $sep=-1;
          $j=$i;
          $l=0;
          $nl++;
        }
        else
          $i++;
      }
      return $nl;
    }
  } //end of class

  //contoh penggunaan
  $dispokepala = get_data_disposisi_file("SELECT * FROM disposisi_file");
      if(count($dispokepala) > 0){  $no = 0;
        foreach($dispokepala as $row){
          $usera = $row['id_pengirim'];
          $userb = $row['iduser'];
          $kodefile = $row['kode_file'];
          $no++; $pengirim =""; $penerima="";
          $file_array = get_data_file("SELECT * FROM file where idfile  LIKE'".$kodefile."'");
          if(count($file_array) > 0){
            foreach($file_array as $rowfile){
              $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$usera."'");
               if(count($getuserdata_array) > 0){
                  foreach($getuserdata_array as $rowuser){
                    $pengirim = $rowuser['nama'];
                  }
                }

               $getuserdata = get_all_user("SELECT * FROM user where iduser LIKE'".$userb."'");
                 if(count($getuserdata) > 0){
                    foreach($getuserdata as $user){
                    $data[] = array(
                      'nofile'	=> $rowfile['no_file'],
                      'pengirim'		  => $pengirim,
                      'penerima' 		=> $user['nama'],
                      'judul' 	=> $rowfile['nama_file'],
                      'jenis' 	  => $rowfile['jenis_file'],
                      'tglfile' 	=> $rowfile['tgl_asal_file'],
                      'tglupld' 	=> $rowfile['tgl_upload'],
                      'tgldispo' 	=> $row['tgl_disposisi'],
                      'jamdispo' 	=> $row['jam_disposisi'],
                      'perihal' 	=> strip_tags($rowfile['detail_dokumen'])
                    );
                  }
               }
            }

          }
        }
      }

  //pilihan
  $options = array(
    'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
    'destinationfile' => '', //I=inline browser (default), F=local file, D=download
    'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
    'orientation'=>'L' //orientation: P=portrait, L=landscape
  );

  $tabel = new FPDF_AutoWrapTable($data, $options);
  $tabel->printPDF();
}

 ?>
