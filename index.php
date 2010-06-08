<?php
//echo $HTTP_RAW_POST_DATA; 
$push = json_decode($HTTP_RAW_POST_DATA);

//var_dump($push);

$head = split("/", $push->ref);
echo "Head of this was ".$head[count($head)-1]."<br/>";
?>
