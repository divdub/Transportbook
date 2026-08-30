<?php
/*call the FPDF library*/
// error_reporting(0);
include("../adminsession.php");
include("../fpdf17/rotation.php");
 
  $cond=' ';
  
   if($_GET['fromdate'] && $_GET['todate'])
   {
      $fromdate = $_GET['fromdate'];
         $todate = $_GET['todate'];
    
   }
   else
   {
    $fromdate = $currentdate;
    $todate = $currentdate;
   
   }
   
  
   if ($_GET['vehicle_id']) {
    $vehicle_id = $_GET['vehicle_id'];
   } else
    $vehicle_id = '';
     if ($_GET['owner_id']) {
    $owner_id = $_GET['owner_id'];
   } else
    $owner_id = '';
    
   
   if ($fromdate != '' && $todate != '') {
    $crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
   }
   if ($vehicle_id != '') {
    $crit .= " and vehicle_id='$vehicle_id'";
   }
 
 if ($owner_id != '') {
    $crit .= " and owner_id='$owner_id'";
   }
  
$c_logo = $cmn->getvalfield($connection,"m_company","clogo","comp_id='$_SESSION[comp_id]'");

//       $voucher_date = $cmn->getvalfield($connection,"payment","voucher_date","consignorid=$consignorid && comp_id=$comp_id  && voucher_id='$voucher_no' && session_id=$session_id "); 

//       $payment = $cmn->getvalfield($connection,"payment","sum(amt_paid_to)","consignorid=$consignorid && comp_id=$comp_id && category_id=$category_id && voucher_date <= '$voucher_date' && session_id=$session_id  and catname='$catname'"); 
//       $payment_receive = $cmn->getvalfield($connection,"payment_receive","sum(receive_amt)","consignorid=$consignorid && comp_id=$comp_id && receive_date <= '$voucher_date' && category=$category_id && session_id=$session_id  and catname='$catname'"); 



