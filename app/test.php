<?php

$order_no = "SAL-ORD-26";
$pos=strripos($order_no,"-");
echo substr($order_no,$pos+1,strlen($order_no));

?>