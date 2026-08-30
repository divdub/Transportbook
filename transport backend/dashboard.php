<?php
include("adminsession.php");
$currentTimestamp = time();

// Get current date in a specific format (e.g., YYYY-MM-DD)
$currentDate = date('d-m-Y', $currentTimestamp);
$todate = date('Y-m-d');
// Get current time in a specific format (e.g., HH:MM:SS)
$currentTime = date('H:i:s', $currentTimestamp);

// Get current day of the week (e.g., Monday, Tuesday, etc.)
$currentDay = date('l', $currentTimestamp);

$bilty = $cmn->getvalfield($connection, "dispatch_entry", "count(dispatch_id)", "bilty_date='$currentdate' && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");
$todaybiltywtmt = $cmn->getvalfield($connection, "dispatch_entry", "sum(wt_mt)", "bilty_date='$currentdate' && consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");
$totalbilty = $cmn->getvalfield($connection, "dispatch_entry", "count(dispatch_id)", "consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");
$totalbiltywt = $cmn->getvalfield($connection, "dispatch_entry", "sum(wt_mt)", "consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");

$paycash_adv = $cmn->getvalfield($connection, "payment", "sum(cash_adv)", "consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id && is_paid=1");
$paydiesel_adv_amt = $cmn->getvalfield($connection, "payment", "sum(diesel_adv_amt)", "consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id && is_paid=1");

