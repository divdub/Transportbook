<?php
/*call the FPDF library*/
// error_reporting(0);
include("adminsession.php");
include("fpdf17/rotation.php");
if($_GET['fromdate']!='' && $_GET['todate']!='')
{
     $fromdate = $_GET['fromdate'];
     $todate = $_GET['todate'];
    
}
else
{
 $fromdate = date("Y-m-d", strtotime("-3 months"));
 $todate = date('Y-m-d');

}

if (isset($_GET['vehicle_id'])) {
    $vehicle_id = trim(addslashes($_GET['vehicle_id']));
} else
    $vehicle_id = '';
    



if ($fromdate != '' && $todate != '') {
    $crit .= "where bilty_date BETWEEN  '$fromdate' and  '$todate' ";
    //echo $crit;
}

if (isset($_GET['cat_id'])) {
    $cat_id = trim(addslashes($_GET['cat_id']));
} else
    $cat_id = '';
       
if (isset($_GET['catname'])) {
    $catname = trim(addslashes($_GET['catname']));
} else
    $catname = '';

if ($vehicle_id != '') {
    $crit .= " and vehicle_id='$vehicle_id'";
}
$vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$vehicle_id");
if($cat_id=='1') {
    $crit .= " and agent_id='$catname'";
    $owner_name=$cmn->getvalfield($connection,"m_agent","agent_name","agent_id=$catname");
    $acc_holder_name=$cmn->getvalfield($connection,"m_agent","acc_holder_name","agent_id=$catname");
    $acc_no=$cmn->getvalfield($connection,"m_agent","acc_no","agent_id=$catname");
    
    $ifsc_code=$cmn->getvalfield($connection,"m_agent","ifsc_code","agent_id=$catname");
    $bank_name=$cmn->getvalfield($connection,"m_agent","bank_name","agent_id=$catname");
    $branch_name=$cmn->getvalfield($connection,"m_agent","branch_name","agent_id=$catname");
    $mobile_no=$cmn->getvalfield($connection,"m_agent","mobileno1","agent_id=$catname");
    $pan_no=$cmn->getvalfield($connection,"m_agent","pan_no","agent_id=$catname");
    $type='Agent';
 }
 if($cat_id=='2') {
    $crit .= " and consignee_id='$catname'";
    $owner_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$catname");
    $acc_holder_name=$cmn->getvalfield($connection,"m_consignee","acc_holder_name","consignee_id=$catname");
    $acc_no=$cmn->getvalfield($connection,"m_consignee","acc_no","consignee_id=$catname");
    $ifsc_code=$cmn->getvalfield($connection,"m_consignee","ifsc_code","consignee_id=$catname");
    $bank_name=$cmn->getvalfield($connection,"m_consignee","bank_name","consignee_id=$catname");
    $branch_name=$cmn->getvalfield($connection,"m_consignee","branch_name","consignee_id=$catname");
    $mobile_no=$cmn->getvalfield($connection,"m_consignee","mobile_no","consignee_id=$catname");
    $pan_no=$cmn->getvalfield($connection,"m_consignee","pan_no","consignee_id=$catname");
    $type='Consignee';
     $type1='Difference Payment';
    
 }
 if($cat_id=='4') {
    $crit .= " and owner_id='$catname'";
   
    $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$catname");
    $acc_holder_name=$cmn->getvalfield($connection,"m_vehicle_owner","acc_holder_name","owner_id=$catname");
    $acc_no=$cmn->getvalfield($connection,"m_vehicle_owner","acc_no","owner_id=$catname");
    $ifsc_code=$cmn->getvalfield($connection,"m_vehicle_owner","ifsc_code","owner_id=$catname");
    $bank_name=$cmn->getvalfield($connection,"m_vehicle_owner","bank_name","owner_id=$catname");
  
    $branch_name=$cmn->getvalfield($connection,"m_vehicle_owner","branch_name","owner_id=$catname");
    $mobile_no=$cmn->getvalfield($connection,"m_vehicle_owner","mobileno1","owner_id=$catname");
    $pan_no=$cmn->getvalfield($connection,"m_vehicle_owner","pan_no","owner_id=$catname");
   
    $type='Owner';
 }


  
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
        $this->MultiCell(200, 5, '|| Developed By Chaaruvi Infotech Raipur, Contact us- +91-8871181890,Visit us- www.chaaruvi.com ||', 0, 'C');
   
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
                               
                                       $pdf->Image('upload/logo/'.$c_logo,12,4,25);
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

                                            
                                         $pdf->SetFont('Times','',10);
                                       $pdf->Cell(350,5,'',2,0,'L');
                                        $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(125,-20,'Contact : '.$onwer['mobileno1'].",".$onwer['mobileno2'],2,0,'R');
                                         
                                               

                                        // $pdf->SetFont('Arial','',10);
                                        // $pdf->Cell(150,5,'',2,0,'L');
                                        $pdf->SetFont('Times','',10);
                                        $pdf->SetY('30');
                                        $pdf->Cell(60,-10,'GST No. : '.$onwer['gst_no'],2,0,'R');
                                        $pdf->Ln();


                                        // $pdf->SetFont('Arial','',10);

                                    //    $pdf->Cell(150,10,'',2,0,'R');

                                        $pdf->SetFont('Times','',10);
                                        $pdf->SetY('20');
                                        $pdf->Cell(230,8,'PAN No. : '.$onwer['pan_no'],2,0,'R');
                                        $pdf->Ln();


                                    //      $pdf->SetFont('Arial','',10);

                                    //    $pdf->Cell(150,10,'',2,0,'R');
 $pdf->SetFillColor(175, 213, 240);
                                        $pdf->SetFont('Arial','B',15);
                                        $pdf->SetX('2');
                                        $pdf->Cell(293,8,'Vehicle Ledger',1,0,'C','F');
                                        $pdf->Ln();

                                        $pdf->SetFont('Arial','B',12);
                                        $pdf->SetY('35');
                                        $pdf->Cell(260,8,$type.' Name :'.$owner_name,2,1,'R');
                                                                                $pdf->SetFont('Arial','B',12);
                                        $pdf->SetY('40');
                                        $pdf->Cell(260,8,$type1 ,2,1,'R');
                                      
                                        $pdf->SetFont('Arial', 'B', 10);
                                        $pdf->SetX('22');
                                        $pdf->SetY('40');
                                     
                                        $pdf->Ln();

                                        $pdf->SetFont('Arial','B',12);
                                        $pdf->SetY('44');
                                        $pdf->Cell(60,-10,'Vehicle No. :'      .$vehicle_no,2,0,'L');
                                        $pdf->SetY('50');
                                        $pdf->SetX('22');
                                        $pdf->Ln();
                                        $currentDateTime = date('d F Y h:i A'); 
                                        // $currentDateTime = date('d-m-Y H:i:s');
                                        $pdf->Cell(25, 8, 'Print Date and Time: ' . $currentDateTime, 2, 0,'L');

                                        $pdf->SetFont('Arial','B',12);
                                       
                                        $pdf->SetY('49');
                                         $pdf->SetX('225');
                                        $pdf->Cell(26,-10,'Date : '.date('d-m-Y',strtotime($fromdate)).' To '.date('d-m-Y',strtotime($todate)) ,2,0,'R');
                                        $pdf->Ln();
                                        
                               
                                      $pdf->SetY(48);
 $pdf->SetFillColor(211, 211, 211);
                                        $pdf->SetFont('Arial','B',9);
                                        $pdf->SetX(2);
                                        $pdf->Cell(6,8,'SN',1,0,'C','F');
                                        $pdf->Cell(15,8,'DI No.',1,0,'C','F');
                                        // $pdf->Cell(15,8,'Bilty No.',1,0,'C');
                                        $pdf->Cell(15,8,'Bilty Date',1,0,'C','F');
                                        // $pdf->Cell(32,8,'Consignee',1,0,'C');
                                        
                                        $pdf->Cell(20,8,'Destinaton',1,0,'C','F');
                                        $pdf->Cell(14,8,'Item',1,0,'C','F');
                                        $pdf->Cell(8,8,'Wt',1,0,'C','F');
                                        $pdf->Cell(10,8,'Rate',1,0,'C','F');
                                        $pdf->Cell(10,8,'Frt',1,0,'C','F');
                                         $pdf->Cell(12,8,'C. Adv',1,0,'C','F');
                                         $pdf->Cell(12,8,'D. Adv',1,0,'C','F');
                                        $pdf->Cell(10,8,'GPS',1,0,'C','F');
                                        $pdf->Cell(12,8,'B Com.',1,0,'C','F');
                                        $pdf->Cell(8,8,'Shrt',1,0,'C','F');
                                        $pdf->Cell(10,8,'Tds',1,0,'C','F');
                                        $pdf->Cell(10,8,'Bank',1,0,'C','F');
                                        $pdf->Cell(19,8,'Voucher No.',1,0,'C','F');
                                     
                                          $pdf->Cell(15,8,'Final Pay',1,0,'C','F');
                                          $pdf->Cell(15,8,'Pay Date',1,0,'C','F');
                                          $pdf->Cell(15,8,'Paid Amt',1,0,'C','F');
                                          $pdf->Cell(39,8,'UTR No.',1,0,'C','F');
                                          $pdf->Cell(18,8,'Balance',1,0,'C','F');
                                        $pdf->Ln();
                                         
                                  
                                               


                 
                  
                                        if($cat_id ==4) {
                   $sn=1;
                    //   echo		"Select * from  dispatch_entry  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by dispatch_id desc";
                     $sql = mysqli_query($connection,"Select * from  dispatch_entry  $crit  && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id order by dispatch_id desc");
                           while($row= mysqli_fetch_array($sql)) {
                     $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
                     $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
                     $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
                     $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
                     $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
                         $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
                $is_voucher=$row['is_voucher'];
           
              $checkbox = $row['checkbox'];
              $paid_to=$row['paid_to'];
              if( $checkbox=='0'){
               $rate=$row['own_rate'];
               $frt=$row['wt_mt'] * $row['own_rate'];
               $cash_adv=  $row['cash_adv'];
               $diesel_adv_amt=$row['diesel_adv_amt'];
               
               $adv = $row['other_cash_adv'];

               } else {
                   $rate= $cmn->getvalfield($connection,"tpa_entry","rate","dispatch_id='$row[dispatch_id]' && tpcat_id='4'");
                  $frt= $cmn->getvalfield($connection,"tpa_entry","amt","dispatch_id='$row[dispatch_id]' && tpcat_id='4'");
if($paid_to=='Truck Owner') {
// $adv = $row['other_cash_adv'] + $row['cash_adv'] + $row['diesel_adv_amt'];
     $cash_adv=  $row['cash_adv'];
               $diesel_adv_amt=$row['diesel_adv_amt'];
               
               $adv = $row['other_cash_adv'];

} else {
$adv='0';
}
                 


               } 

               $bank_charge = $cmn->getvalfield($connection,"payment","bank_charge","dispatch_id='$row[dispatch_id]' && category_id='4'");

   $owneramt= $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && category_id='4'");
   $tds_amt = $cmn->getvalfield($connection,"payment","tds_amt","dispatch_id='$row[dispatch_id]' && category_id='4'");
   $sortamt = $cmn->getvalfield($connection,"payment","sortamt","dispatch_id='$row[dispatch_id]' && category_id='4'");
               $voucher_id = $cmn->getvalfield($connection,"payment","voucher_id","dispatch_id='$row[dispatch_id]' && category_id='4'");
if($tds_amt==0){$sign='';}else {$sign='-';}
               
                                                 $bilty_commision = $cmn->getvalfield($connection,"payment","bilty_commision","dispatch_id='$row[dispatch_id]' && category_id='4'");
               $amt_paid = $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && is_paid='1' && category_id='4'");
if($amt_paid==''){$amt_paid='0';}
if($owneramt==''){ $owneramt='0';}               
$payee_name = $cmn->getvalfield($connection,"payment","payee_name","voucher_id='$voucher_id' && consignorid=$consignorid");
$paydate = $cmn->getvalfield($connection,"payment_receive","receive_date","voucher_no='$voucher_id' && consignorid=$consignorid");
$utrno = $cmn->getvalfield($connection,"payment_receive","utrno","voucher_no='$voucher_id' && consignorid=$consignorid");
                       $final=$owneramt ; 
                       $bal=$final - $amt_paid;


      $pdf->SetFont('Arial','',8);
      $pdf->SetX(2);
                                               

                                                $pdf->SetFont('Arial','',8);
                                                $pdf->SetX(2);
                                                $pdf->Cell(6,8, $sn++,1,0,'L');
                                                $pdf->Cell(15,8,$row['di_no'],1,0,'L');
                                                // $pdf->Cell(15,8,$row['bilty_no'],1,0,'R');
                                                $pdf->Cell(15,8,date('d-m-Y',strtotime($row['bilty_date'])),1,0,'C');
                                        
                                                // $pdf->Cell(32,8, $consignee_name, 1,0, 'R');
                                             

                                                $pdf->Cell(20,8,$destination,1,0,'C');
                                                $pdf->Cell(14,8, $item_name,1,0,'C');
                                                $pdf->Cell(8,8,$row['wt_mt'],1,0,'C');
                                                $pdf->Cell(10,8,$rate,1,0,'R');
                                                $pdf->Cell(10,8,$frt,1,0,'R');
                                                $pdf->Cell(12,8,round($cash_adv),1,0,'R');
                                                 $pdf->Cell(12,8,round($diesel_adv_amt),1,0,'R');
                                                $pdf->Cell(10,8,round($adv),1,0,'R');
                                                $pdf->Cell(12,8,round($bilty_commision),1,0,'R');
                                                // $pdf->Cell(14,8,$sort_wt,1,0,'R');
                                                $pdf->Cell(8,8,$sortamt,1,0,'R');
                                                // $pdf->Cell(8,8,$tds.'%',1,0,'R');
                                                 $pdf->SetTextColor(255, 0, 0);
        // $pdf->Cell(190, 4, "LUCKY CONSTRUCTION", '0', 1, 'C', 0);
                                                $pdf->Cell(10,8,$sign.round($tds_amt),1,0,'R');
                                                
                                                $pdf->Cell(10,8,round($bank_charge),1,0,'R');
                                                 $pdf->SetTextColor(0, 0, 0);
                                                $pdf->Cell(19,8,$voucher_id,1,0,'R');
                                                 
                                                 $pdf->Cell(15,8,round($final),1,0,'R');
                                                 
                                                 if($paydate==''){ 
                                                    $pdf->Cell(15,8,'',1,0,'R');
                                                  } else {
                                                  $pdf->Cell(15,8,date('d-m-Y',strtotime($paydate)),1,0,'C');
                                                  }

                                                 $pdf->Cell(15,8,round($amt_paid),1,0,'R');
                                                     $pdf->Cell(39,8,$utrno,1,0,'R');
                                                 $pdf->Cell(18,8,round($bal),1,0,'R');
                                                 
                                                $pdf->Ln();
                                                $freight_amt=$row['wt_mt']*$row['own_rate'];
                                                    $total_wt_mt+=$row['wt_mt'];
                                                     $total_freight+=$freight_amt;
                                                       $total_commision+=$bilty_commision;
                                                          
                                                                $total_tds+=$tds_amt;
                                                                    $total_cash_adv +=$cash_adv;
                                                                                                                                                                                   $total_diesel_adv_amt +=$diesel_adv_amt;
                                                                                                                                                                             $total_adv +=$adv;
                                                                        $total_deduct+=$sortamt; 
                                                                      
                                                                          
                                                                                 $total_final+=$final;
                                                                                 $total_amt_paid+=$amt_paid;
                                                                                 $total_bal+=$bal;
                                            }    } 

                                                     
                                                   
                                        if($cat_id ==2) { 

                                         
                                                
                                                         $sn=1;
                                                         $sql = mysqli_query($connection,"Select * from  dispatch_entry  $crit  && consignor_id=$consignorid && checkbox=1 &&comp_id=$comp_id && session_id=$session_id order by dispatch_id desc");
                                                              while($row= mysqli_fetch_array($sql)) {
                                                         $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
                                                         $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
                                                         $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
                                                         $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
                                                         $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
                                                             $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
                                                    $is_voucher=$row['is_voucher'];
                                                    
                                                  $paid_to=$row['paid_to'];
                                                  $tpa_id= $cmn->getvalfield($connection,"tpa_entry","tpa_id","dispatch_id='$row[dispatch_id]' && tpcat_id='2'");
                                                
                                                      $rate= $cmn->getvalfield($connection,"tpa_entry","rate","dispatch_id='$row[dispatch_id]' && tpcat_id='2'");
                                                      $frt= $cmn->getvalfield($connection,"tpa_entry","amt","dispatch_id='$row[dispatch_id]' && tpcat_id='2'");
                                                if($paid_to=='Consignee') {
                                                    $cash_adv=  $row['cash_adv'];
               $diesel_adv_amt=$row['diesel_adv_amt'];
               
               $adv = $row['other_cash_adv'];
                                                
                                                } else {
                                                $adv='0';
                                                }
                                                     
                                                
                                                
                                                   
                                                $bank_charge = $cmn->getvalfield($connection,"payment","bank_charge","dispatch_id='$row[dispatch_id]' && category_id='2'");
             
                                                $tds_amt = $cmn->getvalfield($connection,"payment","tds_amt","dispatch_id='$row[dispatch_id]' && category_id='2'");
                                                $sortamt = $cmn->getvalfield($connection,"payment","sortamt","dispatch_id='$row[dispatch_id]' && category_id='2'");
                                                   $consigneeamt= $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && category_id='2'");
                                                   $voucher_id = $cmn->getvalfield($connection,"payment","voucher_id","dispatch_id='$row[dispatch_id]' && category_id='2'");
                                                
if($tds_amt==0){$sign='';}else {$sign='-';}
$bilty_commision = $cmn->getvalfield($connection,"payment","bilty_commision","dispatch_id='$row[dispatch_id]' && category_id='2'");
                                                   $amt_paid = $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && is_paid='1' && category_id='2'");
                                                if($amt_paid==''){$amt_paid='0';}
                                                if($consigneeamt==''){ $consigneeamt='0';}
                                                $payee_name = $cmn->getvalfield($connection,"payment","payee_name","voucher_id='$voucher_id' && consignorid=$consignorid");
                                                $paydate = $cmn->getvalfield($connection,"payment_receive","receive_date","voucher_no='$voucher_id' && consignorid=$consignorid");
                                                           $final=$consigneeamt; 
                                                           $bal=$final - $amt_paid;
                                                     
                                          
                                                           $pdf->SetFont('Arial','',8);
                                                           $pdf->SetX(2);
                                                                                                    
                                                     
                                                                                                     $pdf->SetFont('Arial','',8);
                                                                                                     $pdf->SetX(2);
                                                                                                      $pdf->Cell(6,8, $sn++,1,0,'L');
                                                $pdf->Cell(15,8,$row['di_no'],1,0,'L');
                                                // $pdf->Cell(15,8,$row['bilty_no'],1,0,'R');
                                                $pdf->Cell(15,8,date('d-m-Y',strtotime($row['bilty_date'])),1,0,'C');
                                        
                                                // $pdf->Cell(32,8, $consignee_name, 1,0, 'R');
                                             

                                                $pdf->Cell(20,8,$destination,1,0,'C');
                                                $pdf->Cell(14,8, $item_name,1,0,'C');
                                                $pdf->Cell(8,8,$row['wt_mt'],1,0,'C');
                                                $pdf->Cell(10,8,$row['own_rate'],1,0,'R');
                                                $pdf->Cell(10,8,$row['wt_mt']*$row['own_rate'],1,0,'R');
                                                $pdf->Cell(12,8,round($cash_adv),1,0,'R');
                                                 $pdf->Cell(12,8,round($diesel_adv_amt),1,0,'R');
                                                $pdf->Cell(10,8,round($adv),1,0,'R');
                                                $pdf->Cell(12,8,round($bilty_commision),1,0,'R');
                                                // $pdf->Cell(14,8,$sort_wt,1,0,'R');
                                                $pdf->Cell(8,8,$sortamt,1,0,'R');
                                                // $pdf->Cell(8,8,$tds.'%',1,0,'R');
                                                 $pdf->SetTextColor(255, 0, 0);
        // $pdf->Cell(190, 4, "LUCKY CONSTRUCTION", '0', 1, 'C', 0);
                                                $pdf->Cell(10,8,$sign.round($tds_amt),1,0,'R');
                                                
                                                $pdf->Cell(10,8,round($bank_charge),1,0,'R');
                                                 $pdf->SetTextColor(0, 0, 0);
                                                $pdf->Cell(19,8,$voucher_id,1,0,'R');
                                                 
                                                 $pdf->Cell(15,8,round($final),1,0,'R');
                                                 
                                                 if($paydate==''){ 
                                                    $pdf->Cell(15,8,'',1,0,'R');
                                                  } else {
                                                  $pdf->Cell(15,8,date('d-m-Y',strtotime($paydate)),1,0,'C');
                                                  }

                                                 $pdf->Cell(15,8,round($amt_paid),1,0,'R');
                                                     $pdf->Cell(39,8,$utrno,1,0,'R');
                                                 $pdf->Cell(18,8,round($bal),1,0,'R');
                                                                                                      
                                                                                                     $pdf->Ln();
                                                                                                     $freight_amt=$row['wt_mt']*$row['own_rate'];
                                                                                                         $total_wt_mt+=$row['wt_mt'];
                                                                                                          $total_freight+=$freight_amt;
                                                                                                            $total_commision+=$bilty_commision;
                                                                                                               
                                                                                                                     $total_tds+=$tds_amt;
                                                                                                                         $total_cash_adv +=$cash_adv;
                                                                                                                                                                                   $total_diesel_adv_amt +=$diesel_adv_amt;
                                                                                                                                                                             $total_adv +=$adv;
                                                                                                                             $total_deduct+=$sortamt; 
                                                                                                                           
                                                                                                                               
                                                                                                                                      $total_final+=$final;
                                                                                                                                      $total_amt_paid+=$amt_paid;
                                                                                                                                      $total_bal+=$bal;
                                                                                                 }    } 
                                                     

                                                                                                  if($cat_id ==1) { 

                                                                                                  
                                                                                                             $sn=1;
                                                                                                             // echo		"Select * from  $tblname  $crit  && consignor_id=$consignorid && checkbox=1 &&comp_id=$comp_id && session_id=$session_id order by $tblpkey desc";
                                                                                                             $sql = mysqli_query($connection,"Select * from  dispatch_entry  $crit  && consignor_id=$consignorid && checkbox=1 &&comp_id=$comp_id && session_id=$session_id order by dispatch_id desc");
                                                                                                                  while($row= mysqli_fetch_array($sql)) {
                                                                                                             $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
                                                                                                             $consignee_name=$cmn->getvalfield($connection,"m_consignee","consignee_name","consignee_id=$row[consignee_id]");
                                                                                                             $vehicle_no=$cmn->getvalfield($connection,"m_vehicle","vehicle_no","vehicle_id=$row[vehicle_id]");
                                                                                                             $destination=$cmn->getvalfield($connection,"m_place","place_name","place_id=$row[destination_id]");	
                                                                                                             $item_name=$cmn->getvalfield($connection,"m_item","item_name","item_id=$row[item_id]");				
                                                                                                                 $owner_name=$cmn->getvalfield($connection,"m_vehicle_owner","owner_name","owner_id=$row[owner_id]");
                                                                                                        $is_voucher=$row['is_voucher'];
                                                                                                        
                                                                                                      $paid_to=$row['paid_to'];
                                                                                                      $tpa_id= $cmn->getvalfield($connection,"tpa_entry","tpa_id","dispatch_id='$row[dispatch_id]' && tpcat_id='1'");
                                                                                                    
                                                                                                          $rate= $cmn->getvalfield($connection,"tpa_entry","rate","dispatch_id='$row[dispatch_id]' && tpcat_id='1'");
                                                                                                          $frt= $cmn->getvalfield($connection,"tpa_entry","amt","dispatch_id='$row[dispatch_id]' && tpcat_id='1'");
                                                                                                    if($paid_to=='Agent') {
                                                                                                      $cash_adv=  $row['cash_adv'];
               $diesel_adv_amt=$row['diesel_adv_amt'];
               
               $adv = $row['other_cash_adv'];
                                                                                                    
                                                                                                    } else {
                                                                                                    $adv='0';
                                                                                                    }
                                                                                                         
                                                                                                    
                                                                                                    
                                                                                                       
                                                                                                    $bank_charge = $cmn->getvalfield($connection,"payment","bank_charge","dispatch_id='$row[dispatch_id]' && category_id='1'");
                              
                                                                                                    $tds_amt = $cmn->getvalfield($connection,"payment","tds_amt","dispatch_id='$row[dispatch_id]' && category_id='1'");
                                                                                                    $sortamt = $cmn->getvalfield($connection,"payment","sortamt","dispatch_id='$row[dispatch_id]' && category_id='1'");
                                                                                                       $consigneeamt= $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && category_id='1'");
                                                                                                       $voucher_id = $cmn->getvalfield($connection,"payment","voucher_id","dispatch_id='$row[dispatch_id]' && category_id='1'");
                                                                                                    if($tds_amt==0){$sign='';}else {$sign='-';}
                                                                                                       
                                                                                                                                         $bilty_commision = $cmn->getvalfield($connection,"payment","bilty_commision","dispatch_id='$row[dispatch_id]' && category_id='1'");
                                                                                                       $amt_paid = $cmn->getvalfield($connection,"payment","amt_paid_to","dispatch_id='$row[dispatch_id]' && is_paid='1' && category_id='1'");
                                                                                                    if($amt_paid==''){$amt_paid='0';}
                                                                                                    if($consigneeamt==''){ $consigneeamt='0';}
                                                                                                    $payee_name = $cmn->getvalfield($connection,"payment","payee_name","voucher_id='$voucher_id' && consignorid=$consignorid");
                                                                                                    $paydate = $cmn->getvalfield($connection,"payment_receive","receive_date","voucher_no='$voucher_id' && consignorid=$consignorid");
                                                                                                               $final=$consigneeamt; 
                                                                                                               $bal=$final - $amt_paid;
                                                                                                    
                                                     
                                                                                                               $pdf->SetFont('Arial','',8);
                                                                                                               $pdf->SetX(2);
                                                                                                                                                        
                                                                                                         
                                                                                                                                                         $pdf->SetFont('Arial','',8);
                                                                                                                                                         $pdf->SetX(2);
                                                                                                                                                    $pdf->Cell(6,8, $sn++,1,0,'L');
                                                $pdf->Cell(15,8,$row['di_no'],1,0,'L');
                                                // $pdf->Cell(15,8,$row['bilty_no'],1,0,'R');
                                                $pdf->Cell(15,8,date('d-m-Y',strtotime($row['bilty_date'])),1,0,'C');
                                        
                                                // $pdf->Cell(32,8, $consignee_name, 1,0, 'R');
                                             

                                                $pdf->Cell(20,8,$destination,1,0,'C');
                                                $pdf->Cell(14,8, $item_name,1,0,'C');
                                                $pdf->Cell(8,8,$row['wt_mt'],1,0,'C');
                                                $pdf->Cell(10,8,$row['own_rate'],1,0,'R');
                                                $pdf->Cell(10,8,$row['wt_mt']*$row['own_rate'],1,0,'R');
                                                $pdf->Cell(12,8,round($cash_adv),1,0,'R');
                                                 $pdf->Cell(12,8,round($diesel_adv_amt),1,0,'R');
                                                $pdf->Cell(10,8,round($adv),1,0,'R');
                                                $pdf->Cell(12,8,round($bilty_commision),1,0,'R');
                                                // $pdf->Cell(14,8,$sort_wt,1,0,'R');
                                                $pdf->Cell(8,8,$sortamt,1,0,'R');
                                                // $pdf->Cell(8,8,$tds.'%',1,0,'R');
                                                 $pdf->SetTextColor(255, 0, 0);
        // $pdf->Cell(190, 4, "LUCKY CONSTRUCTION", '0', 1, 'C', 0);
                                                $pdf->Cell(10,8,$sign.round($tds_amt),1,0,'R');
                                                
                                                $pdf->Cell(10,8,round($bank_charge),1,0,'R');
                                                 $pdf->SetTextColor(0, 0, 0);
                                                $pdf->Cell(19,8,$voucher_id,1,0,'R');
                                                 
                                                 $pdf->Cell(15,8,round($final),1,0,'R');
                                                 
                                                 if($paydate==''){ 
                                                    $pdf->Cell(15,8,'',1,0,'R');
                                                  } else {
                                                  $pdf->Cell(15,8,date('d-m-Y',strtotime($paydate)),1,0,'C');
                                                  }

                                                 $pdf->Cell(15,8,round($amt_paid),1,0,'R');
                                                     $pdf->Cell(39,8,$utrno,1,0,'R');
                                                 $pdf->Cell(18,8,round($bal),1,0,'R');
                                                                                                                                                          
                                                                                                                                                         $pdf->Ln();
                                                                                                                                                         $freight_amt=$row['wt_mt']*$row['own_rate'];
                                                                                                                                                             $total_wt_mt+=$row['wt_mt'];
                                                                                                                                                              $total_freight+=$freight_amt;
                                                                                                                                                                $total_commision+=$bilty_commision;
                                                                                                                                                                   
                                                                                                                                                                         $total_tds+=$tds_amt;
                                                                                                                                                                              $total_cash_adv +=$cash_adv;
                                                                                                                                                                                   $total_diesel_adv_amt +=$diesel_adv_amt;
                                                                                                                                                                             $total_adv +=$adv;
                                                                                                                                                                                 $total_deduct+=$sortamt; 
                                                                                                                                                                               
                                                                                                                                                                                   
                                                                                                                                                                                          $total_final+=$final;
                                                                                                                                                                                          $total_amt_paid+=$amt_paid;
                                                                                                                                                                                          $total_bal+=$bal;
                                                                                                                                                     }    } 
                                        $pdf->SetX(2);
                                        $currentX = $pdf->GetX();
                                        $currentY = $pdf->GetY();
                                         $pdf->SetFillColor(175, 213, 240);
                                        // Draw a line from current position (after the Cell)
                                        $pdf->Line($currentX , $currentY + 16, $currentX + 293, $currentY + 16); 
                                                     $pdf->SetFont('Arial','B',9);
                                                     $pdf->Cell(70,12,'Total',1,0,'C','F');

                                                     
                                                     
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(8,12, $total_wt_mt,1,0,'R','F');
                                                     $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(10,12,'',1,0,'R');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,12,$total_freight,1,0,'R','F');
                                                       $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,12,round($total_cash_adv),1,0,'R','F');
                                                       $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,12,round($total_diesel_adv_amt),1,0,'R','F');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(10,12,round($total_adv),1,0,'R','F');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(11.9,12,$total_commision,1,0,'R','F');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(8,12,$total_deduct,1,0,'R','F');
                                                    
                                                      $pdf->SetFont('Arial','B',8);
                                                   $pdf->SetTextColor(255, 0, 0);
                                                     $pdf->Cell(10,12,'-'.round($total_tds),1,0,'R','F');
                                                       $pdf->SetTextColor(0, 0, 0);
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(10,12,'',1,0,'R','F');

                                                 

                                             $pdf->SetFont('Arial','B',8);
                                             $pdf->Cell(19,12,'',1,0,'R','F');
                                                   
                                                       $pdf->SetFont('Arial','B',8);
                                                      $pdf->Cell(15,12,$total_final,1,0,'R','F');
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,12,'',1,0,'R','F');
                                                      $pdf->SetFont('Arial','B',8);
                                                      $pdf->Cell(15,12,$total_amt_paid,1,0,'R','F');
                                                      $pdf->SetFont('Arial','B',8);
                                                      $pdf->Cell(57,12,$total_bal,1,1,'R','F');

                                                    
                                                     $pdf->Ln(5);
                                                    
                                                     $currentX = $pdf->GetX();
                                                     $currentY = $pdf->GetY();
                                                     
                                                     // Draw a line from current position (after the Cell)
                                                     $pdf->Line($currentX - 8, $currentY + 36, $currentX + 285, $currentY + 36); 
                                                     $pdf->Line($currentX + 75, $currentY, $currentX + 75, $currentY + 35); 
                                                     $pdf->Line($currentX + 155, $currentY, $currentX + 155, $currentY + 35); 
                                                    //  $pdf->Ln(5);
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(2);      $pdf->Cell(45,5,'Name of A/c Holder   ',2,0,'L');

                                                     $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($acc_holder_name),2,0,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(95);      $pdf->Cell(45,5,'TDS Deducted ',2,0,'L');
                                                     $pdf->SetFont('Arial','B',10);
                                                       $pdf->SetTextColor(255, 0, 0);
                                                     $pdf->SetX(135);     $pdf->Cell(50,5,'Rs. -'.round($total_tds),2,0,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                       $pdf->SetTextColor(0, 0, 0);
                                                     $pdf->SetX(175);      $pdf->Cell(45,5,'Prepared By',2,1,'L');
                                                    
                                                     $pdf->SetFont('Arial','',10);          $pdf->SetX(2);      $pdf->Cell(45,5,'Payee Pan   ',2,0,'L');

                                                     $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($pan_no),2,0,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(95);      $pdf->Cell(45,5,'Net Amount Payable ',2,0,'L');
                                                     $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(135);     $pdf->Cell(50,5,'Rs. '.round($total_final),2,1,'L');
                                                     $pdf->SetFont('Arial','',10);       $pdf->SetX(2);      $pdf->Cell(45,5,'Account No.   ',2,0,'L');
                                                     $pdf->SetFont('Arial','B',10);
                                                     
                                                     $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($acc_no),2,0,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(95);      $pdf->Cell(45,5,'Net Amount Paid ',2,0,'L');
                                                     $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(135);     $pdf->Cell(50,5,'Rs. '.round($total_amt_paid),2,0,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(175);      $pdf->Cell(45,5,'Authorised By',2,1,'L');
                                                     $pdf->SetFont('Arial','',10);       $pdf->SetX(2);      $pdf->Cell(45,5,'IFSC Code  ',2,0,'L');
                                                     $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($ifsc_code),2,0,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(95);      $pdf->Cell(45,5,'Balance Amount ',2,0,'L');
                                                     $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(135);     $pdf->Cell(50,5,'Rs. '.round($total_bal),2,1,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(2);      $pdf->Cell(45,5,'Bank Name  ',2,0,'L');

                                                     $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($bank_name),2,0,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(175);      $pdf->Cell(45,5,'Entered By',2,1,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(2);      $pdf->Cell(45,5,'Branch Name  ',2,0,'L');

                                                     $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(45);     $pdf->Cell(50,5,ucwords($branch_name),2,1,'L');
                                                     $pdf->SetFont('Arial','',10);
                                                     $pdf->SetX(2);      $pdf->Cell(45,5,'Mobile No  ',2,0,'L');

                                                     $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(45);     $pdf->Cell(50,5,$mobile_no,2,1,'L');
                                                  
                                                     
                                                         
                                                     $pdf->Ln(5);
                                                     $pdf->SetX(2);
                                                      $pdf->SetFont('Arial','B',10);
                                                    
                                                     $pdf->Cell(45,10,'Amount Payable : ',2,0,'L');

                                                     $pdf->SetX(45); 
                                                     $pdf->Cell(90,10,ucwords(convert_number_to_words($total_final))." Rupees Only",2,1,'L');
                                                     $pdf->SetX(2);        $pdf->Cell(45,10,'Amount Paid :',2,0,'L');

                                                     if($amt_paid != '0'){
                                                     $pdf->SetX(45);     $pdf->Cell(90,10,ucwords(convert_number_to_words($total_amt_paid))." Rupees Only",2,1,'L');
                                                       } else {
                                                        $pdf->SetX(45);     $pdf->Cell(90,10,"",2,1,'L');

                                                       } 
                                                       
                                                       
                                                       $pdf->SetX(2);      $pdf->Cell(45,10,'Balance Payable  :',2,0,'L');

                                                       $pdf->SetFont('Arial','B',10);
                                                     $pdf->SetX(45);     $pdf->Cell(90,10,ucwords(convert_number_to_words($total_bal))." Rupees Only",2,1,'L');

                                               


                                                  
                                                     
                                                      

                                               

 $pdf->Output();
?>
