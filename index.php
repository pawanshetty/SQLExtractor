<?php
/**
* Author  : Pawan Shetty ( pawanshetty@outlook.com )
* Version : 1.0
* Purpose : Simple User-Interface to upload files.
* Date    : 14/09/2012
**/
include "head.inc"; 
?>

<style type="text/css">
body{
text-align:center;
padding:20px;
}
</style>
<body>
<div class="hero-unit" style="width:850px;margin-left:12%;">
<b><span class="alert alert-info" style="font-size:16px;">Choose a file from your computer, Press "Upload and Extract" and wait untill the upload is complete.</span></b><br/><br/><br/>
<form action="upload.php" method="post" enctype="multipart/form-data">
<!--<label for="file"><b>File:</b></label>-->
<input type="file" name="file" id="file" class="btn btn-inverse" style="padding-bottom:25px;"/> 
<br /><br />
<input type="submit" name="submit" value="Upload and Extract" class="btn btn-primary btn-large" style="width:200px;"/>
</form>
</div>
</body>
</html>