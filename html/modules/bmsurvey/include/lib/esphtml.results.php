<?php

# $Id: esphtml.results.php,v 1.1.1.1 2005/08/10 12:14:03 yoshis Exp $

// Written by James Flemer
// <jflemer@alum.rpi.edu>

// void		mkrespercent(int[char*] counts, int total, bool showTotals);
// void		mkresrank(int[char*] counts, int total, bool showTotals);
// void		mkrescount(int[char*] counts, int total, bool showTotals);
// void		mkreslist(int[char*] counts, int total, bool showTotals);
// void		mkresavg(int[char*] counts, int total, bool showTotals);

/* {{{ proto void mkrespercent(array weights, int total, int precision, bool show_totals)
  Builds HTML showing PERCENTAGE results. */
function mkrespercent($counts,$total,$precision,$showTotals) {
	$i=0;
	$bg='';
?>
<table width="100%" border="0">
<?php
	while(list($content,$num) = each($counts)) {
		if($num>0) { $percent = $num/$total*100.0; }
		else { $percent = 0; }
		if($percent > 100) { $percent = 100; }

		if($bg != $GLOBALS['FMXCONFIG']['bgalt_color1'])
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color1'];
		else
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
		echo "<tr bgcolor=".$bg."><td align='right'>".$content."</td>";
		echo "<td width='10%'>(".$num;
		printf(")&nbsp;%.${precision}f%%</td>",$percent);
		echo "<td align='left' width='50%'>";
		$div_style = "background-color: #9999ff; border: 1px solid #777777; text-align: center;";
		if($num) {
//			echo("&nbsp;<img src=\"" .$GLOBALS['FMXCONFIG']['image_url'] ."hbar_l.gif\" height=9 width=4>");
//			printf("<img src=\"" .$GLOBALS['FMXCONFIG']['image_url'] ."hbar.gif\" height=9 width=%d>",$percent*2);
//			printf("<img src=\"" .$GLOBALS['FMXCONFIG']['image_url'] ."hbar_r.gif\" height=9 width=4> %.${precision}f%%",$percent);
			echo("<div style=\"".$div_style." width: ");
			printf("%dpx\">&nbsp;</div>",$percent*2);
		}
		echo "</td></tr>";
		$i += $num;
	} // end while
	if($showTotals) {
		if($i>0) { $percent = $i/$total*100.0; }
		else { $percent = 0; }
		if($percent > 100) { $percent = 100; }

		if($bg != $GLOBALS['FMXCONFIG']['bgalt_color1'])
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color1'];
		else
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
		echo "<tr bgcolor=".$bg.">";
		echo "<td align='right'><b>"._MB_TOTAL;
		echo "</b></td>";
		echo "<td width=\"10%\" align='left'><b>(".$total;
		printf(")&nbsp;%.${precision}f%%",$percent);
		echo "</b></td>";
		echo "<td width=\"40%\" align=\"left\"><b>";
//			echo("<img src=\"" .$GLOBALS['FMXCONFIG']['image_url'] ."hbar_l.gif\" height=9 width=4>");
//			printf("<img src=\"" .$GLOBALS['FMXCONFIG']['image_url'] ."hbar.gif\" height=9 width=%d>",$percent*2);
//			echo("<img src=\"" .$GLOBALS['FMXCONFIG']['image_url'] ."hbar_r.gif\" height=9 width=4>");
//			printf("&nbsp;%.${precision}f%%</b></td>",$percent);
			echo("<div style=\"".$div_style." width: ");
			printf("%dpx\">&nbsp;</div></b></td>",$percent*2);
		echo "</tr>";
	}
?>
</table>
<?php
}
/* }}} */


/* {{{ proto void mkresrank(array weights, int total, int precision, bool show_totals)
   Builds HTML showing RANK results. */
