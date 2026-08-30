<?php
/*call the FPDF library*/
// error_reporting(0);
include("adminsession.php");
include("fpdf17/rotation.php");

if(isset($_GET['fromdate'])) {
    $fromdate = $_GET['fromdate'];
  }
  else
  $fromdate=date('Y-m-d');

if(isset($_GET['todate'])) {
    $todate =$_GET['todate'];
  }
  else
  $todate=date('Y-m-d');
 if (isset($_GET['item_id'])) {
   	$item_id = trim(addslashes($_GET['item_id']));
   } else
   	$item_id = '';
   	
   
   if (isset($_GET['is_invoice'])) {
   	$is_invoice = trim(addslashes($_GET['is_invoice']));
   } else
   	$is_invoice = '';
   
   
   if ($fromdate != '' && $todate != '') {
   	$crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
   	//echo $crit;
   }
   
   if ($is_invoice != '') {
   	$crit .= " and is_invoice='$is_invoice'";
   }
   if ($item_id != '') {
   	$crit .= " and item_id='$item_id'";
   }


    // $acc_holder_name=$cmn->getvalfield($connection,"m_petrol_pump","acc_holder_name","pump_id=$pump_id");
    // $acc_no=$cmn->getvalfield($connection,"m_petrol_pump","acc_no","pump_id=$pump_id");
    
    // $ifsc_code=$cmn->getvalfield($connection,"m_petrol_pump","ifsc_code","pump_id=$pump_id");
    // $bank_name=$cmn->getvalfield($connection,"m_petrol_pump","bank_name","pump_id=$pump_id");
    // $branch_name=$cmn->getvalfield($connection,"m_petrol_pump","branch_name","pump_id=$pump_id");
    // $mobile_no=$cmn->getvalfield($connection,"m_petrol_pump","mobile_no","pump_id=$pump_id");




//   $pump= $cmn->getvalfield($connection,"m_petrol_pump","pump_name","pump_id='$pump_id'");
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
                               
                                       $pdf->Image('upload/logo/'.$c_logo,10,6,20);
                                    //    echo $onwer['cname']; die;         
                                        $pdf->SetX(70);
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
                                        $pdf->Cell(293,8,'Invoice Book',1,0,'C','F');
                                        $pdf->Ln();

                       
                                      
                                        $pdf->SetFont('Arial', 'B', 10);
                                        $pdf->SetX('20');
                                        $pdf->SetY('40');
                                     
                                        $pdf->Ln();

                                        $pdf->SetFont('Arial','B',11);
                                        $pdf->SetY('45');
                                        // $pdf->Cell(60,-10,'PUMP NAME. :'      .$pump,2,0,'L');
                                        $pdf->SetY('36');
                                        $pdf->SetX('210');
                                    
                                        $currentDateTime = date('d F Y h:i A'); 
                                        // $currentDateTime = date('d-m-Y H:i:s');
                                        $pdf->Cell(25, 8, 'Print Date and Time: ' . $currentDateTime, 2, 0,'L');

                                        $pdf->SetFont('Arial','B',12);
                                        $pdf->SetY('40');
                                        // $pdf->Cell(26,-10,'PAN No. : '.$onwer['pan_no'],2,0,'R');
                                        $pdf->Ln();
                                        
             
                                                      
	$pdf->SetX(2);
	$pdf->SetFont('Arial','B',9);
  $pdf->SetFillColor(211, 211, 211);
	//$this->SetTextColor(255,255,255);
	$pdf->Cell(7,6,'Sno','1',0,'L','F'); 
	 
    $pdf->Cell(18,6,'Invoice NO',1,0,'L',1);
	$pdf->Cell(18,6,'GR Date.',1,0,'L',1);
	$pdf->Cell(15,6,'DI No.',1,0,'L',1);
	$pdf->Cell(18,6,'GR No.',1,0,'L',1);
// 	$pdf->Cell(20,6,'Consignor',1,0,'L',1);
	$pdf->Cell(48,6,'Consignee',1,0,'L',1);	
