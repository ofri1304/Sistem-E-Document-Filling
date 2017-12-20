<?php
session_start();
$iduser = $_SESSION['iduser'];
$kode_akses_user = substr($iduser,2,2);
require_once("database.php");
require_once ("assets/fpdf/fpdf.php");
if($kode_akses_user == 01){
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

    $this->SetFont('Arial','',10);
    $this->SetFillColor(200,200,200);
    $left = $this->GetX();
    $this->Cell(30,$h,'NO',1,0,'C',true);
    $this->SetX($left += 30); $this->Cell(150, $h, 'PENERIMA FILE', 1, 0, 'C',true);
    $this->SetX($left += 150); $this->Cell(110, $h, 'PENGIRIM FILE', 1, 0, 'C',true);
    $this->SetX($left += 110); $this->Cell(110, $h, 'NOMOR SURAT', 1, 0, 'C',true);
    $this->SetX($left += 110); $this->Cell(110, $h, 'JUDUL', 1, 0, 'C',true);
    $this->SetX($left += 110); $this->Cell(110, $h, 'KATEGORI', 1, 0, 'C',true);
    $this->SetX($left += 110); $this->Cell(110, $h, 'PERIHAL', 1, 0, 'C',true);
    $this->SetX($left += 110); $this->Cell(75, $h, 'DISPOSISI', 1, 0, 'C',true);
    $this->SetX($left += 75); $this->Cell(75, $h, 'DEADLINE', 1, 0, 'C',true);
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
    $this->SetWidths(array(30,150,110,110,110,110,110,75,75));
    $this->SetAligns(array('C','L','L','L','L','L','L','C','C'));
		$no = 1; $this->SetFillColor(255);
		foreach ($this->data as $baris) {
			$this->Row(
        array($no++,
        $baris['penerima'],
        $baris['pengirim'],
        $baris['nosu'],
        $baris['judul'],
        $baris['kategori'],
        $baris['perihal'],
        $baris['disposisi'],
        $baris['deadline']
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

$rows_array =get_data_disposisi_file("SELECT * FROM disposisi_file WHERE iduser LIKE'".$iduser."' ");
$data = array();
if(count($rows_array) > 0):
  foreach($rows_array as $row):
    $id = $row['kode_file'];
    $file_array =get_data_file("SELECT * FROM file WHERE idfile LIKE'".$id."'");
    if(count($file_array > 0)):
      foreach($file_array as $rows):
        $dispokepala_array = get_data_disposisi_kepala("SELECT * FROM kepala WHERE kode_file_asal LIKE'".$id."'");

        if(count($dispokepala_array) > 0):
          foreach($dispokepala_array as $rowstaf):
            $iduserstaf = $rowstaf['iduser_staf'];
            $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduserstaf."'");
            if(count($getuserdata_array) > 0):
              foreach($getuserdata_array as $rowuser):
                    $data[] = array(
                      'penerima'	=> $rowuser['nama'],
                      'pengirim'	=> $rows['asal_file'],
                      'nosu' 		  => $rows['no_file'],
                      'judul' 	  => $rows['nama_file'],
                      'kategori' 	=> $rows['jenis_file'],
                      'perihal' 	=> strip_tags($rows['detail_dokumen']),
                      'disposisi' => $row['tgl_disposisi'],
                      'deadline' 	=> $row['tgl_deadline']
                    );
            endforeach;  endif;
          endforeach;
        else:
              $none ="-";
              $data[] = array(
                'penerima'	=> $none,
                'pengirim'	=> $rows['asal_file'],
                'nosu' 		  => $rows['no_file'],
                'judul' 	  => $rows['nama_file'],
                'kategori' 	=> $rows['jenis_file'],
                'perihal' 	=> strip_tags($rows['detail_dokumen']),
                'disposisi' => $row['tgl_disposisi'],
                'deadline' 	=> $row['tgl_deadline']
              );
        endif;
      endforeach; endif;
     endforeach;  endif;

//pilihan
$options = array(
	'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
	'destinationfile' => '', //I=inline browser (default), F=local file, D=download
	'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
	'orientation'=>'L' //orientation: P=portrait, L=landscape
);

$tabel = new FPDF_AutoWrapTable($data, $options);
$tabel->printPDF();

}elseif($kode_akses_user == 03){
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

      $this->SetFont('Arial','',10);
      $this->SetFillColor(200,200,200);
      $left = $this->GetX();
      $this->Cell(30,$h,'NO',1,0,'C',true);
      $this->SetX($left += 30); $this->Cell(150, $h, 'PENGIRIM FILE', 1, 0, 'C',true);
      $this->SetX($left += 150); $this->Cell(110, $h, 'ASAL FILE', 1, 0, 'C',true);
      $this->SetX($left += 110); $this->Cell(110, $h, 'NOMOR SURAT', 1, 0, 'C',true);
      $this->SetX($left += 110); $this->Cell(110, $h, 'JUDUL', 1, 0, 'C',true);
      $this->SetX($left += 110); $this->Cell(110, $h, 'KATEGORI', 1, 0, 'C',true);
      $this->SetX($left += 110); $this->Cell(110, $h, 'PERIHAL', 1, 0, 'C',true);
      $this->SetX($left += 110); $this->Cell(75, $h, 'DISPOSISI', 1, 0, 'C',true);
      $this->SetX($left += 75); $this->Cell(75, $h, 'DIUPLOAD', 1, 0, 'C',true);
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
      $this->SetWidths(array(30,150,110,110,110,110,110,75,75));
      $this->SetAligns(array('C','L','L','L','L','L','L','C','C'));
  		$no = 1; $this->SetFillColor(255);
  		foreach ($this->data as $baris) {
  			$this->Row(
          array($no++,
          $baris['pengirim'],
          $baris['asal'],
          $baris['nosu'],
          $baris['judul'],
          $baris['kategori'],
          $baris['perihal'],
          $baris['disposisi'],
          $baris['upload']
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
  $rows_array = get_data_disposisi_kepala("SELECT * FROM kepala WHERE iduser_staf LIKE'".$iduser."' ");
  if(count($rows_array) > 0):
    foreach($rows_array as $row):
      $id = $row['kode_file_asal'];
      $file_array =get_data_file("SELECT * FROM file WHERE idfile LIKE'".$id."'");
      if(count($file_array > 0)):
        foreach($file_array as $rows):
         $id = $id."_".$iduser;
         $dispokepala_array = get_data_disposisi_kepala("SELECT * FROM kepala where idfile LIKE'".$id."'");
         if(count($dispokepala_array) > 0):
           foreach($dispokepala_array as $rowstaf):
            $iduserkepala = $rowstaf['iduser_kepala'];
            $getuserdata_array = get_all_user("SELECT * FROM user where iduser LIKE'".$iduserkepala."'");
            if(count($getuserdata_array) > 0):
              foreach($getuserdata_array as $rowuser):
                $data[] = array(
                  'pengirim'	=> $rowuser['nama'],
                  'asal'      => $rows['asal_file'],
                  'nosu' 		  => $rows['no_file'],
                  'judul' 	  => $rows['nama_file'],
                  'kategori' 	=> $rows['jenis_file'],
                  'perihal' 	=> strip_tags($rows['detail_dokumen']),
                  'disposisi' => $row['tgl_disposisi'],
                  'upload'  	=> $rows['tgl_upload']
                );
            endforeach;  endif;
          endforeach; endif;
        endforeach; endif;
      endforeach;
      else:
        $data[] = array(
          'pengirim'	=> "",
          'asal'      => "",
          'nosu' 		  => "",
          'judul' 	  => "",
          'kategori' 	=> "",
          'perihal' 	=> "",
          'disposisi' => "",
          'upload'  	=> ""
        );
      endif;

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
