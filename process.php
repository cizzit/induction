<?php
// start sessions 
session_start();

// functions file, containing database class and functions 
require_once('db.class.php');
// put session variables into normal vars
  $course=$_SESSION['course'];
  $rowid=$_SESSION['rowid'];

  // check for empty vars. If any are empty (for whatever reason), take back to front page without updating any records
  if((!$course) || (!$rowid)) { exit($rowid); header("Location: logout.php"); }


$db = new db_class;
if (!$db->connect()) 
   $db->print_last_error(false);

  // update the $rowid with the time() variable
  $timenow=time();
  $query="UPDATE users SET datelast='$timenow' WHERE id='$rowid'";
  $sql=$db->update_sql($query);
  if($sql==FALSE) exit($db->print_last_error(false));

header("Location:index.php?course=".$course."&finish=ok");
//exit("Location:design.php?course=".$course."&finish=ok");
?> 
