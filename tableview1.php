<?php
$con = mysql_connect("SQL09.FREEMYSQL.NET","evanpractice","legodude232");
if (!$con)//"www.freesql.org","evantest","legodude232"
  {
  die('Could not connect: ' . mysql_error());
  }
  else
  {
  //echo "Connected!<br>";
  }

// some code
mysql_select_db("evanstorage") or die(mysql_error());
//echo "Connected to Database<br>";

//-----------------------------------------------------


//get INPUTS
if(isset($_POST['Submit'])){
	if(isset($_POST['topic'])){	$topic = $_POST['topic']; } else{$topic = "";}
	if(isset($_POST['lessonName'])){	$lessonName = $_POST['lessonName']; } else{$lessonName = "";}
	if(isset($_POST['prereqs'])){	$prereqs = $_POST['prereqs']; } else{$prereqs = "";}
	if(isset($_POST['text'])){	$text = $_POST['text']; } else{$text = "";}
	if(isset($_POST['quiz'])){	$quiz = $_POST['quiz']; } else{$quiz = "";}
	if(isset($_POST['rewardFile'])){	$rewardFile = $_POST['rewardFile']; } else{$rewardFile = "";}
	if(isset($_POST['id'])){	$id = $_POST['id']; } else{$id = "";}
	/*$lessonName = $_POST['lessonName'];
	$prereqs = $_POST['prereqs'];
	$text = $_POST['text'];
	$quiz = $_POST['quiz'];
	$rewardFile = $_POST['rewardFile'];
	$id = $_POST['id'];*/
	if(isset($_POST['todelete'])){//check if anything was checked to delete
		$todelete = $_POST['todelete'];
	}
	
	if(isset($_POST['toremove'])){ //anything to remove?
		$toremove = $_POST['toremove'];
	}
	
	//create input[] array	
	for($i=0; $i<count($id); $i++){
		$input[$i]['topic'] = $topic[$i];
		$input[$i]['lessonName'] = $lessonName[$i];
		$input[$i]['prereqs'] = $prereqs[$i];
		$input[$i]['text'] = $text[$i];
		$input[$i]['quiz'] = $quiz[$i];
		$input[$i]['rewardFile'] = $rewardFile[$i];
		$input[$i]['id']=$id[$i];
		
		if(isset($todelete)){
			for($j=0; $j<count($todelete); $j++){
				if($todelete[$j]==$i){
					$input[$i]['delete'] = true;
                                        $j = count($todelete); //exit loop
				}
                                else{
                                    $input[$i]['delete'] = false;
                                }
				
			}
		}
		else{
			$input[$i]['delete'] = false;
		}
                
                //check if added rows need to be removed
                if(isset($toremove)){
                        for($j=0; $j<count($toremove); $j++){
				if($toremove[$j]==$i){
					$input[$i]['delete'] = true;
                                        $j = count($toremove); // exit loop
                                }
                                //no "else{} because the "todelete" has already been checked
                        }
                }	
           }
}

//$tbl_name="lessons"; // Table name

//$sql="SELECT * FROM $tbl_name";

//get database table
$query="SELECT 
	@i := @i + 1 as row_number, lessons.*
	FROM
		lessons,
		(select @i := 0) vlessons
		
	ORDER BY topic";

//ROW_NUMBER() OVER (ORDER BY topic) AS row, *
//FROM lessons";
$queryresult=mysql_query($query) or die(mysql_error());
mysql_data_seek($queryresult, 0); 
$r=0;
//$sql = array();
while($rows=mysql_fetch_array($queryresult)){ //get all db values and put them in a table array
	$sql[$r]['topic'] = $rows['topic'];
	$sql[$r]['lessonName'] = $rows['lessonName'];
	$sql[$r]['prereqs'] = $rows['prereqs'];
	$sql[$r]['text'] = $rows['text'];
	$sql[$r]['quiz'] = $rows['quiz'];
	$sql[$r]['rewardFile'] = $rows['rewardFile'];
	$sql[$r]['id'] = $rows['id'];
	$r++;
}


