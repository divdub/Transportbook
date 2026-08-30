<?php
//  error_reporting(0);

include("../adminsession.php");
require("../fpdf184/fpdf.php");
$crit=" where 1=1";
  
if(isset($_GET['purchaseid']))
{
	$purchaseid = trim(addslashes($_GET['purchaseid']));
}
else
$purchaseid = 0; 
 
$cname = $cmn->getvalfield($connection, "m_company", "cname", "comp_id=$_SESSION[comp_id]");

// $term_condition = $cmn->getvalfield($connection, "m_company", "term_condition", "comp_id=$_SESSION[comp_id]");

$clogo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");

$mobileno1 = $cmn->getvalfield($connection, "m_company", "mobileno1", "comp_id=$_SESSION[comp_id]");
$mobileno2 = $cmn->getvalfield($connection, "m_company", "mobileno2", "comp_id=$_SESSION[comp_id]");
$caddress = $cmn->getvalfield($connection, "m_company", "caddress", "comp_id=$_SESSION[comp_id]");
$emailid = $cmn->getvalfield($connection, "m_company", "emailid", "comp_id=$_SESSION[comp_id]");



$sql = mysqli_query($connection,"select * from purchaseentry where purchaseid='$purchaseid'");

$row=mysqli_fetch_assoc($sql);
 $customer_name = $cmn->getvalfield($connection, "m_customer", "cust_name", "customer_id='$row[supplier_id]'");

$billno=$row['billno'];
$bill_type=$row['bill_type'];
$purchase_date= dateformatindia($row['purchase_date']);



 $customer_address = $cmn->getvalfield($connection,"m_customer","saddress","customer_id='$row[supplier_id]'");
  
  $cust_cifsc_code = $cmn->getvalfield($connection,"m_customer","ifsc_code","customer_id='$row[supplier_id]'");
  
  $cust_branch_name = $cmn->getvalfield($connection,"m_customer","branch_name","customer_id='$row[supplier_id]'");

 $cust_acc_no	 = $cmn->getvalfield($connection,"m_customer","acc_no	","customer_id='$row[supplier_id]'");
   
  $cust_acc_holder_name = $cmn->getvalfield($connection,"m_customer","acc_holder_name","customer_id='$row[supplier_id]'");
 $acc_holder_name = $cmn->getvalfield($connection,"m_company","acc_holder_name","comp_id='$_SESSION[comp_id]'");
 
 $branch_name = $cmn->getvalfield($connection,"m_company","branch_name","comp_id='$_SESSION[comp_id]'");
 $mobile_no = $cmn->getvalfield($connection,"m_customer","mobile_no","customer_id='$row[supplier_id]'");
 
 $acc_no = $cmn->getvalfield($connection,"m_company","acc_no","comp_id='$_SESSION[comp_id]'");
 $ifsc_code = $cmn->getvalfield($connection,"m_company","ifsc_code","comp_id='$_SESSION[comp_id]'");
$c_logo = $cmn->getvalfield($connection,"m_company","clogo","comp_id='$_SESSION[comp_id]'");


function convert_number($number)
{
    $no = (int)floor($number);
    $point = (int)round(($number - $no) * 100);
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        '0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;


        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] .
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
    if ($points != '') {
        return $result . "Rupees  " . $points . " Paise ";
    } else {

        return $result . "Rupees ";
    }
}