// $curr_openingbal = $payment - $payment_receive ;
// $rc_amt=$cmn->getvalfield($connection,"payment_receive","sum(receive_amt)","voucher_no='$voucher_no' && comp_id=$comp_id && session_id=$session_id"); 
// if($rc_amt==''){
//     $rcamt=0;
// } else {
//      $rcamt=$rc_amt;
// }
// $bankid=$cmn->getvalfield($connection,"payment_receive","bankid","voucher_no='$voucher_no' && comp_id=$comp_id && session_id=$session_id");
// $acc_holder_name=$cmn->getvalfield($connection,"m_bank","acc_holder_name","bankid='$bankid' ");
// $acc_no1=$cmn->getvalfield($connection,"m_bank","acc_no","bankid='$bankid'");
// $utrno=$cmn->getvalfield($connection,"payment_receive","utrno","voucher_no='$voucher_no' && comp_id=$comp_id && session_id=$session_id");
// $ifsc_code1=$cmn->getvalfield($connection,"m_bank","ifsc_code","bankid='$bankid'");
// $bank_name=$cmn->getvalfield($connection,"m_bank","bank_name","bankid='$bankid'");
// $branch_name=$cmn->getvalfield($connection,"m_bank","branch_name","bankid='$bankid'");
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
        
        if($bal_amt=='0'){
        $this->SetFont('Arial','B',80);
        $this->SetTextColor(255,192,203);
        $this->RotatedText(100,150,'PAID',45);
        $this->SetFont('Arial','B',18);
        $this->RotatedText(110,150,$receive_date,45);
        }
       if($receive_date!='' && $bal_amt > 0){
            $this->SetFont('Arial','B',80);
            $this->SetTextColor(255,192,203);
            $this->RotatedText(100,150,'Pending',45);
            $this->SetFont('Arial','B',18);
            //$this->RotatedText(110,150,$receive_date,45); 
        }
        $this->Rect(2,2,290,200,'D');
    }
    
    function Footer()

    { 

        global $comp_name;
        // Position at 1.5 cm from bottom
        $this->SetY(-6);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 10);
        // Page number
        $this->SetX(5);
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

 $pdf->SetX(20);
 
                                       
                                          
                                            $company_owner = "SELECT * FROM `m_company` where comp_id='$comp_id' ";

                                    $cmp_owm = mysqli_query($connection,$company_owner);
                               $onwer = mysqli_fetch_assoc($cmp_owm);
   
    $mobile_no=$onwer['mobileno1'];
                                       $pdf->Image('../upload/logo/'.$c_logo,10,3,20);
                                                    
                                        $pdf->SetX(70);
                                        $pdf->SetTextColor(255, 0, 0);
                                      
                                         $pdf->SetFont('Courier','B',24);
                                        $pdf->Cell(150,8,$onwer['cname'],2,0,'L');
                                        $pdf->SetTextColor(0, 0, 0);
                                         $pdf->SetX(130);
                                         $pdf->SetFont('Times','',24);
                                        $pdf->Cell(150,8,'',2,0,'L');
                                        
                                        $pdf->Ln();

                                        $pdf->SetX(50);
                                         $pdf->SetFont('Times','',10);
                                        $pdf->Cell(260,6,$onwer['caddress'],2,0,'L');
                                        $pdf->Ln();

                                            
                                         $pdf->SetFont('Times','',10);
                                       $pdf->Cell(350,5,'',2,0,'L');
                                        $pdf->SetFont('Times','',10);
                                       $pdf->Cell(125,-20,'Contact : '.$onwer['mobileno1'].",".$onwer['mobileno2'],2,1,'R');
                                         
                                               
                                       $pdf->SetX(50);
                                      

                                         
                                   

                                        $pdf->SetFont('Arial','',10);
                                        // $pdf->Cell(125,8,'PAN No. : '.$onwer['pan_no'],2,1,'R');
                                       



                                        $pdf->SetFont('Arial','',10);
                                        // $pdf->Cell(125,2,'GST No. : '.$onwer['gst_no'],2,0,'L');
                                        $pdf->Ln();

                                           

                                           $lh = 100;
                                            $lw= $lh;

                                            $pdf->Line(2, 20, 292,20);
                                             $pdf->Ln(2);
                                             $pdf->SetFont('Arial','B',10);
                                             $pdf->SetFillColor(175, 213, 240);
                                             
                                             $pdf->SetY(20.4);

                                             $pdf->SetX(2.5);
                                     
                                               $pdf->Cell(290,7,'Trip Details',0,0,'C','F');
                                             
                                         $pdf->SetFont('Arial','B',12);


               
                            
//                   $invoicquery = "SELECT * from payment  $cond && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id";

//                                             $invres = mysqli_query($connection,$invoicquery);
//                                     $incrow = mysqli_fetch_array($invres);
 
