<?php
require_once('lib/gitpuller.inc.php');
//echo $HTTP_RAW_POST_DATA; 
//$push = json_decode($HTTP_RAW_POST_DATA);
//var_dump($push);

/*
$head = explode("/", $push->ref);
echo "<br/>Head of this was ".$head[count($head)-1]."<br/>\n";
echo "Owner was ".$push->repository->owner->name."<br/>\n";
echo "Project was ".$push->repository->name."<br/>\n";
 */
$G= new GitPuller();
$G->dumpcfg();
$G->process($HTTP_RAW_POST_DATA);

?>