// 	$pdf->Cell(48,6,'Truck No.',1,0,'L',1);
// 	$pdf->Cell(28,6,'Owner Name',1,0,'L',1);
		$pdf->Cell(28,6,'Destination','1',0,'L',1); 
// 	$pdf->Cell(15,6,'Item',1,0,'L',1);
	// $pdf->Cell(15,6,'RATE',1,0,'L',1);
	// $pdf->Cell(18,6,'FREIGHT',1,0,'L',1);
	//$this->Cell(16,6,'LABOUR',1,0,'L',1);	
	$pdf->Cell(8,6,'WT',1,0,'C',1);
// 		$pdf->Cell(25,6,'Qty (Bags)',1,0,'C',1);
		$pdf->Cell(8,6,'Rate',1,0,'C',1);
	$pdf->Cell(15,6,'Freight',1,0,'L',1);
	$pdf->Cell(25,6,'Bill No',1,0,'L',1);
	$pdf->Cell(17,6,'Bill Date',1,0,'L',1);
		$pdf->Cell(17,6,'Rec. Date',1,0,'L',1);
		$pdf->Cell(17,6,'Tds',1,0,'L',1);
			$pdf->Cell(17,6,'Gst Amt',1,0,'L',1);
				$pdf->Cell(17,6,'Rec. Amt',1,1,'L',1);
	// $pdf->Cell(10,6,'SHT',1,1,'L',1);
	
	//$this->Cell(10,6,'SHT-BG',1,0,'L',1);
	//$this->Cell(10,6,'SHT-MT',1,1,'L',1);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','B',9);
	  
