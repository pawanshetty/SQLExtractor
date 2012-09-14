<?php

/**
* Author  : Pawan Shetty ( pawanshetty@outlook.com )
* Version : 1.0
* Purpose : Simple User-Interface to upload files.
* Date    : 14/09/2012
**/
class SqlParser {


    public static function parseSQLDump($content) { //for SQL Dump files shortcut to speedup things...
        $sqlList = array();
        $lines = explode("\n", $content); // Processing the SQL file content	 
        $query = ""; //just to sure
        // Parsing the SQL file content			 
        foreach ($lines as $sql_line): //for each line
            if (trim($sql_line) != "" && strpos($sql_line, "--") === false && strpos($sql_line, "#") !== 0){ //ignoring comments
                if(empty($sql_line)) continue; //skip if empty line
                $query .= $sql_line;
                // Checking whether the line is a valid statement
                if (preg_match("/(.*);/", $sql_line)) {
                    $sqlList[] = $query; //store this query
                    $query = ""; //reset the variable
                }
            }
        endforeach;
        return $sqlList;
    }
		
	public static function parse($content) {	//for SQL Dump files
	//list of start-words, which will normally start a query
	$startKeywords = array("SELECT ","INSERT ","CREATE ","UPDATE ","DELETE ","INDEX ","VIEW ","COMMIT ","ROLLBACK ","GRANT ","REVOKE ","CHECK "); 
	$content = strtoupper($content);	//convert all test to uppercase to ease comparision
	$sqlList = array();
	for($i=0;$i<12;$i++){ //checking all start-words
		$pos = ""; //eset pos
		$found = self::strpos_r($content, $startKeywords[$i]);	//recursive strpos to find all occurence of start-word
			foreach($found as $pos) {	//for each start-word found find the end of query
				if($pos != ""){	//if any stop words found
					if($content[$pos-1] == "\""){ //if " is found previous to query then seek next "
						$query="";	//reset query
						$tempPos=$pos;
						while($content[$tempPos] != "\""){ //find the respective terminating " charcter by character
							$query = $query . $content[$tempPos];
							$tempPos++;
							if($content[$tempPos-1] == "\\"){ //taking care of escaping in some programming lanuages by ignoring escaped "
								$query = $query . $content[$tempPos];
								$tempPos++;
							}//end if
						} //end while
						$sqlList[] = $query;
					} //end if
				} //end if
			} //end for each
		} //end for
	//self::print_myArray($sqlList);
	return $sqlList;
	}//End of function

	public static function strpos_r($haystack, $needle, $offset = 0, &$results = array()) { 
	//recuursively call strpos to find all occurences by keeping track of current offset and position               
		$offset = strpos($haystack, $needle, $offset);
		if($offset === false) {
			return $results;            
		} else {
			$results[] = $offset;
			return self::strpos_r($haystack, $needle, ($offset + 1), $results);
		}
	}	//end of strpos_r

	public function print_myArray($aArray){ //function to out put array(pretty)
	$aCount = count($aArray); //get array length
	echo "<div><span class=\"label label-success\" style=\"font-size:20px\">Total <b>" . $aCount . "</b> queries found!</span> <a class=\"btn btn-inverse btn-large\" href=\"fwd.php\" style=\"margin-bottom:5px;\">Save to File</a></div><br/>";
	$fp = fopen("outputSQL.txt", "w");	//open file for writing
	for($i=0;$i<$aCount;$i++){	//for each query
		echo $aArray[$i] . "<br/><br/>";	//ouput each query to browser
		fwrite($fp, " ".$aArray[$i]."\r\n");	//write line by line
	}
	fclose($fp);	//close file pointer
	}	//end of print_myArray

}	//End of class
?>