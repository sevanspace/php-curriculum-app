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

$tbl_name="lessons"; // Table name

$sql="SELECT * FROM $tbl_name";
$result=mysql_query($sql);

if(isset($_POST['Submit'])){

	$topic = $_POST['topic'];
	$lessonName = $_POST['lessonName'];
	$prereqs = $_POST['prereqs'];
	$text = $_POST['text'];
	$quiz = $_POST['quiz'];
	$rewardFile = $_POST['rewardFile'];
	$id = $_POST['id'];
	
	//$semicolon_separated_topics = implode(";",$topicsarray);
	//$changetopic = $_POST['topic'];
	//if ($changetopic == "NewTopicCheck"){ //get new topic name if submitted
	//	$changetopic = $_POST['newTopicName'];
	//}

	mysql_data_seek($result, 0);
	$count=mysql_num_rows($result);
	
	for($i=0;$i<$count;$i++){
//	if(isset($topic[$i])){
//		$sqltopic = 'topic = "' . $topic[$i];
//	}
//	else{
	//	$sqltopic = ""
	
	//$sqlupdate = 'UPDATE $tbl_name SET topic="' . $sqltopic
	
	$sql1="UPDATE $tbl_name SET topic='$topic[$i]', lessonName='$lessonName[$i]', prereqs='$prereqs[$i]', text='$text[$i]', quiz='$quiz[$i]', rewardFile='$rewardFile[$i]' WHERE id='$id[$i]'";
	$result1=mysql_query($sql1);
	}
	//$sqlupdate = 'UPDATE lessons SET topic='
//	mysql_query("UPDATE lessons
	//		SET topic='"
	//		WHERE lessonName='$lessonName'
	//		")
//	or die(mysql_error());
	
	
	
	
	//mysql_query("INSERT INTO lessons (topic, lessonName, prereqs)
	//VALUES ('$changetopic', '$lessonName', '$semicolon_separated_prereqs')") or die(mysql_error());
	//echo "Values added!<br>";
}
$sql="SELECT * FROM $tbl_name";
$result=mysql_query($sql);
// Count table rows 
$count=mysql_num_rows($result);
mysql_data_seek($result, 0);  
$rows=mysql_fetch_array($result);
$id[]=$rows['id'];
mysql_data_seek($result, 0);  
?>
<html>
<table width="500" border="0" cellspacing="1" cellpadding="0">
<form name="form1" action="tableview.php" method="post" enctype="multipart/form-data">
<tr> 
<td>
<table width="500" border="0" cellspacing="1" cellpadding="0">


