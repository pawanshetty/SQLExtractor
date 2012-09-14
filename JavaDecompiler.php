
<?php
/**
* Author  : Pawan Shetty ( pawanshetty@outlook.com )
* Version : 1.0
* Purpose : Simple User-Interface to upload files.
* Date    : 14/09/2012
**/
require_once("SqlParser.php");
class JavaDecompiler  {

   public static function printDecompiled($fileName)
   {
   
    echo "<div><br/><span class=\"label label-success\" style=\"font-size:20px\">Decompiled Code</span></div></br>";
	echo $fileName;
    //<a class=\"btn btn-inverse btn-large\" href=\"fwd.php\" style=\"margin-bottom:5px;\">Save to File</a></div><br/>";
	$fp = fopen($fileName, "r");
	
	while(!feof($fp))
	{
	echo fgets($fp)."</br>";
	}
	$sqlLists = SqlParser::parse(file_get_contents($fileName)); //call if file is not an SQL Dump
if(is_array($sqlLists)){
$SqlParser= new SqlParser();
$SqlParser->print_myArray($sqlLists);
   }
   }
   
	}

?>