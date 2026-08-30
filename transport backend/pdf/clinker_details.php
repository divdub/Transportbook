<?php  
error_reporting(0); 
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
$sql = mysqli_query($connection,"select * from invoicebilty where invoiceid='$invoiceid'");
$row= mysqli_fetch_assoc($sql);
$invdate = $cmn->dateformatindia($row['invdate']);
$invno = $row['invno'];
$itemtype = $row['itemtype'];
$gst = $row['gst'];
$gsttype= $row['gsttype'];
$planttype = $row['planttype'];
$consigneeid = $cmn->getvalfield($connection,"dispatch_entry","consignee_id","invoiceid='$invoiceid'");
$consignor_id1 = $cmn->getvalfield($connection,"dispatch_entry","consignor_id","invoiceid='$invoiceid'");
$sqlm = mysqli_query($connection,"
    SELECT 
        MIN(gr_date) as min_date, 
        MAX(gr_date) as max_date 
    FROM dispatch_entry 
    WHERE invoiceid='$invoiceid'
");

$rowm = mysqli_fetch_assoc($sqlm);
$min_date =  $cmn->dateformatindia($rowm['min_date']);
$max_date =  $cmn->dateformatindia($rowm['max_date']);
$psup = $cmn->getvalfield($connection,"dispatch_entry","destination_id","invoiceid='$invoiceid'");
		$deliverat = $cmn->getvalfield($connection,"m_place","place_name","place_id='$psup'");
// $consigneename = $cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id='$consignor_id1'");
// $consigneeaddress =  $cmn->getvalfield($connection,"m_consignor","consignor_address","consignor_id='$consignor_id1'");
// $consignneepan = $cmn->getvalfield($connection,"m_consignor","pan_no","consignor_id='$consignor_id1'");
// $consignneegst =  $cmn->getvalfield($connection,"m_consignor","gst_no","consignor_id='$consignor_id1'");
		
if($planttype=='bihar'){
$consigneename='M/s SHREE CEMENT LIMITED BIHAR CEMENT PLANT	';
$consigneeaddress="A UNIT OF SHREE CEMENT LTD,BIADA	INDUSTRIAL,NEAR JASOIA MOR, AURANGABAD,BIHAR";
 $consignneepan='AACCS8796G';
 $consignneegst='10AACCS8796G1Z6';
} 
if($planttype=='odisha'){
$consigneename='M/s SHREE CEMENT LIMITED ODISHA CEMENT PLANT	';
$consigneeaddress="A UNIT OF SHREE CEMENT LTD,CHANDRABAL ISHYAMPUR, ATHAGARH, ODISHA";
 $consignneepan='AACCS8796G';
 $consignneegst='21AACCS8796G1Z3';
} 				

$c_logo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");

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
    global $cname,$caddress,$companygst,$companypan,$c_logo;


    $this->Rect(5,5,200,287,'D');


    $this->Image('../upload/logo/'.$c_logo,6,6,18,11);


    $this->SetFont('Arial','B',14);
    $this->SetX(5);
    $this->SetY(6);
    $this->Cell(200,6,$cname,0,1,'C');

    // // Address
    // $this->SetFont('Arial','',10);
    // $this->Cell(200,5,$caddress,0,1,'C');
    // $this->Cell(200,4,"Pan No.: ".$companypan,0,1,'C');
    // $this->Cell(200,4,"GSTIN: ".$companygst,0,1,'C');

    // $this->Line(5,32,205,32);


    // if($this->PageNo() == 1){
    //     $this->SetY(34);
    //     $this->SetFont('Arial','B',12);
    //     $this->Cell(190,6,"TAX INVOICE",0,1,'C');
    // }

    // $this->Line(5,40,205,40);
    $this->SetY(35);
}
	function Footer()
	{ 
	    global $cname;
	    	$this->setX(1);
	    $this->Ln(3); 
	$this->SetFont('Arial','',11);
// 	$this->Rect(5,269,105,23,'D'); //For A4	
$this->SetTextColor(0,0,0);
$this->Cell(200);
$this->Cell(87,4," FOR: ".$cname,'0',0,'C',0); 

 $this->Ln(6); 
$this->setX(5);
$this->SetFont('Arial','',12);
$this->SetTextColor(0,0,0);
$this->Cell(200);
$this->Cell(87,4," Authorised Signatory",'0',0,'C',0); 
						
     }
     function TableHeader()
{
    $this->SetX(5);
    $this->SetFont('Arial','',8);
    $this->SetFillColor(255,255,255);

    $this->Cell(8,6,'Sno','1',0,'L',1); 
     $this->Cell(21,6,'Invoice No.','1',0,'L',1);
      $this->Cell(30,6,'Invoice Date','1',0,'L',1);
     $this->Cell(30,6,'GR No','1',0,'L',1);
   $this->Cell(30,6,'DI No.','1',0,'L',1);	
    $this->Cell(30,6,'Truck No.','1',0,'L',1); 
    // $this->Cell(32,6,'Destination','1',0,'L',1);
    $this->Cell(12,6,'Disp Wt','1',0,'L',1);
    $this->Cell(12,6,'Frt Rate','1',0,'L',1);
    // $this->Cell(14,6,'Unloading','1',0,'L',1);
    $this->Cell(27,6,'Total Frt','1',1,'L',1);
    // $this->Cell(14,6,'Shortage','1',1,'L',1);
    // $this->SetX(5);
    // $this->Cell(8,6,'','1',0,'L',1); 
    // $this->Cell(21,6,'','1',0,'L',1);  
    // $this->Cell(16,6,'','1',0,'L',1);
    // $this->Cell(17,6,'','1',0,'L',1);
    // $this->Cell(18,6,'','1',0,'L',1);
    // $this->Cell(20,6,'','1',0,'L',1);	
    // $this->Cell(32,6,'','1',0,'L',1);
    // $this->Cell(12,6,'(M.T)','1',0,'L',1);
    // $this->Cell(12,6,'(Ton)','1',0,'L',1);
    // $this->Cell(14,6,'Chrgs(Rs)','1',0,'L',1);
    // $this->Cell(16,6,'','1',0,'L',1);
    // $this->Cell(14,6,'','1',1,'L',1);
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
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));

    $h=5*$nb;

    /* PAGE BREAK CHECK */
   if($this->GetY()+$h>250)
    {
        $this->AddPage();
        $this->TableHeader(); // header repeat
    }

    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $x=$this->GetX();
        $y=$this->GetY();

        $this->Rect($x,$y,$w,$h);
        $this->MultiCell($w,5,$data[$i],0,'L');

        $this->SetXY($x+$w,$y);
    }

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
    if($this->GetY()+$h>$this->PageBreakTrigger)
    {
        $this->AddPage($this->CurOrientation);
        $this->TableHeader(); // new page me header firse print hoga
    }
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
$pdf->AddPage('p','A4');
$pdf->SetX(0);
//$pdf->MultiCell(80,5,"Customer Copy",0,'L');