//                                     $voucher_date=$incrow['voucher_date']; 
//                                     $payee_name=$incrow['payee_name']; 
//                                     $panno=$incrow['panno']; 
//                                     // echo $catname; die;
//                                     $category_id=$incrow['category_id']; 
//                                     $ifsc_code=$incrow['ifsc_code']; 
//                                     $acc_no=$incrow['acc_no']; 
//                                      $voucher=$incrow['voucher_id'];
//                                     if($category_id==1){
//                                     $cname="Agent";
//                 //  $voucher_no=$incrow['voucher_id'];
//     // $voucher="AG-".$voucher_no;
// $agent_id=$cmn->getvalfield($connection,"dispatch_entry","agent_id","dispatch_id='$incrow[dispatch_id]'");
// $vname=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id='$agent_id'");
// // $panno=$cmn->getvalfield($connection,"m_agent","pan_no","agent_name=$payee_name");
//                                     }
//                  if($category_id==2){
//                                 $cname="Consignee";
//     // $voucher_no=$incrow['voucher_no'];
//     // $voucher="CO-".$voucher_no;
// $consignee_id=$cmn->getvalfield($connection,"dispatch_entry","consignee_id","dispatch_id='$incrow[dispatch_id]'");
// $vname=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id='$consignee_id'");
// // $panno=$cmn->getvalfield($connection,"m_consignee","pan_no","consignee_name=$payee_name");
//                                     }
//                                      if($category_id==4){
//                                  $cname="Truck Owner";
//     // $voucher_no=$incrow['voucher_no'];
//     // $voucher="TO-".$voucher_no;
// $owner_id=$cmn->getvalfield($connection,"dispatch_entry","owner_id","dispatch_id='$incrow[dispatch_id]'");
// $vname=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id='$owner_id'");
// // $panno=$cmn->getvalfield($connection,"m_vehicle_owner","pan_no","owner_name='$payee_name'");
//                                     }
      $remark=$incrow['remark']; 
    //   $pdf->SetX(50);
                                      $pdf->SetY(28);

                                        $pdf->SetFont('Arial','B',9);
                                        $pdf->SetX(2);
                                        $pdf->Cell(51,8,'Category :',2,0,'L');
                                         
                                        $pdf->SetFont('Arial','',9); 
                                      $pdf->Cell(51,8,$cname ,2,0,'L');
                        //$pdf->Cell(125,6,'Category: '.$cname ,1,0,'L');
                                         
                                               

                                    //     $pdf->SetFont('Arial','',10);

                                    //   $pdf->Cell(45,10,'',2,0,'L');

                                        // $pdf->SetFont('Arial','',10);
                                        
                                        $pdf->SetY(28);

                                        $pdf->SetFont('Arial','B',9);
                                        $pdf->SetX(108);
                                        $pdf->Cell(52,8,'Voucher No.:',2,0,'L');
                                        $pdf->SetFont('Arial','',9);
                                        $pdf->Cell(52,8,$voucher ,2,0,'L');
                                        
                                    //     $pdf->Ln(8);

                                    //     $pdf->SetY(34);

                                    //     $pdf->SetFont('Arial','B',9);
                                    //     $pdf->SetX(2);
                                    //     $pdf->Cell(51,8,'Voucher Name :',2,0,'L');
                                         
                                    //     $pdf->SetFont('Arial','',9);
                                    //   $pdf->Cell(51,8,$vname ,2,0,'L');
                                    //   // $pdf->Cell(125,10,'Voucher Name : '.$vname ,1,0,'L');
                                    //   //$pdf->Ln(15);
                                    //   $pdf->SetY(34);
      
                                    //   $pdf->SetFont('Arial','B',9);
                                    //   $pdf->SetX(108);
                                    //   $pdf->Cell(52,8,'Voucher Date :',2,0,'L');
                                    //   $pdf->SetFont('Arial','',9);
                                    //   $pdf->Cell(52,8,date('d-m-Y',strtotime($voucher_date)) ,2,0,'L');
                                    //   // $pdf->Cell(5,10,'',2,0,'L');
                                    //      $pdf->SetFont('Arial','',9);
                                      // $pdf->Cell(80,10,'Voucher Date : '.date('d-m-Y',strtotime($voucher_date)) ,2,1,'L');
                                       
                                             

                                    //     $pdf->SetFont('Arial','',10);

                                    //   $pdf->Cell(45,10,'',2,0,'L');

                                    //     $pdf->SetFont('Arial','',10);
                                    //     $pdf->Cell(95,8,'Location: Laipur',2,1,'L');
                                         //$pdf->Ln(10);
                                    //      $pdf->SetY(40);

                                    //     $pdf->SetFont('Arial','B',9);
                                    //     $pdf->SetX(2);
                                    //     $pdf->Cell(51,8,'Paid To :',2,0,'L');
                                         
                                    //     $pdf->SetFont('Arial','',9);
                                    //   $pdf->Cell(51,8,$payee_name ,2,0,'L');
                                    //      $pdf->SetFont('Arial','B',9);
                                        //   $pdf->Cell(5,10,'',2,0,'L');
                                       // $pdf->Cell(125,8,'Paid To : '.$payee_name ,2,0,'L');
                                          // $toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'"); 
                                        //   $pdf->SetY(40);
      
                                        //   $pdf->SetFont('Arial','B',9);
                                        //   $pdf->SetX(108);
                                        //   $pdf->Cell(52,8,'Remark :',2,0,'L');
                                        //   $pdf->SetFont('Arial','',9);
                                        //   $pdf->Cell(52,8,$remark ,2,0,'L');
                                         
                                        //   $pdf->SetY(46);

                                        //   $pdf->SetFont('Arial','B',9);
                                        //   $pdf->SetX(2);
                                        //   $pdf->Cell(51,8,'Account No. :',2,0,'L');
                                        //   $pdf->SetFont('Arial','',9);
                                        // $pdf->Cell(51,8,$acc_no ,2,0,'L');
                                        
                                          // $toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'"); 
                                        //  $pdf->SetY(46);
      
                                        //   $pdf->SetFont('Arial','B',9);
                                        //   $pdf->SetX(108);
                                        //   $pdf->Cell(52,8,'IFSC Code :',2,0,'L');
                                        //   $pdf->SetFont('Arial','',9);
                                        //   $pdf->Cell(52,8,$ifsc_code ,2,0,'L');
                                          
                                        //     $pdf->SetY(52);

                                        //   $pdf->SetFont('Arial','B',9);
                                        //   $pdf->SetX(2);
                                        //   $pdf->Cell(51,8,'Pan No. :',2,0,'L');
                                        //   $pdf->SetFont('Arial','',9);
                                        // $pdf->Cell(51,8,$panno ,2,0,'L');
                                          //$pdf->Ln(30);
                                          //$pdf->SetX(200);
                                          //$pdf->SetY(20);
                                      
                                        
                                        
                                    
                                      
                    //   $pdf->Ln(4);
                                        
                                        
                    //                       $pdf->SetFont('Arial','',10);

                    //                   $pdf->Cell(5,10,'',2,0,'L');

                                      
                                        
                                        $pdf->Ln(3);
                                        $pdf->SetX(2);
                                        $pdf->SetFillColor(211, 211, 211);
                                       
                                            $pdf->SetFont('Arial','B',8);
                                                    $pdf->Cell(6,8,'S.N',1,0,'C','F');

                                                     

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'DI/LR No',1,0,'L','F');
                                                     
                                                      
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(18,8,'Bilty Date',1,0,'R','F');
                                                     
