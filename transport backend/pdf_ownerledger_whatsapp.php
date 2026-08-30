<?php
/*call the FPDF library*/
// error_reporting(0);
include("adminsession.php");
include("fpdf17/rotation.php");

if(isset($_REQUEST['fromdate'])) {
    $fromdate = $_REQUEST['fromdate'];
  }
  else
  $fromdate=date('Y-m-d');

if(isset($_REQUEST['todate'])) {
    $todate =$_REQUEST['todate'];
  }
  else
  $todate=date('Y-m-d');

  $cond="";
  $cond2="";

if(isset($_REQUEST['owner_id'])) {
    $owner_id =$_REQUEST['owner_id'];
  }
  else
  $owner_id='';

if($fromdate !='' && $todate !='' ) {
//   $cond = "and inc_date between '$fromdate' and '$todate' "; 
//     $cond1 = "and exp_date between '$fromdate' and '$todate' "; 
 $cond= "WHERE voucher_date BETWEEN '$fromdate' AND '$todate'";
//   $cond1 =" WHERE other_expense_entry.exp_date BETWEEN '$fromdate' AND '$todate'";
  $cond2="WHERE receive_date BETWEEN '$fromdate' AND '$todate'";
}
if($owner_id !='' ) {
  $cond .= "and catname='$owner_id'"; 
   	 $ownername = $cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id='$owner_id'");
    $cond2 .= "and catname='$owner_id'"; 
}
// $prevbalance = $cmn->getcashopeningplant($connection,$fromdate,$comp_id,$consignorid,$session_id);
$filename = 'whatsapp/'.$owner_id.'.pdf';
$currdate_str = strtotime($fromdate);
	
$currdate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));

      $payment = $cmn->getvalfield($connection,"payment","sum(amt_paid_to)","consignorid=$consignorid && comp_id=$comp_id && category_id=4  && voucher_date <= '$currdate' and catname='$owner_id'"); 
      $payment_receive = $cmn->getvalfield($connection,"payment_receive","sum(receive_amt)","consignorid=$consignorid && comp_id=$comp_id && category=4  && receive_date <= '$currdate' and catname='$owner_id'"); 



$curr_openingbal = $payment - $payment_receive ;
  
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

  
$c_logo = $cmn->getvalfield($connection,"m_company","clogo","comp_id='$_SESSION[comp_id]'");

