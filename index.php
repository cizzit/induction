<?php
session_start();
function finaltext($reason, $class = "errordesc"){
  echo "<p class=\"$class\">$reason</p></div>
</body>
</html>";
  exit();
}
// functions file, containing database class and functions 
require_once('db.class.php');
// open a database connection now (we don't do it earlier so as to minimse the number of database calls
$db = new db_class;
if (!$db->connect()) $db->print_last_error(false);

$qrysec = "SELECT value FROM admin WHERE variable='secmonth'";   
$secmonth = $db->select_one($qrysec);
$qryces = "SELECT value FROM admin WHERE variable='USERinterval'";
$sqlces = $db->select_one($qryces);
$secyear = $sqlces*$secmonth;
//$secyear='31536000';
?>
<html>
<head>
<link href="./style/stylesheet.css" rel="stylesheet" />
<style type="text/css"></style>
<title>
Induction System by LG Coding
</title>
</head>
<body>
<div id="all">
<div id="header">
<p>Tamworth</p>
</div>
	<div id="container">
<?php
if(!ISSET($_GET['course'])){
// Show Course selection
?>
<h1><center>Please select a section</center></h1>
<form method="GET" action="<?php echo $PHP_SELF;?>">
<div id="buttons" align="center"><input type="submit" class="button buttvis" name="course" value="visitor"/><br />
<input type="submit" class="button buttcon" name="course" value="contractor" /><br />
<input type="submit" class="button buttemp" name="course" value="qemployee" /></div>
</form>
<p class="admin_link">[<a href="./admin/">admin</a>]</p>
<?php
} elseif(ISSET($_GET['course'])){
// check course is a valid one
switch($_GET['course']) {
    case "visitor":
      // admin course selected
      $courseval="visitor";
      $_SESSION['course']="visitor";
      $_SESSION['coursepath']="./visitor/index.php";
      $imgstr = "buttvis";
      $misctext="Authorised Contact";
      break;
    case "contractor":
      // contractor course selected
      $courseval="contractor";
      $_SESSION['course']="contractor";
      $_SESSION['coursepath']="./contractor/index.php";
      $imgstr = "buttcon";
      $misctext="Contractor Ref + Business Name";
      break;
    case "qemployee":
      // contractor course selected
      $courseval="qemployee";
      $_SESSION['course']="qemployee";
      $_SESSION['coursepath']="./qemployee/index.php";
      $imgstr = "buttemp";
      $misctext="QantasLink Employee #";
      break;
    default:
      // assume no course selected, use meta refresh to go to logout.php
      $exittext='<meta http-equiv="refresh" content="0;url=logout.php" />';
      exit($exittext);
  }
// course is valid, display selected image
// based off the button above
echo "<div id=\"buttons\" align=\"center\"><input type=\"submit\" class=\"button $imgstr\" name=\"course\" value=\"\"/></div>";

if(ISSET($_GET['finish']) && $_GET['finish']=="ok") {
// course done, databased updated
echo "<h1>Induction complete!</h1>";
finaltext("You have successfully completed the induction course for your chosen module.<br /><a href=\"logout.php\">Click here to return to the main menu</a>.","normali");
}

// processing

if(ISSET($_POST['command'])&&(is_numeric($_POST['command']))) {
// processing form
// check submitted values
// expected fields are: fname, lname, dobd, dobm, doby, misc
if($_POST['fname']==""){
    $errors='1';
    $fnameerr="error";
}else{
  $fname=addslashes($_POST['fname']);
}
if($_POST['lname']==""){
    $errors='1';
    $lnameerr="error";
}else{
  $lname=addslashes($_POST['lname']);
}
if($_POST['misc']==""){
    $errors='1';
    $miscerr="error";
}else{
  $misc=addslashes($_POST['misc']);
}
if(($_POST['dobd']=="")||!is_numeric($_POST['dobd'])) {
    $errors='1';
    $dayerr="error";
}else{
  $dobd=$_POST['dobd'];
}
if(($_POST['dobm']=="")||!is_numeric($_POST['dobm'])) {
    $errors='1';
    $monerr="error";
}else{
  $dobm=$_POST['dobm'];
}
if(($_POST['doby']=="")||!is_numeric($_POST['doby'])) {
    $errors='1';
    $yearerr="error";
}else{
  $doby=$_POST['doby'];
}
} //if(ISSET($_POST['command'])&&(is_numeric($_POST['command']))

// end processing

// Show Details Form
?>
		<h1>User Details</h1>
		<p>Please enter your information below. All sections are required.<br />
<br />
If this is your first time with this course, you will be added to our database and the course will begin. <a href="privacy.html">Click here to read the privacy policy regarding the usage and storage of your data</a>.<br />
<br />
If you have taken this course in the past, you will be notified if you are required to take it again. If you do not need to do so, you will be shown the date from which you will need to re-take this course.</p>
		<form method="post" action="<?php echo $PHP_SELF."?course=".$_GET['course']; ?>">
			<label for="fname" class="<?php //if(ISSET($fnameerr)){echo "error";}?>">First Name:</label> <input type="text" class="<?php if(ISSET($fnameerr)){echo"error";}else{echo"text";}?>" name="fname" value="<?php if(ISSET($fname)){echo $fname;}?>" /><br />
			<label for="lname" class="<?php //if(ISSET($lnameerr)){echo "error";}?>">Last Name:</label> <input type="text" class="<?php if(ISSET($lnameerr)){echo"error";}else{echo"text";}?>" name="lname" value="<?php if(ISSET($lname)){echo $lname;}?>"/><br />
			<label class="<?php //if(ISSET($dayerr, $monerr, $yearerr)){echo "error";} ?>">Date of Birth:</label>
			<select name="dobd" class="<?php if(ISSET($dayerr)){echo "error";}?>"> <option value=""/>Day
<?php
for($i=1;$i<=31;$i++){
  if($i<10){$i='0'.$i;}
  if(ISSET($dobd) && $dobd==$i){
    echo "<option value=\"$i\" selected=\"selected\" />$i";
  }
  echo "<option value=\"$i\" />$i ";
}
?>
</select>
&nbsp;
<select name="dobm" class="<?php if(ISSET($monerr)){echo "error";}?>"> <option value=""/>Month
<?php
$monthlist=array(1 => "January",2 => "February",3 => "March",4 => "April",5 => "May",6 => "June",7 => "July",8 => "August",9 => "September",10 => "October",11 => "November",12 => "December");
for($i=1;$i<=12;$i++){
  if(ISSET($dobm) && $dobm==$i) {
if($i<10){$u='0'.$i;}else{$u==$i;}
    echo "<option value=\"$u\" selected=\"selected\">".$monthlist[$i];
  } else {
if($i<10){$u='0'.$i;}else{$u==$i;}
    echo "<option value=\"$u\">".$monthlist[$i];
}
}
?>

<!--
<option value="01" />January<option value="02" />February<option value="03" />March<option value="04" />April<option value="05" />May<option value="06" />June<option value="07" />July<option value="08" />August<option value="09" />September<option value="10" />October<option value="11" />November<option value="12" />December-->
</select>
&nbsp;
<select name="doby" class="<?php if(ISSET($yearerr)){echo "error";}?>"> <option value=""/>Year
<?php
for($i=1930;$i<=2000;$i++){
  if(ISSET($doby)&&($doby==$i)){
    echo "<option value=\"$i\" selected=\"selected\">$i";
  } else {
    echo "<option value=\"$i\" />$i";
  }
}
?>
</select>
<br />
<input type="hidden" name="command" value="<?php echo time();?>"/>
			<label for="misc" class="<?php //if(ISSET($miscerr)){echo "error";}?>"><?php echo $misctext;?></label> <input type="text" class="<?php if(ISSET($miscerr)){echo"error";}else{echo"text";}?>" name="misc" value="<?php if(ISSET($misc)){echo $misc;} ?>"/><br />
			<div id="buttons" align="center"><input type="submit" class="button buttok" name="submit" value=""/> <input type="submit" class="button buttcan" name="cancel" value="" onClick="document.forms[0].action = 'logout.php'; return true;"  /></div>
		</form>
<?php
if(ISSET($errors)){echo '<p class="errordesc ">Errors have been reported. Please check the form above for any missing information. The fields that did not register any information are highlighted in red. Please rectify this and try again. If you continue to receive this error, even after entering the correct information, please contact reception ASAP.</p>';
} //if(ISSET($errors))
elseif(!ISSET($errors) && ISSET($_POST['command'])) {
// form is processed, no errors, let get to the checking.

// generate date of birth and course
$datebirth=$dobd.$dobm.$doby;
$course=$_GET['course'];

// qry1 checks to see if there's a match for the submitted information already, and gets id and datelast to
// determine if they need to do it again or not
$qry1 = "SELECT id, datelast FROM users WHERE fname='$fname' AND lname='$lname' AND datebirth='$datebirth' AND course='$course'";
$sql1 = $db->select($qry1);
$sql1count = $db->row_count($sql1);
if($sql1count<1) {
  // no records found, create new record
  $insertqry = "INSERT INTO users(fname, lname, datebirth, course, misc) VALUES('$fname','$lname','$datebirth','$course', '$misc')";
  $insertsql = $db->insert_sql($insertqry);
  if(!ISSET($insertsql)){
    // query failed, show error and process
    finaltext("Error in SQL Statement at line 189: ".$db->print_last_error."<br />Query was: $insertqry","errordesc");
  }
  // from here, it succeeded. Assign values and get cracking on the course!

  // run quick query to get rowid
  $row=$db->select($qry1);
  $rowtwo=$db->get_row($row);
  $rowid=$rowtwo['id'];

  $_SESSION['rowid'] = $rowid;

  echo "<meta http-equiv=\"refresh\" content=\"10;url=".$_SESSION['coursepath']."\" />";
finaltext("Your information has been added to the database. This induction course will load in 10 seconds, or you can <a href=\"".$_SESSION['coursepath']."\">click here</a> to load it now.","normali");
} // if($sqlcount==0) {   NEW USER ADDITION
else { // record that matches has been found, lets have a look
  $row=$db->select($qry1);
  $rowtwo=$db->get_row($row);
  $datelast=$rowtwo['datelast'];
  $rowid=$rowtwo['id'];

  $timenow=time();
  if(($timenow-$datelast)<=$secyear){
    // less that timeinterval has passed, they do not need to do the course
    $datedue=$datelast+$secyear;
    $datedue=date('d-m-Y',$datedue);
    finaltext("You have taken this Induction within the time frame allowed, you do not need to do it again until $datedue. <a href=\"logout.php\">Click here to return to the main menu</a>","normali");
  } else {
    $_SESSION['rowid']=$rowid;
    // update the database with the MISC line
    $doneqry = "UPDATE users SET misc='$misc' WHERE id='$rowid'";
    $donesql=$db->update_sql($doneqry);
    // more than timeinterval has passed, you need to do it again
    echo "<meta http-equiv=\"refresh\" content=\"10;url=".$_SESSION['coursepath']."\" />";
    finaltext("You are required to undertake this induction course again. The course will load in 10 seconds, or you can <a href=\"".$_SESSION['coursepath']."\">click here</a> to load it now.","normali");
  } // record found, end processing
}
} // elseif(!ISSET($errors))
} //elseif(ISSET($_GET['course'])
// footer below
?>
</div>
</body>
</html>
