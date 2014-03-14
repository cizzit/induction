<?php
session_start();
// I want to have a security function here
// to check if they are signed in
// For now, lets just say $loggedin=true

// include database files and create a connection
require_once('../db.class.php');
$db = new db_class;
if (!$db->connect()) 
   $db->print_last_error(false);

?>
<html>
<head>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<div id="content">
<table id="mngmnt">
<tr>
       <td colspan="3" class="center title"> Administration </td>
</tr>
<tr>
       <td colspan="3" class="center semititle"><strong>Database Management</strong></td>
</tr>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
<?php
// build query to get variables from admin database
$qry_int = "SELECT value FROM admin WHERE variable='USERinterval' LIMIT 1";
$sql_int = $db->select_one($qry_int);
// $sql_int should now contain the value for interval
$interval_limit=array('1','2','3','4','5','6','12','18','24','36');
$interval_count = 9;
for($u=0;$u<=$interval_count;$u++) {
  if($sql_int == $interval_limit[$u]) { $gotcha=$sql_int; break; }
}

?>
       <td> How often should people be required to re-sit the induction?<br />Please note that this will have an immediate effect. </td>
       <td> Current Value: <em><span id="stuff"><?php echo $gotcha;?></span> months</em></td>
       <td> New Value: <form action="process.php" method="GET">
<input type="hidden" name="section" value="interval" />
<select name="interval" onChange="this.form.submit()">
<?php
// let's build the for loop to generate the SELECT field
for($i=0;$i<=$interval_count;$i++) {
  $digvar = "<option value=\"$interval_limit[$i]\" ";
  if($interval_limit[$i] == $sql_int) { $digvar .= "selected=\"selected\"";}
  $digvar .= " /> $interval_limit[$i]\n";
  echo $digvar;
}
?>
</select> months</form></td>
</tr>
<?php
$qrydate = "SELECT value FROM admin WHERE variable='resetdate' LIMIT 1";
$sqldate = $db->select_one($qrydate);
// should be in format ddmmyyyy
$dld = substr($sqldate,0,2);
$dlm = substr($sqldate,2,2);
$dly = substr($sqldate,4,4);
$datelastreset = $dld.'/'.$dlm.'/'.$dly;
if ($datelastreset == 0) {$datelastreset = "never";}

// database report dates
for($i=1;$i<=7;$i++){
    $qry = "SELECT value FROM admin WHERE variable='report".$i."'";
    $crampot = $db->select_one($qry);
    $report[$i] = @date('d-m-Y', $crampot );
}
// should now have $report[1]=(report 1's date)

?>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
       <td> Expire all records? (<strong>This will require <u>everyone</u> to re-sit induction!</strong>) </td>
       <td> Last performed: <em><?php echo $datelastreset;?></em></td>
       <td> <input type="submit" class="inputbutt" name="submit" value="!! Expire All Records !!" onClick="javascript:window.location='process.php?go=reset';return false;" /> </td>
</tr>
<tr>
       <td colspan="3" class="center semititle"><strong>Reporting</strong></td>
</tr>
<tr>
       <td colspan="3"> Select a report to run below </td>
</tr>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
       <td> View all records held in database:</td>
       <td> Last ran: <em><?php if($report[1]){echo $report[1];} else {echo "never";} ?></em> </td>
       <td> <input type="button" class="inputbutt" name="allrec" value="Run Report" onClick="javascript:window.location='process.php?report=1';return false;" /></td>
</tr>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
       <td> View all inductees for the &quot;Visitor&quot; course:</td>
       <td> Last ran: <em><?php if($report[2]){echo $report[2];} else {echo "never";} ?></em> </td>
       <td> <input type="button" class="inputbutt" name="allrec" value="Run Report" onClick="javascript:window.location='process.php?report=2';return false;" /></td>
</tr>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
       <td> View all inductees for the &quot;Contractor&quot; course:</td>
       <td> Last ran: <em><?php if($report[3]){echo $report[3];} else {echo "never";} ?></em> </td>
       <td> <input type="button" class="inputbutt" name="allrec" value="Run Report" onClick="javascript:window.location='process.php?report=3';return false;" /></td>
</tr>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
       <td> View all inductees for the &quot;QantasLink Employee&quot; course:</td>
       <td> Last ran: <em><?php if($report[4]){echo $report[4];} else {echo "never";} ?></em> </td>
       <td> <input type="button" class="inputbutt" name="allrec" value="Run Report" onClick="javascript:window.location='process.php?report=4';return false;" /></td>
</tr>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
       <td> View all inductions performed on a certain date:</td>
       <td> Last ran: <em><?php if($report[5]){echo $report[5];} else {echo "never";} ?></em> </td>
       <td> <input type="button" class="inputbutt" name="allrec" value="Run Report" onClick="javascript:window.location='process.php?report=5';return false;" /></td>
</tr>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
       <td> View all inductions that are expired:</td>
       <td> Last ran: <em><?php if($report[6]){echo $report[6];} else {echo "never";} ?></em> </td>
       <td> <input type="button" class="inputbutt" name="allrec" value="Run Report" onClick="javascript:window.location='process.php?report=6';return false;" /></td>
</tr>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
       <td> View all inductions that are not yet expired:</td>
       <td> Last ran: <em><?php if($report[7]){echo $report[7];} else {echo "never";} ?></em> </td>
       <td> <input type="button" class="inputbutt" name="allrec" value="Run Report" onClick="javascript:window.location='process.php?report=7';return false;" /></td>
</tr>
<tr>
       <td colspan="3" class="spacer">&nbsp;</td>
</tr>
<tr onMouseOver="this.style.backgroundColor='#eeeeee'"; onMouseOut="this.style.backgroundColor='#dddddd'";>
       <td colspan="3" class="center"><input type="submit" name="leaveadmin" class="inputbutt" value="Leave Admin Mode" onClick="javascript:window.location='../logout.php';" /> </td>
</tr>

</table>
</div>
</body>
</html> 
