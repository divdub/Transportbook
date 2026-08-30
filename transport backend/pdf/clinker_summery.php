<?php  
// error_reporting(0); 
include("../adminsession.php");
include("../fpdf17/fpdf.php");
// $tblname="m_payment";
// $tblpkey = "payment_id";
// $module = "Masters";
$keyvalue="";



if(isset($_GET['invoiceid'])) {
	$invoiceid = trim(addslashes($_GET['invoiceid']));
}
else
$invoiceid='';

// $session_name=$cmn->getvalfield($connection,"m_session","session_name","session_id=$session_id");
$sql = mysqli_query($connection,"select * from invoicebilty where invoiceid='$invoiceid'");
$row= mysqli_fetch_assoc($sql);
$invdate = $cmn->dateformatindia($row['invdate']);
$invno = $row['invno'];
$gst = $row['gst'];
$gsttype= $row['gsttype'];
$itemtype = $row['itemtype'];
$planttype = $row['planttype'];
$consignor_id1 = $cmn->getvalfield($connection,"dispatch_entry","consignor_id","invoiceid='$invoiceid'");
// $consigneename = $cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id='$consignor_id1'");
// $consigneeaddress = $cmn->getvalfield($connection,"m_consignor","consignor_address","consignor_id='$consignor_id1'");
// $consignneepan =  $cmn->getvalfield($connection,"m_consignor","pan_no","consignor_id='$consignor_id1'");
// $consignneegst =  $cmn->getvalfield($connection,"m_consignor","gst_no","consignor_id='$consignor_id1'");
$c_logo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");
		
if($planttype=='bihar'){
$consigneename='SHREE CEMENT LIMITED BIHAR CEMENT PLANT';
$consigneeaddress="A UNIT OF SHREE CEMENT LTD,BIADA\nINDUSTRIAL,NEAR JASOIA MOR, AURANGABAD,\nBIHAR";
 $consignneepan='AACCS8796G';
 $consignneegst='10AACCS8796G1Z6';
} 
if($planttype=='odisha'){
$consigneename='SHREE CEMENT LIMITED ODISHA CEMENT PLANT';
$consigneeaddress="A UNIT OF SHREE CEMENT LTD,CHANDRABAL \n ISHYAMPUR, ATHAGARH, ODISHA";
 $consignneepan='AACCS8796G';
 $consignneegst='21AACCS8796G1Z3';
} 				
	

// $cname = $cmn->getvalfield($connection,"m_company","cname","1 = 1");
// $headaddress = $cmn->getvalfield($connection,"m_company","headaddress","1 = 1");
// $mobileno1  = $cmn->getvalfield($connection,"m_company","mobileno1","1 = 1");
// $mobileno2  = $cmn->getvalfield($connection,"m_company","mobileno2","1 = 1");
$companygst  = $cmn->getvalfield($connection,"m_company","gst_no","comp_id=$_SESSION[comp_id]");
// $companysaac  = $cmn->getvalfield($connection,"m_company","saaccode","1 = 1");
$companypan  = $cmn->getvalfield($connection,"m_company","pan_no", "comp_id=$_SESSION[comp_id]");
$cname = $cmn->getvalfield($connection, "m_company", "cname", "comp_id=$_SESSION[comp_id]");
$mobileno1 = $cmn->getvalfield($connection, "m_company", "mobileno1", "comp_id=$_SESSION[comp_id]");
$mobileno2 = $cmn->getvalfield($connection, "m_company", "mobileno2", "comp_id=$_SESSION[comp_id]");
$caddress = $cmn->getvalfield($connection, "m_company", "caddress", "comp_id=$_SESSION[comp_id]");
$emailid = $cmn->getvalfield($connection, "m_company", "emailid", "comp_id=$_SESSION[comp_id]");
$clogo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");
$user = $cmn->getvalfield($connection, "m_userlogin", "user_name", "user_id=$_SESSION[user_id]");

