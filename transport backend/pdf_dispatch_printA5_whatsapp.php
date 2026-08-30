<?php  
error_reporting(0);
include("adminsession.php");
require("fpdf17/fpdf.php");

if($_REQUEST['billid'])
{
    $dispatch_id = $_REQUEST['billid'];    
}
else
$dispatch_id = 0; 
$filename = 'whatsapp/'.$dispatch_id.'.pdf';

$cname = $cmn->getvalfield($connection, "m_company", "cname", "comp_id=$_SESSION[comp_id]");
$phoneno = $cmn->getvalfield($connection, "m_company", "mobileno1", "comp_id=$_SESSION[comp_id]");
$mobileno1 = $cmn->getvalfield($connection, "m_company", "mobileno2", "comp_id=$_SESSION[comp_id]");
$caddress = $cmn->getvalfield($connection, "m_company", "caddress", "comp_id=$_SESSION[comp_id]");
$email_id = $cmn->getvalfield($connection, "m_company", "emailid", "comp_id=$_SESSION[comp_id]");
$c_logo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");

$companygst = $cmn->getvalfield($connection,"m_company","gst_no","comp_id='$_SESSION[comp_id]'");
$pan_card = $cmn->getvalfield($connection,"m_company","comp_id","comp_id='$_SESSION[comp_id]'");
if($dispatch_id !='')
{
    $sql_Q= mysqli_query($connection,"select * from dispatch_entry where dispatch_id='$dispatch_id'");
    $row=mysqli_fetch_assoc($sql_Q);
    $di_no = $row['di_no'];
    $gr_date = $cmn->dateformatindia($row['gr_date']);
    $gr_no = $row['gr_no'];
    $bilty_date = $row['bilty_date'];
    $dt = new DateTime($bilty_date);    
    $bilty_date = $dt->format('d-m-Y');
         $odn_no = $row['odn_no'];
    $bilty_date = $cmn->dateformatindia($row['bilty_date']);
    $invoiceno = $row['invoice_no'];
    // $distance = $row['distance'];
    $deliverat = $row['unloading_place'];
    $consignorid = $row['consignor_id'];
    $consigneeid = $row['consignee_id'];
    $truckid = $row['vehicle_id'];
    $ownerid = $row['owner_id'];
    $placeid = $row['from_id'];
    $destinationid = $row['destination_id']; 
    $brand_id = $row['brand_id'];
    $noofqty = $row['qty'];
    $driver_id = $row['driver_id'];
   $chalan=$row['bilty_no'];
    $adv_cash = $row['cash_adv'];
    $adv_diesel = $row['diesel_adv_amt'];
    $adv_other = $row['other_cash_adv'];
    $adv_cheque = $row['consignor_cash_adv'];
        $consignee_cash_adv = $row['consignee_cash_adv'];
            $biltyremark = $row['remark'];
    $consigneename = $cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consigneeid'"); 
    $consigneeaddress = $cmn->getvalfield($connection,"m_consignee","consignee_address","consignee_id='$consigneeid'"); 
    $consignorname = $cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id='$consignorid'"); 
     $cgst_no= $cmn->getvalfield($connection,"m_consignor","gst_no","consignor_id='$consignorid'"); 
    $truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$truckid'"); 
$driver_name = $cmn->getvalfield($connection,"m_driver","driver_name","driver_id='$driver_id'"); 
$drivermobile = $cmn->getvalfield($connection,"m_driver","mobile_no","driver_id='$driver_id'"); 
    $ownername = $cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id='$ownerid'");    
    $ownermobileno = $cmn->getvalfield($connection,"m_vehicle_owner","mobileno1","owner_id='$ownerid'");    
    
    $placename = $cmn->getvalfield($connection,"m_place","place_name","place_id='$placeid'");
    $destination = $cmn->getvalfield($connection,"m_place","place_name","place_id='$destinationid'");
    $brand_name = $cmn->getvalfield($connection,"m_brand","brand_name","brand_id='$brand_id'");
    $totalweight = $row['wt_mt'];
    $own_rate = $row['comp_rate'];
    $itemid = $row['item_id'];
    $itemname = $cmn->getvalfield($connection,"m_item","item_name","item_id='$itemid'");
    
    
}

function getinwordsbyindia($number)
{
   $no = round($number);
   $point = round($number - $no, 2) * 100;
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
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? 'and ' : null;
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
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] :'';
          
        
          