<tr>
<td align="center"><strong>id</strong></td>
<td align="center"><strong>Topic</strong></td>
<td align="center"><strong>Lesson Titles</strong></td>
<td align="center"><strong>Prerequisites</strong></td>
<td align="center"><strong>Lesson Material</strong></td>
<td align="center"><strong>quiz</strong></td>
<td align="center"><strong>rewardFile</strong></td>
</tr>
<?php
while($rows=mysql_fetch_array($result)){
?>
<tr>
<td align="center"><? $id[]=$rows['id']; echo $rows['id']; ?><input type="hidden" name="id[]" id="id" value="<? echo $rows['id']; ?>"></td>
<td align="center"><input name="topic[]" type="text" id="topic" value="<? echo $rows['topic']; ?>"></td>
<td align="center"><input name="lessonName[]" type="text" id="lessonName" value="<? echo $rows['lessonName']; ?>"></td>
<td align="center"><input name="prereqs[]" type="text" id="prereqs" value="<? echo $rows['prereqs']; ?>"></td>
<td align="center"><input name="text[]" type="text" id="text" value="<? echo $rows['text']; ?>"></td>
<td align="center"><input name="quiz[]" type="text" id="quiz" value="<? echo $rows['quiz']; ?>"></td>
<td align="center"><input name="rewardFile[]" type="text" id="rewardFile" value="<? echo $rows['rewardFile']; ?>"></td>
</tr>
<?php
}
?>
<tr>
<td colspan="4" align="center"><input type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</td>
</tr>
</form>
</table>
</html>
<!--
<?php
// Check if button name "Submit" is active, do this 
/*if(isset($_POST['Submit'])){
	for($i=0;$i<$count;$i++){
	$sql1="UPDATE $tbl_name SET topic='$topic[$i]', lessonName='$lessonName[$i]', prereqs='$prereqs[$i]', text='$text[$i]', quiz='$quiz[$i]', rewardFile='$rewardFile[$i]' WHERE id='$id[$i]'";
	$result1=mysql_query($sql1);
	}
}

if(isset($result1)){
header("location:update_multiple.php");
}*/
mysql_close();
?>
-->
<!--
//-----------------------------------------------------
/*

//collect submitted info if table is submitted
if(isset($_POST['Submit'])){

	$topicsarray = $_POST['topic'];
	$semicolon_separated_topics = implode(";",$topicsarray);
	$changetopic = $_POST['topic'];
	//if ($changetopic == "NewTopicCheck"){ //get new topic name if submitted
	//	$changetopic = $_POST['newTopicName'];
	//}


	$lessonName = $_POST['lesson'];
	//put into array
	if(!empty($_POST['selected'])){ // check to make sure prereqs were submitted
		$prereqsarray = $_POST['selected'];
		$semicolon_separated_prereqs = implode(";",$prereqsarray);
	}
	else{
		$semicolon_separated_prereqs = ""; //define empty prereqs data entry
	}
	
	
	$sqlupdate = 'UPDATE lessons SET topic='
	mysql_query("UPDATE lessons
			SET topic='"
			WHERE lessonName='$lessonName'
			")
	or die(mysql_error());
	
	
	
	
	//mysql_query("INSERT INTO lessons (topic, lessonName, prereqs)
	//VALUES ('$changetopic', '$lessonName', '$semicolon_separated_prereqs')") or die(mysql_error());
	//echo "Values added!<br>";
}


//echo "<br><br>Values added<br>";

$result = mysql_query("SELECT * FROM lessons");
$row = mysql_fetch_array($result);
?>
<html>
<body>
<form name="form" action="tableview.php" method="post" enctype="multipart/form-data" >
<table border="1">
<tr>
<th>Topic</th>
<th>Lesson Title</th>
<th>Prerequisites</th>
<th>Lesson Material</th>
<th>quiz</th>
<th>rewardFile</th>
<th><input type="button" name="Edit" value="Edit"/>
</tr>




<?php

if(mysql_num_rows($result)>=1){ // make sure table is not empty
	mysql_data_seek($result, 0);  
	
	//generate topic list for each topic select in table
	$priortopic = 'FALSEVALUE';
	$k=0;
	while($row = mysql_fetch_array($result)) {
		$topic = $row['topic'];
		if($topic != $priortopic){
			$priortopic = $topic;
			$topiclist[$k] = '<option value="' . $topic . '">' . $topic . '</option>';
			$k++;
 		 }
 	}
 	
}
$topicoptions=implode("",$topiclist);

mysql_data_seek($result, 0);  
while($row = mysql_fetch_array($result))
  {
  $prereqs = str_replace(";",", ", $row['prereqs']);
  $texttype = substr($row['text'], 0, 1);
  $text = substr($row['text'], 1, 12);
  echo "<tr>";
  echo '<td><select name="topic[]" value=">' . $row['topic'] . '">' . $topicoptions . '</select></td>';
  echo '<td><input type="text" name="lesson[]" value="' . $row['lessonName'] . '"/></td>';
  echo "<td>" . $prereqs . "</td>";
  echo "<td>" . $text . "</td>";
  echo "<td>" . $row['quiz'] . "</td>";
  echo "<td>" . $row['rewardFile'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

?>

<br>
<input type="submit" name="Submit" value="Submit"/>
</form>
</body>
</html>
*/
-->