//$pdf->SetX(13);


	
$pdf->SetFont('courier','b',9);
$pdf->Rect(5,5,200,287,'D'); //For A4	




	
	 $pdf->setY(22);

			
	   //$pdf->Image('../upload/logo/'.$c_logo,10,150,25,15);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
$pdf->Image('../upload/logo/'.$c_logo,6,6,18,11);
$pdf->Line(5,20,205,20);



	$pdf->SetFont('Arial','b',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(280,4,"Desp. WH:  SHREE RAIPUR CEMENT PLANT,RAIPUR",'0',1,'L',0);
	$pdf->Ln(2);
	
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,"Recv. WH: RMG:RAW MATERIAL $deliverat",'0',1,'L',0);
	$pdf->Ln(2);
	//$this->setY(40);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->MultiCell(180,5,"No of Trip Per Month Report Between:                                                                                     $min_date  TO  $max_date",0,'L');

	
	
	$pdf->Ln(2);
	  
	//$this->setY(40);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(90,4,"Details of Bill No. & Date:                                                                                $invno             $invdate",'0',1,'L',0);
// 	$pdf->Ln(2);
// 	$pdf->SetFont('Arial','',10);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(150,4,"GST NO- $consignneegst",'0',1,'L',0);
	
	
// 	$pdf->setY(42);
// 	$pdf->setX(90);
// 	$pdf->SetFont('Arial','B',10);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"BILL NO :",'0',0,'R',0);
// 	$pdf->Cell(80,4,"$invno",'0',1,'L',0);
// 	$pdf->Ln(2);
// 	$pdf->setX(92);
// 	$pdf->SetFont('Arial','B',10);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"Bill DATE :",'0',0,'R',0);
// 	$pdf->Cell(80,4,"$invdate",'0',1,'L',0);
// 	$pdf->Ln(2);
// 		$pdf->setX(91);
// 	$pdf->SetFont('Arial','',9);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"SAC Code :",'0',0,'R',0);
// 	$pdf->Cell(80,4,"",'0',1,'L',0);
// 	$pdf->Ln(2);
// 		$pdf->setX(102);
// 	$pdf->SetFont('Arial','',9);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"Mode Of Transport:",'0',0,'R',0);
// 		$pdf->SetFont('Arial','',11);
// 	$pdf->Cell(80,4,"By Road",'0',1,'L',0);
// 	$pdf->Ln(2);
// 		$pdf->setX(99);
// 	$pdf->SetFont('Arial','',9);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"Reverse Charge:",'0',0,'R',0);
// 	$pdf->Cell(80,4,"NO",'0',1,'L',0);
// 	$pdf->Ln(2);
// 		$pdf->setX(117);
// 	$pdf->SetFont('Arial','',9);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"PLACE TO SUPPLY STATE :",'0',0,'R',0);
// 	$pdf->Cell(80,4,"CHATTISHGARH",'0',1,'L',0);
// 		$pdf->Ln(2);
// 		$pdf->setX(105);
// 	$pdf->SetFont('Arial','',9);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"PLACE TO SUPPLY:",'0',0,'R',0);
// 	if($planttype=='bihar'){
// 	$pdf->Cell(80,4,"1",'0',1,'L',0);
// 		} else {
// 			$pdf->Cell(80,4,"21",'0',1,'L',0); 
// 		}

	
// 	$pdf->Ln(2);
// 		$pdf->setX(100);
// 	$pdf->SetFont('Arial','',9);
// 	$pdf->SetTextColor(0,0,0);
// 	$pdf->Cell(40,4,"VENDOR CODE:",'0',0,'R',0);
// 	$pdf->Cell(80,4,"0001101918",'0',1,'L',0);


	

	$pdf->Ln(5);
	 
	$pdf->SetX(5);

	$pdf->TableHeader();
	$pdf->SetWidths(array(8,21,30,30,30,30,12,12,27));
	$pdf->SetAligns(array("C","L","L","L","L","L","L","L","L","L","L","L","L","L"));
	$pdf->SetX(5);	
	$pdf->SetFont('Arial','B',9);

