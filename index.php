<?php
require_once('lib/gitpuller.inc.php');
$G= new GitPuller();
$G->dumpcfg();
$G->process($HTTP_RAW_POST_DATA);

?>
