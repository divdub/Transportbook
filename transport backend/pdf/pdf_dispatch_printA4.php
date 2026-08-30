<?php 
error_reporting(0);
include("../adminsession.php");
require("../fpdf184/fpdf.php");

if(isset($_GET['dispatch_id']))
{
    $dispatch_id = trim(addslashes($_GET['dispatch_id']));  
}

$cname = $cmn->getvalfield($connection, "m_company", "cname", "comp_id=$_SESSION[comp_id]");
$phoneno = $cmn->getvalfield($connection, "m_company", "mobileno1", "comp_id=$_SESSION[comp_id]");
$mobileno1 = $cmn->getvalfield($connection, "m_company", "mobileno2", "comp_id=$_SESSION[comp_id]");
$caddress = $cmn->getvalfield($connection, "m_company", "caddress", "comp_id=$_SESSION[comp_id]");
$email_id = $cmn->getvalfield($connection, "m_company", "emailid", "comp_id=$_SESSION[comp_id]");
$c_logo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");

$companygst = $cmn->getvalfield($connection,"m_company","gst_no","comp_id='$_SESSION[comp_id]'");
$pan_card = $cmn->getvalfield($connection,"m_company","comp_id","comp_id='$_SESSION[comp_id]'");

// $company_gst = $cmn->getvalfield($connection,"m_company","gst_no","compid='$_SESSION[compid]'");

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
        
    $bilty_date = $cmn->dateformatindia($row['bilty_date']);
    $invoiceno = $row['invoice_no'];
    // $distance = $row['distance'];
    $deliverat = $row['unloading_place'];
    $consignorid = $row['consignor_id'];
    $consigneeid = $row['consignee_id'];
    $truckid = $row['vehicle_id'];
    $ownerid = $row['owner_id'];
      $ownerid = $row['owner_id'];
    $odn_no = $row['odn_no'];
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
        global $title1,$di_no,$pan_card,$tokendate,$gr_no,$ewayno,$companyname,$companyaddrs,$companymob1,$companymob2,$company_gst,$lr_no,$phoneno,$c_logo,$email_id;
        // Rect(float x, float y, float w, float h [, string style])
      
    }
      // Page footer
    function Footer()
    {
        global $title1,$di_no,$pan_card,$tokendate,$gr_no,$ewayno,$companyname,$email_id,$cname;
    $this->SetY(-8);
    $this->SetX(5);
    $this->SetFont('arial','b',8);
    $this->SetTextColor(0,0,0);
    $this->Cell(50,5,'Signature Of Truck Owner/Driver',0,0,'R',0);
$this->Cell(130,5,'For, '.$cname,0,0,'R',0);

    
    $this->SetY(-35);
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


//$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');


    $pdf->Ln(10);
    
     $pdf->Rect(5,1,200,17,'D'); // sabse upper
        $pdf->Rect(5,1,200,13,'D');
        $pdf->Rect(5,18,200,120,'D');
        $pdf->Rect(5,18,53,35,'D');//driver name
        $pdf->Rect(58,18,79,35,'D');//consignee
        $pdf->Rect(137,18,68,35,'D');//truck no
    
    $pdf->Rect(5,98,200,26,'D');//truck no
    $pdf->Rect(155,98,50,26,'D');
       
        
   $pdf->SetFont('arial','b',16);
   $pdf->SetFont('arial','b',16);
   $pdf->Image('../upload/logo/'.$c_logo,6,150,18,11);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
$pdf->Image('../upload/logo/'.$c_logo,6,2,18,11);
//$this->Image('bpslogo.png',80,3,35,16);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
          $pdf->SetY(7);
           $pdf->SetX(20);
 $pdf->Cell(86,0,$cname,0,1,'C');
    
        $pdf->SetY(3);
         $pdf->SetX(28);
        $pdf->SetFont('arial','b',8);
        
        $pdf->Cell(10,0,"CONSIGNMENT NOTE ",0,1,'L');
          $pdf->SetY(3);
        $pdf->SetFont('arial','b',8);
        $pdf->Cell(170);
        $pdf->Cell(65,0,"AT OWNER RISK",0,1,'L');

        if($companygst !='') {
        $pdf->SetFont('arial','b',7);  
        $pdf->Cell(180,26,"GSTIN No : $companygst",0,1,'R');
        }

       
        $pdf->Ln(7);
        $pdf->SetFont('arial','b',40);
        $pdf->Cell(70);
        $pdf->Cell(50,0,"",0,1,'L');
        $pdf->SetX(5);
        $pdf->SetY(20);
        
         $pdf->SetY(16);
          $pdf->SetX(5);
        $pdf->SetFont('arial','b',7);  
         $pdf->Cell(30);
        $pdf->Cell(5,0,"PAN No : $pan_card",0,0,'R');
        $pdf->Cell(65,0, " Contact No : ".$phoneno.",".$mobileno1.",".$mobileno2,0,1,'R');
        $pdf->Ln(4);
        
        
        
        
        
        
         $pdf->SetY(12);
          $pdf->SetX(16);
        $pdf->SetFont('arial','b',10); 
        $pdf->Cell(170,0,$caddress,0,1,'C');
               
    $pdf->SetY(20);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(19,3,"DI No.",0,0,'L');
    $pdf->Cell(33,3,": ".$di_no,0,0,'L');
    
   
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(18,3," Consignor",0,0,'L');
    $pdf->Cell(62,3,": ".substr($consignorname,0,-11),0,0,'L');
       
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(23,3,"Truck No",0,0,'L');
    $pdf->Cell(15,3,": ".$truckno,0,1,'L');
    
    
    $pdf->Ln(2);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(19,3,"GR No. ",0,0,'L');
    $pdf->Cell(34,3,": ".$gr_no,0,0,'L');
    
   
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(17,3,"From",0,0,'L');
    $pdf->Cell(31,3,": ".$placename,0,0,'L');
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(12,3," ",0,0,'L');
    $pdf->Cell(19,3," ",0,0,'L');
    
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(22,3,"Truck Owner",0,0,'L');
    $pdf->Cell(19,3,": ".substr($ownername,0,23),0,1,'L');
    
    $pdf->Ln(2);
     $pdf->SetX(5);    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(19,3,"GR Date",0,0,'L');
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(34,3,": ".$gr_date,0,0,'L');
    
    
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(17,3,"Consignee",0,0,'L');
    $pdf->Cell(62,3,": ".$consigneename,0,0,'L');
            
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(16,3,"Mobile No",0,0,'L');
    $pdf->Cell(40,3,": ".$ownermobileno,0,1,'L');
    
    $pdf->Ln(2);
    
    $pdf->SetX(5);     
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(18,3,"Invoice No",0,0,'L');
    $pdf->Cell(35,3," : ".$invoiceno,0  ,0,'L');
    
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(17,3,"To",0,0,'L');
    $pdf->Cell(62,3,": ".$destination,0,0,'L'); 
    
    
  
    
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(9,3,"Driver",0,0,'L');
    $pdf->Cell(40,3," : ".$driver_name,0,1,'L');
    $pdf->Ln(2);
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
    $pdf->Cell(19,3,"Bilty No ",0,0,'L');
    $pdf->Cell(35,3,": ".$chalan,0,0,'L');
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
  $pdf->SetY(138);
    $pdf->SetX(5);
    $pdf->SetFont('arial','b',8);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(50,5,'Signature Of Truck Owner/Driver',0,0,'R',0);
$pdf->Cell(130,5,'For, '.$cname,0,0,'R',0);

    
    $pdf->SetY(118);
    $pdf->SetFont('arial','b',8);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(190,5,'Received By Seal & Sign.',0,0,'R',0);

      
    $pdf->SetY(145);
$pdf->SetX(0);

    $pdf->Cell(204,1,'----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'L',0);
$pdf->Image('../upload/cut.jpg',190,142,7,7);
    $pdf->Ln(5);
        
    
     $pdf->Rect(5,149,200,17,'D'); // sabse upper
        $pdf->Rect(5,149,200,13,'D');
        $pdf->Rect(5,166,200,120,'D');
        $pdf->Rect(5,166,53,35,'D');//driver name
        $pdf->Rect(58,166,79,35,'D');//consignee
        $pdf->Rect(137,166,68,35,'D');//truck no
    
    $pdf->Rect(5,246,200,26,'D');//truck no
    $pdf->Rect(155,246,50,26,'D');
       
        
   $pdf->SetFont('arial','b',16);
   $pdf->SetFont('arial','b',16);
   // $pdf->Image('../upload/logo/'.$c_logo,6,152,22,11);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
// $pdf->Image('../upload/logo/'.$c_logo,6,2,22,11);
//$this->Image('bpslogo.png',80,3,35,16);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
          $pdf->SetY(155);
           $pdf->SetX(20);
 $pdf->Cell(86,0,$cname,0,1,'C');
    
        $pdf->SetY(151);
         $pdf->SetX(28);
        $pdf->SetFont('arial','b',8);
        
        $pdf->Cell(10,0,"CONSIGNMENT NOTE ",0,1,'L');
          $pdf->SetY(151);
        $pdf->SetFont('arial','b',8);
        $pdf->Cell(170);
        $pdf->Cell(65,0,"AT OWNER RISK",0,1,'L');

        if($companygst !='') {
        $pdf->SetFont('arial','b',7);  
        $pdf->Cell(180,26,"GSTIN No : $companygst",0,1,'R');
        }

       
        $pdf->Ln(7);
        $pdf->SetFont('arial','b',40);
        $pdf->Cell(70);
        $pdf->Cell(50,0,"",0,1,'L');
        $pdf->SetX(5);
        $pdf->SetY(20);
        
         $pdf->SetY(164);
          $pdf->SetX(5);
        $pdf->SetFont('arial','b',7);  
         $pdf->Cell(30);
        $pdf->Cell(5,0,"PAN No : $pan_card",0,0,'R');
        $pdf->Cell(65,0, " Contact No : ".$phoneno.",".$mobileno1.",".$mobileno2,0,1,'R');
        $pdf->Ln(4);
        
        
        
        
        
        
         $pdf->SetY(160);
          $pdf->SetX(16);
        $pdf->SetFont('arial','b',10); 
        $pdf->Cell(170,0,$caddress,0,1,'C');
               
    $pdf->SetY(170);
    $pdf->SetX(5);
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(13,3,"DI No.",0,0,'L');
    $pdf->Cell(40,3,": ".$di_no,0,0,'L');
    
   
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(18,3," Consignor",0,0,'L');
    $pdf->Cell(62,3,": ".substr($consignorname,0,-11),0,0,'L');
       
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
    $pdf->Cell(36,3,$chalan,0,0,'L');
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(20,3," ",0,0,'L');
    $pdf->Cell(60,3," ",0,0,'L');
    
    $pdf->SetFont('Arial','b',9);
    $pdf->Cell(15,3,"Deliver At",0,0,'L');
    $pdf->Cell(60,3," : ".$deliverat,0,1,'L');
    
    
$pdf->Ln(2);
$pdf->SetY(199);
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


$pdf->SetY(262);
$pdf->SetX(5);

$pdf->Cell(16,5,'Remark',0,1,'L',0);
$pdf->SetX(5);
$pdf->Cell(140,5,$biltyremark,'0',1,'L',0); 


$pdf->Output();
?> 
                            
<?php
mysqli_close($connection);



?>