function convert_number_to_words($number)
{
    $hyphen      = ' ';
    $conjunction = ' AND ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'ZERO',
        1                   => 'ONE',
        2                   => 'TWO',
        3                   => 'THREE',
        4                   => 'FOUR',
        5                   => 'FIVE',
        6                   => 'SIX',
        7                   => 'SEVEN',
        8                   => 'EIGHT',
        9                   => 'NINE',
        10                  => 'TEN',
        11                  => 'ELEVEN',
        12                  => 'TWELVE',
        13                  => 'THIRTEEN',
        14                  => 'FOURTEEN',
        15                  => 'FIFTEEN',
        16                  => 'SIXTEEN',
        17                  => 'SEVENTEEN',
        18                  => 'EIGHTEEN',
        19                  => 'NINETEEN',
        20                  => 'TWENTY',
        30                  => 'THIRTY',
        40                  => 'FOURTY',
        50                  => 'FIFTY',
        60                  => 'SIXTY',
        70                  => 'SEVENTY',
        80                  => 'EIGHTY',
        90                  => 'NINETY',
        100                 => 'HUNDRED',
        1000                => 'THOUSAND',
        1000000             => 'MILLION',
        1000000000          => 'BILLION',
        1000000000000       => 'TRILLION',
        1000000000000000    => 'QUADRILLION',
        1000000000000000000 => 'QUINTILLION',
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
        
        global $emailid, $mobileno1, $mobileno2, $caddress, $cname ,$clogo,$customer_name,$billno,$purchase_date ,$bill_type,$customer_address ,$mobile_no;
        //courier 25
        
          $this->SetFont('courier', 'b', 9);
        $this->Rect(5, 5, 200, 290, 'D'); //For A4	
        $this->SetFont('courier', 'b', 9);
        $this->Rect(5, 38, 200, 15, 'D');

        $this->SetFillColor(175, 213, 240);
        $this->Rect(5, 38.2, 199.5, 14.8, 'F'); //For A4
        $this->Rect(5, 53, 150, 35, 'D'); //For A4  
        $this->Rect(155, 53, 50, 35, 'D');
        $this->SetFillColor(175, 213, 240);
        // $this->Rect(5, 80, 100, 7, 'F'); //For A4
        $this->SetFillColor(175, 213, 240);
        // $this->Rect(5, 80, 200, 7, 'F');


        // $this->Rect(5, 80, 100, 32, 'D'); //For A4

        $this->SetFillColor(255, 255, 255);
        // $this->Rect(5, 80, 200, 32, 'D');

        $this->Rect(5, 5,200,280,'D');
        //for first Rect
        //$this->Rect(5,28,100,33,'D');
        //for second Rect
        //$this->Rect(105,28,100,33,'D');
        //$this->SetFont('courier','b',20);
        ///for Second part
        //$this->Rect(5,40,100,20,'D');
        //for second Rect
        //$this->Rect(5,70,200,14,'D');
         $this->Image('../upload/logo/'.$clogo,7,7,20,20);
         $this->SetFont('courier', 'BU', 30);

        $this->SetFont('Arial', '', 12);

        $this->Ln(2);


        $this->SetFont('times', 'B', 19);
        $this->SetTextColor(255, 0, 0);
        $this->Cell(190, 6, $cname, '0', 1, 'C', 0);
        $this->Ln(2);

        $this->SetFont('times', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(200, 4, $caddress, '0', 1, 'C', 0);
        $this->Ln(2);

        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(200, 4, "Tel. : $mobileno1, $mobileno2", '0', 1, 'C', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(200, 4, "Email: " . $emailid, '0', 1, 'C', 0);

  $this->SetY(42);
        $this->SetFont('Arial', 'b', 12);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(200, 6, "PURCHASE BILL ", '0', 1, 'C', 0);

      
       
    $this->SetY(55);
    $this->SetX(7);
     $this->SetFont('Arial', 'b', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(28, 4, 'Customer Name.', '0', 0, 'R', 0);
        $this->SetFont('Arial', '', 9.5);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(110, 4, ': ' . $customer_name, '0', 0, 'R', 0);
        $this->SetY(55);
   $this->SetX(141);
     $this->SetFont('Arial', 'b', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(28, 4, 'Bill No.', '0', 0, 'R', 0);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(30, 4, '    : ' . $billno, '0', 0, 'L', 0);

       $this->SetY(65);
         $this->SetX(4);
     $this->SetFont('Arial', 'b', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(28, 4, ' Mobile No .', '0', 0, 'L', 0);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(110, 4, '   : ' . $mobile_no , '0', 0, 'L', 0);
        
         $this->SetY(60);
        $this->Ln(5);
          $this->SetX(144);
     $this->SetFont('Arial', 'b', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(28, 4, 'Bill Date.', '0', 0, 'R', 0);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(30, 4, '  : ' .$purchase_date, '0', 0, 'L', 0);
     
              $this->SetY(66);
        $this->Ln(5);
          $this->SetX(5);
     $this->SetFont('Arial', 'b', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(28, 4, 'Address', '0', 0, 'L', 0);
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(115, 4, '  : ' . $customer_address, '0', 0, 'R', 0);
        
                $this->SetY(66);
        $this->Ln(5);
        $this->SetX(144);
     $this->SetFont('Arial', 'b', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(28, 4, 'Bill type.', '0', 0, 'R', 0);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(30, 4, '  : ' . $bill_type, '0', 0, 'L', 0);

  

        $this->Ln(7);
         $this->SetY(85);
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
$this->SetFillColor(175, 213, 240);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(8, 7, 'Sno', '1', 0, 'L', 1);
         $this->Cell(85, 7, 'Description Of Goods', 1, 0, 'C', 1);
        // $this->Cell(42, 7, 'Item', 1, 0, 'C', 1);
        $this->Cell(25, 7, 'Unit', 1, 0, 'C', 1);
         $this->Cell(25, 7, 'Qty', 1, 0, 'C', 1);
        $this->Cell(22, 7, 'Rate', 1, 0, 'C', 1);
        $this->Cell(35, 7, 'Amonut', 1, 1, 'C', 1);
        $this->SetFont('Arial', '', 8);
 $this->SetX(5);
        $this->SetWidths(array(8,85,25,25,22,35));
      
        $this->SetAligns(array("L", "C", "C","C","C","R"));
    }
    
    // Page footer
    function Footer()
    {
        
        global $comp_name ,$customer_address ,$cname,$acc_holder_name,$branch_name,$acc_no,$ifsc_code,$tot_exp,$net_amt1,$cust_acc_holder_name,$cust_acc_no,$cust_cifsc_code,$cust_branch_name;
     

//  $this->Rect(5, 126, 200, 25, 'D');

$this->Rect(5, 210, 100, 75, 'D');


$this->setX(5);
$this->SetFont('Arial', '', 9);
$this->SetFillColor(255,255,255);
// $pdf->Cell(75, 5, "", '1', 0, 'R', 'F');
$this->Cell(40, 5,  'AMOUNT IN WORDS:  ', '1', 0, 'L', 'F');
$this->SetFont('Arial', 'b', 9);
$this->Cell(160, 5,  strtoupper(convert_number(round($net_amt1 + $tot_exp))) ." ONLY", '1', 1, 'L', 'F');


//  $this->setX(6);
 
//   $this->SetFont('Arial', 'b', 10);
//  $this->SetTextColor(0, 0, 0);
//  $this->Cell(30, 5, 'Bank Details  :', '0', 0, 'L', 0);
 
 
//  $this->SetFont('Arial', '', 10);
//   $this->SetTextColor(0, 0, 0);
//   $this->Cell(180, 5,  strtoupper($cust_acc_holder_name) .  '      ' ."AC No.:".$cust_acc_no .  '   ' ."IFSC Code :".$cust_cifsc_code , '0', 1, 'L', 0);

//  $this->setX(6);
 
//   $this->SetFont('Arial', 'b', 10);
//  $this->SetTextColor(0, 0, 0);
//  $this->Cell(30, 5, 'Branch Name :', '0', 0, 'L', 0);

//  $this->SetFont('Arial', '', 10);
//   $this->SetTextColor(0, 0, 0);
//   $this->Cell(180, 5,  strtoupper($cust_branch_name), '0', 1, 'L', 0);

$this->SetY(210);
$this->SetX(5);
$this->SetFont('Arial', 'Ub', 11);
$this->SetTextColor(0, 0, 0);
$this->Cell(25, 10, 'Terms & Conditions :', '0', 1, 'L', 0);
$this->SetFont('Arial', '', 10);
 $this->SetTextColor(0, 0, 0);
 $this->Cell(230, 4, 'Receiver Signature :', '0', 0, 'C', 0);
  
 $this->Rect(105,210, 100, 25, 'D');
 
  $this->SetY(270);
$this->SetX(120);
$this->SetFont('Arial', 'b', 10);
$this->SetTextColor(0, 0, 0);
$this->Cell(40, 10, 'For '.$cname, '0', 1, 'L', 0);
$this->SetFont('Arial', '', 8);
 $this->SetTextColor(0, 0, 0);
 $this->Cell(21, 4, '', '0', 0, 'C', 0);


 $this->SetY(215);
 $this->SetX(5);
$this->SetFont('Arial', 'b', 10);
$this->SetTextColor(0, 0, 0);
$this->Cell(25, 10, 'E.& O.E. :', '0', 1, 'L', 0);
$this->SetFont('Arial', '', 10);
 $this->SetTextColor(0, 0, 0);
 $this->Cell(21, 4, '', '0', 0, 'C', 0);

 $this->SetY(225);
 $this->SetX(6);
$this->SetFont('Arial', 'b', 8);
$this->SetTextColor(0, 0, 0);
$this->MultiCell(80, 6, $term_condition, '0', 1, 'L', 0);


 
  $this->SetY(287);
 $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->SetX(5);
        $this->MultiCell(200, 5, '|| Developed By Chaaruvi Infotech Raipur, Contact us- +91-8871181890,Visit us- www.chaaruvi.com ||', 0, 'C');

// $this->Rect(5, 175, 200, 35, 'D');
  
  
    }
    
    
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }
    function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 8 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 8, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
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
    $nb = rand(3, 10);
    $w = '';
    for ($i = 1; $i <= $nb; $i++)
        $w .= chr(rand(ord('a'), ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb = rand(1, 10);
    $s = '';
    for ($i = 1; $i <= $nb; $i++)
        $s .= GenerateWord() . ' ';
    return substr($s, 0, -1);
}
$pdf = new PDF_MC_Table();
$pdf->SetTitle($title1);
$title2 = " PURCHASE ENTRY";
$pdf->SetTitle($title2);


$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4');

$slno = 1;
$sql = mysqli_query($connection, "Select * from  purchasentry_detail  where purchaseid ='$purchaseid' order by purdetail_id  desc");
 
while ($row = mysqli_fetch_array($sql)) {
    
    // $pdf->SetX(5);
	$item_name = $cmn->getvalfield($connection, "m_item", "item_name", "item_id='$row[item_id]'");

																$unit_name = $cmn->getvalfield($connection, "m_unit", "unit_name", "unit_id='$row[unit_id]'");
																$qty= $row['qty'];
																$rate =$row['rate'];
																	$description =$row['description'];
																	
																$itemcategoryname = $cmn->getvalfield($connection, "m_iteminv", "item_name", "iteminv_id ='$row[iteminv_id]'");
									
									$iteminv_id= $cmn->getvalfield($connection, "purchasentry_detail", "iteminv_id", "purdetail_id ='$row[purdetail_id]'");
										
									 $iteminv_category_id = $cmn->getvalfield($connection, "m_iteminv", "iteminv_category_id", "iteminv_id ='$iteminv_id'");
			
				$item_category_name = $cmn->getvalfield($connection, "m_iteminv_category", "category_name", "iteminv_category_id='$iteminv_category_id'");
           		
																	
																	
																	
																$total_amt =$qty*$rate;
																	$net_amt1 +=$total_amt ;

															
    $pdf->SetX(5);
    $pdf->Row(array($slno++,$item_name.$itemcategoryname.$item_category_name,$unit_name,$qty,$rate,number_format($total_amt,2)));
}




    $pdf->SetX(5);
     $pdf->SetFont('Arial','B',11);
     $pdf->Cell(165,6,'Total','1',0,'R',0);
	  $pdf->Cell(35,6,number_format($net_amt1,2),'1',1,'R',0);
     
     $pdf->SetFont('Arial', 'B', 8);
   $pdf->Cell(70, 7, '', '0', 1, 'L', 0);
    $pdf->SetFont('Arial', 'B', 8);
        // $pdf->SetFillColor(170, 170, 170); //gray
        $pdf->SetFillColor(175, 213, 240);
        $pdf->SetTextColor(0, 0, 0);
            $pdf->SetX(5);
        $pdf->Cell(200, 7, 'Expense', '1', 1, 'L', 1);
        $pdf->SetWidths(array(70));
        $pdf->SetAligns(array("L"));
           
     
     
     $sno=1;
    //  $sql2 = mysqli_query($connection, "select * from purchaseexp where purchaseid='$purchaseid'");
      
// 	while($row1=mysqli_fetch_assoc($sql2))
// 		{
// 			$remark = $row1['remark'];
// 		$type = $row1['type'];
// 		$expprocess = trim($row1['expprocess']);
		
// 		if($type=='rs')
// 		{
// 		$expamt = $row1['expamt'];
// 		}
// 		else
// 		{
// 		$expamt = ($netamount * $row1['expamt'])/100;
// 		}
		
// 		if($expprocess =='Add') {
// 		$tot_exp += $expamt;
// 		}	
// 		else
// 		{
// 		$tot_exp -= $expamt;
// 		}
		
			
// 		if($expprocess =='Add') {
// 		  //  echo"ok"; die;
//           $expprocess1="Add (+)";
        
// 		$tot_exp += $expamt;
// 		}	
// 		else
// 		{
//             $expprocess1="less (-)";
// 		      //echo"hii"; die;
            
// 		$tot_exp -= $expamt;
// // 		echo $tot_exp."hii"; die;
// 		}
		
// 			$tot_exp += $expamt;
// 			$expname =$cmn->getvalfield($connection,"add_exp","expname","addexp_id='$row1[addexp_id]'"); 
			
//              $pdf->SetX(5);
          
//      $pdf->SetX(5);

// $pdf->SetFont('Arial', '', 8);
// $pdf->Cell(7, 5, $sno++, 1, 0, 'L');
// $pdf->Cell(120, 5, ucfirst($remark), 1, 0, 'L');
// $pdf->Cell(35, 5, ucfirst($expname), 1, 0, 'L');
// $pdf->Cell(15, 5, ucfirst($expprocess1), 1, 0, 'L');
// $pdf->Cell(23, 5, number_format($expamt,2), 1, 1, 'R');

    
              
        
// }  
    
	$slno++;

// $pdf->SetX(5);
//           $pdf->SetFont('Arial', 'B', 8);
//   $pdf->Cell(177,6,'Total','1',0,'R',0);
//      $pdf->Cell(23,6,$tot_exp,'1',1,'R',0);
     
       $pdf->SetX(5);
     $pdf->SetFont('Arial','B',11);
 $pdf->SetFillColor(175, 213, 240);
     $pdf->Cell(160,6,'Net Total','1',0,'R',0);
     
	  $pdf->Cell(40,6,round($net_amt1 + $tot_exp),'1',1,'R',0);

$pdf->Output();
?> 
                          	
<?php
mysqli_close($db_link);

?>
