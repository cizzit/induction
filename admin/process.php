<?php
session_start();
// process.php
require_once('../db.class.php');
$db = new db_class;
if (!$db->connect()) 
   $db->print_last_error(false);

$wherefrom = $_SERVER['HTTP_REFERER'];
//////////////////////////
if (ISSET($_GET['interval'])) {
  // value exists and is a number
  $USERINT = $_GET['interval'];
  $qry = "UPDATE admin SET value='$USERINT' WHERE variable='USERinterval'";
  $updsql = $db->update_sql($qry);
  header("Location: ".$wherefrom);
}
//////////////////////////
if(ISSET($_GET['go']) && $_GET['go']=='reset') {
  // reset everyone to '0' activated time
  // need to get an array of 'id' from the database
  $qry_get = "SELECT id FROM users";
  $sql_get = $db->select($qry_get);
  $r = $db->select($qry_get);
  if (!$r) exit('QUERY FAILED');
  $i = 1;
  while ($row = mysql_fetch_assoc($r)) {
    foreach($row as $value) {
      $runqrydmc = "UPDATE users SET datelast='0' WHERE id='$value'";
      $runsqldms = $db->update_sql($runqrydmc);
    }
    $i++;
  }
  $dateupdated = date('dmY');
  $runqrydate = "UPDATE admin SET value='$dateupdated' WHERE variable='resetdate'";
  $runsqldate = $db->update_sql($runqrydate);
  header("Location: ".$wherefrom);
}
//////////////////////////
if(ISSET($_GET['report']) && is_numeric($_GET['report'])) {
  // report has been issued, lets open a switch to get our parameters
  if(!ISSET($_GET['sort'])){$sortdir = "ASC";$sortby="id";} else {$sortdir = $_GET['sortdir'];$sortby=$_GET['sort'];}
  $selects = "fname, lname, datebirth, datelast, course, misc";
  switch($_GET['report']) {
    case "1":
      // View all records held in database:
      $qry = "SELECT $selects FROM users ORDER BY $sortby $sortdir";
      $title = "All information held in database";
      break;
    case "2":
      // View all inductees for the "Visitor" course:
      $qry = "SELECT $selects FROM users WHERE course='visitor' ORDER BY $sortby $sortdir";
      $title = "All inductees for the Visitors course";
      break;
    case "3":
      // View all inductees for the "Contractor" course:
      $qry = "SELECT $selects FROM users WHERE coures='contractor' ORDER BY $sortby $sortdir";
      $title = "All inductees for the Contractors course";
      break;
    case "4":
      // View all inductees for the "QantasLink Employee" course:
      $qry = "SELECT $selects FROM users WHERE course='qemployee' ORDER BY $sortby $sortdir";
      $title = "All inductees for the QantasLink Employee course";
      break;
    case "5":
      // View all inductions performed on a certain date:
      if(ISSET($_GET['dat'])){
	$dat = $_GET['dat']; // should be formatted as ddmmyyyy
	$datd = substr($dat,0,2); //dd
	$datm = substr($dat,2,2); //mm
	$daty = substr($dat,4,4); //yyyy
	$godate = mktime(0,0,0,$datd, $datm, $daty);
      } else {
	$godate = time(); // defaults to today if not selected
      }
      $qry = "SELECT $selects FROM users WHERE datelast='$godate' ORDER BY $sortby $sortdir";
      $godategood = date('d-m-Y',$godate);
      $title = "All inductions performed on $godategood";
      break;
    case "6":
    case "7":
      // View all inductions that are expired or not yet expired
      $timenow = time();
      $secmonth = "SELECT value FROM admin WHERE variable='secmonth'";
      $secmonth = $db->select_one($secmonth);
      $intqry = "SELECT value FROM admin WHERE variable = 'USERinterval'";
      $intqry = $db->select_one($intqry);
      $intervaltime = $secmonth * $intqry;
      $timediff = time()-$intervaltime;
      if($_GET['report']=='6') {
	$qry = "SELECT $selects FROM users WHERE datelast<='$timediff' ORDER BY $sortby $sortdir";
	$title = "All records that are currently expired";
      } elseif($_GET['report']='7') {
	$qry = "SELECT $selects FROM users WHERE datelast>='$timediff' ORDER BY $sortby $sortdir";
	$title = "All records that are not yet expired";
      }
      break;
      default:
      header("Location: index.php"); // back to home page, you hax0r!
  }	// end switch
  // lets go ahead and update the database with lastran
  // vars are $_GET['report'] number, and time()
  $datelastran = time();
  $reporttype = $_GET['report'];
  $noqry = "UPDATE admin SET value='$datelastran' WHERE variable='report".$reporttype."'";
  $goqrygo = $db->update_sql($noqry);

  // by this time, $qry should be set, so lets run the query then dump it
  // lets pretty things up first
?>
<html>
<head>
<link rel="stylesheet" href="style.css" />
<script src="functions.js" type="text/javascript"></script>
</head>
<body>
<div id="content">
<table id="mngmnt">
<?php
  // going to use ind_dump() function, this will have the columns set up and colours, etc. Looks nice, I hope.
  $db->ind_dump($qry,$title);
?>
</body></html>
<?php
}
?>