if($points !='' && $points !='0')
{
 $words=  "$result Rupees $points  Paise";
}
else
{
    $words=  "$result Rupees  ";
}
   
   return $words;
}



function convert_number_to_words($number)
 {
  
    $hyphen      = '-';
    $conjunction = ' and ';
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
        global $title1,$title2,$companygst,$headaddress,$phoneno,$mobileno1,$mobileno2,$caddress,$cname,$di_no,$gr_date,$gr_no,$bilty_date,$invoiceno,$distance,$deliverat,$consigneename,$consignorname,$truckno,$placename,$destination,$totalweight,$own_rate,$itemname,$pan_card,$clogo;
        // Rect(float x, float y, float w, float h [, string style])
        $this->Rect(5,1,200,17,'D'); // sabse upper
        $this->Rect(5,1,200,13,'D');
        $this->Rect(5,18,200,120,'D');
        $this->Rect(5,18,53,35,'D');//driver name
        $this->Rect(58,18,79,35,'D');//consignee
        $this->Rect(137,18,68,35,'D');//truck no
    
    $this->Rect(5,98,200,26,'D');//truck no
    $this->Rect(155,98,50,26,'D');
      $this->SetY(7);
   $this->SetFont('arial','b',14);
   // $this->Image('../upload/logo/'.$clogo,15,5,14,14);
//$this->Image('bpslogo.png',80,3,35,16);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
   $this->SetX(60);
 $this->Cell(30,0,$cname,0,1,'C');
    
        $this->SetY(3);
         $this->SetX(35);
        $this->SetFont('arial','b',8);
        
        $this->Cell(10,0,"CONSIGNMENT NOTE ",0,1,'L');
          $this->SetY(3);
        $this->SetFont('arial','b',8);
        $this->Cell(170);
        $this->Cell(65,0,"AT OWNER RISK",0,1,'L');
        if($companygst !='') {
        $this->SetFont('arial','b',7);  
        $this->Cell(180,26,"GSTIN No : $companygst",0,1,'R');
        }
        
        $this->Ln(7);
        $this->SetFont('arial','b',40);
        $this->Cell(70);
        $this->Cell(50,0,"",0,1,'L');
        $this->SetX(5);
        $this->SetY(20);
        
         $this->SetY(16);
          $this->SetX(5);
        $this->SetFont('arial','b',7);  
         $this->Cell(30);
        $this->Cell(5,0,"PAN No : $pan_card",0,1,'R');
          $this->Cell(105,0, " Contact No : ".$phoneno.",".$mobileno1.",".$mobileno2,0,1,'R');
        $this->Ln(4);
        
        
        
        
        
        
         $this->SetY(12);
          $this->SetX(30);
        $this->SetFont('arial','b',10); 
        $this->Cell(170,0,$caddress,0,1,'C');
        
        $this->SetX(5);
        //$this->SetY(20);
        
        //$this->Line(5,15,205,15);
        //$this->Line(5,32,205,32);
        //$this->Line(5,39,205,39);
        //$this->Line(5,46,205,46);
        //$this->Line(5,56,205,56);
        //$this->Line(5,66,205,66);
    
        //$this->Line(5,126,205,126);
    //$this->Line(90, 16, 90, 24); //horizental
        //$this->Line(160, 16,160, 24); //horizental
        
    
    
         $this->SetX(7);
$this->SetFont('courier','b',8);
$y = $this->GetY();
$x = $this->GetX();
$width = 75;

$this->MultiCell($width,3,$consignoradd,0, 'L', FALSE);
$this->SetXY($x + $width, $y);
        
    
        //for Supplier Name
        
            $this->Ln(2);
        //$this->Cell(71,5,":".$challan_no,0,1,'L');
        $this->SetY(60);
       $this->SetX(5);
        
    
        $this->SetX(5);
        
        $this->SetWidths(array(7,16,42,18,18,22,22));
        //$this->SetAligns(array("L","L","L","L","R","R","R","R","R","R","R","R"));
        $this->SetAligns(array("C","L",'L',"L","L","L","R"));
        
    }
      // Page footer
    function Footer()
    {
        global $ownername,$mobileno1,$mobileno2,$mobile,$cname;
    // Position at 1.5 cm from bottom
    
        //$this->MultiCell(200,5,'Subject To Raipur Jurisdiction',0,'C');
    $this->SetY(-8);
    $this->SetX(5);
    $this->SetFont('arial','b',8);
    $this->SetTextColor(0,0,0);
    $this->Cell(50,5,'Signature Of Truck Owner/Driver',0,0,'R',0);
$this->Cell(130,5,'For, '.$cname,0,0,'R',0);

    
    $this->SetY(118);
    $this->SetFont('arial','b',8);
    $this->SetTextColor(0,0,0);
    $this->Cell(190,5,'Received By Seal & Sign.',0,0,'R',0);
    
     
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
    $h=8*$nb;
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
        $this->MultiCell($w,8,$data[$i],0,$a);
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
$title1 = "Bilty INVOICE";
$pdf->SetTitle($title1);

$title3 = $address;
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A5');



 $pdf->SetX(20);
   $pdf->SetFont('arial','b',9);
// $pdf->Image('termcondition2.png',7,100,60,7);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])

  $pdf->Image('upload/logo/'.$c_logo,6,2,18,11);

////$pdf->SetFont('arial','b',9);
//$pdf->Image('party.png',180,0,20,10);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])

   
         
        
    $pdf->SetY(20);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(13,3,"DI No.",0,0,'L');
    $pdf->Cell(40,3,": ".$di_no,0,0,'L');
    
   
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(18,3," Consignor",0,0,'L');
    $pdf->Cell(62,3,": ".substr($consignorname,0,-11),0,0,'L');
    
    //$pdf->SetFont('Arial','b',9);
//    $pdf->Cell(13,4,"From",0,0,'L');
//  $pdf->Cell(32,4," : ".$placename,0,0,'L');
    
    //$pdf->SetFont('Arial','b',9);
//    $pdf->Cell(13,4,"GR Date",0,0,'L');
//  $pdf->Cell(22,4," : ".$gr_date,0,0,'L');
    
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(23,3,"Truck No",0,0,'L');
    $pdf->Cell(15,3,": ".$truckno,0,1,'L');
    
    
    $pdf->Ln(2);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(14,3,"GR No. ",0,0,'L');
    $pdf->Cell(40,3,":".$gr_no,0,0,'L');
    
   
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(18,3,"From",0,0,'L');
    $pdf->Cell(30,3,":".$placename,0,0,'L');
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(12,3," ",0,0,'L');
    $pdf->Cell(19,3," ",0,0,'L');
    
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(22,3,"Truck Owner",0,0,'L');
    $pdf->Cell(19,3,":".substr($ownername,0,23),0,1,'L');
    
    $pdf->Ln(2);
     $pdf->SetX(5);    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(13,3,"GR Date",0,0,'L');
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(40,3,": ".$gr_date,0,0,'L');
    
    
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(17,3,"Consignee",0,0,'L');
    $pdf->Cell(63,3,": ".$consigneename,0,0,'L');
            
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(16,3,"Mobile No",0,0,'L');
    $pdf->Cell(40,3,": ".$ownermobileno,0,1,'L');
    
    $pdf->Ln(2);
    
    $pdf->SetX(5);     
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(15,3,"Invoice No",0,0,'L');
    $pdf->Cell(39,3," : ".$invoiceno,0  ,0,'L');
    
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(20,3,"To",0,0,'L');
    $pdf->Cell(60,3,": ".$destination,0,0,'L'); 
    
    
    
    
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(9,3,"Driver",0,0,'L');
    $pdf->Cell(40,3," : ".$driver_name,0,1,'L');
    $pdf->Ln(2);
    
    /*
    
    $y = $pdf->GetY();
    $x = $pdf->GetX();
    $width = 59;
    $pdf->MultiCell($width,4," : ".$subconsigneename,0, 'L', FALSE);
     $pdf->SetXY($x + $width, $y);
     
     */
    
    //$pdf->Cell(56,4,": ".$subconsigneename,0,0,'L');
    
    $pdf->SetX(5);  
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(18,3,"Invoice Date",0,0,'L');
    $pdf->Cell(36,3," : ".$gr_date,0,0,'L');
    
     $pdf->SetFont('Arial','b',9);
    $pdf->Cell(17,3,"GST No.",0,0,'L');
    $pdf->Cell(62,3,": ".  $cgst_no,0,0,'L');
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(15,3,"Driver No.",0,0,'L');
    $pdf->Cell(60,3," : ".$drivermobile,0,1,'L');
    
    $pdf->Ln(2);
    $pdf->SetX(5);  
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(18,3,"Bilty No :",0,0,'L');
    $pdf->Cell(35,3,$chalan,0,0,'L');
        $pdf->SetFont('Arial','b',9);
    $pdf->Cell(17,3,"Odn No.",0,0,'L');
    $pdf->Cell(62,3,": ".  $odn_no,0,0,'L');
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(20,3," ",0,0,'L');
    $pdf->Cell(60,3," ",0,0,'L');
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(15,3,"Deliver At",0,0,'L');
    $pdf->Cell(60,3," : ".$deliverat,0,1,'L');
    
    
$pdf->Ln(2);
$pdf->SetY(50);
$pdf->SetX(5);

$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(0,0,0); //gray
$pdf->SetTextColor(255,255,255);
$pdf->Cell(47,6,'Description(Said to contain)',1,0,'L',1);
$pdf->Cell(30,6,'Brand','1',0,'C',1);  
$pdf->Cell(39,6,'Qty(In Bags)',1,0,'C',1);
$pdf->Cell(22,6,'Weight(MT)',1,0,'L',1);
$pdf->Cell(22,6,'RATE/MT',1,0,'C',1);
$pdf->Cell(40,6,'Freight',1,1,'C',1);
$pdf->SetFont('Arial','',6);
    
$pdf->SetWidths(array(47,30,39,22,22,40));
$pdf->SetAligns(array("C","C","C","C","C","R"));
$freight =  $totalweight * $own_rate;

$pdf->SetX(5);  
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($itemname,$brand_name,$noofqty,$totalweight,$own_rate,number_format($freight,2)));