if(isset($input)){
    $lastinputrow = end(array_keys($input));
	for($i=0; $i<=$lastinputrow; $i++){
		if(isset($sql[$i])){
			if($input[$i]['delete']==false){
				$sql[$i]['topic']=$input[$i]['topic'];
				$sql[$i]['lessonName']=$input[$i]['lessonName'];
				$sql[$i]['prereqs']=$input[$i]['prereqs'];
				$sql[$i]['text'] = $input[$i]['text'];
				$sql[$i]['quiz'] = $input[$i]['quiz'];
				$sql[$i]['rewardFile']=$input[$i]['rewardFile'];
		
				mysql_query('UPDATE lessons SET topic = "' . $sql[$i]['topic'] . '",
                                             lessonName = "' . $sql[$i]['lessonName'] . '",
                                             prereqs = "' . $sql[$i]['prereqs'] . '",
                                             text = "' . $sql[$i]['text'] . '",
                                             quiz = "' . $sql[$i]['quiz'] . '",
                                             rewardFile = "' . $sql[$i]['rewardFile'] . '" WHERE id = ' . $sql[$i]['id']) or die(mysql_error());
                         
			}
			else {
			
				mysql_query('DELETE FROM lessons WHERE id = ' . $sql[$i]['id']) or die(mysql_error());
				unset($sql[$i]);
			}
		}
		else{
			if($input[$i]['delete'] == false){
				$sql[$i] = array('topic' => $input[$i]['topic'],
								'lessonName' => $input[$i]['lessonName'],
								'prereqs' => $input[$i]['prereqs'],
								'text' => $input[$i]['text'],
								'quiz' => $input[$i]['quiz'],
								'rewardFile' => $input[$i]['rewardFile']);
				
				mysql_query('INSERT INTO lessons (topic, lessonName, prereqs, text, quiz, rewardFile)
								VALUES ("' . $sql[$i]['topic'] . '", "' 
										. $sql[$i]['lessonName'] . '", "' 
										. $sql[$i]['prereqs'] . '", "' 
										. $sql[$i]['text'] . '", "'
                                                                                . $sql[$i]['quiz'] . '", "'
										. $sql[$i]['rewardFile'] . '")') or die(mysql_error());
			
			}
		}
	}	
	
}/*
$sql="SELECT * FROM $tbl_name";
$result=mysql_query($sql);
// Count table rows 
$count=mysql_num_rows($result);
mysql_data_seek($result, 0);  
$rows=mysql_fetch_array($result);
$id[]=$rows['id'];
mysql_data_seek($result, 0); 
*/

if(isset($sql)){
	$k=0;
	$temparray = array("");
	$topiclist = array("");
	$lastkey = end(array_keys($sql));
	for($i=0; $i<=$lastkey; $i++){
		if(isset($sql[$i])){
			$topict = $sql[$i]['topic'];
		
			if(!in_array($topict, $temparray)){
				$topiclist[$k] = '<option value="' . $topict . '">' . $topict . '</option>';
				$temparray[$k] = $topict;
				$k++;
			}
		}
	
	}
	$topicoptions=implode("",$topiclist);
}
else{
    $topicoptions="";
}
?>
<html>
	<body>
		<script>

			var added = 0

			function addRow() {
			
			added++;
			
			var table = document.getElementById("table2");

			var rowCount = table.rows.length - 1; //get # rows
			var row = table.insertRow(rowCount + 1);
                        
                        row.innerHTML = '<td align="center">' + rowCount + '<input type="hidden" name="id[]" id="id" value="' + rowCount + '"></td>' +
'<td align="center"><select name="topic[]" id="' + rowCount + '" value=""><?echo $topicoptions ?></select></td>' +
'<td align="center"><input name="lessonName[]" type="text" id="lessonName" value=""></td>' +
'<td align="center"><input name="prereqs[]" type="text" id="prereqs" value=""></td>' +
'<td align="center"><input name="text[]" type="text" id="text" value=""></td>' +
'<td align="center"><input name="quiz[]" type="text" id="quiz" value=""></td>' +
'<td align="center"><input name="rewardFile[]" type="text" id="rewardFile" value=""></td>' +
'<td align="center"><input name="toremove[]" type="checkbox" id="toremove" value="' + rowCount + '"></td>';
			/*
			var colCount = table.rows[0].cells.length; //get # columns
			
			for(var i=0; i<colCount; i++) {
				
				var rowid = table.rows.length - 1;
				
				var newcell = row.insertCell(i);
				
				
				switch(i){
					case 0:
						newcell.innerHTML = rowCount + '<input type="hidden" name="id[]" id="id" value="' + rowCount + '">';
						break;
					case 2: //Lesson Titles
						newcell.innerHTML='<input name="lessonName[]" type="text" id="lessonName" value="">';
					//	newcell.innerHTML = table.rows[rowCount - 1].cells[i].innerHTML;
					//	newcell.value = "";
						break;
					case 7: // Delete check
						newcell.innerHTML='<input name="toremove[]" type="checkbox" id="toremove" value="' + rowCount + '">';
					default:
						newcell.innerHTML = table.rows[rowCount].cells[i].innerHTML;
				}
				
		//		if(i==0){
		//			newcell.innerHTML = rowCount + '<input type="hidden" name="id[]" id="id" value="' + rowCount + '">';
		//		}
		//		else{
		//		newcell.innerHTML = table.rows[rowCount - 1].cells[i].innerHTML;
		//		}
				
			//	if(newcell.childNodes[0].name = "topic[]") {
					
				
	//			if(i=0){
			//		newcell.childNodes[0].value = "3";
			//	}
				
				
				
				/*switch(newcell.childNodes[0].type) {
					case "hidden":
					//	newcell.childNodes[0].value = ""
						break;
					case "text":
						//newcell.childNodes[0].value = "";
						break;
				}
				
				
                        }
				
			/*
			var cell1 = row.insertCell(0);
			var element1 = document.createElement("input");
			element1.type = "checkbox";
			cell1.appendChild(element1);

			var cell2 = row.insertCell(1);
			cell2.innerHTML = rowCount + 1;

			var cell3 = row.insertCell(2);
			var element2 = document.createElement("input");
			element2.type = "text";
			cell3.appendChild(element2);
			*/
                        }
		</script>
		<form name="form1" action="tableview1.php" method="post" enctype="multipart/form-data">
			<table>
				<table id="table2" width="500" border="0" cellspacing="1" cellpadding="0">


					<tr>
						<td align="center"><strong>id</strong></td>
						<td align="center"><strong>Topic</strong></td>
						<td align="center"><strong>Lesson Titles</strong></td>
						<td align="center"><strong>Prerequisites</strong></td>
						<td align="center"><strong>Lesson Material</strong></td>
						<td align="center"><strong>quiz</strong></td>
						<td align="center"><strong>rewardFile</strong></td>
						<td align="center"><strong>DELETE</strong></td>
					</tr>

<?php
	//prepare <select> str for topic options

$sql=array_values(array_filter($sql));

//mysql_data_seek($result, 0);  
//while($rows=mysql_fetch_array($result)){
if(isset($sql)){

$lastkey = end(array_keys($sql));
?>
<?php

for($i=0; $i<=$lastkey; $i++){
        if(isset($sql[$i])){
            $itopic = $sql[$i]['topic'];
            $ilessonName = $sql[$i]['lessonName'];
            $iprereqs = $sql[$i]['prereqs'];
            $itext = $sql[$i]['text'];
            $iquiz = $sql[$i]['quiz'];
            $irewardFile = $sql[$i]['rewardFile'];
            $iid = $sql[$i]['id'];
        }
        else{
            $itopic = "";
            $ilessonName = "";
            $iprereqs = "";
            $itext = "";
            $iquiz = "";
            $irewardFile = "";
            $iid = "";
        }
        
        /*
	if(isset($sql[$i]['topic'])){
		$itopic = $sql[$i]['topic'];
	}
	else{
		$itopic = "";
	}
	if(isset($sql[$i]['lessonName'])){
		$ilessonName = $sql[$i]['lessonName'];
	}
	else{
		$ilessonName = "";
	}
        
         */
?>


<tr>
<td align="center"><? echo $i; ?><input type="hidden" name="id[]" id="id" value="<? echo $i ?>"></td>
<td align="center"><? echo '<select name="topic[]" id="' . $i . '" value="' . $itopic . '">' . $topicoptions . '</select>'; ?></td>
<td align="center"><input name="lessonName[]" type="text" id="lessonName" value="<? echo $ilessonName; ?>"></td>
<td align="center"><input name="prereqs[]" type="text" id="prereqs" value="<? echo $iprereqs; ?>"></td>
<td align="center"><input name="changeText" type="button" value="Edit" ONCLICK="window.location.href='lessoncontent.php?editid=<? echo $iid; ?>'"><? echo substr($itext,1,7); ?>
            </td>
<td align="center"><input name="quiz[]" type="text" id="quiz" value="<? echo $iquiz; ?>"></td>
<td align="center"><input name="rewardFile[]" type="text" id="rewardFile" value="<? echo $irewardFile; ?>"></td>
<td align="center"><input name="todelete[]" type="checkbox" id="todelete" value="<? echo $i; ?>"></td>
</tr>



<?php
echo '
<script>
var options = document.getElementById("' . $i . '").getElementsByTagName("option")
for (var i=0; i<options.length; i++){
	if(options[i].value == "' . $itopic . '"){
		options[i].selected = true
	}
}
</script>
';
}
}
?>

				</table>
			</table>
			<input type="hidden" name="added[]" id="added" value="0"/>
			<input type="submit" name="Submit" value="Submit"/>
                        <br><br>
                        <input  type="button"  value="Add Row" onClick="addRow()"/>
                         <br><br>
                        <INPUT TYPE="BUTTON" VALUE="Create Lesson" ONCLICK="window.location.href='AdminScreen.php'"> 
                
                </form>
	
                
        </body>

</html>