//  $pdf->Cell(30,8, 'Consignor', 1, 0, 'L','F');
        $pdf->Cell(60,8, 'Consignee', 1, 0, 'L','F');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(21,8,'Truck No',1,0,'R','F');

                                                     $pdf->SetFont('Arial','B',8);
                                                   //  $pdf->Cell(30,8,'Destination',1,0,'L');
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(30,8,'Destination',1,0,'L','F');
                                                     
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(12,8,'Wt.(MT)',1,0,'R');
                                                     $pdf->SetFont('Arial','B',7);
                                                     $pdf->Cell(10,8,'Rec.wt',1,0,'R','F');
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,8,'Com. Rate',1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',7);
                                                    //  $pdf->Cell(13,8,'Commi.',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(10,8,'Rate',1,0,'L','F');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(13,8,'Frt Amt',1,0,'R','F');

                                                    $pdf->SetFont('Arial','B',7);
                                                     $pdf->Cell(9,8,"Comm",1,0,'R','F');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(8,8,'Bank',1,0,'R','F');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(9,8,'Rebid',1,0,'C','F');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(8,8,'Shrt',1,0,'R','F');


                                                    // $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(8,8,'TDS',1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(11,8,'TDS',1,0,'R','F');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(10,8,'Di Adv',1,0,'C','F');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(13,8,'Cash Adv',1,0,'C','F');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(8,8,'GPS ',1,0,'C','F');
                                                    //       $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(18,8,'Consignor',1,0,'C');
                                                    //      $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(18,8,'Consignee',1,0,'C');
                                                    
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,8,' Net Amt',1,1,'R','F');
                           $sn=1;                         