/*  
    $pdf->SetX(5);
$pdf->SetFont('arial','',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(30,5,'service Tax Liabll-',1,0,'R',0);
$pdf->Cell(23,5,'Consignor',1,0,'R',0);
$pdf->Cell(24,5,'Consignee',1,0,'R',0);
$pdf->Cell(39,5,'Goods Transport Agency',1,0,'R',0);
$pdf->Cell(44,5,'Add Service Tax Payable',1,0,'R',0);
$pdf->Cell(40,5,number_format($total,2),'1',1,'R',0);


$pdf->SetX(5);
$pdf->SetFont('arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(160,5,'Gross Amount',1,0,'R',0);
$pdf->Cell(40,5,number_format($total,2),'1',1,'R',0);

*/


$total_adv = $adv_cash + $adv_other + $adv_cheque + $consignee_cash_adv;

$pdf->SetX(5);
$pdf->SetFont('arial','b',8);
$pdf->SetTextColor(0,0,0);
// $pdf->Cell(160,5,'Advance Paid',1,0,'R',0);
// $pdf->Cell(40,5,number_format($total_adv,2),'1',1,'R',0);


$pdf->SetX(5);
$pdf->SetFont('arial','b',8);
$pdf->SetTextColor(0,0,0);
// $pdf->Cell(160,5,'Advance Diesel',1,0,'R',0);
// $pdf->Cell(40,5,number_format($adv_diesel,2),'1',1,'R',0); 