function mkresrank($counts,$total,$precision,$showTotals) {
	$bg='';
	echo "<table border=\"0\"><tr><td align='left' colspan=4><b>"._MB_Rank."</b></td><tr>";
	arsort($counts);
	$i=0; $pt=0;
	while(list($content,$num) = each($counts)) {
		if($num)
			$p = $num/$total*100.0;
		else
			$p = 0;
		$pt += $p;

		if($bg != $GLOBALS['FMXCONFIG']['bgalt_color1'])
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color1'];
		else
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
		echo "<tr bgcolor='".$bg.">";
		echo "<td align='left'><b>".++$i."</b></td>";
		echo "<td align='left'>".$content."</td>";
		echo "<td align='left' width=\"60\">";
		if($p) printf("%.${precision}f%%",$p);
		echo "</td><td align='left' width=\"60\">(".$num.")</td>";
		echo "</tr>";
	} // end while
	if($showTotals) {
		if($bg != $GLOBALS['FMXCONFIG']['bgalt_color1'])
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color1'];
		else
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<td colspan=2 align='left'><b><?php echo(_MB_TOTAL); ?></b></td>
		<td align='left'><b><?php printf("%.${precision}f%%",$pt); ?></b></td>
		<td align='left'><b><?php echo($total); ?></b></td>
	</tr>
<?php } ?>
</table>
<?php
}
/* }}} */

/* {{{ proto void mkrescount(array weights, int total, int precision, bool show_totals)
   Builds HTML showing COUNT results. */
function mkrescount($counts,$total,$precision,$showTotals) {
	$i=0;
?>
<table width="90%" border="0">
<?php
    $bg = '';
	while(list($content,$num) = each($counts)) {
		if($bg != $GLOBALS['FMXCONFIG']['bgalt_color1'])
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color1'];
		else
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<td align='left'><?php echo($content); ?></td>
		<td align='left' width="60"><?php echo($num); ?></td>
		<td align='left' width="60">(<?php if($num) printf("%.${precision}f",$num/$total*100.0); ?>%)</td>
	</tr>
<?php
		$i += $num;
	} // end while
	if($showTotals) {
		if($bg != $GLOBALS['FMXCONFIG']['bgalt_color1'])
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color1'];
		else
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
?>
	<tr bgcolor="<?php echo($bg); ?>">
		<td align='left'><b><?php echo(_MB_TOTAL); ?></b></td>
		<td align='left'><b><?php echo($total); ?></b></td>
		<td align='left'><b>(<?php if($i) printf("%.${precision}f",$i/$total*100.0); ?>%)</b></td>
	</tr>
<?php	} ?>
</table>
<?php
}
/* }}} */

/* {{{ proto void mkreslist(array weights, int total, int precision, bool show_totals)
	Builds HTML showing LIST results. */
function mkreslist($counts,$total,$precision,$showTotals) {
	if($total==0)	return;
	$bg='';
?>
<table width="90%" border="0" cellpadding="1">
	<tr><th align='left'><?php echo(_MB_Num); ?></th><th><?php echo(_MB_Response); ?></th></tr>
<?php
	while(list($text,$num) = each($counts)) {
		if($bg != $GLOBALS['FMXCONFIG']['bgalt_color1'])
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color1'];
		else
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
		echo("<tr bgcolor=\"$bg\"><th width='20%' align='right' valign=\"top\">$num</th><td align='left'>$text</td></tr>\n");
	}
?>
</table>
<?php
}
/* }}} */

/* {{{ proto void mkresavg(array weights, int total, int precision, bool show_totals)
	Builds HTML showing AVG results. */