function convert_number_to_words($number) {



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

class PDF extends PDF_Rotate
{
    var $widths;

    var $aligns;
    function Header()
    {
         global $adv_date,$bal_amt,$receive_date;
        /* Put the watermark */
        
        // // if($bal_amt=='0')
        // $this->SetFont('Arial','B',30);
        // $this->Sety(20);
        // $this->Cell(0,10,'GURU ASSOCIATES',0,0,'C');
        

        // $this->SetTextColor(255,192,203);
        // $this->RotatedText(100,150,'PAID',45);
        // $this->SetFont('Arial','B',18);
        // $this->RotatedText(110,150,$receive_date,45);
        
    //    if($receive_date!='' && $bal_amt > 0)
            // $this->SetFont('Arial','B',80);
            // $this->SetTextColor(255,192,203);
            // $this->RotatedText(100,150,'Pending',45);
            // $this->SetFont('Arial','B',18);
            //$this->RotatedText(110,150,$receive_date,45); 
        
        $this->Rect(2,2,293,206);
    }
    
    function Footer()

    { 

        global $comp_name;
        // Position at 1.5 cm from bottom
        $this->SetY(-11);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 10);
        // Page number
        $this->SetX(35);
        $this->MultiCell(200, 5, '|| Developed By Chaaruvi Infotech Raipur, Contact us- +91-8871181890,Visit us- www.chaaruviinfotech.com ||', 0, 'C');
   
    }

     }
    

    function RotatedText($x, $y, $txt, $angle)
    {
        /* Text rotated around its origin */
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
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

    
    
$pdf=new PDF('L','mm','A4');
$pdf->AddPage();
/*output the result*/
$pdf->SetY(5);

//  $pdf->SetX(20);
 
                                    
                                        // echo "SELECT * FROM `m_company` where comp_id='$comp_id' ";die;
                                            $company_owner = "SELECT * FROM `m_company` where comp_id='$comp_id' ";

                                    $cmp_owm = mysqli_query($connection,$company_owner);
                               $onwer = mysqli_fetch_assoc($cmp_owm);
                               
                                       $pdf->Image('upload/logo/'.$c_logo,15,4,25);
                                    //    echo $onwer['cname']; die;         
                                        $pdf->SetX(70);
                                        // $pdf->SetFont('Arial','',24);
                                           $pdf->SetTextColor(255, 0, 0);
                                      
                                         $pdf->SetFont('Courier','B',24);
                                        $pdf->Cell(150,8,$onwer['cname'],2,0,'C');
                                         $pdf->SetTextColor(0, 0, 0);
                                        $pdf->SetX(130);
                                        $pdf->SetFont('Arial','',24);
                                        $pdf->Cell(150,8,'',2,0,'L');
                                        
                                        $pdf->Ln();
                                       
                                        $pdf->SetX(80);
                                         $pdf->SetFont('Times','',10);
                                        $pdf->Cell(260,6,$onwer['caddress'],2,0,'L');
                                        $pdf->Ln();

                                            
                                         $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(350,5,'',2,0,'L');
                                        $pdf->SetFont('Times','',10);
                                       $pdf->Cell(125,-20,'Contact : '.$onwer['mobileno1'].",".$onwer['mobileno2'],2,0,'R');
                                         
                                               

                                        // $pdf->SetFont('Arial','',10);
                                        // $pdf->Cell(150,5,'',2,0,'L');
                                        $pdf->SetFont('Arial','',10);
                                        $pdf->SetY('30');
                                        $pdf->Cell(60,-10,'GST No. : '.$onwer['gst_no'],2,0,'R');
                                        $pdf->Ln();


                                        // $pdf->SetFont('Arial','',10);

                                    //    $pdf->Cell(150,10,'',2,0,'R');

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->SetY('20');
                                        $pdf->Cell(230,8,'PAN No. : '.$onwer['pan_no'],2,0,'R');
                                        $pdf->Ln();


                                    //      $pdf->SetFont('Arial','',10);

                                    //    $pdf->Cell(150,10,'',2,0,'R');
   $pdf->SetFillColor(175, 213, 240);
                                        $pdf->SetFont('Arial','B',15);
                                        $pdf->SetX('2');
                                        $pdf->Cell(293,8,'Owner Ledger',1,0,'C','F');
                                        $pdf->Ln();

                       
                                      
                                        $pdf->SetFont('Arial', 'B', 10);
                                        $pdf->SetX('20');
                                        $pdf->SetY('40');
                                     
                                        $pdf->Ln();

                                        $pdf->SetFont('Arial','B',11);
                                        $pdf->SetY('45');
                                        $pdf->Cell(60,-10,'Owner Name : '      .$ownername,2,0,'L');
                                        // $pdf->SetY('36');
                                        $pdf->SetX('205');
                                    
                                        $currentDateTime = date('d F Y h:i A'); 
                                        // $currentDateTime = date('d-m-Y H:i:s');
                                        $pdf->Cell(25, 8, 'Print Date and Time: ' . $currentDateTime, 2, 1,'L');

  $pdf->SetX('45');
                                        // $pdf->SetY('40');
                                          $pdf->Cell(26,-10,'Date : '.date('d-m-Y',strtotime($fromdate)).' To '.date('d-m-Y',strtotime($todate)),2,1,'R');

                                        $pdf->SetFont('Arial','B',12);
                                        $pdf->SetY('65');
                                     
                                        $pdf->Ln();
                                        
             
                                                      
	$pdf->SetX(15);
	$pdf->SetFont('Arial','B',9);
	    $pdf->SetFillColor(211, 211, 211);
// 	$pdf->SetFillColor(255,255,255); //gray
	//$this->SetTextColor(255,255,255);
	$pdf->Cell(8,6,'Sno','1',0,'L','F'); 
	
//     $pdf->Cell(25,6,'Invoice No',1,0,'L',1);

	$pdf->Cell(19,6,'Date',1,0,'L',1);
// 	$pdf->Cell(24,6,'GR/TR NO',1,0,'L',1);
	$pdf->Cell(50,6,'Particular',1,0,'C',1);
	$pdf->Cell(30,6,'Bill No.',1,0,'C',1);	
    $pdf->Cell(30,6,'Slip No.',1,0,'C',1);	
	$pdf->Cell(30,6,'Bill Amount ',1,0,'C',1);	
// 	$pdf->Cell(48,6,'CONSIGNEE',1,0,'L',1);
// 	$pdf->Cell(28,6,'DESTINATION',1,0,'L',1);
// 		$pdf->Cell(13,6,'Slip No','1',0,'L',1); 
// 	$pdf->Cell(15,6,'Bill No',1,0,'L',1);
	// $pdf->Cell(15,6,'RATE',1,0,'L',1);
	// $pdf->Cell(18,6,'FREIGHT',1,0,'L',1);
	//$this->Cell(16,6,'LABOUR',1,0,'L',1);	
// 	$pdf->Cell(20,6,'CASH ADV',1,0,'C',1);
// 		$pdf->Cell(25,6,'INCOME',1,0,'C',1);
		$pdf->Cell(40,6,'Paid Amount',1,0,'C',1);
	$pdf->Cell(60,6,'Balance',1,1,'C',1);
	// $pdf->Cell(14,6,'SGST',1,0,'L',1);
	// $pdf->Cell(10,6,'SHT',1,0,'L',1);
	// $pdf->Cell(10,6,'SHT',1,1,'L',1);
	
	//$this->Cell(10,6,'SHT-BG',1,0,'L',1);
	//$this->Cell(10,6,'SHT-MT',1,1,'L',1);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','B',9);
	  
                                
                   $sn=1;
//                       echo	"SELECT invno,invdate, invoiceid 
// FROM invoicebilty $cond2 and sessionid='$session_id'  && consignorid=$consignorid 
// UNION
// SELECT invoiceid,receive_date, minvid 
// FROM manualinv $cond and session_id='$session_id'  && consignorid=$consignorid
//  ORDER BY invdate;";
                    $sql = mysqli_query($connection,"SELECT voucher_id,sortamt,voucher_date,amt_paid_to,for_ledger
FROM payment $cond && consignorid=$consignorid && comp_id=$comp_id && category_id=4  && session_id=$session_id GROUP BY voucher_id
UNION 
SELECT voucher_no,rec_no,receive_date,receive_amt,for_ledger
FROM payment_receive $cond2 && category=4 && consignorid=$consignorid && comp_id=$comp_id  && session_id=$session_id
 ORDER BY voucher_date;");

                           while($row= mysqli_fetch_array($sql)) {
                     
	$head_id=$row['vehicle_id'];
	$type=$row['for_ledger'];
	$incamount=0;
	$expense_amount=0;
	$cash_adv=0;
	if($totbalamt==''){
	    $totbalamt=$curr_openingbal;
	}
	
if($type==''){
    $particular=" Payment";
//  $invno = $cmn->getvalfield($connection,"invoicebilty","invno","invoiceid='$row[invno]'");
$rec_no='0'.$row['sortamt'];
   $received_amt=$row['amt_paid_to'];
    $balamt = $totbalamt - $received_amt;
    $amount1='0';
    $payee_name = $cmn->getvalfield($connection, "payment", "payee_name", "voucher_id='$row[voucher_id]' && consignorid=$consignorid && session_id=$session_id && comp_id=$comp_id");
} else {
     $particular='Voucher';
//  $invno=$row['invno'];
$rec_no='';
 $amount1=$cmn->getvalfield($connection,"payment","sum(amt_paid_to)","voucher_id='$row[voucher_id]' && consignorid=$consignorid && session_id=$session_id && comp_id=$comp_id");
$payee_name = '';
//  	$amount = $cmn->getinvoiceamount1($connection,$row['invoiceid']);
 	 	// $gst =  ($amount * 12)/100;
    //                                   	$amount1=$amount+$gst;
                                      	$received_amt='0';
    // $cash_adv=$row['cash_adv'];
    $balamt= $totbalamt + $amount1;
}

//  $balamt = $amount1  - $received_amt   ;       
	
//         $truckno = $cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id='$truckid'");
// 	$deliverat = $cmn->getvalfield($connection,"m_place","place_name","place_id='$destination_id'");
//     $pump_name = $cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id='$row[pump_id]'");
//          $dbillno = $cmn->getvalfield($connection,"dieselbill","dbillno","dbillid='$row[dbillid]'");
//                 
             
      $pdf->SetFont('Arial','',8);
      $pdf->SetX(15);
                                               

                                                $pdf->SetFont('Arial','',8);
                                                $pdf->SetX(15);
                                                $pdf->Cell(8,8, $sn++,1,0,'L');
                                             
                                                // $pdf->Cell(25,8,$row['voucher_id'],1,0,'L');
                                                // $pdf->Cell(15,8,$row['bilty_no'],1,0,'R');
                                                $pdf->Cell(19,8,date('d-m-Y',strtotime($row['voucher_date'])),1,0,'R');
                                                                                        // $pdf->Cell(24,8, $gr_no, 1,0, 'R');
                                                                                        
                                                    $pdf->Cell(50,8, $particular . ($payee_name != '' ? " ($payee_name)" : ''), 1,0, 'R');
                                                       $pdf->Cell(30,8, $row['voucher_id'], 1,0, 'C');
                                                       $pdf->Cell(30,8, $rec_no, 1,0, 'C');
                                                    $pdf->Cell(30,8, round($amount1,2), 1,0, 'R');
                                                    // $pdf->Cell(28,8, $deliverat, 1,0, 'R');
                                                    //      $pdf->Cell(13,8, $slip_no,1,0,'L');
                                                    //  $pdf->Cell(15,8, $dbillno, 1,0, 'R');
                                             
                                              $pdf->Cell(40,8,round($received_amt),1,0,'C');

                                               $pdf->Cell(60,8,round($balamt),1,0,'C');
                                  
                      $pdf->Ln();
                                            
                                               
                                                                $total_tds+=$tds_amt;
                                                                    $total_adv +=$adv;
                                                                        $total_deduct+=$sortamt; 
                                                                      
                                                                          
                                                                                 $total_final+=$cash_adv;
                                                                                 $total_incamount+= $amount1;
                                                                                 $total_expense_amount+=$received_amt;
                                                                                //   $balamt=$total_bal-$total_amt2;
                                                                                 $totbalamt +=  $balamt + $total_incamount  -$total_expense_amount;
                                                                    $totbalamt = $curr_openingbal + $total_incamount  -$total_expense_amount ;                                                                                                    
                                            }    

                                                  
       $pdf->SetX(15);
                                        $currentX = $pdf->GetX();
                                        $currentY = $pdf->GetY();
                                        
                                        // Draw a line from current position (after the Cell)
                                        // $pdf->Line($currentX , $currentY + 16, $currentX + 293, $currentY + 16); 
                                           $pdf->SetFillColor(175, 213, 240);

                                                     $pdf->SetFont('Arial','B',9);
                                                     $pdf->Cell(117,12,'Total',1,0,'C','F');

                                                     
                                                  
                                                      $pdf->SetFont('Arial','B',8);
                                                    //   $pdf->Cell(20,12,$total_final,1,0,'R','F');
                                                        $pdf->Cell(50,12,$total_incamount,1,0,'R','F');
                                                      $pdf->Cell(40,12,$total_expense_amount,1,0,'R','F');
   $pdf->Cell(60,12,round($totbalamt),1,1,'R','F');

                                                     $pdf->Ln(5);
                                                     $pdf->SetX(10);
                                                      $pdf->SetFont('Arial','B',10);
                                                    
                                                    //  $pdf->Cell(45,8,'Total Cash Advance : ',2,0,'L');

                                                    //  $pdf->SetX(55); 
                                                    //  $pdf->Cell(90,8,ucwords(convert_number_to_words($total_final))." Rupees Only",2,1,'L');
                                                     $pdf->SetX(10);        $pdf->Cell(45,8,'Total Bill Amount  :',2,0,'L');

                                                  
                                                     $pdf->SetX(55);     $pdf->Cell(90,8,ucwords(getinwordsbyindia($total_incamount))."  Only",2,1,'L');
                                                       $pdf->SetX(10);
                                                       
                                                         $pdf->Cell(45,8,'Total Paid Amount : ',2,0,'L');

                                                     $pdf->SetX(55); 
                                                     $pdf->Cell(90,8,ucwords(getinwordsbyindia($total_expense_amount))."  Only",2,1,'L');
                                                      $pdf->SetX(10);      $pdf->Cell(45,8,'Balance   :',2,0,'L');

                                                      $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(55);     $pdf->Cell(90,8,ucwords(getinwordsbyindia(round($totbalamt)))."  Only",2,1,'L');


  
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