// echo "select * from dispatch_entry $crit && consignor_id=$consignorid"; die;
$sql = mysqli_query($connection, "select * from dispatch_entry $crit && consignor_id=$consignorid");
while ($row_get = mysqli_fetch_array($sql)) {
    
    
    $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row_get[consignor_id]");
    $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row_get[consignee_id]");
    $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row_get[vehicle_id]");
$destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row_get[destination_id]"); 
$item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row_get[item_id]");         
    $bilty_date=dateformatindia($row_get['bilty_date']);
     $wt_mt=$row_get['wt_mt'];
      $rec_wt=$row_get['rec_wt'];
       $sort_wt= $wt_mt - $rec_wt;
     $diesel_adv_amt=$row_get['diesel_adv_amt'];   
     $cash_adv=$row_get['cash_adv'];    
     $other_cash_adv=$row_get['other_cash_adv'];   
  $consignor_cash_adv=$row_get['consignor_cash_adv'];    
     $consignee_cash_adv=$row_get['consignee_cash_adv'];
     $di_no=$row_get['di_no'];
$cnt=$cmn->getvalfield($connection,"payment","count(payment_id)","dispatch_id='$row_get[dispatch_id]'");
if($cnt==0){
  $freight_rate=$row_get['own_rate'];
  $freight_amt=$freight_rate * $rec_wt;
  $amt_paid_to= $freight_amt - $consignor_cash_adv - $cash_adv - $other_cash_adv - $consignee_cash_adv;
   
} else {
  $freight_amt=$cmn->getvalfield($connection,"payment","freight_amt","dispatch_id='$row_get[dispatch_id]'"); 
  $freight_rate=$cmn->getvalfield($connection,"payment","freight_rate","dispatch_id='$row_get[dispatch_id]'");
   $bilty_commision=$cmn->getvalfield($connection,"payment","bilty_commision","dispatch_id='$row_get[dispatch_id]'");
    $tds=$cmn->getvalfield($connection,"payment","tds","dispatch_id='$row_get[dispatch_id]'");
     $tds_amt=$cmn->getvalfield($connection,"payment","tds_amt","dispatch_id='$row_get[dispatch_id]'");
      $rebidcharge=$cmn->getvalfield($connection,"payment","rebidcharge","dispatch_id='$row_get[dispatch_id]'");
       $sortamt=$cmn->getvalfield($connection,"payment","sortamt","dispatch_id='$row_get[dispatch_id]'");
           $amt_paid_to=$cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row_get[dispatch_id]'");
               $bank_charge=$cmn->getvalfield($connection,"payment","bank_charge","dispatch_id='$row_get[dispatch_id]'");   
}
 
      $pdf->SetFont('Arial','',8);
      $pdf->SetX(2);
                                                    $pdf->Cell(6,8, $sn++,1,0,'L');

                                                     

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(20,8,$di_no,1,0,'L');
                                                     
                                                    
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(18,8,date('d-m-Y',strtotime($bilty_date)),1,0,'R');
                                                     
// $pdf->SetFont('Arial','',8);
//                                                      $pdf->Cell(50,8,$consignor_name,1,0,'R');
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(60,8,$consignee_name,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(21,8,$vehicle_no,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                   //  $pdf->Cell(30,8,$toplace,1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(30,8,$destination,1,0,'C');
                                                     
                                                    //  $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(12,8, $wt_mt,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(10,8,$rec_wt,1,0,'R');

                                                    //  $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(13,8,$rate_mt,1,0,'R');


                                                    // $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(13,8,$trip_commission,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                    $pdf->Cell(10,8,round($freight_rate),1,0,'R');
                                                    
                                                     $pdf->Cell(13,8,round($freight_amt),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(9,8,round($bilty_commision),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);
                                                      $pdf->SetTextColor(255, 0, 0);
                                                     $pdf->Cell(8,8,$bank_charge,1,0,'R');
                                                     $pdf->SetFont('Arial','',8);
                                                   
                                                    $pdf->Cell(9,8,$rebidcharge,1,0,'R');
                                                     
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(8,8,$sortamt,1,0,'R');



                                                    // $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(8,8,$tds.'%',1,0,'R');

                                                    $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(11,8,'-'.round($tds_amt),1,0,'R');
                                                    $pdf->SetTextColor(0, 0, 0);
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(10,8,round($diesel_adv_amt),1,0,'R');
                                                      $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(13,8,round($cash_adv),1,0,'R');
                                                      $pdf->SetFont('Arial','',8);
                                                $pdf->Cell(8,8,round($other_cash_adv),1,0,'R');
                                                    //   $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(18,8,round($consignor_cash_adv),1,0,'R');
                                                    //   $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(18,8,round($consignee_cash_adv),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);
                                                    
                                                    $pdf->Cell(15,8,number_format(round($amt_paid_to),2),1,0,'R');

      
                                                   
                                                 

                                                      $pdf->Ln();
                                                    $total_wt_mt+=$wt_mt;
                                                $total_recweight+=$rec_wt;
                                                $total_final_rate+=$freight_rate;
                                                    $total_rate_mt+=$rate_mt;
                                                $total_rebidcharge+=$rebidcharge;
                                                $total_commision+=$bilty_commision;
                                                $total_freight+=$freight_amt;
                                                $total_deduct+=$sortamt;    
                                                $total_tds_amount+=$tds_amt;
                                                $total_adv +=$cash_adv;
                                                $total_desial_adv += $diesel_adv_amt;
                                                $total_netamout +=$netamount;
                                                $toal_advconsi +=$consignor_cash_adv;
                                                $great_total +=$amt_paid_to;
                                                $total_tds+=$tds_amt;
                                                 $total_bank_charge+=$bank_charge;
                                          
$balamt= $great_total - $rcamt ;
                                           }  
                                                     
                                        $pdf->SetX(2);
                                                     $pdf->SetFont('Arial','B',9);
                                                     $pdf->Cell(155,12,'Total',1,0,'C');

                                                     
                                                     
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(12,12, $total_wt_mt,1,0,'R');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(10,12,$total_recweight,1,0,'R');
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,12,$total_rate_mt,1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,12,$total_trip_commission,1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(10,12,'',1,0,'R');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(13,12,round($total_freight),1,0,'R');
                                                     

                                                  $pdf->SetFont('Arial','B',8);
                                             $pdf->Cell(9,12,round($total_commision),1,0,'R');
                                                        $pdf->SetFont('Arial','B',8);
                                                         $pdf->SetTextColor(255, 0, 0);
                                                     $pdf->Cell(8,12,$total_bank_charge,1,0,'R');
                                                     $pdf->Cell(9,12,$total_rebidcharge,1,0,'R');
                                                     $pdf->SetFont('Arial','B',8);
                                                     
                                                     $pdf->Cell(8,12,$total_deduct,1,0,'R');

//  $pdf->SetTextColor(0, 0, 0);
                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(11,12,'-'.$total_tds,1,0,'R');
                                                     $pdf->SetTextColor(0, 0, 0);

                                                    // $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(8,12,'',1,0,'R');
                                                     

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(10,12,round($total_desial_adv),1,0,'R');
                                                        $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(13,12,round($total_adv),1,0,'R');
                                                   
                                                       $pdf->SetFont('Arial','B',8);
                                                      $pdf->Cell(8,12,'',1,0,'R');
                                                        $pdf->SetFont('Arial','B',8);
                                                        
                                                   //  $pdf->Cell(24,12,'',1,0,'R');
                                                    
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,12,number_format(round($great_total),2),1,0,'R');



                                                      $pdf->Ln();
                                                     $pdf->SetX(2);
                                                      $pdf->SetFont('Arial','B',10);
                                                      $pdf->SetFillColor(175, 213, 240);
                                                     $pdf->Cell(155,12,'Grant Total Amount',1,0,'C','F');

                                                     
                                                     $pdf->Cell(124,12,number_format(round($great_total),2),1,1,'R','F');


//   $pdf->Cell(25,10,'In Words :',2,0,'C');

//   $pdf->Cell(155,10,UCWORDS(getinwordsbyindia($great_total)),2,0,'L');
                                                  
    //   $pdf->Ln(5);
                                                    
    //                                                  $currentX = $pdf->GetX();
    //                                                  $currentY = $pdf->GetY();
                                                     
    //                                                  // Draw a line from current position (after the Cell)
    //                                                  $pdf->Line($currentX - 8, $currentY + 36, $currentX + 198, $currentY + 36); 
    //                                                 //  $pdf->Line($currentX + 75, $currentY, $currentX + 75, $currentY + 35); 
    //                                                 //  $pdf->Line($currentX + 155, $currentY, $currentX + 155, $currentY + 35); 
    //                                                 //  $pdf->Ln(5);
    //                                                  $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(2);      $pdf->Cell(45,5,'Name of A/c Holder   ',2,0,'L');

    //                                                  $pdf->SetFont('Arial','B',10);
    //                                                  $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($acc_holder_name),2,0,'L');
                                           
    //                                                  $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(95);      $pdf->Cell(45,5,' ',2,0,'L');
    //                                                  $pdf->SetFont('Arial','B',10);
    //                                                  $pdf->SetX(135);     $pdf->Cell(50,5,'',2,0,'L');
                                                     
    //                                           $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(175);      $pdf->Cell(45,5,'',2,1,'L');
                                                    
    //                                                  $pdf->SetFont('Arial','',10);       $pdf->SetX(2);      $pdf->Cell(45,5,'Account No.   ',2,0,'L');
    //                                                  $pdf->SetFont('Arial','B',10);
                                                     
    //                                                  $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($acc_no1),2,0,'L');
    //                                                  $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(95);      $pdf->Cell(45,5,'',2,0,'L');
    //                                                  $pdf->SetFont('Arial','B',10);
    //                                                  $pdf->SetX(135);     $pdf->Cell(50,5,'',2,0,'L');
                                                    
    //                                                  $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(175);      $pdf->Cell(45,5,'',2,1,'L');
    //                                                  $pdf->SetFont('Arial','',10);       $pdf->SetX(2);      $pdf->Cell(45,5,'IFSC Code  ',2,0,'L');
    //                                                  $pdf->SetFont('Arial','B',10);
    //                                                  $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($ifsc_code1),2,0,'L');
    //                                                  $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(95);      $pdf->Cell(45,5,'',2,0,'L');
    //                                                  $pdf->SetFont('Arial','B',10);
    //                                                  $pdf->SetX(135);     $pdf->Cell(50,5,'',2,0,'L');
    //                                                       $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(175);      $pdf->Cell(45,5,'',2,1,'L');
    //                                                  $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(2);      $pdf->Cell(45,5,'Bank Name  ',2,0,'L');

    //                                                  $pdf->SetFont('Arial','B',10);
    //                                                  $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($bank_name),2,1,'L');
                                               
    //                                                  $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(2);      $pdf->Cell(45,5,'Branch Name  ',2,0,'L');

    //                                                  $pdf->SetFont('Arial','B',10);
    //                                                  $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($branch_name),2,1,'L');
    //                                                  $pdf->SetFont('Arial','',10);
    //                                                  $pdf->SetX(2);      $pdf->Cell(45,5,'UTR / Refrence No  ',2,0,'L');

    //                                                  $pdf->SetFont('Arial','B',10);
    //                                                  $pdf->SetX(45);     $pdf->Cell(50,5,$utrno,2,1,'L');
                                                  
                                                     
                                                         
    //                                                  $pdf->Ln(5);
    //                                                  $pdf->SetX(2);
    //                                                   $pdf->SetFont('Arial','B',10);
                                                    
    //                                                  $pdf->Cell(45,8,'Amount Payable : ',2,0,'L');

    //                                                  $pdf->SetX(45); 
    //                                                  $pdf->Cell(90,8,ucwords(getinwordsbyindia(round($great_total),2))." Only",2,1,'L');
    //                                                  $pdf->SetX(2);        $pdf->Cell(45,8,'Amount Paid :',2,0,'L');

    //                                                  if($amt_paid != '0'){
    //                                                  $pdf->SetX(45);     $pdf->Cell(90,8,ucwords(getinwordsbyindia($rcamt))." Only",2,1,'L');
    //                                                   } else {
    //                                                     $pdf->SetX(45);     $pdf->Cell(90,8,"",2,1,'L');

    //                                                   } 
                                                       
                                                       
    //                                                   $pdf->SetX(2);      $pdf->Cell(45,8,'Balance Payable  :',2,0,'L');

    //                                                   $pdf->SetFont('Arial','B',10);
    //                                                  $pdf->SetX(45);     $pdf->Cell(90,8,ucwords(getinwordsbyindia(round($balamt),2))." Only",2,1,'L');                                               
                                                      

                                               


                                                  
                                                     
                                                      

                                               

 $pdf->Output();
?>
