<?php

function dateformatindia($date)
{
	if($date == "0000-00-00" || $date =="")
	{
	return "";
	}
	else
	{
	$ndate = explode("-",$date);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = $ndate[1];
	
	return $day . "-" . $month . "-" . $year;
	}
	
}
?>