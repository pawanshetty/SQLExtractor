<?php
/**
* Author  : Pawan Shetty ( pawanshetty@outlook.com )
* Version : 1.0
* Purpose : Simple User-Interface to upload files.
* Date    : 14/09/2012
**/

include "head.inc";
require_once("JavaDecompiler.php");
require_once("SqlParser.php");
if(array_key_exists("file",$_FILES) == false){	//direct visit, redirect to index.php
echo "<a class=\"btn btn-medium btn-primary\" href=\"index.php\"><-- Go Back </a>";	//redirect to index.php
exit;	//stop execution
}

echo "<div class=\"hero-unit\" style=\"width:850px;margin-left:12%;\">";	//hero unit start

if($_FILES["file"]["name"]==""){	//if no file name specified, throw error
echo "<a class=\"btn btn-medium btn-primary\" href=\"index.php\"><-- Go Back </a><br/><br/><span class=\"label label-important\" style=\"font-size:16px;\">No File Selected!</span><br/><br/><b>Please go back and select a valid file.</b>";
exit;
}

//$allowedExts = array("txt", "jpeg", "gif", "png");	//list of allowed extenstions (if required in future, useful to filter files based on their types)
//$maxFileSize = 200000; //200k ----check again----
$fileName=explode(".", $_FILES["file"]["name"]);
$extension = end($fileName);	//get extenstion
//if ((($_FILES["file"]["type"] == "image/gif")	//possible filters if needed in future
//|| ($_FILES["file"]["type"] == "image/jpeg")
//|| ($_FILES["file"]["type"] == "image/pjpeg"))
//&& ($_FILES["file"]["size"] < $maxFileSize) && in_array($extension, $allowedExts))
  //{
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
	echo "<a class=\"btn btn-medium btn-primary\" href=\"./\"><-- Go Back </a><b> Note: Do Not reload/leave this page, untill you are done.</b><br/><br/><span class=\"label label-success\" style=\"font-size:18px\">File <b>" . $_FILES["file"]["name"] . "</b> Uploaded sucessfully</span><br/><br/>";
    //echo "<b>Uploaded File Name:</b> " . $_FILES["file"]["name"] . "<br />";
    echo "<b>File Type:</b> " . $_FILES["file"]["type"] . "<br />";
    echo "<b>File Size:</b> " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    //echo "<b>File Stored in (Server Path):</b> " . $_FILES["file"]["tmp_name"];
    }
  //}
//else
//  {
//  echo "Invalid file or Not supported";
//  }

echo "<br/>";  

$tempName = $_FILES["file"]["tmp_name"];
$extension = strtolower($extension); // converting extenstion to make it easy to comaprision
$sqlLists ="";	//output variable

if($extension == "sql") //check if sql dump
$sqlLists = SqlParser::parseSQLDump(file_get_contents($tempName)); //call if file is a SQL Dump , parsing will be speed
else if($extension == "class") //check if it is a java file
 {
  move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
       exec("jad -s class c:/xampp/htdocs/sql/upload/".$_FILES["file"]["name"]);
  exec("del.bat"); 
  JavaDecompiler::printDecompiled($_FILES["file"]["name"]);
  echo "break";
  }
else $sqlLists = SqlParser::parse(file_get_contents($tempName)); //call if file is not an SQL Dump
if(is_array($sqlLists)){
SqlParser::print_myArray($sqlLists);
//foreach($sqlLists as $sql):
//echo $sql."\n<br>\n<br>";
//endforeach;
}

echo "</div>";	//hero unit end

?>