$sn=1;
$tot_wt=0;
$tot_own_rate=0;
$nettotal_amt=0;
$tot_gst=0;
$unloading = 0;
$shortage = '';
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
    $truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$truckid'");
// 	$deliverat = $cmn->getvalfield($connection,"m_place","place_name","place_id='$destination_id'");
	$total_amt = $totalweight * $comp_rate;
  
	$gstamt =  ($total_amt * $gst)/100;
	$grandtotal=$total_amt+$gstamt;
      if($gsttype=="gst"){
       
        $igst='0';
        $gst1=$gstamt/2; 

    }else{
        $igst=$gstamt;
        $gst1='0';
    }
	$pdf->SetX(5);	
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Row(array($sn++,$invoiceno,$cmn->dateformatindia($gr_date),$gr_no,$di_no,$truckno,$totalweight,$comp_rate,number_format($total_amt,2)));

	$tot_wt += $totalweight;
	$tot_own_rate += $comp_rate;
	$nettotal_amt += $total_amt;
	$tot_gst += $gstamt;
		$tot_gst1 += $gst1;
		$totgst += $igst;


}

	$pdf->setX(5);
	$pdf->SetFont('Arial','b',8);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(119,6," ",'1',0,'L',0);
	$pdf->Cell(30,6,"Total Weight",'1',0,'R',0);
	$pdf->Cell(12,6,number_format($tot_wt,2),'1',0,'L',0);
	$pdf->Cell(12,6,'','1',0,'L',0);
// 	$pdf->Cell(14,6," ",'1',0,'L',0);
	
// 		$pdf->Cell(20,4,'','1',0,'L',0);
	
	$pdf->Cell(27,6,number_format($nettotal_amt,2),'1',1,'L',0);	
// 	$pdf->Cell(14,6,"",'1',1,'L',0);

	
// $pdf->setX(5);
// $pdf->SetFont('Arial','b',8);
// $pdf->SetTextColor(0,0,0);
// // $note = "Note: Please find xerox copy of GRS enclosed we have correctly delivered Cement of above mentioned GRS to Consignee Party was not having rubber stamp at unloading site hence has not been placed on GR we are responsible for safe delivery. Please pass this bill.";
// $note='';
// $x = $pdf->GetX();
// $y = $pdf->GetY();

// /* NOTE HEIGHT CALCULATE */
// $pdf->SetFont('Arial','B',8);

// $nb = $pdf->NbLines(100,$note);
// $height = 5 * $nb;

