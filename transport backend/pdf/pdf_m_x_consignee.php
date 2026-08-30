<?php
error_reporting(0);
include("../adminsession.php");
require("../fpdf184/fpdf.php");
$cname = $cmn->getvalfield($connection, "m_company", "cname", "comp_id=$_SESSION[comp_id]");
$mobileno1 = $cmn->getvalfield($connection, "m_company", "mobileno1", "comp_id=$_SESSION[comp_id]");
$mobileno2 = $cmn->getvalfield($connection, "m_company", "mobileno2", "comp_id=$_SESSION[comp_id]");
$caddress = $cmn->getvalfield($connection, "m_company", "caddress", "comp_id=$_SESSION[comp_id]");
$emailid = $cmn->getvalfield($connection, "m_company", "emailid", "comp_id=$_SESSION[comp_id]");
$clogo = $cmn->getvalfield($connection, "m_company", "clogo", "comp_id=$_SESSION[comp_id]");
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
        global  $emailid, $mobileno1, $mobileno2, $caddress, $cname ,$clogo;
        //courier 25
        //$this->Rect(5, 5,200,287,'D');
        //for first Rect
        //$this->Rect(5,28,100,33,'D');
        //for second Rect
        //$this->Rect(105,28,100,33,'D');
        //$this->SetFont('courier','b',20);
        ///for Second part
        //$this->Rect(5,40,100,20,'D');
        //for second Rect
        //$this->Rect(5,70,200,14,'D');
        $this->Image('../upload/logo/'.$clogo,15,2,18,18);
        $this->SetFont('courier', 'BU', 30);

        $this->SetY(11);
        $this->Cell(90);
       $this->Cell(10, 8, "" . $cname, 0, 0, 'C');
       $this->Ln(5);
       $this->SetFont('courier', 'b', 14);
       $this->Cell(90);
    $this->Cell(10, 14,strtoupper($caddress), 0, 0, 'C');
      $this->Ln(0);
       $this->SetFont('courier', 'b', 12);
     $this->Cell(90);
    $this->Cell(2,24,$mobileno1 .",". $mobileno2." ".$emailid, 0, 0, 'C');
     
        $this->ln(6);
        $this->SetXY(2, 12);
        $this->SetFont('Times', 'BU', 10);
        $this->ln();
        $this->Cell(0, 0, '', 'B', 'L');
        $this->ln();
        $this->Cell(0, 0, '', 'B', 'L');
        $this->SetFont('Arial', 'b', 16);
        $this->Ln(5);
        $this->SetY(28);
        $this->Cell(90);
        $this->Cell(10, 28, "X-CONSIGNEE DETAILS", 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('courier', 'b', 11);
        $this->Cell(90);
        $this->Cell(10, 0, "", 0, 1, 'C');
        $this->Ln(5);

        $this->ln(8);
        $this->SetXY(2, 48);
        $this->SetFont('Times', 'BU', 10);
        $this->ln();
        $this->Cell(0, 0, '', 'B', 'L');
        $this->ln();
        $this->Cell(0, 0, '', 'B', 'L');


        $this->Ln(7);
        // $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(170, 170, 170); //gray
        $this->SetTextColor(0, 0, 0);
        $this->Cell(10, 7, 'Sno', '1', 0, 'L', 1);
        $this->Cell(40, 7, 'X-CONSIGNEE NAME ', 1, 0, 'L', 1);
        $this->Cell(20, 7, 'MOBILE NO. ', 1, 0, 'L', 1);
        $this->Cell(30, 7, 'ADDRESS', 1, 0, 'L', 1);
         $this->Cell(50, 7, 'OPENING BALANCE', 1, 0, 'L', 1);
        $this->Cell(40, 7, 'OPENING BALANCE DATE', 1, 1, 'L', 1);


        $this->SetWidths(array(10, 40, 20,30,50,40));
        $this->SetAligns(array("L", "L", "L","L","L","L"));
    }
    // Page footer
    function Footer()
    {
        global $comp_name;
        // Position at 1.5 cm from bottom
        $this->SetY(-11);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->SetX(5);
        $this->MultiCell(200, 5, '|| Developed By Chaaruvi Infotech Raipur, Contact us- +91-8871181890,Visit us- www.chaaruvi.com ||', 0, 'C');
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
$title2 = "Trans Book";
$pdf->SetTitle($title2);


$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4');



$slno = 1;
$sql = mysqli_query($connection, "select * from m_x_consignee");
while ($row_get = mysqli_fetch_array($sql)) {
    // $pdf->SetX(5);
    $opn_balnc_date=dateformatindia($row_get['opn_balnc_date']);
    $pdf->Row(array($slno++, $row_get['xconsignee_name'], $row_get['mobile_no'],$row_get['xconsignee_address'],$row_get['opn_balnc'],$opn_balnc_date));
}
$pdf->Output();
?> 
                          	
<?php
mysqli_close($db_link);

?>