function mkresavg($counts,$total,$precision,$showTotals,$length) {
	if (!$length) $length = 5;
	$width = 200 / $length;
	echo '<table border="0" cellspacing="0" cellpadding="0">';
	echo "<tr><td align='left'></td>";
	printf ("<td align='center' colspan='%u' >", $length+2 );
	echo _MB_Average_rank . "</td></tr>";
	echo "<tr><td align='left'></td>";
	for ($i = 0; $i < $length; ){
		echo( "<td align='right' width='".$width."'>". ++$i ."</td>\n");
	}
	echo "<td width='20'></td><td align='left'></td></tr>";
    $bg = '';
	while(list($content,$avg) = each($counts)) {
		if($bg != $GLOBALS['FMXCONFIG']['bgalt_color1']){
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color1'];
		}else{
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
		}
		echo "<tr bgcolor=".$bg.">";
		echo "<td align='left'>".$content."&nbsp;</td>";
		printf("<td align='left' width='220' colspan='%u'>", $length+1 );
		if($avg) {
			echo('<img src="'. $GLOBALS['FMXCONFIG']['image_url'] .'hbar_l.gif" height="9" width="4">');
			if (($j = $avg * $width - 11) > 0)
				printf('<img src="'. $GLOBALS['FMXCONFIG']['image_url'] .'hbar.gif" height="9" width="%d">', $j);
			echo('<img src="'. $GLOBALS['FMXCONFIG']['image_url'] .'hbar_r.gif" height="9" width="4">');
		}
		echo "</td><td align='left' width='60'>(";
		printf("%.${precision}f",$avg);
		echo "</td></tr>";
	}
	echo "</table>";
}
/* }}} */

/* {{{ proto void mkresavg(array weights, int total, int precision, bool show_totals)
	Builds HTML showing AVG results. */
function mkresratecount($counts,$total,$precision,$showTotals,$length,$fullcount,$th_title) {
	if (!$length) $length = 5;
	$width = 70 / ($length+2) . "%";
	$nalign = "center";
	$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
	echo '<div align="center"><table border="3" cellspacing="0" cellpadding="2" width="90%">';
	echo "<caption><b><font size=+1>"._AM_BMSURVEY_RATECOUNT."</font></b></caption>";
	echo "<tr bgcolor=".$bg.">";
	echo "<td align='left'></td>";
	for ($i = 0; $i < $length; $i++){
		$title = strlen($th_title[$i])>1 ? $i+1 .". ". $th_title[$i] : $th_title[$i];
		printf ("<td width='%s'>%s</td>\n",$width,$title);
	    $vsum[$i] = 0;
	}
	echo "<td align='center' width='$width'>"._AM_BMSURVEY_NORESPONSE
		."</td><td align='center' width='$width'>"._AM_BMSURVEY_TOTAL."</td></tr>";
    $bg = '';
    $noresSum = 0;
    $vcount = "A";
	foreach ($counts as $key => $val) {
		if($bg != $GLOBALS['FMXCONFIG']['bgalt_color1']){
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color1'];
		}else{
			$bg = $GLOBALS['FMXCONFIG']['bgalt_color2'];
		}
		echo "<tr bgcolor=".$bg.">";
		echo "<td width='30%'>".$vcount.". ".$key."&nbsp;</td>";
		$rsum=0;
		for ($i = 0; $i < $length; $i++){
			echo "<td align='$nalign' width='%width'>";
			if(isset($val[$i])){
				echo $val[$i];
				$rsum += $val[$i];
				$vsum[$i] += $val[$i];
			}else
				echo "&nbsp;";
			echo "</td>";
		}
		$nores = $fullcount - $rsum;
		$noresSum += $nores;
		echo "<td align='$nalign' width='20'>$nores</td>";
		echo "<td align='$nalign' width='20'>$fullcount</td>";
		echo "</tr>";
		$vcount++;
	}
	echo "<tr><td align='right'>"._AM_BMSURVEY_TOTAL."</td>";
	$rsum=0;
	for ($i = 0; $i < $length; $i++){
		echo "<td align='$nalign' width='$width'>".$vsum[$i]."</td>\n";
		$rsum += $vsum[$i];
	}
	$rsum += $noresSum;
	echo "<td align='$nalign' width='$width'>$noresSum</td>";
	echo "<td align='$nalign' width='$width'>$rsum</td></tr>";
	echo "</table></div>";
}
/* }}} */

?>