// /* PAGE BREAK CHECK */
// if($y + $height > 260){
//     $pdf->AddPage();
//     $y = $pdf->GetY();
// }

/* print note */
// $pdf->SetXY($x,$y);
// $pdf->MultiCell(100,5,$note,'LTR','L');


// $pdf->SetXY($x + 100, $y);
// $pdf->SetFont('Arial', '', 10);
// $pdf->SetTextColor(0, 0, 0);
// $pdf->Cell(32, 6, 'Particulars', '1', 0, 'L', 0);
// $pdf->SetFont('Arial', '', 10);
// $pdf->SetTextColor(0, 0, 0);
// $pdf->Cell(38, 6, 'GST Rate' . '', '1', 0, 'L', 0);
// $pdf->Cell(16, 6, 'Amount' . '', '1', 1, 'L', 0);
// $pdf->Cell(14, 6, '' . '', '1', 1, 'L', 0);

// $pdf->setX(105);
// $pdf->SetFont('Arial', '', 10);

// $pdf->Cell(32, 6, 'Bill', '1', 0, 'L', 0);
// $pdf->Cell(38, 6, '', '1', 0, 'L', 0);
// $pdf->Cell(16, 6,$nettotal_amt, '1', 1, 'L', 0);
// $pdf->Cell(14, 6, '', '1', 1, 'L', 0);
// $pdf->setX(105);
//  if($gsttype=="gst"){
// $pdf->Cell(32, 6, 'CGST', '1', 0, 'L', 0);
// $pdf->Cell(38, 6, $gst/2 .'%', '1', 0, 'L', 0);
// $pdf->SetFont('Arial', '', 9);
// $pdf->Cell(16, 6, number_format($tot_gst1,2), '1', 1, 'L', 0);
// // $pdf->Cell(14, 6, '', '1', 1, 'L', 0);
// $pdf->setX(105);
// $pdf->Cell(32, 6, 'SGST', '1', 0, 'L', 0);
// $pdf->Cell(38, 6, $gst/2 .'%', '1', 0, 'L', 0);
// $pdf->Cell(16, 6,number_format($tot_gst1,2), '1', 1, 'L', 0);
// }
// $pdf->setX(105);
// $pdf->Cell(32, 6, 'IGST', '1', 0, 'L', 0);
// $pdf->Cell(38, 6, '', '1', 0, 'L', 0);
// $pdf->Cell(16, 6, number_format($totgst,2), '1', 1, 'L', 0);
// // $pdf->Cell(14, 6, '', '1', 1, 'L', 0);
// $pdf->setX(5);
// $pdf->Cell(132, 6, '', '1', 0, 'L', 0);
// $pdf->Cell(38, 6, 'GST Total', '1', 0, 'L', 0);
// $pdf->Cell(16, 6,number_format($tot_gst,2), '1', 0, 'L', 0);
// $pdf->Cell(14, 6, '', '1', 1, 'L', 0);
// $pdf->setX(5);
// $pdf->SetFont('Arial','B',8);
// $pdf->Cell(132, 8, 'In Words : '.ucwords(convert_number($nettotal_amt +$tot_gst))." only",'1',0,'L',0);
// $pdf->Cell(38, 8, 'Total', '1', 0, 'L', 0);
// $pdf->Cell(16, 8, number_format($nettotal_amt +$tot_gst), '1', 0, 'L', 0);
// $pdf->Cell(14, 8, '', '1', 1, 'L', 1);
// $pdf->Ln(2);

// $pdf->Ln(2);

/* page space check */
if($pdf->GetY() > 240){
    $pdf->AddPage();
}

$x = 5;
$y = $pdf->GetY();
// $declaration = "                                                                      DECLARATION

// I/We have taken registration under the CGST Act, 2017 and have exercised the option to pay tax for services of GTA in relation to transport of goods supplied by us during the Financial Year 2025-26 under forward charge.";
// $declaration='';
// /* height calculate */
// $pdf->SetFont('Arial','',8);

// $startY = $pdf->GetY();

// $endY = $pdf->GetY();

// $height = $endY - $startY;


// $pdf->SetXY($x,$y);


// $pdf->MultiCell(132,4,$declaration,1,'L');


// $pdf->SetXY($x+132,$y);

// $pdf->SetFont('Arial','B',8);
// $pdf->Cell(68,20,"FOR: M/S. GURU ASSOCIATES",1,2,'C');
// $pdf->Cell(66,20,"",1,2,'C');
  $pdf->Output();	
?>
