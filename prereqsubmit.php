


<?php
$con = mysql_connect("SQL09.FREEMYSQL.NET","evanpractice","legodude232");
if (!$con)//"www.freesql.org","evantest","legodude232"
  {
  die('Could not connect: ' . mysql_error());
  }
  else
  {
  echo "Connected!<br>";
  }

mysql_select_db("evanstorage") or die(mysql_error());
echo "Connected to Database<br>";

//store values from submission

if(isset($_POST['Submit'])){ // make sure something was actually submitted
    $topic = $_POST['topicUnder'];
    if ($topic == "NewTopicCheck"){ //get new topic name if submitted
        	$topic = $_POST['newTopicName'];
    }


    $lessonName = $_POST['lessonName'];
    //put into array
    if(!empty($_POST['selected'])){ // check to make sure prereqs were submitted
    	$prereqsarray = $_POST['selected'];
    	$semicolon_separated_prereqs = implode(";",$prereqsarray);
    }
    else{
    	$semicolon_separated_prereqs = ""; //define empty prereqs data entry
    }

    mysql_query("INSERT INTO lessons (topic, lessonName, prereqs)
    VALUES ('$topic', '$lessonName', '$semicolon_separated_prereqs')") or die(mysql_error());
    echo "Values added<br>";
}

//get data for drawing table
$result = mysql_query("SELECT * FROM lessons");

//build table
echo "<table border='1'>
<tr>
<th>topic</th>
<th>lessonName</th>
<th>prereqs</th>
<th>text</th>
<th>quiz</th>
<th>rewardFile</th>
</tr>";

//enter data for table
while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['topic'] . "</td>";
  echo "<td>" . $row['lessonName'] . "</td>";
  echo "<td>" . $row['prereqs'] . "</td>";
  echo "<td>" . $row['text'] . "</td>";
  echo "<td>" . $row['quiz'] . "</td>";
  echo "<td>" . $row['rewardFile'] . "</td>";
  echo "</tr>";
  }
echo "</table>";


//echo $_POST(

/*mysql_query("CREATE TABLE example(
id INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
 name VARCHAR(30), 
 age INT)")
 or die(mysql_error());  

echo "Table Created!<br>";*/


?>
<html>
<button type="button" onclick="clearTable()">Clear Table</button>

<script>

function clearTable() {
	window.open("cleartable.php", "Table Cleared!", "height=200, width=200")
}
</script>


<br>
<br>
<br>
<form action="lessoncontent.php" method="post" enctype="multipart/form-data">
<?php
if(isset($lessonName)){//make sure they came from the lesson creation page;
    echo ' <input type="hidden" name="lesson" value="' . $lessonName . '"/>';
    echo ' <input type="submit" value="Next" name="Next"/>';
       
}
else{
    echo 'No lesson submission currently in progress.';
}
?>
    <br><br>
<INPUT TYPE="BUTTON" VALUE="View All Lessons" ONCLICK="window.location.href='tableview1.php'"> 
</form>	
</html>