$balamt = $freight - $total_adv - $adv_diesel;

$pdf->SetX(5);
$pdf->SetFont('arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(160,5,'Total Freight',1,0,'R',0);
$pdf->Cell(40,5,number_format($freight,2),'1',1,'R',0);





$pdf->Ln(1);
$pdf->SetX(5);
$pdf->SetFont('Arial','b',8);
$pdf->Cell(100,5,'UNDERTAKING',0,0,'L',0);
$pdf->Ln();





$pdf->SetFont('Arial','',8);
//$pdf->Cell(100,5,$terms,0,0,'L',0);
$pdf->SetX(7);
$pdf->MultiCell(198,4,"In Terms of Service Tax Notification 32/2004-ST dated 03.12.2004, Service Tax is calculated on a value which is Equivalent to 25% of the Gross amount charged from the customer for providing the taxable service, and no credit of Duty paid on input or Capital Goods for providing such taxable service has been taken by us under the provisions of Cenvat Credit Rules,2004.",0,'L');
//$pdf->Ln(50);



 $pdf->SetFont('arial','b',9);
//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])


$pdf->SetY(112);
$pdf->SetX(5);

$pdf->Cell(16,5,'Remark',0,1,'L',0);
$pdf->SetX(5);
$pdf->Cell(140,5,$biltyremark,'0',1,'L',0);
if ($_REQUEST['source']) { 
    $file = __FILE__;
    header("Content-Type: text/plain");
    header("Content-Length: ".filesize($file));
    header("Content-Disposition: attachment; filename='".$file."'");
    readfile($file);
    exit; 
}
$pdf->Output($filename,'F');

?> 
                            
<?php
mysqli_close($connection);



?>