function convert_number($number) 
{ 
  $no = (int)floor($number);
   $point = (int)round(($number - $no) * 100);
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;


     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);


  if ($point > 20) {
    $points = ($point) ?
      "" . $words[floor($point / 10) * 10] . " " . 
          $words[$point = $point % 10] : ''; 
  } else {
      $points = $words[$point];
  }
  if($points != ''){        
      return $result . "Rupees  " . $points . " Paise ";
  } else {

      return $result . "Rupees ";
  }
}

	
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' & ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;
	function Header()
	{ 
	   global $companygst,$companysaac,$consigneeaddress,$companypan,$invdate,$invno,$consigneename,$consignneepan,$consignneegst,$c_logo,$session_name;
	
	$this->setX(5);

	//$this->SetFillColor(0,0,0); //gray
	//$this->SetTextColor(255,255,255);
	//$this->Row(array('Sno','TAX INV NO','GR DATE','GR/TR NO','DI NO ','TRUCK NO ','CONSIGNEE','DESTINATION','WEIGHT (MT)','RATE/MT','FREIGHT','LABOUR','TOTAL AMOUNT','CGST','SGST','SHT-BG','SHT-MT'));
		
	}
	function Footer()
	{ 
	    global $cname,$session_name;
	    	$this->setX(1);
	    $this->Ln(5); 
	$this->SetFont('Arial','',10);
$this->SetTextColor(0,0,0);
$this->Cell(90);
$this->Cell(105,8," FOR : ".$cname,'T',0,'C',0); 

 $this->Ln(6); 
$this->setX(5);
$this->SetFont('Arial','',10);
$this->SetTextColor(0,0,0);
$this->Cell(105);
$this->Cell(87,8," Authorised Signatory",'0',1,'C',0); 
 $this->Ln(16); 
 $this->setX(5);
// $x = $this->GetX();
$y = $this->GetY();

$this->MultiCell(200,8,"1.  I /we have taken registration under the CGST Act, 2017 and have exercised the option to pay tax on services\n of GTAin relation to transport of goods supplied by us during the Financial year $session_name under forward charge.",1,
    'C'
);

// agar aapko next cell same line me chahiye ho
$this->SetXY($x + 87, $y);
										
				
     }
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
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
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
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function Row2($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
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
        $this->MultiCell($w,5,$data[$i],0,$a);
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
}
?>
<?php


function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1,10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s,0,-1);
}



$pdf=new PDF_MC_Table();
$pdf->SetTitle("Invoice");
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetX(5);
//$pdf->MultiCell(80,5,"Customer Copy",0,'L');


