<?php
require_once('lib/gitpuller.inc.php');
$G= new GitPuller();
$G->dumpcfg();
$payload = $_POST['payload'];
if(get_magic_quotes_gpc()){ 
    $payload=stripslashes($payload); 
}
$G->process($payload);
?>