$cashadv = $cmn->getvalfield($connection, "dispatch_entry", "sum(cash_adv)", "consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");
$dieseladvamt = $cmn->getvalfield($connection, "dispatch_entry", "sum(diesel_adv_amt)", "consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id");
$receive_amt = $cmn->getvalfield($connection, "payment_receive", "sum(receive_amt)", "consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
$cash_adv = $cashadv - $paycash_adv;
$diesel_adv_amt = $dieseladvamt - $paydiesel_adv_amt;
$open_bal_date = $cmn->getvalfield($connection, "account_setting", "open_bal_date", "consignorid=$consignorid");
$prevbalance = $cmn->getcashopeningplant($connection, $currentdate, $comp_id, $consignorid, $session_id);
$incomeamount = $cmn->getvalfield($connection, "othr_inc_entry", "sum(amount)", "consignorid=$consignorid && session_id=$session_id && amount!=0 && inc_date='$currentdate'");
$expamount = $cmn->getvalfield($connection, "other_expense_entry", "sum(amount)", "consignorid=$consignorid && session_id=$session_id && amount!=0 && exp_date='$currentdate'");
$netadv = $cmn->getvalfield($connection, "dispatch_entry", "sum(cash_adv)", "consignor_id=$consignorid && session_id=$session_id and (cash_adv !=0) and cash_adv_date !=0 && cash_adv_date='$currentdate'");
$balamt = $prevbalance + $incomeamount - $netadv - $expamount;
// $balamt= $incomeamount;
// $dpaycount=$cmn->getvalfield($connection,"dieselbill","count(dbillid)","consignorid=$consignorid && sessionid=$session_id and  is_pay='0'"); 
$dpayc = 0;
$tdpayamt = 0;
$sqlq = mysqli_query($connection, "Select * from  dieselbill   where consignorid=$consignorid && is_pay=0 && sessionid=$session_id  order by dbillid desc");
while ($rowq = mysqli_fetch_array($sqlq)) {

    $dpayamt = $cmn->getvalfield($connection, "dispatch_entry", "sum(diesel_adv_amt)", "consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id && dbillid='$rowq[dbillid]'");
    $tdpayamt += $dpayamt;
    $dpayc++;
}
$prec = $cmn->getvalfield($connection, "dispatch_entry", "count(dispatch_id)", "consignor_id=$consignorid && session_id=$session_id and (is_receive =0) ");
$pinvoice = $cmn->getvalfield($connection, "dispatch_entry", "count(dispatch_id)", "consignor_id=$consignorid && session_id=$session_id and (is_invoice =0) ");
$pinvoiceamt = $cmn->getvalfield($connection, "dispatch_entry", "sum(wt_mt*comp_rate)", "consignor_id=$consignorid && session_id=$session_id and (is_invoice =0) ");
$ipayc = 0;
$tipayamt = 0;
$sqlq1 = mysqli_query($connection, "Select * from  invoicebilty   where consignorid=$consignorid && is_pay=0 && sessionid=$session_id  order by invoiceid desc");
while ($rowq1 = mysqli_fetch_array($sqlq1)) {
    $ipayamt = $cmn->getinvoiceamount1($connection, $rowq1['invoiceid']);
    $tipayamt += $ipayamt;
    $ipayc++;
}
$dbill = $cmn->getvalfield($connection, "dispatch_entry", "sum(diesel_adv_amt)", "consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id && dbillid=0");
$dbillc = $cmn->getvalfield($connection, "dispatch_entry", "count(dispatch_id)", "consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id && dbillid=0");
$voucherc = $cmn->getvalfield($connection, "dispatch_entry", "count(dispatch_id)", "consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id && is_voucher=0");
$voucheramt = $cmn->getvalfield($connection, "dispatch_entry", "sum(own_rate * wt_mt)", "consignor_id=$consignorid && comp_id=$comp_id && session_id=$session_id && is_voucher=0");
$vpayamt = $cmn->getvalfield($connection, "payment", "sum(amt_paid_to)", "consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id && is_paid=0");
$vpayc = $cmn->getvalfield($connection, "payment", "count(payment_id)", "consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id && is_paid=0 GROUP BY voucher_id");
$formdate = $cmn->getvalfield($connection, "m_session", "session_start", "  session_id='$session_id'");
$biltymonth = $cmn->getvalfield(
    $connection,
    "dispatch_entry",
    "count(dispatch_id)",
    "bilty_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND created_date <= LAST_DAY(CURDATE())  AND consignor_id = $consignorid AND comp_id = $comp_id AND session_id = $session_id"
);

$biltysunmonth = $cmn->getvalfield(
    $connection,
    "dispatch_entry",
    "sum(wt_mt)",
    "bilty_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01') AND created_date <= LAST_DAY(CURDATE())  AND consignor_id = $consignorid AND comp_id = $comp_id AND session_id = $session_id"
);

$total_rcamt = 0;
$pay_sql = mysqli_query($connection, "SELECT voucher_id FROM payment  WHERE consignorid = $consignorid AND comp_id = $comp_id AND session_id = $session_id AND is_paid = 0 GROUP BY voucher_id");

while ($row_get = mysqli_fetch_array($pay_sql)) {
    $voucher_no = $row_get['voucher_id'];
    $to_rcamt = $cmn->getvalfield($connection, "payment_receive", "sum(receive_amt)", "voucher_no='$voucher_no' && consignorid=$consignorid && comp_id=$comp_id && session_id=$session_id");
    $total_rcamt += $to_rcamt;
}
$bal_amt = $vpayamt - $total_rcamt;

?>
<!doctype html>
<html>



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- Apple devices fullscreen -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Apple devices fullscreen -->
    <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <title>TRANS BOOK :: CHAARUVI INFOTECH PVT. LTD.</title>

    <?php include("inc/top-files.php"); ?>

    <!-- DASHBOARD FULL DARK THEME -->
    <style>
        /* ── Outer Layout (Ocean Blue Gradient) ── */
        body {
            background: linear-gradient(145deg, #0a3d6b 0%, #0b2e52 50%, #072040 100%) !important;
        }

        #content {
            background: linear-gradient(145deg, #0a3d6b 0%, #0b2e52 50%, #072040 100%) !important;
        }

        #main {
            background: linear-gradient(145deg, #0f4c75 0%, #0d3b66 50%, #0a2d50 100%) !important;
        }

        #left {
            background: linear-gradient(180deg, #0b2e52 0%, #072040 100%) !important;
        }

        #left .subnav .subnav-title .toggle-subnav {
            color: #b0b0b0 !important;
        }

        #left .subnav .subnav-title .toggle-subnav:hover {
            color: #e0e0e0 !important;
        }

        #left .subnav .subnav-menu>li>a {
            color: #b0b0b0 !important;
        }

        #left .subnav .subnav-menu>li>a:hover {
            background: #1a2d3d !important;
            color: #fff !important;
        }

        #left .subnav .subnav-menu>li.active>a {
            background: #1a2d3d !important;
            color: #fff !important;
        }

        #main .page-header .pull-left h3 {
            color: #e0e0e0 !important;
        }

        #main .page-header .pull-left h6 {
            color: #90a0b0 !important;
        }

        #main .breadcrumbs {
            background: #1a2d3d !important;
        }

        #main .breadcrumbs ul>li {
            color: #b0b0b0 !important;
        }

        #main .breadcrumbs ul>li>a {
            color: #b0b0b0 !important;
        }

        #navigation,
        #navigation .container-fluid {
            background: linear-gradient(90deg, #1a4872 0%, #172554 45%, #1e3a8a 100%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
            box-shadow: 0 6px 18px rgba(2, 6, 23, 0.45);
        }

        #navigation #brand {
            color: #f8fafc !important;
            font-weight: 700;
        }

        #navigation .main-nav>li>a {
            color: rgba(235, 240, 250, 0.95) !important;
        }

        #navigation .main-nav>li.active>a {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.02));
            color: #fff !important;
        }

        #navigation .main-nav>li.active>a:hover {
            background: #1e74c5 !important;
            color: #fff !important;
        }

        #navigation .toggle-nav {
            color: rgba(235, 240, 250, 0.9) !important;
        }

        #footer {
            background: #0a121a !important;
        }

        #footer p {
            color: #b0b0b0 !important;
        }

        /* ═══════════════════════════════════════════════
   KPI DASHBOARD CARDS — Premium Dark / Glassmorphism
   ═══════════════════════════════════════════════ */

        /* ── Card Row ── */
        .kpi-row {
            margin: 18px -8px 30px -8px;
        }

        .kpi-row>[class*="col-"] {
            padding: 0 8px;
            margin-bottom: 18px;
        }

        /* ── Card Base ── */
        .kpi-card {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            position: relative;
            background: rgba(15, 23, 42, 0.25);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 20px 18px;
            min-height: 140px;
            height: auto;
            width: 100%;
            text-decoration: none !important;
            color: #fff !important;
            overflow: hidden;
            backdrop-filter: blur(32px) saturate(250%);
            -webkit-backdrop-filter: blur(32px) saturate(250%);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                0 8px 32px rgba(2, 6, 23, 0.50);
            transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            cursor: pointer;
        }

        .kpi-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 14px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0.06) 40%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            text-decoration: none;
            color: #fff !important;
        }

        /* ── Per-Card Glowing Glass Styles & Hover — Matching QA Icon Backgrounds Exactly ── */

        /* 1 — Like QA #1 (Dispatch) #1e3a5f → #0f172a — Blue  */
        .kpi-today-bilty {
            background: linear-gradient(135deg, #1e3a5f, #0f172a) !important;
            border-color: rgba(59, 130, 246, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.12), inset 0 1px 0 rgba(59, 130, 246, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-today-bilty:hover {
            box-shadow: 0 8px 35px rgba(59, 130, 246, 0.40), 0 0 0 1px rgba(59, 130, 246, 0.60), inset 0 1px 0 rgba(59, 130, 246, 0.25);
        }

        /* 2 — Like QA #4 (Account) #3b1e5f → #0f172a — Purple  */
        .kpi-month-bilty {
            background: linear-gradient(135deg, #3b1e5f, #0f172a) !important;
            border-color: rgba(168, 85, 247, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(168, 85, 247, 0.12), inset 0 1px 0 rgba(168, 85, 247, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-month-bilty:hover {
            box-shadow: 0 8px 35px rgba(168, 85, 247, 0.40), 0 0 0 1px rgba(168, 85, 247, 0.60), inset 0 1px 0 rgba(168, 85, 247, 0.25);
        }

        /* 3 — Like QA #11 (Sale) #1e5f2e → #0f172a — Green  */
        .kpi-total-bilty {
            background: linear-gradient(135deg, #1e5f2e, #0f172a) !important;
            border-color: rgba(34, 197, 94, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(34, 197, 94, 0.12), inset 0 1px 0 rgba(34, 197, 94, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-total-bilty:hover {
            box-shadow: 0 8px 35px rgba(34, 197, 94, 0.40), 0 0 0 1px rgba(34, 197, 94, 0.60), inset 0 1px 0 rgba(34, 197, 94, 0.25);
        }

        /* 4 — Like QA #3 (Document) #1e5f5e → #0f172a — Cyan  */
        .kpi-cash-adv {
            background: linear-gradient(135deg, #1e5f5e, #0f172a) !important;
            border-color: rgba(6, 182, 212, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(6, 182, 212, 0.12), inset 0 1px 0 rgba(6, 182, 212, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-cash-adv:hover {
            box-shadow: 0 8px 35px rgba(6, 182, 212, 0.40), 0 0 0 1px rgba(6, 182, 212, 0.60), inset 0 1px 0 rgba(6, 182, 212, 0.25);
        }

        /* 5 — Like QA #2 (Payment) #5f1e1e → #0f172a — Red  */
        .kpi-diesel-adv {
            background: linear-gradient(135deg, #5f1e1e, #0f172a) !important;
            border-color: rgba(239, 68, 68, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(239, 68, 68, 0.12), inset 0 1px 0 rgba(239, 68, 68, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-diesel-adv:hover {
            box-shadow: 0 8px 35px rgba(239, 68, 68, 0.40), 0 0 0 1px rgba(239, 68, 68, 0.60), inset 0 1px 0 rgba(239, 68, 68, 0.25);
        }

        /* 6 — Like QA #6 (Billing) #1e3e5f → #0f172a — Sky Blue  */
        .kpi-bilty-pay {
            background: linear-gradient(135deg, #1e3e5f, #0f172a) !important;
            border-color: rgba(14, 165, 233, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(14, 165, 233, 0.12), inset 0 1px 0 rgba(14, 165, 233, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-bilty-pay:hover {
            box-shadow: 0 8px 35px rgba(14, 165, 233, 0.40), 0 0 0 1px rgba(14, 165, 233, 0.60), inset 0 1px 0 rgba(14, 165, 233, 0.25);
        }

        /* 7 — Like QA #7 (Cash Book) #1e2e5f → #0f172a — Blue  */
        .kpi-co-pending {
            background: linear-gradient(135deg, #1e2e5f, #0f172a) !important;
            border-color: rgba(37, 99, 235, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.12), inset 0 1px 0 rgba(37, 99, 235, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-co-pending:hover {
            box-shadow: 0 8px 35px rgba(37, 99, 235, 0.40), 0 0 0 1px rgba(37, 99, 235, 0.60), inset 0 1px 0 rgba(37, 99, 235, 0.25);
        }

        /* 8 — Like QA #8 (Payroll) #5f531e → #0f172a — Gold  */
        .kpi-co-pay-pending {
            background: linear-gradient(135deg, #5f531e, #0f172a) !important;
            border-color: rgba(234, 179, 8, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(234, 179, 8, 0.12), inset 0 1px 0 rgba(234, 179, 8, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-co-pay-pending:hover {
            box-shadow: 0 8px 35px rgba(234, 179, 8, 0.40), 0 0 0 1px rgba(234, 179, 8, 0.60), inset 0 1px 0 rgba(234, 179, 8, 0.25);
        }

        /* 9 — Like QA #5 (Maintenance) #5f3a1e → #0f172a — Orange  */
        .kpi-pending-rec {
            background: linear-gradient(135deg, #5f3a1e, #0f172a) !important;
            border-color: rgba(249, 115, 22, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(249, 115, 22, 0.12), inset 0 1px 0 rgba(249, 115, 22, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-pending-rec:hover {
            box-shadow: 0 8px 35px rgba(249, 115, 22, 0.40), 0 0 0 1px rgba(249, 115, 22, 0.60), inset 0 1px 0 rgba(249, 115, 22, 0.25);
        }

        /* 10 — Like QA #12 (Item Issue) #1e5f4e → #0f172a — Teal  */
        .kpi-pending-diesel {
            background: linear-gradient(135deg, #1e5f4e, #0f172a) !important;
            border-color: rgba(20, 184, 166, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(20, 184, 166, 0.12), inset 0 1px 0 rgba(20, 184, 166, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-pending-diesel:hover {
            box-shadow: 0 8px 35px rgba(20, 184, 166, 0.40), 0 0 0 1px rgba(20, 184, 166, 0.60), inset 0 1px 0 rgba(20, 184, 166, 0.25);
        }

        /* 11 — Like QA #9 (Inventory) #2e1e5f → #0f172a — Indigo  */
        .kpi-pending-diesel-pay {
            background: linear-gradient(135deg, #2e1e5f, #0f172a) !important;
            border-color: rgba(99, 102, 241, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(99, 102, 241, 0.12), inset 0 1px 0 rgba(99, 102, 241, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-pending-diesel-pay:hover {
            box-shadow: 0 8px 35px rgba(99, 102, 241, 0.40), 0 0 0 1px rgba(99, 102, 241, 0.60), inset 0 1px 0 rgba(99, 102, 241, 0.25);
        }

        /* 12 — Like QA #10 (Purchase) #5f1e4e → #0f172a — Magenta  */
        .kpi-pending-voucher {
            background: linear-gradient(135deg, #5f1e4e, #0f172a) !important;
            border-color: rgba(217, 70, 239, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(217, 70, 239, 0.12), inset 0 1px 0 rgba(217, 70, 239, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-pending-voucher:hover {
            box-shadow: 0 8px 35px rgba(217, 70, 239, 0.40), 0 0 0 1px rgba(217, 70, 239, 0.60), inset 0 1px 0 rgba(217, 70, 239, 0.25);
        }

        /* 13 — Like QA #13 (Tyre Issue) #5f2e1e → #0f172a — Orange  */
        .kpi-owner-pending {
            background: linear-gradient(135deg, #5f2e1e, #0f172a) !important;
            border-color: rgba(249, 115, 22, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(249, 115, 22, 0.12), inset 0 1px 0 rgba(249, 115, 22, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-owner-pending:hover {
            box-shadow: 0 8px 35px rgba(249, 115, 22, 0.40), 0 0 0 1px rgba(249, 115, 22, 0.60), inset 0 1px 0 rgba(249, 115, 22, 0.25);
        }

        /* 14 — Truck Owner Receive Payment — Blue/Indigo */
        .kpi-total-rcamt {
            background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;
            border-color: rgba(59, 130, 246, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(59, 130, 246, 0.12), inset 0 1px 0 rgba(59, 130, 246, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-total-rcamt:hover {
            box-shadow: 0 8px 35px rgba(59, 130, 246, 0.40), 0 0 0 1px rgba(59, 130, 246, 0.60), inset 0 1px 0 rgba(59, 130, 246, 0.25);
        }

        /* 15 — Truck Owner Balance Amount — Teal */
        .kpi-bal-amt {
            background: linear-gradient(135deg, #766f0f, #0f172a) !important;
            border-color: rgba(184, 162, 20, 0.55) !important;
            box-shadow: 0 0 0 1px rgba(154, 184, 20, 0.12), inset 0 1px 0 rgba(20, 184, 166, 0.18), 0 8px 32px rgba(2, 6, 23, 0.50);
        }

        .kpi-bal-amt:hover {
            box-shadow: 0 8px 35px rgba(179, 184, 20, 0.4), 0 0 0 1px rgba(179, 184, 20, 0.6), inset 0 1px 0 rgba(157, 184, 20, 0.25);
        }

        /* ── Icon Circle ── */
        .kpi-icon-wrap {
            flex: 0 0 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .kpi-icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            position: relative;
            flex-shrink: 0;
        }

        .kpi-icon-circle i {
            font-size: 20px;
            color: #fff;
            position: relative;
            z-index: 2;
        }

        /* Per-card icon circle gradients */
        .kpi-today-bilty .kpi-icon-circle {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.4);
        }

        .kpi-month-bilty .kpi-icon-circle {
            background: linear-gradient(135deg, #6b21a8, #a855f7);
            box-shadow: 0 0 10px rgba(168, 85, 247, 0.4);
        }

        .kpi-total-bilty .kpi-icon-circle {
            background: linear-gradient(135deg, #15803d, #22c55e);
            box-shadow: 0 0 10px rgba(34, 197, 94, 0.4);
        }

        .kpi-cash-adv .kpi-icon-circle {
            background: linear-gradient(135deg, #0e7490, #06b6d4);
            box-shadow: 0 0 10px rgba(6, 182, 212, 0.4);
        }

        .kpi-diesel-adv .kpi-icon-circle {
            background: linear-gradient(135deg, #b91c1c, #ef4444);
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);
        }

        .kpi-bilty-pay .kpi-icon-circle {
            background: linear-gradient(135deg, #047857, #10b981);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
        }

        .kpi-co-pending .kpi-icon-circle {
            background: linear-gradient(135deg, #1e3a5f, #2563eb);
            box-shadow: 0 0 10px rgba(37, 99, 235, 0.4);
        }

        .kpi-co-pay-pending .kpi-icon-circle {
            background: linear-gradient(135deg, #065f46, #10b981);
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
        }

        .kpi-pending-rec .kpi-icon-circle {
            background: linear-gradient(135deg, #9a3412, #f97316);
            box-shadow: 0 0 10px rgba(249, 115, 22, 0.4);
        }

        .kpi-pending-diesel .kpi-icon-circle {
            background: linear-gradient(135deg, #115e59, #14b8a6);
            box-shadow: 0 0 10px rgba(20, 184, 166, 0.4);
        }

        .kpi-pending-diesel-pay .kpi-icon-circle {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.4);
        }

        .kpi-pending-voucher .kpi-icon-circle {
            background: linear-gradient(135deg, #6b21a8, #a855f7);
            box-shadow: 0 0 10px rgba(168, 85, 247, 0.4);
        }

        .kpi-owner-pending .kpi-icon-circle {
            background: linear-gradient(135deg, #9d174d, #ec4899);
            box-shadow: 0 0 10px rgba(236, 72, 153, 0.4);
        }

        .kpi-total-rcamt .kpi-icon-circle {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.4);
        }

        .kpi-bal-amt .kpi-icon-circle {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            box-shadow: 0 0 10px rgba(20, 184, 166, 0.4);
        }

        /* ── Body (Value + Title) ── */
        .kpi-body {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .kpi-value {
            font-size: 26px;
            font-weight: 700;
            line-height: 1.1;
            color: #fff;
            letter-spacing: -0.02em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .kpi-title {
            font-size: 15px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.72);
            margin-top: 2px;
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ── Description (bottom full-width) ── */
        .kpi-desc {
            width: 100%;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.58);
            margin-top: 5px;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ── Badge (top-right pill) ── */
        .kpi-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 20px;
            line-height: 1.4;
            border: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 3;
        }

        /* ── Sparkline (bottom-right SVG) ── */
        .kpi-sparkline {
            position: absolute;
            bottom: 12px;
            right: 14px;
            width: 44px;
            height: 16px;
            opacity: 0.25;
            z-index: 1;
            pointer-events: none;
        }

        .kpi-sparkline polyline,
        .kpi-sparkline path {
            fill: none;
            stroke: rgba(255, 255, 255, 0.5);
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ── 5 columns per row (20% width) for all screen sizes ── */
        .col-lg-2-4,
        .col-md-2-4,
        .col-sm-2-4,
        .col-xs-2-4 {
            position: relative;
            min-height: 1px;
            padding-left: 8px;
            padding-right: 8px;
            float: left;
            width: 20%;
        }

        @media (max-width: 1199px) and (min-width: 992px) {
            .kpi-card {
                min-height: 130px;
                padding: 16px;
            }

            .kpi-value {
                font-size: 22px;
            }

            .kpi-icon-wrap {
                margin-right: 10px;
            }

            .kpi-icon-circle {
                width: 46px;
                height: 46px;
                font-size: 17px;
            }

            .kpi-icon-circle i {
                font-size: 17px;
            }
        }

        @media (max-width: 991px) and (min-width: 768px) {
            .kpi-card {
                min-height: 130px;
                padding: 14px;
            }

            .kpi-value {
                font-size: 20px;
            }

            .kpi-title {
                font-size: 11px;
            }

            .kpi-icon-wrap {
                margin-right: 8px;
            }

            .kpi-icon-circle {
                width: 42px;
                height: 42px;
                font-size: 16px;
            }

            .kpi-icon-circle i {
                font-size: 16px;
            }
        }

        @media (max-width: 767px) {
            .kpi-card {
                min-height: 120px;
                padding: 12px;
            }

            .kpi-value {
                font-size: 18px;
            }

            .kpi-title {
                font-size: 10px;
            }

            .kpi-icon-wrap {
                margin-right: 8px;
            }

            .kpi-icon-circle {
                width: 38px;
                height: 38px;
                font-size: 14px;
            }

            .kpi-icon-circle i {
                font-size: 14px;
            }

            .kpi-desc {
                font-size: 10px;
            }

            .kpi-sparkline {
                width: 36px;
                height: 12px;
                bottom: 8px;
                right: 10px;
            }
        }

        /* ── Box Containers (Dashboard) ── */
        .box {
            background: #1a2d3d !important;
            border-radius: 10px !important;
        }

        .box .box-title {
            background: #0f1923 !important;
            border-bottom: 1px solid #2a4055 !important;
            border-radius: 10px 10px 0 0 !important;
            margin-top: 0 !important;
        }

        .box .box-title h3 {
            color: #e0e0e0 !important;
        }

        .box .box-title .actions>a {
            color: #90a0b0 !important;
        }

        .box .box-title .actions>a:hover {
            background: #2a4055 !important;
            color: #fff !important;
        }

        .box .box-content {
            background: #0f1a2a !important;
            border-radius: 0 0 10px 10px !important;
        }

        .box.box-bordered .box-title {
            border-color: #2a4055 !important;
        }

        .box.box-bordered .box-content {
            border-color: #2a4055 !important;
            border-top: 0 !important;
        }

        /* ── Tables inside Dashboard ── */
        .table {
            background: #0f1a2a !important;
            color: #d0d8e0 !important;
        }

        .table thead th {
            background: #0a121f !important;
            color: #f1f5f9 !important;
            font-weight: 700 !important;
            font-size: 13px;
            border-bottom: 2px solid #3b82f6 !important;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .table tbody td {
            border-top: 1px solid #1e3044 !important;
            color: #d0d8e0 !important;
        }

        .table tbody tr:hover>td {
            background: #1a2a40 !important;
        }

        .table tbody tr:nth-child(odd) td {
            background: #0d1828 !important;
        }

        .table tbody tr:nth-child(even) td {
            background: #101d30 !important;
        }

        .table tbody tr:hover td {
            background: #1e3045 !important;
        }

        .table-bordered {
            border: 1px solid #2a4055 !important;
        }

        .table-bordered th,
        .table-bordered td {
            border-left: 1px solid #2a4055 !important;
        }

        /* ═══════════════════════════════════════════════
   QUICK ACCESS — Premium Futuristic Glassmorphism
   ═══════════════════════════════════════════════ */

        /* ── Grid ── */
        .quick-access-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(92px, 1fr));
            gap: 12px 14px;
            padding: 8px 4px 6px;
            align-items: stretch;
            justify-items: center;
            max-width: 100%;
            margin: 0;
            background: transparent;
            border: 0;
            border-radius: 0;
            box-shadow: none;
        }

        /* ── Card (minimal - no outer box) ── */
        .qa-item {
            width: 100%;
            max-width: 108px;
            min-height: auto;
            aspect-ratio: auto;
            background: transparent !important;
            border: none !important;
            border-radius: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            text-decoration: none !important;
            position: relative;
            overflow: visible;
            cursor: pointer;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            box-shadow: none !important;
            padding: 4px 0;
        }

        /* ── Remove glass border gradient ── */
        .qa-item::before {
            display: none !important;
        }

        /* ── Link ── */
        .qa-item>a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            text-decoration: none !important;
            position: relative;
            z-index: 1;
            gap: 6px;
        }

        /* ── Icon (larger with neon glow) ── */
        .qa-item img {
            width: 48px;
            height: 48px;
            padding: 12px;
            border-radius: 18px;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: none;
            object-fit: contain;
            box-sizing: content-box;
            transition: all 0.35s ease;
            filter: none;
        }

        /* ── Module Name ── */
        .qa-item h5 {
            color: rgba(255, 255, 255, 0.75) !important;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            margin: 0;
            line-height: 1.2;
            letter-spacing: 0.01em;
        }

        /* ═══════════════════════════════════════════════
   PER-CARD NEON GLOW COLORS (14 modules) — ON ICON ONLY
   ═══════════════════════════════════════════════ */

        /* 1  — Dispatch   → Blue       */
        .qa-item:nth-child(14n+1) img {
            background: linear-gradient(135deg, #1e3a5f, #0f172a) !important;
            border-color: rgba(59, 130, 246, 0.5) !important;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.35), 0 0 40px rgba(59, 130, 246, 0.15), inset 0 0 10px rgba(59, 130, 246, 0.08) !important;
        }

        /* 2  — Payment   → Red        */
        .qa-item:nth-child(14n+2) img {
            background: linear-gradient(135deg, #5f1e1e, #0f172a) !important;
            border-color: rgba(239, 68, 68, 0.5) !important;
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.35), 0 0 40px rgba(239, 68, 68, 0.15), inset 0 0 10px rgba(239, 68, 68, 0.08) !important;
        }

        /* 3  — Document  → Cyan       */
        .qa-item:nth-child(14n+3) img {
            background: linear-gradient(135deg, #1e5f5e, #0f172a) !important;
            border-color: rgba(6, 182, 212, 0.5) !important;
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.35), 0 0 40px rgba(6, 182, 212, 0.15), inset 0 0 10px rgba(6, 182, 212, 0.08) !important;
        }

        /* 4  — Account   → Purple     */
        .qa-item:nth-child(14n+4) img {
            background: linear-gradient(135deg, #3b1e5f, #0f172a) !important;
            border-color: rgba(168, 85, 247, 0.5) !important;
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.35), 0 0 40px rgba(168, 85, 247, 0.15), inset 0 0 10px rgba(168, 85, 247, 0.08) !important;
        }

        /* 5  — Maintenance → Orange   */
        .qa-item:nth-child(14n+5) img {
            background: linear-gradient(135deg, #5f3a1e, #0f172a) !important;
            border-color: rgba(249, 115, 22, 0.5) !important;
            box-shadow: 0 0 20px rgba(249, 115, 22, 0.35), 0 0 40px rgba(249, 115, 22, 0.15), inset 0 0 10px rgba(249, 115, 22, 0.08) !important;
        }

        /* 6  — Billing   → Sky Blue   */
        .qa-item:nth-child(14n+6) img {
            background: linear-gradient(135deg, #1e3e5f, #0f172a) !important;
            border-color: rgba(14, 165, 233, 0.5) !important;
            box-shadow: 0 0 20px rgba(14, 165, 233, 0.35), 0 0 40px rgba(14, 165, 233, 0.15), inset 0 0 10px rgba(14, 165, 233, 0.08) !important;
        }

        /* 7  — Cash Book → Blue       */
        .qa-item:nth-child(14n+7) img {
            background: linear-gradient(135deg, #1e2e5f, #0f172a) !important;
            border-color: rgba(37, 99, 235, 0.5) !important;
            box-shadow: 0 0 20px rgba(37, 99, 235, 0.35), 0 0 40px rgba(37, 99, 235, 0.15), inset 0 0 10px rgba(37, 99, 235, 0.08) !important;
        }

        /* 8  — Payroll   → Gold       */
        .qa-item:nth-child(14n+8) img {
            background: linear-gradient(135deg, #5f531e, #0f172a) !important;
            border-color: rgba(234, 179, 8, 0.5) !important;
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.35), 0 0 40px rgba(234, 179, 8, 0.15), inset 0 0 10px rgba(234, 179, 8, 0.08) !important;
        }

        /* 9  — Inventory → Indigo     */
        .qa-item:nth-child(14n+9) img {
            background: linear-gradient(135deg, #2e1e5f, #0f172a) !important;
            border-color: rgba(99, 102, 241, 0.5) !important;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.35), 0 0 40px rgba(99, 102, 241, 0.15), inset 0 0 10px rgba(99, 102, 241, 0.08) !important;
        }

        /* 10 — Purchase  → Magenta    */
        .qa-item:nth-child(14n+10) img {
            background: linear-gradient(135deg, #5f1e4e, #0f172a) !important;
            border-color: rgba(217, 70, 239, 0.5) !important;
            box-shadow: 0 0 20px rgba(217, 70, 239, 0.35), 0 0 40px rgba(217, 70, 239, 0.15), inset 0 0 10px rgba(217, 70, 239, 0.08) !important;
        }

        /* 11 — Sale      → Green      */
        .qa-item:nth-child(14n+11) img {
            background: linear-gradient(135deg, #1e5f2e, #0f172a) !important;
            border-color: rgba(34, 197, 94, 0.5) !important;
            box-shadow: 0 0 20px rgba(34, 197, 94, 0.35), 0 0 40px rgba(34, 197, 94, 0.15), inset 0 0 10px rgba(34, 197, 94, 0.08) !important;
        }

        /* 12 — Item Issue → Teal      */
        .qa-item:nth-child(14n+12) img {
            background: linear-gradient(135deg, #1e5f4e, #0f172a) !important;
            border-color: rgba(20, 184, 166, 0.5) !important;
            box-shadow: 0 0 20px rgba(20, 184, 166, 0.35), 0 0 40px rgba(20, 184, 166, 0.15), inset 0 0 10px rgba(20, 184, 166, 0.08) !important;
        }

        /* 13 — Tyre Issue → Orange    */
        .qa-item:nth-child(14n+13) img {
            background: linear-gradient(135deg, #5f2e1e, #0f172a) !important;
            border-color: rgba(249, 115, 22, 0.5) !important;
            box-shadow: 0 0 20px rgba(249, 115, 22, 0.35), 0 0 40px rgba(249, 115, 22, 0.15), inset 0 0 10px rgba(249, 115, 22, 0.08) !important;
        }

        /* 14 — Yard Report → Blue     */
        .qa-item:nth-child(14n+14) img {
            background: linear-gradient(135deg, #1e3a5f, #0f172a) !important;
            border-color: rgba(59, 130, 246, 0.5) !important;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.35), 0 0 40px rgba(59, 130, 246, 0.15), inset 0 0 10px rgba(59, 130, 246, 0.08) !important;
        }

        /* ═══════════════════════════════════════════════
   WEEKLY PERFORMANCE CHART — Premium CSS Bar Chart
   ═══════════════════════════════════════════════ */
        .kpi-chart-col {
            padding: 0 8px;
            margin-bottom: 18px;
        }

        .kpi-chart-wrap {
            position: relative;
            background: linear-gradient(145deg, rgba(12, 20, 35, 0.55), rgba(15, 23, 42, 0.45));
            border: 1.5px solid rgba(59, 130, 246, 0.40);
            border-radius: 16px;
            padding: 18px 18px 14px;
            height: 290px;
            width: 100%;
            backdrop-filter: blur(24px) saturate(220%);
            -webkit-backdrop-filter: blur(24px) saturate(220%);
            box-shadow:
                0 0 0 1px rgba(59, 130, 246, 0.10),
                inset 0 1px 0 rgba(255, 255, 255, 0.10),
                0 8px 32px rgba(2, 6, 23, 0.55);
            overflow: hidden;
            transition: all 0.40s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .kpi-chart-wrap:hover {
            border-color: rgba(59, 130, 246, 0.65);
            box-shadow:
                0 0 0 1px rgba(59, 130, 246, 0.20),
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                0 12px 40px rgba(2, 6, 23, 0.70),
                0 0 60px rgba(59, 130, 246, 0.10);
            transform: translateY(-2px);
        }

        /* ── Header ── */
        .kpi-chart-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .kpi-chart-title-group {
            display: flex;
            flex-direction: column;
        }

        .kpi-chart-title {
            font-size: 15px;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: 0.01em;
            line-height: 1.2;
        }

        .kpi-chart-subtitle {
            font-size: 11px;
            font-weight: 500;
            color: rgba(148, 163, 184, 0.75);
            margin-top: 1px;
            letter-spacing: 0.02em;
        }

        .kpi-chart-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            background: rgba(16, 185, 129, 0.18);
            border: 1px solid rgba(16, 185, 129, 0.35);
            border-radius: 20px;
            padding: 3px 10px 3px 8px;
            font-size: 11px;
            font-weight: 700;
            color: #34d399;
            line-height: 1.4;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            box-shadow: 0 0 12px rgba(16, 185, 129, 0.12);
            white-space: nowrap;
        }

        .kpi-chart-badge i {
            font-size: 9px;
        }

        /* ── Bar Chart Container ── */
        .kpi-bar-chart {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            height: calc(100% - 36px);
            width: 100%;
            gap: 6px;
            padding-top: 6px;
        }

        .kpi-bar-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            height: 100%;
            min-width: 0;
        }

        .kpi-bar-value {
            font-size: 11px;
            font-weight: 700;
            color: #e2e8f0;
            margin-bottom: 4px;
            line-height: 1;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        .kpi-bar-track {
            width: 100%;
            max-width: 32px;
            height: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            border-radius: 4px 4px 2px 2px;
            position: relative;
            background: rgba(15, 23, 42, 0.3);
            overflow: hidden;
        }

        .kpi-bar-fill {
            width: 100%;
            border-radius: 3px 3px 1px 1px;
            min-height: 4px;
            position: relative;
            transition: height 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.25);
        }

        .kpi-bar-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.18), transparent);
            border-radius: 3px 3px 0 0;
        }

        .kpi-bar-label {
            font-size: 9px;
            font-weight: 600;
            color: rgba(148, 163, 184, 0.7);
            margin-top: 5px;
            line-height: 1;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* ── Per-bar Gradient Colors ── */
        .kpi-bar-fill.color-blue {
            background: linear-gradient(180deg, #3b82f6, #1d4ed8);
        }

        .kpi-bar-fill.color-cyan {
            background: linear-gradient(180deg, #06b6d4, #0e7490);
        }

        .kpi-bar-fill.color-purple {
            background: linear-gradient(180deg, #a855f7, #7e22ce);
        }

        .kpi-bar-fill.color-green {
            background: linear-gradient(180deg, #22c55e, #15803d);
        }

        .kpi-bar-fill.color-orange {
            background: linear-gradient(180deg, #f97316, #c2410c);
        }

        .kpi-bar-fill.color-pink {
            background: linear-gradient(180deg, #ec4899, #be185d);
        }

        .kpi-bar-fill.color-indigo {
            background: linear-gradient(180deg, #6366f1, #4338ca);
        }

        /* ── Max Bar Glow ── */
        .kpi-bar-item.max .kpi-bar-fill {
            box-shadow: 0 0 18px rgba(59, 130, 246, 0.45), 0 0 40px rgba(59, 130, 246, 0.15);
        }

        .kpi-bar-item.max .kpi-bar-value {
            color: #60a5fa;
        }

        /* ── 40% width for chart column next to 3 KPI cards (3×20% = 60%) ── */
        .col-lg-4-10,
        .col-md-4-10,
        .col-sm-4-10,
        .col-xs-4-10 {
            position: relative;
            min-height: 1px;
            padding-left: 8px;
            padding-right: 8px;
            float: left;
            width: 40%;
        }

        @media (max-width: 1199px) and (min-width: 992px) {
            .kpi-chart-wrap {
                height: 270px;
                padding: 18px 18px 14px;
            }

            .kpi-chart-title {
                font-size: 14px;
            }
        }

        @media (max-width: 991px) and (min-width: 768px) {
            .kpi-chart-wrap {
                height: 260px;
                padding: 16px 16px 12px;
            }

            .kpi-chart-title {
                font-size: 13px;
            }

            .kpi-chart-subtitle {
                font-size: 10px;
            }

            .kpi-chart-badge {
                font-size: 10px;
                padding: 2px 8px;
            }
        }

        @media (max-width: 767px) {
            .col-xs-4-10 {
                width: 100%;
            }

            .kpi-chart-wrap {
                height: 280px;
                padding: 18px;
            }
        }

        /* ═══════════════════════════════════════════════
   BILTY TREND (MT) — Smooth Line Chart (SVG)
   ═══════════════════════════════════════════════ */
        .bilty-chart-wrap {
            height: 260px !important;
            padding: 10px 14px 6px !important;
        }

        .bilty-chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2px;
        }

        .bilty-chart-title-group {
            display: flex;
            flex-direction: column;
        }

        .bilty-chart-title {
            font-size: 13px;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: 0.01em;
            line-height: 1.3;
            font-family: Inter, Poppins, sans-serif;
        }

        .bilty-chart-dropdown {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: rgba(6, 50, 95, 0.76);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 20px;
            padding: 3px 10px 3px 12px;
            font-size: 11px;
            font-weight: 600;
            color: #e2e8f0;
            line-height: 1.5;
            cursor: pointer;
            white-space: nowrap;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            transition: all 0.2s;
        }

        .bilty-chart-dropdown i {
            font-size: 8px;
            color: rgba(255, 255, 255, 0.5);
        }

        .bilty-chart-dropdown:hover {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(255, 255, 255, 0.18);
        }

        .bilty-svg-container {
            width: 100%;
            height: calc(100% - 52px);
            position: relative;
            overflow: hidden;
        }

        .bilty-svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .bilty-line {
            stroke-dasharray: 2000;
            stroke-dashoffset: 2000;
            animation: biltyDraw 0.8s ease-out forwards;
        }

        .bilty-area {
            opacity: 0;
            animation: biltyFadeIn 1s ease-out 0.3s forwards;
        }

        .bilty-marker {
            opacity: 0;
            animation: biltyMarkerPop 0.4s ease-out forwards;
        }

        .bilty-marker:nth-child(1) {
            animation-delay: 0.0s;
        }

        .bilty-marker:nth-child(2) {
            animation-delay: 0.08s;
        }

        .bilty-marker:nth-child(3) {
            animation-delay: 0.15s;
        }

        .bilty-marker:nth-child(4) {
            animation-delay: 0.22s;
        }

        .bilty-marker:nth-child(5) {
            animation-delay: 0.28s;
        }

        .bilty-marker:nth-child(6) {
            animation-delay: 0.33s;
        }

        .bilty-marker:nth-child(7) {
            animation-delay: 0.37s;
        }

        .bilty-marker:nth-child(8) {
            animation-delay: 0.4s;
        }

        .bilty-marker:nth-child(9) {
            animation-delay: 0.42s;
        }

        .bilty-marker:nth-child(10) {
            animation-delay: 0.43s;
        }

        .bilty-marker:nth-child(11) {
            animation-delay: 0.44s;
        }

        .bilty-marker:nth-child(12) {
            animation-delay: 0.45s;
        }

        .bilty-marker:nth-child(13) {
            animation-delay: 0.46s;
        }

        .bilty-marker:nth-child(14) {
            animation-delay: 0.47s;
        }

        @keyframes biltyDraw {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes biltyFadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes biltyMarkerPop {
            0% {
                opacity: 0;
                transform: scale(0);
            }

            70% {
                transform: scale(1.15);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .bilty-chart-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0;
            padding-top: 2px;
        }

        .bilty-footer-total {
            font-size: 10px;
            font-weight: 600;
            color: #d6e3ff;
            font-family: Inter, Poppins, sans-serif;
            letter-spacing: 0.02em;
        }

        .bilty-footer-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            background: rgba(34, 197, 94, 0.18);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 20px;
            padding: 2px 9px 2px 7px;
            font-size: 10px;
            font-weight: 700;
            color: #4ade80;
            line-height: 1.4;
            white-space: nowrap;
        }

        .bilty-footer-badge i {
            font-size: 8px;
            color: #4ade80;
        }

        @media (max-width: 1199px) and (min-width: 992px) {
            .bilty-chart-wrap {
                height: 250px !important;
                padding: 10px 12px 6px !important;
            }

            .bilty-chart-title {
                font-size: 12px;
            }

            .bilty-chart-dropdown {
                font-size: 10px;
                padding: 2px 8px;
            }
        }

        @media (max-width: 991px) and (min-width: 768px) {
            .bilty-chart-wrap {
                height: 240px !important;
                padding: 10px 12px 6px !important;
            }

            .bilty-chart-title {
                font-size: 12px;
            }

            .bilty-chart-dropdown {
                font-size: 10px;
                padding: 2px 8px;
            }

            .bilty-footer-total {
                font-size: 9px;
            }

            .bilty-footer-badge {
                font-size: 9px;
            }
        }

        @media (max-width: 767px) {
            .bilty-chart-wrap {
                height: 260px !important;
                padding: 10px 14px 6px !important;
            }

            .bilty-chart-title {
                font-size: 14px;
            }
        }

        /* ═══════════════════════════════════════════════
   HOVER EFFECT — Glow Intensifies
   ═══════════════════════════════════════════════ */
        .qa-item:hover {
            transform: translateY(-3px) scale(1.04);
            border-color: transparent !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        .qa-item:hover img {
            transform: scale(1.10);
            filter: brightness(1.15);
        }

        .qa-item:hover h5 {
            color: #fff !important;
        }

        /* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
        @media (max-width: 1400px) {
            .quick-access-grid {
                grid-template-columns: repeat(6, minmax(90px, 1fr));
            }

            .qa-item {
                max-width: 100px;
            }

            .qa-item img {
                width: 42px;
                height: 42px;
                padding: 10px;
            }

            .qa-item h5 {
                font-size: 11px;
            }
        }

        @media (max-width: 1200px) {
            .quick-access-grid {
                grid-template-columns: repeat(5, minmax(88px, 1fr));
            }

            .qa-item {
                max-width: 96px;
            }

            .qa-item img {
                width: 40px;
                height: 40px;
                padding: 9px;
            }

            .qa-item h5 {
                font-size: 11px;
            }
        }

        @media (max-width: 768px) {
            .quick-access-grid {
                grid-template-columns: repeat(3, minmax(84px, 1fr));
                gap: 12px;
                padding: 16px;
            }

            .qa-item {
                max-width: 96px;
            }

            .qa-item img {
                width: 38px;
                height: 38px;
                padding: 9px;
            }

            .qa-item h5 {
                font-size: 10px;
            }
        }

        @media (max-width: 480px) {
            .quick-access-grid {
                grid-template-columns: repeat(2, minmax(88px, 1fr));
                gap: 10px;
                padding: 12px;
            }

            .qa-item {
                max-width: 90px;
            }

            .qa-item img {
                width: 36px;
                height: 36px;
                padding: 8px;
            }

            .qa-item h5 {
                font-size: 10px;
            }
        }

        /* ── Report Panel Styling (Bottom 2 panels) ── */
        .report-panel {
            border-radius: 14px !important;
            overflow: hidden;
        }

        .report-panel .box-title {
            padding: 14px 18px !important;
        }

        .report-panel .box-title h3 {
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .report-panel .box-title h3 i {
            margin-right: 6px;
        }

        .report-panel .box-content {
            border-radius: 0 0 14px 14px !important;
        }

        /* Blue theme for Dispatch Report */
        .report-panel-blue {
            border: 1px solid rgba(59, 130, 246, 0.22) !important;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.08);
        }

        .report-panel-blue .box-title {
            background: linear-gradient(0deg, rgba(2, 6, 23, 0.55) 0%, rgba(25, 55, 152, 0.55) 45%, rgba(36, 82, 209, 0.85) 100%) !important;
            backdrop-filter: blur(12px) saturate(1.3) !important;
            -webkit-backdrop-filter: blur(12px) saturate(1.3) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12) !important;
            border-top: 1px solid rgba(96, 165, 250, 0.3) !important;
        }

        .report-panel-blue .box-title h3 {
            color: #f8fafc !important;
        }

        .report-panel-blue .box-title h3 i {
            color: #60a5fa;
            text-shadow: 0 0 8px rgba(96, 165, 250, 0.4);
        }

        /* Red theme for Diesel Bill */
        .report-panel-red {
            border: 1px solid rgba(239, 68, 68, 0.2) !important;
            box-shadow: 0 4px 20px rgba(239, 68, 68, 0.08);
        }

        .report-panel-red .box-title {
            background: linear-gradient(0deg, rgba(31, 10, 10, 0.55) 0%, rgba(151, 23, 23, 0.55) 45%, rgba(211, 32, 32, 0.82) 100%) !important;
            backdrop-filter: blur(12px) saturate(1.3) !important;
            -webkit-backdrop-filter: blur(12px) saturate(1.3) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12) !important;
            border-top: 1px solid rgba(252, 165, 165, 0.3) !important;
        }

        .report-panel-red .box-title h3 {
            color: #fef2f2 !important;
        }

        .report-panel-red .box-title h3 i {
            color: #fca5a5;
            text-shadow: 0 0 8px rgba(252, 165, 165, 0.4);
        }

        /* Dashboard box header styling from image */
        .dashboard-box-neon {
            background: linear-gradient(145deg, #020617 0%, #0f172a 100%) !important;
            border: 1px solid rgba(59, 130, 246, 0.22) !important;
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(2, 6, 23, 0.45);
        }

        .dashboard-box-neon .box-title {
            background: linear-gradient(90deg, #2e4e76 0%, #284194 45%, #1f54e7 100%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
            border-top: 1px solid rgba(125, 211, 252, 0.28) !important;
            border-radius: 14px 14px 0 0;
            padding: 12px 15px !important;
        }

        .dashboard-box-neon .box-title h3 {
            color: #f8fafc !important;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .dashboard-box-neon .box-title h3 i {
            color: #93c5fd;
            text-shadow: 0 0 8px rgba(147, 197, 253, 0.45);
        }

        .dashboard-box-neon .box-content {
            background: transparent !important;
            padding: 6px 8px 10px !important;
        }

        /* ── Left Sidebar Progress Bar Labels & Stats - White for visibility ── */
        .pagestats.bar span {
            color: #ffffff !important;
        }

        .quickstats>li .value {
            color: #ffffff !important;
        }

        .quickstats>li .name {
            color: #ffffff !important;
        }

        /* Make progress bar track darker so colored fill bars stand out better */
        #left .progress.small {
            background: #fafbfc !important;
        }

        /* ── Bottom table text white for better readability ── */
        .report-panel .table thead th {
            color: #ffffff !important;
        }

        .report-panel .table tbody td {
            color: #ffffff !important;
        }

        /* DataTable UI text (Show entries, search, info, pagination) white */
        .report-panel .dataTables_wrapper .dataTables_length label,
        .report-panel .dataTables_wrapper .dataTables_length label select,
        .report-panel .dataTables_wrapper .dataTables_filter label,
        .report-panel .dataTables_wrapper .dataTables_filter input,
        .report-panel .dataTables_wrapper .dataTables_info,
        .report-panel .dataTables_wrapper .dataTables_paginate a {
            color: #ffffff !important;
        }

        .report-panel .dataTables_wrapper .dataTables_length label select option {
            color: #f9f6f6 !important;
        }

        .report-panel .dataTables_wrapper .dataTables_paginate a {
            color: #f8f6f6 !important;
        }

        .report-panel .dataTables_wrapper .dataTables_length label select {
            color: #faf6f6 !important;
        }

        .report-panel .dataTables_wrapper .dataTables_length label select option {
            color: #faf6f6 !important;
        }

        .report-panel .dataTables_wrapper .dataTables_filter input {
            color: #fdfbfb !important;
        }
    </style>
</head>

<body onload="loadDispatchChart();">

    <?php include("inc/model.php"); ?>

    <?php include("inc/top-header.php"); ?>


    <div class="container-fluid" id="content">
        <?php include("inc/left-menu.php"); ?>



        <div id="main">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="pull-left">
                        <h3>Welcome <?php echo $user_name ?></h3>
                    </div>
                    <div class="pull-right">
                        <ul class="minitiles">
                            <li class='grey'>
                                <a href="#">
                                    <i class="fa fa-cogs"></i>
                                </a>
                            </li>
                            <li class='lightgrey'>
                                <a href="#">
                                    <i class="fa fa-globe"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="stats">
                            <li class='satgreen'>
                                <i class="fa fa-money"></i>
                                <div class="details">
                                    <span class="big"><?php echo $balamt; ?></span>
                                    <span>Balance</span>
                                </div>
                            </li>
                            <li class='lightred'>
                                <i class="fa fa-calendar"></i>
                                <div class="details">
                                    <span class="big"><?php echo $currentDate; ?></span>
                                    <span><?php echo $currentDay; ?>, <?php $currentTime; ?> </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>



                <div class="row">

                    <div class="col-sm-12">
                        <div class="box box-color box-bordered dashboard-box-neon">
                            <div class="box-title">
                                <h3>
                                    <i class="fa fa-bar-chart-o"></i>
                                    Dashboard
                                </h3>
                                <div class="actions">
                                    <a href="#" class="btn btn-mini content-refresh">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    <a href="#" class="btn btn-mini content-remove">
                                        <i class="fa fa-times"></i>
                                    </a>
                                    <a href="#" class="btn btn-mini content-slideUp">
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="box-content">
                                <div class="quick-access-grid">
                                    <?php

                                    $sn = 1;
                                    $sql = mysqli_query($connection, " SELECT up.status, up.menu_id, mm.type, mm.menu_name, mm.img_name, mm.pagename FROM user_privilege AS up INNER JOIN m_menu AS mm ON up.menu_id = mm.menu_id WHERE up.menu_id != 0 AND up.submenu_id = 0
										AND up.subcat_id = 0 AND up.user_id = '$user_id' ORDER BY up.menu_id ASC ");
                                    while ($row = mysqli_fetch_array($sql)) {
                                       
                                        $activity1 = $row['status'];
										$menu_id   = $row['menu_id'];
										$type      = $row['type'];
										$menu_name = $row['menu_name'];
										$img_name  = $row['img_name'];
										$pagename  = $row['pagename'];

                                        if ($activity1 == '1'  && $type == 'Module') {
                                    ?>
                                            <div class="qa-item">
                                                <a href="<?php echo $pagename; ?>">
                                                    <img src="icon/<?php echo $img_name; ?>" alt="Dispatch">
                                                    <h5> <?php echo ucfirst($menu_name); ?> </h5>

                                                </a>
                                            </div>

                                    <?php }
                                    } ?>



                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <?php	if($user_type=='admin'){  ?>
                <div class="row kpi-row">
                    <!-- Card 1: Today Bilty -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="all-dispatch-entry.php?fromdate=<?php echo $currentdate ?>&todate=<?php echo $currentdate; ?>&search=search"  class="kpi-card kpi-co-pending" class="kpi-card kpi-today-bilty">
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-file-text-o"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value"><?php echo $bilty; ?></div>
                                <div class="kpi-title">Today Bilty</div>
                            </div>
                            <div class="kpi-desc"><?php echo $todaybiltywtmt; ?> Mt</div>

                        </a>
                    </div>

                    <!-- Card 2: Current Month Bilty -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="all-dispatch-entry.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $formdate; ?>&search=search"  class="kpi-card kpi-co-pending" class="kpi-card kpi-today-bilty" class="kpi-card kpi-month-bilty">
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-calendar"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value"><?php echo number_format($biltymonth, 2); ?></div>
                                <div class="kpi-title">Current Month Bilty</div>
                            </div>
                            <div class="kpi-desc"><?php echo number_format($biltysunmonth, 2); ?> Mt</div>

                        </a>
                    </div>

                    <!-- Card 3: Total Bilty -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="all-dispatch-entry.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $formdate; ?>&search=search"  class="kpi-card kpi-co-pending" class="kpi-card kpi-today-bilty" class="kpi-card kpi-month-bilty" class="kpi-card kpi-total-bilty">
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-bar-chart"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value"><?php echo number_format($totalbilty, 2); ?></div>
                                <div class="kpi-title">Total Bilty</div>
                            </div>
                            <div class="kpi-desc"><?php echo number_format($totalbiltywt, 2); ?> Mt</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,10 8,12 16,7 24,9 32,4 40,6" />
                            </svg>
                        </a>
                    </div>

                    <!-- Card 4: Cash Advance -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="cash_adv_report.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $formdate; ?>&search=search"  class="kpi-card kpi-co-pending" class="kpi-card kpi-today-bilty" class="kpi-card kpi-month-bilty" class="kpi-card kpi-total-bilty" class="kpi-card kpi-cash-adv">
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-money"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value"><?php echo $cash_adv; ?></div>
                                <div class="kpi-title">Cash Adv.</div>
                            </div>
                            <div class="kpi-desc">Advance amount</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,11 8,6 16,9 24,5 32,8 40,2" />
                            </svg>
                        </a>
                    </div>

                    <!-- Card 5: Diesel Advance -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="diesel_adv_report.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $formdate; ?>&search=search"  class="kpi-card kpi-co-pending" class="kpi-card kpi-today-bilty" class="kpi-card kpi-month-bilty" class="kpi-card kpi-total-bilty" class="kpi-card kpi-cash-adv" class="kpi-card kpi-diesel-adv">
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-tint"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value"><?php echo $diesel_adv_amt; ?></div>
                                <div class="kpi-title">Diesel Adv.</div>
                            </div>
                            <div class="kpi-desc">Diesel advance</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,13 8,9 16,11 24,7 32,10 40,5" />
                            </svg>
                        </a>
                    </div>

                    <!-- Card 6: Bilty Payment -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="payment_report.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $formdate; ?>&search=search"  class="kpi-card kpi-co-pending" class="kpi-card kpi-today-bilty" class="kpi-card kpi-month-bilty" class="kpi-card kpi-total-bilty" class="kpi-card kpi-cash-adv" class="kpi-card kpi-diesel-adv" class="kpi-card kpi-bilty-pay">
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-credit-card"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value"><?php echo $receive_amt; ?></div>
                                <div class="kpi-title">Bilty Payment</div>
                            </div>
                            <div class="kpi-desc">Received amount</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,12 8,7 16,10 24,4 32,8 40,3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Card 7: Company Pending Bill -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="bilty_status_report.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $todate; ?>&search=search&is_invoice=0"  class="kpi-card kpi-co-pending">
                            <span class="kpi-badge"><?php echo number_format($pinvoice, 0); ?></span>
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-clipboard"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value">₹ <?php echo number_format($pinvoiceamt, 2); ?></div>
                                <div class="kpi-title">Company Pending Bill</div>
                            </div>
                            <div class="kpi-desc">Invoice pending</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,10 8,13 16,7 24,10 32,5 40,8" />
                            </svg>
                        </a>
                    </div>

                    <!-- Card 8: Company Pending Bill Payment -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="invoice_report.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $todate; ?>&search=search&is_pay=0&billtype=party" target="_blank" class="kpi-card kpi-co-pay-pending">
                            <span class="kpi-badge"><?php echo number_format($ipayc, 0); ?></span>
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-rupee"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value">₹ <?php echo $tipayamt; ?></div>
                                <div class="kpi-title">Co. Pending Bill Pay</div>
                            </div>
                            <div class="kpi-desc">Payment pending</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,11 8,8 16,13 24,7 32,10 40,4" />
                            </svg>
                        </a>
                    </div>

                    <!-- Card 9: Pending Receiving -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="receive_pending_report.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $todate; ?>&search=search&is_receive=0" target="_blank" class="kpi-card kpi-pending-rec">
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-clock-o"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value"><?php echo number_format($prec, 0); ?></div>
                                <div class="kpi-title">Pending Receiving</div>
                            </div>
                            <div class="kpi-desc">Not received yet</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,9 8,11 16,6 24,8 32,3 40,5" />
                            </svg>
                        </a>
                    </div>

                    <!-- Card 10: Pending Diesel Bill -->
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="all-dispatch-entry2.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $todate; ?>&search=search&dbillid=0" target="_blank" class="kpi-card kpi-pending-diesel">
                            <span class="kpi-badge"><?php echo $dbillc; ?></span>
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-file-text-o"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value">₹ <?php echo $dbill; ?></div>
                                <div class="kpi-title">Pending Diesel Bill</div>
                            </div>
                            <div class="kpi-desc">Diesel not billed</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,12 8,7 16,10 24,3 32,6 40,2" />
                            </svg>
                        </a>
                    </div>

                    
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="diesel_bill_report.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $todate; ?>&is_pay=0&search=search" target="_blank" class="kpi-card kpi-pending-diesel-pay">
                            <span class="kpi-badge"><?php echo $dpayc; ?></span>
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-credit-card"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value">₹ <?php echo $tdpayamt; ?></div>
                                <div class="kpi-title">Pending Diesel Pay</div>
                            </div>
                            <div class="kpi-desc">Diesel payment due</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,8 8,10 16,5 24,7 32,2 40,4" />
                            </svg>
                        </a>
                    </div>

                    
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="all-dispatch-entry.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $todate; ?>&is_voucher=0&search=search" target="_blank" class="kpi-card kpi-pending-voucher">
                            <span class="kpi-badge"><?php echo $voucherc; ?></span>
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-ticket"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value">₹ <?php echo number_format($voucheramt, 2); ?></div>
                                <div class="kpi-title">Pending Voucher</div>
                            </div>
                            <div class="kpi-desc">Voucher pending</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,13 8,9 16,11 24,6 32,8 40,3" />
                            </svg>
                        </a>
                    </div>

                 
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="voucher_report.php?fromdate=<?php echo $formdate ?>&todate=<?php echo $todate; ?>&is_paid=0&search=search" target="_blank" class="kpi-card kpi-owner-pending">
                            <span class="kpi-badge"><?php echo $vpayc; ?></span>
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-truck"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value">₹ <?php echo number_format($vpayamt, 2); ?></div>
                                <div class="kpi-title">Owner Pending Pay</div>
                            </div>
                            <div class="kpi-desc">Payment to truck owner</div>

                        </a>
                    </div>

                    
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="#" class="kpi-card kpi-total-rcamt">
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-check-circle"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value">₹ <?php echo number_format($total_rcamt, 2); ?></div>
                                <div class="kpi-title">Owner Rec. Pmt</div>
                            </div>
                            <div class="kpi-desc">Total received payment</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,10 8,12 16,7 24,9 32,4 40,6" />
                            </svg>
                        </a>
                    </div>

                    
                    <div class="col-lg-2-4 col-md-2-4 col-sm-2-4 col-xs-2-4">
                        <a href="#" class="kpi-card kpi-bal-amt">
                            <span class="kpi-icon-wrap"><span class="kpi-icon-circle"><i class="fa fa-balance-scale"></i></span></span>
                            <div class="kpi-body">
                                <div class="kpi-value">₹ <?php echo number_format($bal_amt, 2); ?></div>
                                <div class="kpi-title"> Balance Amount</div>
                            </div>
                            <div class="kpi-desc">Remaining balance</div>
                            <svg class="kpi-sparkline" viewBox="0 0 40 16">
                                <polyline points="0,9 8,11 16,6 24,8 32,3 40,5" />
                            </svg>
                        </a>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">

                        <div class="card" style="padding:15px;">

                            
                            <h4 style="text-align:center;margin:0 0 10px 0; font-weight:bold; color:#1f4e79;">

                                MONTH WISE DISPATCH COMPARISON
                            </h4>

                            <div style=" width:100%;height:430px;">

                                <canvas id="dispatchComparisonChart"></canvas>

                            </div>

                        </div>

                    </div>
                 </div>


                <div class="row">





                    <div class="col-sm-6">
                        <div class="box box-color box-bordered report-panel report-panel-blue">
                            <div class="box-title">
                                <h3>
                                    <i class="fa fa-file-text-o"></i>
                                    Today Dispatch Report
                                </h3>

                            </div>
                            <div class="box-content" style="height:500px; overflow:scroll;padding:0">
                                <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>DI No.</th>
                                            <th>Bilty No.</th>
                                            <th class='hidden-350'>Bilty Date</th>
                                            <!-- <th>Consignor</th> -->
                                            <th>Consignee</th>
                                            <th class='hidden-1024'>Truck No.</th>
                                            <th>Destination</th>
                                            <th>Item</th>
                                            <th>Weight/MT</th>
                                            <!-- <th>Qty (Bags)</th> -->
                                            <th>Company Rate</th>
                                            <th>Total Freight (Rs)</th>
                                            <!-- <th class='hidden-480'>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sn = 1;
                                        $sql = mysqli_query($connection, "Select * from  dispatch_entry where consignor_id=$consignorid && created_date='$currentdate' && comp_id=$comp_id && session_id=$session_id order by dispatch_id desc");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            // $consignor_name=$cmn->getvalfield($connection,"m_consignor","consignor_name","consignor_id=$row[consignor_id]");
                                            $consignee_name = $cmn->getvalfield($connection, "m_consignee", "consignee_name", "consignee_id=$row[consignee_id]");
                                            $vehicle_no = $cmn->getvalfield($connection, "m_vehicle", "vehicle_no", "vehicle_id=$row[vehicle_id]");
                                            $destination = $cmn->getvalfield($connection, "m_place", "place_name", "place_id=$row[destination_id]");
                                            $item_name = $cmn->getvalfield($connection, "m_item", "item_name", "item_id=$row[item_id]");
                                        ?>
                                            <tr>
                                                <td><?php echo $sn++; ?></td>
                                                <td><?php echo $row['di_no']; ?></td>
                                                <td><?php echo $row['bilty_no']; ?></td>
                                                <td><?php echo dateformatindia($row['bilty_date']); ?></td>
                                                <!-- <td><?php echo $consignor_name; ?></td> -->
                                                <td class='hidden-350'><?php echo $consignee_name; ?></td>
                                                <td class='hidden-1024'><?php echo $vehicle_no; ?></td>
                                                <td class='hidden-1024'><?php echo $destination; ?></td>
                                                <td class='hidden-1024'><?php echo $item_name; ?></td>
                                                <td><?php echo $row['wt_mt']; ?></td>
                                                <!-- <td><?php echo $row['qty']; ?></td> -->
                                                <td><?php echo $row['comp_rate']; ?></td>
                                                <td><?php echo ($row['wt_mt'] * $row['comp_rate']); ?></td>
                                                <!-- <td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td> -->

                                            </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php $enddateexpalert = date('Y-m-d', strtotime('+1 months')); ?>
                    <div class="col-sm-6">
                        <div class="box box-color box-bordered report-panel report-panel-red">
                            <div class="box-title">
                                <h3>
                                    <i class="fa fa-tint"></i>
                                    Diesel Bill
                                </h3>

                            </div>
                            <div class="box-content" style="height:500px; overflow:scroll;padding:0">
                                <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                    <thead>
                                        <th>Sno</th>
                                        <th>Bill No</th>
                                        <th>Bill Date</th>
                                        <th>Pump Name</th>
                                        <th>Bill Amount</th>

                                    </thead>
                                    <tbody>
                                        <?php
                                        $sn = 1;
                                        //   echo	"Select * from  $tblname  $crit && consignorid=$consignorid && sessionid=$session_id order by $tblpkey desc";
                                        $sql = mysqli_query($connection, "Select * from  dieselbill  where 1=1 && consignorid=$consignorid && sessionid=$session_id  &&  is_pay=1");
                                        while ($row = mysqli_fetch_array($sql)) {
                                            // $amount = $cmn->getinvoiceamount($connection,$row['dbillid']);
                                            $pump_name = $cmn->getvalfield($connection, "m_petrol_pump", "pump_name", "pump_id='$row[pump_id]'");
                                            $adv_diesel = $cmn->getvalfield($connection, "dispatch_entry", "sum(diesel_adv_amt)", "dbillid='$row[dbillid]'");
                                        ?>
                                            <tr>
                                                <td><?php echo $sn++; ?></td>
                                                <td><?php echo ucfirst($row['dbillno']); ?></td>
                                                <td><?php echo $cmn->dateformatindia($row['dbilldate']); ?></td>
                                                <td><?php echo $pump_name; ?></td>
                                                <!-- <td><?php echo number_format($wt_mt, 2); ?></td> -->
                                                <td><?php echo number_format($adv_diesel, 2); ?></td>



                                                </td>

                                            </tr>
                                        <?php } ?>

                                    </tbody>



                                    </thead>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>


             <?php 	} ?>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        // Chart is now pure CSS — no Canvas JS needed
    </script>
    <script>
        let dispatchChart = null;

        function loadDispatchChart() {

            $.ajax({

                url: 'get_dispatch_data.php',
                type: 'GET',
                dataType: 'json',

                success: function(response) {


                    if (!response.success) {
                        console.error(response.message);
                        return;
                    }

                    const chartData = response.data || [];

                    const months = chartData.map(item => item.month);

                    const currentQty = chartData.map(item =>
                        Number(item.current_qty) || 0
                    );

                    const previousQty = chartData.map(item =>
                        Number(item.previous_qty) || 0
                    );

                    const growth = chartData.map(item => {

                        const previous = Number(item.previous_qty) || 0;
                        const current = Number(item.current_qty) || 0;

                        if (previous === 0) {
                            return current > 0 ? 100 : 0;
                        }

                        return Number(
                            ((current - previous) / previous) * 100
                        ).toFixed(2);

                    });



                    const maxValue = Math.max(
                        ...currentQty,
                        ...previousQty
                    );

                    let stepSize = Math.ceil(maxValue / 8);

                    stepSize = Math.ceil(stepSize / 500) * 500;

                    if (stepSize <= 0) {
                        stepSize = 500;
                    }

                    const yMax =
                        Math.ceil(maxValue / stepSize) * stepSize +
                        stepSize;


                    const currentLabel =
                        'CURRENT SESSION ' +
                        response.current_session;

                    const previousLabel =
                        'PREVIOUS SESSION ' +
                        response.previous_session;


                    if (dispatchChart) {
                        dispatchChart.destroy();
                    }


                    const canvas =
                        document.getElementById(
                            'dispatchComparisonChart'
                        );

                    if (!canvas) {

                        console.error(
                            'dispatchComparisonChart canvas not found'
                        );

                        return;
                    }


                    const ctx = canvas.getContext('2d');


                    dispatchChart = new Chart(ctx, {

                        plugins: [ChartDataLabels],

                        data: {

                            labels: months,

                            datasets: [


                                {
                                    type: 'bar',

                                    label: previousLabel,

                                    data: previousQty,

                                    backgroundColor: '#2D6A9F',

                                    borderColor: '#2D6A9F',

                                    borderWidth: 1,

                                    barPercentage: 0.72,

                                    categoryPercentage: 0.65,

                                    yAxisID: 'y',

                                    datalabels: {

                                        color: '#FFFFFF',

                                        anchor: 'end',

                                        align: 'top',

                                        offset: 3,

                                        font: {
                                            size: 9,
                                            weight: 'bold'
                                        },

                                        formatter: function(value) {

                                            return value ?
                                                Number(value).toLocaleString(
                                                    'en-IN', {
                                                        maximumFractionDigits: 2
                                                    }
                                                ) :
                                                '';

                                        }

                                    }

                                },


                                // =====================
                                // CURRENT SESSION
                                // =====================

                                {
                                    type: 'bar',

                                    label: currentLabel,

                                    data: currentQty,

                                    backgroundColor: '#C94A4A',

                                    borderColor: '#C94A4A',

                                    borderWidth: 1,

                                    barPercentage: 0.72,

                                    categoryPercentage: 0.65,

                                    yAxisID: 'y',

                                    datalabels: {

                                        color: '#FFFFFF',

                                        anchor: 'end',

                                        align: 'top',

                                        offset: 3,

                                        font: {
                                            size: 9,
                                            weight: 'bold'
                                        },

                                        formatter: function(value) {

                                            return value ?
                                                Number(value).toLocaleString(
                                                    'en-IN', {
                                                        maximumFractionDigits: 2
                                                    }
                                                ) :
                                                '';

                                        }

                                    }

                                },


                                // =====================
                                // GROWTH %
                                // =====================

                                {
                                    type: 'line',

                                    label: 'GROWTH IN %',

                                    data: growth,

                                    borderColor: '#8DBB5F',

                                    backgroundColor: '#8DBB5F',

                                    borderWidth: 2.5,

                                    tension: 0.30,

                                    pointRadius: 5,

                                    pointHoverRadius: 7,

                                    pointBackgroundColor: '#8DBB5F',

                                    pointBorderColor: '#FFFFFF',

                                    pointBorderWidth: 2,

                                    yAxisID: 'y1',

                                    datalabels: {

                                        display: true,

                                        color: '#38552A',

                                        backgroundColor: '#F4F8ED',

                                        borderColor: '#8DBB5F',

                                        borderWidth: 1,

                                        borderRadius: 15,

                                        padding: 4,

                                        anchor: 'center',

                                        align: 'center',

                                        font: {
                                            size: 8,
                                            weight: 'bold'
                                        },

                                        formatter: function(value) {
                                            return value + '%';
                                        }

                                    }

                                }

                            ]

                        },


                        options: {

                            responsive: true,

                            maintainAspectRatio: false,

                            interaction: {
                                mode: 'index',
                                intersect: false
                            },


                            plugins: {

                                legend: {

                                    display: true,

                                    position: 'top',

                                    labels: {

                                        color: '#FFFFFF',

                                        boxWidth: 14,

                                        boxHeight: 8,

                                        padding: 18,

                                        font: {
                                            size: 10,
                                            weight: 'bold'
                                        }

                                    }

                                },


                                tooltip: {

                                    backgroundColor: '#123F66',

                                    titleColor: '#FFFFFF',

                                    bodyColor: '#FFFFFF',

                                    callbacks: {

                                        label: function(context) {

                                            const value = context.raw;

                                            if (
                                                context.dataset.label ===
                                                'GROWTH IN %'
                                            ) {

                                                return 'Growth : ' +
                                                    value + '%';

                                            }

                                            return context.dataset.label +
                                                ' : ' +
                                                Number(value).toLocaleString(
                                                    'en-IN', {
                                                        maximumFractionDigits: 2
                                                    }
                                                ) +
                                                ' Tons';

                                        }

                                    }

                                }

                            },


                            scales: {

                                // =====================
                                // DISPATCH
                                // =====================

                                y: {

                                    beginAtZero: true,

                                    max: yMax,

                                    ticks: {

                                        stepSize: stepSize,

                                        color: 'rgba(255,255,255,0.65)',

                                        callback: function(value) {

                                            return Number(value)
                                                .toLocaleString('en-IN');

                                        }

                                    },

                                    title: {

                                        display: true,

                                        text: 'DISPATCH (TONS)',

                                        color: 'rgba(255,255,255,0.75)',

                                        font: {
                                            size: 10,
                                            weight: 'bold'
                                        }

                                    },

                                    grid: {

                                        color: 'rgba(255,255,255,0.10)'

                                    }

                                },


                                // =====================
                                // GROWTH
                                // =====================

                                y1: {

                                    position: 'right',

                                    min: -100,

                                    max: 100,

                                    ticks: {

                                        stepSize: 20,

                                        color: 'rgba(255,255,255,0.65)',

                                        callback: function(value) {

                                            return value + '%';

                                        }

                                    },

                                    title: {

                                        display: true,

                                        text: 'GROWTH IN %',

                                        color: 'rgba(255,255,255,0.75)',

                                        font: {
                                            size: 10,
                                            weight: 'bold'
                                        }

                                    },

                                    grid: {

                                        drawOnChartArea: false

                                    }

                                },


                                // =====================
                                // MONTH
                                // =====================

                                x: {

                                    ticks: {

                                        color: 'rgba(255,255,255,0.75)',

                                        font: {
                                            size: 10,
                                            weight: 'bold'
                                        }

                                    },

                                    grid: {
                                        display: false
                                    }

                                }

                            }

                        }

                    });

                },

                error: function(xhr, status, error) {

                    console.error('AJAX ERROR:', error);

                    console.log(
                        'RAW RESPONSE:',
                        xhr.responseText
                    );

                }

            });

        }

    </script>
</body>



</html>