//$pdf->SetX(13);


	
$pdf->SetFont('courier','b',9);
	$pdf->Rect(5,5,200, 280, 'D'); //For A4	
	$pdf->SetFont('courier','b',9);
	// $pdf->Rect(205,25,80, 20, 'D'); //For A4
	$pdf->Rect(5,54,200,61,'D'); //For A4
	//$this->Rect(3,116, 204, 14, 'D'); //For A4  
	//$this->Rect(3,130, 204, 14, 'D'); //For A4 

	 $pdf->setY(10);
	 
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(280,4,"Original for Recipient",'0',1,'R',0);
	$pdf->Ln(1);
		$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	// $pdf->Cell(280,4,"Duplicate for Supplier",'0',1,'R',0);
		$pdf->setX(100);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	// $pdf->Cell(90,4,"Authorised Signatory",'0',1,'C',0);
	$pdf->Ln(4);
		
	$pdf->SetFont('Arial','ub',16);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(180,4,"TAX INVOICE",'0',1,'C',0);
	$pdf->Ln(6);
		$pdf->SetFont('Arial','UB',14);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(180,4,$cname,'0',1,'C',0);
	$pdf->Ln(2);
		
		$pdf->SetFont('Arial','UB',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(180,4,$caddress,'0',1,'C',0);
	$pdf->Ln(2);
	
		$pdf->setX(90);
		$pdf->SetFont('Arial','UB',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,4,"SAC CODE: 996511",'0',0,'R',0);
		$pdf->setX(150);
		$pdf->SetFont('Arial','UB',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(50,4,"GST NO: $companygst",'0',1,'R',0);
	$pdf->Ln(1);
	// $pdf->setY(28);
	$pdf->setX(150);
	$pdf->SetFont('Arial','UB',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"PAN NO : $companypan",'0',1,'R',0);
	$pdf->Ln(2);
	
	// $pdf->setX(200);

	



	
	 $pdf->setY(55);

			
	   //$pdf->Image('../upload/logo/'.$c_logo,10,150,25,15);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
$pdf->Image('../upload/logo/'.$c_logo,6,6,18,11);
	$pdf->SetFont('Arial','b',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,"M/s",'0',1,'L',0);
	$pdf->Ln(2);
	
	$pdf->SetFont('Arial','B',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,"$consigneename",'0',1,'L',0);
	$pdf->Ln(2);
	//$this->setY(40);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->MultiCell(130,5,"$consigneeaddress",0,'L');
	//$this->Cell(90,4,"",'0',1,'L',0);
	
	
	$pdf->Ln(2);
	  
		$pdf->setY(85);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
		if($planttype=='bihar'){
	$pdf->Cell(150,4,"Place of Supply : Bihar",'0',1,'L',0);
		} else {
		    	$pdf->Cell(150,4,"Place of Supply : Odisha",'0',1,'L',0);
		}
	
	
	$pdf->Ln(2);
	
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
		if($planttype=='bihar'){
	$pdf->Cell(90,4,"State Code : 10",'0',0,'L',0);
		} else {
		 	$pdf->Cell(90,4,"State Code : 21",'0',0,'L',0);   
		}
	
	 $pdf->setY(65);
	$pdf->setX(119.5);
	$pdf->SetFont('Arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"BILL NO :",'0',0,'R',0);
	$pdf->Cell(80,4,"$invno",'0',1,'L',0);
	$pdf->Ln(2);
		$pdf->setX(124);
	$pdf->SetFont('Arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"BILL DATE :",'0',0,'R',0);
	$pdf->Cell(80,4,"$invdate",'0',1,'L',0);
	$pdf->Ln(2);
		$pdf->setX(165);
	$pdf->SetFont('Arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(20,4,"TRANSPORTER CODE:",'0',0,'R',0);
	$pdf->Cell(80,4,"13001370",'0',1,'L',0);
	$pdf->Ln(2);
		$pdf->setX(120);
	$pdf->SetFont('Arial','',11);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"PAN NO :",'0',0,'R',0);
	$pdf->Cell(80,4,"$consignneepan",'0',1,'L',0);
	$pdf->Ln(2);
		$pdf->setX(120);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(40,4,"GST NO:",'0',0,'R',0);
	$pdf->Cell(80,4,"$consignneegst",'0',1,'L',0);
	
// 	$pdf->Ln(2);
// 		$pdf->setX(200);
// 	$pdf->SetFont('Arial','',11);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"NAME OF STATE :",'0',0,'R',0);
// 	$pdf->Cell(80,4,"CHATTISHGARH",'0',1,'L',0);
		$pdf->Ln(2);
		$pdf->setX(210);
	$pdf->SetFont('Arial','',11);
	$pdf->SetTextColor(0,0,0);
	
// 	$pdf->Cell(40,4,"STATE CODE :",'0',0,'R',0);
// 		if($planttype=='bihar'){
// 	$pdf->Cell(80,4,"10",'0',1,'L',0);
// 		} else {
// 			$pdf->Cell(80,4,"21",'0',1,'L',0);    
// 		}
// 			$pdf->Ln(2);
// 		$pdf->setX(200);
// 	$pdf->SetFont('Arial','',11);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"SAC CODE :",'0',0,'R',0);
// 	$pdf->Cell(80,4,"996511",'0',1,'L',0);
// 	$pdf->Ln(2);
// 	$pdf->setX(193);
// 	$pdf->SetFont('Arial','',12);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(46,4,' Description of Service :','0',0,'L',0);
// 	$pdf->SetFont('Arial','',12);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(80,4,'Transportation','0',1,'L',0);
//     $pdf->Ln(2);
// 	$pdf->setX(222);
// 	$pdf->SetFont('Arial','',12);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(34,4,' Place of Supply :','0',0,'L',0);
// 	$pdf->SetFont('Arial','',12);
// 	$pdf->SetTextColor(0,0,0);
// 	if($planttype=='bihar'){
// 	$pdf->Cell(80,4,'Bihar','0',1,'L',0);
// 	} else { 
// 	    $pdf->Cell(80,4,'Odisha','0',1,'L',0);
// 	}
//     $pdf->Ln(2);
// 	$pdf->setX(197);
// 	$pdf->SetFont('Arial','',12);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(42,4,' Location of Supplier :','0',0,'L',0);
// 	$pdf->SetFont('Arial','',12);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(80,4,'Chhattisgarh','0',1,'L',0);$pdf->Ln(2);
// 	$pdf->setX(165);
// 	$pdf->SetFont('Arial','',12);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(75,4,' Wether Reverse Charges Applicable :','0',0,'L',0);
// 	$pdf->SetFont('Arial','',12);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(80,4,'NO','0',1,'L',0);
	$pdf->Ln(5);
	 
	$pdf->SetX(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetFillColor(255,255,255); //gray
	//$this->SetTextColor(255,255,255);
// 	$pdf->Cell(20,6,'Sno','1',0,'L',1); 
  	// $pdf->Cell(17,6,'DI NO ',1,0,'L',1);
          	$pdf->Cell(100,6,'DESCRIPTION','LT',0,'C',1);   

    //      $pdf->Cell(17,6,'GR DATE',1,0,'L',1);  
	// $pdf->Cell(22,6,'TRUCK NO ',1,0,'L',1);	
	// 	$pdf->Cell(24,6,'GR/LR NO',1,0,'L',1);
	// $pdf->Cell(32,6,'CONSIGNEE',1,0,'L',1);
	// $pdf->Cell(28,6,'DESTINATION',1,0,'L',1);
	$pdf->Cell(30,6,'Qty','T',0,'C',1);
	$pdf->Cell(30,6,'Rate','T',0,'C',1);
	$pdf->Cell(40,6,'Total Amount','T',1,'C',1);
	//$this->Cell(16,6,'LABOUR',1,0,'L',1);	

	// 	$pdf->Cell(18,6,'IGST',1,0,'L',1);
	// $pdf->Cell(15,6,'CGST',1,0,'L',1);
	// $pdf->Cell(15,6,'SGST',1,0,'L',1);
	// 	$pdf->Cell(20,6,'GST TOTAL',1,1,'C',1);
// 	$pdf->Cell(10,6,'SHT',1,0,'L',1);
// 	$pdf->Cell(10,6,'SHT',1,1,'L',1);
	
	//$this->Cell(10,6,'SHT-BG',1,0,'L',1);
	//$this->Cell(10,6,'SHT-MT',1,1,'L',1);
	// $pdf->SetX(5);
	// $pdf->SetFont('Arial','B',9);
	//$this->SetFillColor(0,0,0); //gray
	//$this->SetTextColor(255,255,255);
	// $pdf->Cell(8,6,' ','1',0,'L',1); 

	// $pdf->Cell(17,6,' ',1,0,'L',1);
	// $pdf->Cell(24,6,' ','1',0,'L',1);  
	// $pdf->Cell(17,6,' ',1,0,'L',1);
	// $pdf->Cell(22,6,' ',1,0,'L',1);	
	// 	$pdf->Cell(24,6,' ',1,0,'L',1);
	// $pdf->Cell(32,6,' ',1,0,'L',1);
	// $pdf->Cell(28,6,' ',1,0,'L',1);
	// $pdf->Cell(14,6,' (MT)',1,0,'L',1);
	// $pdf->Cell(15,6,' MT',1,0,'L',1);
	// $pdf->Cell(18,6,' ',1,0,'L',1);
	// //$this->Cell(16,6,' ',1,0,'L',1);	
    // if($gsttype=="gst"){
	// $pdf->Cell(18,6,'',1,0,'L',1);
	// $pdf->Cell(15,6,$gst/2 .'%',1,0,'L',1);
	// $pdf->Cell(15,6,$gst/2 .'%',1,1,'L',1);
    // } else {
    //     $pdf->Cell(18,6, $gst.'%',1,0,'L',1);
	// $pdf->Cell(15,6,'',1,0,'L',1);
	// $pdf->Cell(15,6,'',1,1,'L',1);
    // }
// 	$pdf->Cell(10,6,'BG',1,0,'L',1);
// 	$pdf->Cell(10,6,'MT',1,1,'L',1);
	//$this->Cell(10,6,' ',1,0,'L',1);
	//$this->Cell(10,6,' ',1,1,'L',1);
	
	$pdf->SetWidths(array(187,30,30,30,30));
	$pdf->SetAligns(array("C","L","L","L","L"));
	$pdf->SetX(5);	
	$pdf->SetFont('Arial','B',12);

$sn=0;
$tot_wt=0;
$tot_own_rate=0;
$nettotal_amt=0;
$tot_gst=0;
$sql2 = mysqli_query($connection,"select * from dispatch_entry where invoiceid='$invoiceid' order by gr_date asc");
while($row2=mysqli_fetch_assoc($sql2)) {

	$invoiceno = $row2['invoice_no'];
	$gr_date = $row2['gr_date'];
	$gr_no = $row2['gr_no'];
	$di_no = $row2['di_no'];
	$truckid = $row2['vehicle_id'];
	$consignee_id = $row2['consignee_id'];
	$destination_id = $row2['destination_id'];
	$totalweight = $row2['wt_mt'];
	$comp_rate = $row2['comp_rate'];
		$own_rate = $row2['own_rate'];
	$consignee_name = $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consignee_id'");
	$truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$truckid'");
        // $truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$truckid'");
                //   $gst_type = $cmn->getvalfield($connection,"payment","gst_type","dispatch_id='$row2[dispatch_id]'");
                    //  $gstper = $cmn->getvalfield($connection,"payment","gstper","dispatch_id='$row2[dispatch_id]'");
	$deliverat = $cmn->getvalfield($connection,"m_place","place_name","place_id='$destination_id'");
	$total_amt = $totalweight * $comp_rate;
  
	$gstamt =  ($total_amt * $gst)/100;
	$grandtotal=$total_amt + $gstamt;
    if($gsttype=="gst"){
       
        $igst='0';
        $gst1=$gstamt/2; 

    }else{
        $igst=$gstamt;
        $gst1='0';
    }
     $gr_date = $row2['gr_date'];

    // Min Date
    if($min_date == '' || strtotime($gr_date) < strtotime($min_date)){
        $min_date = $gr_date;
    }

    // Max Date
    if($max_date == '' || strtotime($gr_date) > strtotime($max_date)){
        $max_date = $gr_date;
    }
	$tot_wt += $totalweight;
	$tot_own_rate += $comp_rate;
	$nettotal_amt += $total_amt;
	$tot_gst += $gstamt;
		$tot_igst += $igst;
		$tot_gst1 += $gst1;
    $sn++;
}

	$pdf->SetX(5);	
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);
	// $pdf->Row(array('1 -','Primary Freight For The Period Dt '.$cmn->dateformatindia($min_date).' to '.$cmn->dateformatindia($max_date),number_format($tot_wt,2),'',number_format($nettotal_amt,2)));

$pdf->SetX(5);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(255,255,255); //gray
	//$this->SetTextColor(255,255,255);
// 	$pdf->Cell(20,12,'1 -','LT',0,'L',1); 
  	// $pdf->Cell(17,6,'DI NO ',1,0,'L',1);
        //   	$pdf->Cell(167,12,'Primary Freight For The Period Dt '.$cmn->dateformatindia($min_date).' to '.$cmn->dateformatindia($max_date),'T',0,'C',1);   
	   // 	$pdf->Cell(100,12,'Being freight amount charged for transportation of clinker (as per enclosed details of consigment notes)','LT',0,'C',1); 		
 			
$x = $pdf->GetX();
$y = $pdf->GetY();

// LEFT SIDE (100 width, total height 12)
$pdf->MultiCell(100,6,"Being freight amount charged for transportation of clinker\n(as per enclosed details of consigment notes)",'LT','C',1);

// Set position to right side (same row)
$pdf->SetXY($x + 100, $y);
			

    //      $pdf->Cell(17,6,'GR DATE',1,0,'L',1);  
	// $pdf->Cell(22,6,'TRUCK NO ',1,0,'L',1);	
	// 	$pdf->Cell(24,6,'GR/LR NO',1,0,'L',1);
	// $pdf->Cell(32,6,'CONSIGNEE',1,0,'L',1);
	// $pdf->Cell(28,6,'DESTINATION',1,0,'L',1);
	$pdf->Cell(30,12,number_format($tot_wt,2),'T',0,'C',1);
	$pdf->Cell(30,12,$comp_rate,'T',0,'C',1);
	$pdf->Cell(40,12,number_format($nettotal_amt,2),'RT',1,'C',1);
	//$tot_wt += $totalweight;
	//$tot_wt += $totalweight;
$pdf->SetX(5);
$pdf->Cell(60,7,'','L',0,'L',1); 
// $pdf->Cell(185,7,'Details Attached','0',1,'L',1);
$pdf->SetX(5);
$pdf->Cell(60,7,'','L',0,'L',1); 
// $pdf->Cell(185,7,'Total No Of Invoices: '.$sn,'0',1,'L',1);
// 	$pdf->setX(5);
// 	$pdf->SetFont('Arial','b',8);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(187,7,"TOTAL",'1',0,'R',0);
// 	$pdf->Cell(30,7,number_format($tot_wt,2),'1',0,'L',0);
// 	$pdf->Cell(30,7,'','1',0,'L',0);
// 	$pdf->Cell(40,7,number_format($nettotal_amt,2),'1','1','L',0);
$pdf->Ln(6);
	if($gsttype=="gst"){
	$pdf->setX(5);
		$pdf->Cell(180,6,' IGST 0 % ','0','0','R',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    $pdf->Cell(20,6,number_format($tot_igst),'0','1','R',0);
    $pdf->setX(5);
		$pdf->Cell(180,6,'CGST '.number_format($gst/2).'% ','0','0','R',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    $pdf->Cell(20,6,number_format($tot_gst1,2),'0','1','R',0);
      $pdf->setX(5);
		$pdf->Cell(180,6,'SGST'.number_format($gst/2).'% ','0','0','R',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    $pdf->Cell(20,6,number_format($tot_gst1,2),'0','1','R',0);
// 	$pdf->Cell(10,4,"",'1',0,'L',0);
// 	$pdf->Cell(10,4,"",'1',1,'L',0);
    } else { 
        
    $pdf->setX(5);
		$pdf->Cell(180,6,' IGST'.$gst.'% ','0','0','R',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    $pdf->Cell(20,6,number_format($tot_igst),'0','1','R',0);
    $pdf->setX(5);
		$pdf->Cell(180,6,'CGST '.number_format(0).'% ','0','0','R',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    $pdf->Cell(20,6,number_format($tot_gst1,2),'0','1','R',0);
      $pdf->setX(5);
		$pdf->Cell(180,6,'SGST'.number_format(0).'% ','0','0','R',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
    $pdf->Cell(20,6,number_format($tot_gst1,2),'0','1','R',0);
    }
$pdf->setX(5);
		// $pdf->Cell(18,8,0,'1',0,'L',0);


    // }
    $pdf->setX(155);
    $pdf->Cell(30,6,'TOTAL TAX','T','0','R',0);
//   $pdf->Cell(30,6,'','1',0,'L',0);
//     $pdf->Cell(30,6,'','1',0,'L',0);
    $pdf->Cell(20,6,number_format($tot_gst,2),'T','1','R',0);
	$pdf->setX(5);
	$pdf->SetFont('Arial','b',8);
	$pdf->SetTextColor(0,0,0);
	// $pdf->Cell(8,4,' ','1',0,'L',0); 
	// $pdf->Cell(24,4,' ','1',0,'L',0);  
	// $pdf->Cell(17,4,' ',1,0,'L',0);
	// $pdf->Cell(24,4,' ',1,0,'L',0);
	// $pdf->Cell(17,4,' ',1,0,'L',0);
	// $pdf->Cell(22,4,' ',1,0,'L',0);	
	// $pdf->Cell(32,4,' ',1,0,'L',0);
$pdf->Cell(100, 6, 'Delivered at :', 'LTR', 0, 'L');
$pdf->Cell(60,6,"TOTAL AMOUNT : ",'LT',0,'R',0);
    //   $pdf->Cell(30,6,'','1',0,'L',0);
    // $pdf->Cell(30,6,'','1',0,'L',0);
	$pdf->Cell(40,6,number_format($nettotal_amt +$tot_gst,2),'TR','1','R',0);
	$pdf->setX(5);
		$pdf->Cell(100,6,'RMO: RAW MATERIAL '.$deliverat,'LBR',0,'L',0);		
		


	// $pdf->Cell(14,4,'','1',0,'L',0);
	// $pdf->Cell(20,4,'','1',1,'L',0);
	
	$pdf->setX(5);
	$pdf->SetFont('Arial','b',8);
	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(287,4,'In Words : '.ucwords(convert_number($nettotal_amt +$tot_gst))." only",'1',1,'L',0); 
	 
$pdf->setX(5);

$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
// $pdf->Cell(210);
	// $pdf->Cell(877,6,"TOTAL AMOUNT  : ".number_format($nettotal_amt +$tot_gst,2),'0',1,'L',0);
$pdf->Ln(1);
		$pdf->setX(5);
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0,0,0);
    //   $pdf->Cell(30,6,'E & O.E.','L',0,'L',0);
// 	$pdf->MultiCell(157,6,"We are availing the GST credit hance charging 18% for GTA notification No. 15/2025 Central Tax (Rate)",'0',1,'L',0); 
// 		$pdf->SetFont('Arial','B',7.5);
// 			$pdf->setX(5);
// 		$pdf->Cell(50,3,"2024-25 under forward charge	only",'0',1,'L',0);
 // $height = $pdf->getX();


	
  $pdf->Output();	
?>
