<?php
require_once('lib/gitpuller.inc.php');
$G= new GitPuller();
$G->dumpcfg();
$G->process($_POST['payload']);
?>
