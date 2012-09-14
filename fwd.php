<?php
$file = "outputSQL.txt";//output file name
header("Content-Description: File Transfer");//forcing download
header("Content-Type: text/plain"); //content type
header("Content-Disposition: attachment; filename=\"$file\"");//forcing download
readfile ($file);//output to browser

/**
* Author  : Pawan Shetty ( pawanshetty@outlook.com )
* Version : 1.0
* Date    : 14/09/12
* Purpose : Force File Download
**/
?>