$sn=1;
                     $sql = mysqli_query($connection,"Select * from  dispatch_entry  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by dispatch_id desc");
                                          	  while($row= mysqli_fetch_array($sql)) {
                                          $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
                                          $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
                                          $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
                                          $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
                                          $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
                                              $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
                                               $is_voucher=$row['is_voucher'];
                                               $invoiceid = $row['invoiceid'];
                                               	$invno = $cmn->getvalfield($connection,"invoicebilty","invno","invoiceid='$invoiceid'");
                                               	   	$receive_date = $cmn->getvalfield($connection,"manualinv","receive_date","invoiceid='$invoiceid'");
                                               	$tds_per = $cmn->getvalfield($connection,"manualinv","tds_per","invoiceid='$invoiceid'");
                                               	 $gst	 = $cmn->getvalfield($connection,"manualinv","gst","invoiceid='$invoiceid'");
                                               	 $is_pay = $cmn->getvalfield($connection,"invoicebilty","is_pay","invoiceid='$invoiceid'");
                                               	
                                               	 $frt=	$row['wt_mt'] * $row['comp_rate'];
								$tds_amt=$frt *($tds_per/100);
								$total=$frt- $tds_amt;
								$gst_amt=$total * ($gst/100);
								$net= $total + $gst_amt;
								 if($is_pay==0){
                                          $net=0;     	     
                                               	 }
								if($invno=='') { $invno="Unbilled"; }	
								$invdate = $cmn->getvalfield($connection,"invoicebilty","invdate","invoiceid='$invoiceid'");
      $pdf->SetFont('Arial','',8);
      $pdf->SetX(2);
                                               

                                                $pdf->SetFont('Arial','',8);
                                                $pdf->SetX(2);
                                                $pdf->Cell(7,8, $sn++,1,0,'L');
                                             
                                                $pdf->Cell(18,8,$row['invoice_no'],1,0,'L');
                                                // $pdf->Cell(10,8,$row['bilty_no'],1,0,'R');
                                                $pdf->Cell(18,8,date('d-m-Y',strtotime($row['gr_date'])),1,0,'R');
                                                 $pdf->Cell(15,8,$row['di_no'],1,0,'L');
                                                  $pdf->Cell(18,8,$row['gr_no'],1,0,'L');
                                                                                        // $pdf->Cell(24,8, $consignor_name, 1,0, 'R');
                                                                                   $pdf->Cell(48,8, $consignee_name, 1,0, 'R');       
                                                   
                                                    //   $pdf->Cell(22,8, $vehicle_no, 1,0, 'R');
                                                //   $pdf->Cell(50,8, $owner_name, 1,0, 'R');
                                                    $pdf->Cell(28,8, $destination, 1,0, 'R');
                                                        //  $pdf->Cell(13,8, $item_name,1,0,'L');                    
                                                         
                                 
                                        
                                        
                 
                                                     $pdf->Cell(8,8,$row['wt_mt'], 1,0, 'R');
                                             
                                            //   $pdf->Cell(8,8,$row['qty'],1,0,'C');
                                                      $pdf->Cell(8,8,$row['comp_rate'],1,0,'R');
                                                $pdf->Cell(15,8,number_format($row['wt_mt'] * $row['comp_rate'],2),1,0,'C');
                                                     $pdf->Cell(25,8,$invno,1,0,'L');      
                                                          $pdf->Cell(17,8,date('d-m-Y',strtotime($invdate)),1,0,'L');      
                                                              $pdf->Cell(17,8, date('d-m-Y',strtotime($receive_date)),1,0,'L');   
                                                                    $pdf->SetTextColor(255, 0, 0);
                                              $pdf->Cell(17,8, round($tds_amt,2),1,0,'L');    
                                                    $pdf->SetTextColor(0, 0, 0);
                                                 $pdf->Cell(17,8, round($gst_amt,2),1,0,'L');    
                                                    $pdf->Cell(17,8,round($net,2),1,0,'L');    
                                                $pdf->Ln();
                                                $freight_amt=$row['wt_mt']*$row['own_rate'];
                                                    $total_wt_mt+=$row['wt_mt'];
                                                     $total_freight+=$frt;
                                                       $total_commision+=$bilty_commision;
                                                          
                                                                $total_tds+=$tds_amt;
                                                                    $totalamt +=$total;
                                                                     
                                                                                 $total_final+=$gst_amt;
                                                                                 $total_amt_paid+=$net;
                                                                                
                                                                                                                                                               
                                            }    

                                                  
       $pdf->SetX(2);
                                        $currentX = $pdf->GetX();
                                        $currentY = $pdf->GetY();
                                         $pdf->SetFillColor(175, 213, 240);
                                        // Draw a line from current position (after the Cell)
                                        $pdf->Line($currentX , $currentY + 16, $currentX + 293, $currentY + 16); 
                                                     $pdf->SetFont('Arial','B',9);
                                                     $pdf->Cell(168,12,'Total',1,0,'C','F');

                                                     
                                                  
                                                      $pdf->SetFont('Arial','B',8);
                                                      $pdf->Cell(15,12,round($total_freight,2),1,0,'R','F');
                                                        $pdf->Cell(59,12,'',1,0,'R','F');
                                                         $pdf->SetTextColor(255, 0, 0);
                                                      $pdf->Cell(17,12,round($total_tds,2),1,0,'R','F');
                                                       $pdf->SetTextColor(0, 0, 0);
   $pdf->Cell(17,12,round($total_final,2),1,0,'R','F');
      $pdf->Cell(17,12,round($total_amt_paid,2),1,1,'R','F');


 $pdf->Ln(5);
                                                    
                                            //          $currentX = $pdf->GetX();
                                            //          $currentY = $pdf->GetY();
                                                     
                                            //          // Draw a line from current position (after the Cell)
                                            //          $pdf->Line($currentX - 8, $currentY + 36, $currentX + 285, $currentY + 36); 
                                            //          $pdf->Line($currentX + 75, $currentY, $currentX + 75, $currentY + 35); 
                                            //          $pdf->Line($currentX + 155, $currentY, $currentX + 155, $currentY + 35); 
                                            //         //  $pdf->Ln(5);
                                            //          $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(2);      $pdf->Cell(45,5,'Name of A/c Holder   ',2,0,'L');

                                            //          $pdf->SetFont('Arial','B',10);
                                            //          $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($acc_holder_name),2,0,'L');
                                           
                                            //          $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(95);      $pdf->Cell(45,5,'Net Amount Payable ',2,0,'L');
                                            //          $pdf->SetFont('Arial','B',10);
                                            //          $pdf->SetX(135);     $pdf->Cell(50,5,'Rs.'.round($total_bal),2,0,'L');
                                                     
                                            //   $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(175);      $pdf->Cell(45,5,'Prepared By',2,1,'L');
                                                    
                                            //          $pdf->SetFont('Arial','',10);       $pdf->SetX(2);      $pdf->Cell(45,5,'Account No.   ',2,0,'L');
                                            //          $pdf->SetFont('Arial','B',10);
                                                     
                                            //          $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($acc_no),2,0,'L');
                                            //          $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(95);      $pdf->Cell(45,5,'Net Amount Paid ',2,0,'L');
                                            //          $pdf->SetFont('Arial','B',10);
                                            //          $pdf->SetX(135);     $pdf->Cell(50,5,'Rs.'.round($total_amt2),2,0,'L');
                                                    
                                            //          $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(175);      $pdf->Cell(45,5,'Authorised By',2,1,'L');
                                            //          $pdf->SetFont('Arial','',10);       $pdf->SetX(2);      $pdf->Cell(45,5,'IFSC Code  ',2,0,'L');
                                            //          $pdf->SetFont('Arial','B',10);
                                            //          $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($ifsc_code),2,0,'L');
                                            //          $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(95);      $pdf->Cell(45,5,'Balance Amount ',2,0,'L');
                                            //          $pdf->SetFont('Arial','B',10);
                                            //          $pdf->SetX(135);     $pdf->Cell(50,5,'Rs.'.round($balamt),2,0,'L');
                                            //               $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(175);      $pdf->Cell(45,5,'Entered By',2,1,'L');
                                            //          $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(2);      $pdf->Cell(45,5,'Bank Name  ',2,0,'L');

                                            //          $pdf->SetFont('Arial','B',10);
                                            //          $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($bank_name),2,1,'L');
                                               
                                            //          $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(2);      $pdf->Cell(45,5,'Branch Name  ',2,0,'L');

                                            //          $pdf->SetFont('Arial','B',10);
                                            //          $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($branch_name),2,1,'L');
                                            //          $pdf->SetFont('Arial','',10);
                                            //          $pdf->SetX(2);      $pdf->Cell(45,5,'Mobile No  ',2,0,'L');

                                            //          $pdf->SetFont('Arial','B',10);
                                            //          $pdf->SetX(45);     $pdf->Cell(50,5,$mobile_no,2,1,'L');
                                                  
                                                     
                                                         
                                                     $pdf->Ln(5);
                                                     $pdf->SetX(2);
                                                      $pdf->SetFont('Arial','B',10);
                                                    
                                                     $pdf->Cell(45,8,'Amount Payable : ',2,0,'L');

                                                     $pdf->SetX(45); 
                                                     $pdf->Cell(90,8,ucwords(convert_number_to_words($totalamt + $total_final))." Rupees Only",2,1,'L');
                                                     $pdf->SetX(2);        $pdf->Cell(45,8,'Amount Paid :',2,0,'L');

                                                     if($net != '0'){
                                                     $pdf->SetX(45);     $pdf->Cell(90,8,ucwords(convert_number_to_words($total_amt_paid))." Rupees Only",2,1,'L');
                                                       } else {
                                                        $pdf->SetX(45);     $pdf->Cell(90,8,"",2,1,'L');

                                                       } 
                                                       
                                                       
                                                       $pdf->SetX(2);      $pdf->Cell(45,8,'Balance Payable  :',2,0,'L');

                                                       $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(45);     $pdf->Cell(90,8,ucwords(convert_number_to_words($totalamt + $total_final - $total_amt_paid))." Rupees Only",2,1,'L');
                              



 $pdf->Output();
?>
