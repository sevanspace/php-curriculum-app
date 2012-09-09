<?php
ob_start();
$con = mysql_connect("SQL09.FREEMYSQL.NET","evanpractice","legodude232");
if (!$con)//"www.freesql.org","evantest","legodude232"
  {
  die('Could not connect: ' . mysql_error());
  }
  else
  {
//  echo "Connected!<br>";
  }

mysql_select_db("evanstorage") or die(mysql_error());
//echo "Connected to Database<br>";

$result = mysql_query("SELECT * FROM lessons ORDER BY topic");
$row = mysql_fetch_array($result);

$topic = $row['topic'];
if(mysql_num_rows($result)>=1){
	mysql_data_seek($result, 0);  
}



?>

<HTML>
<HEAD>


</HEAD>


<body onLoad ="javascript:ShowHide()">
<form name="form" action="prereqsubmit.php" method="post" enctype="multipart/form-data" onsubmit="selectAll()">
	<br>
	<!-- select topic for new lesson to fall under -->
	Choose the topic for the new lesson: <br>
	<select name="topicUnder" id ="topicselect" onchange ="javascript:ShowHide()">
		<?php
		if(mysql_num_rows($result)>=1){ // make sure table is not empty
			mysql_data_seek($result, 0);  
		

		$priortopic = 'FALSEVALUE';
		while($row = mysql_fetch_array($result)) {
			$topic = $row['topic'];
			if($topic != $priortopic){
				$priortopic = $topic;
 			 	echo '<option value="' . $topic . '">' . $topic . '</option>';
 			 }
 		}
 		
 		}
 		?>
		
		<option name="newtopt" id="newtopt" value="NewTopicCheck" >New Topic</option>
	</select>
	<br>
	<div name="newtdiv" id="newtdiv" >
		Name new topic:<br>
		<input type="text" name="newTopicName"/> 
		
	</div>
	
	<div>
	<br><br>
	Lesson title:<br>
	<input type="text" name="lessonName">
	<br><br>
	Prerequisites
	<br>
	<select name="topics" id="topics" size="4" onChange="updatelessons(this.selectedIndex)" style="width: 150px">
		<?php
		if(mysql_num_rows($result)>=1){ // make sure table is not empty
		
		mysql_data_seek($result, 0); 
		$priortopic = 'FALSEVALUE';
		while($row = mysql_fetch_array($result)) {
			$topic = $row['topic'];
			if($topic != $priortopic){
				$priortopic = $topic;
 			 	echo '<option value="' . $topic . '">' . $topic . '</option>';
 			 }
 		}
 		
 		}
 		?>
	</select>

	<select name="lessons" id="lessons" size="4" style="width: 150px" >
	</select>
	<input
		type="button"
		value="Add"

		onclick="addlesson(document.form.topics.selectedIndex, document.form.lessons.selectedIndex)">
	
	<br>
	<br>
	Selected:
	<br>
	<select multiple="multiple" name="selected[]" id="selected"  size="4" style="width: 150px">
	</select>
	<input
		type="button"
		value="Remove"

		onclick="removelesson()">
		
<br><br>	
<input
	type="submit" value="Submit" name="Submit">
	<br>
<INPUT TYPE="BUTTON" VALUE="View All Lessons" ONCLICK="window.location.href='tableview1.php'"> 	

</div>
</form>

<br>
<br>



<script type="text/javascript" language="JavaScript">

	document.getElementById("newtdiv").style.display = 'none'

	var topicslist=document.form.topics
	var lessonslist=document.form.lessons
	var selectedlist=document.form.selected
	var newtopicfield=document.form.newTopic
	//var selectedlist=document.form.getElementById("selected")
	
	var alreadyAdded = new Boolean(0)
	
	//this array will need to draw from previously user-defined values
	var lessons=new Array()
	<?php
	
	if(mysql_num_rows($result)>=1){ // make sure table is not empty
	
	mysql_data_seek($result, 0);
	if($row = mysql_fetch_array($result)){
		$priortopic = $row['topic'];
		$topic = $row['topic'];
		$i = 0;
		echo 'lessons[0]=["' . $row['lessonName'] . '"'; //begin entire lesson[] list
		while($row = mysql_fetch_array($result)) {
			$topic = $row['topic'];
			if($topic != $priortopic){
				$priortopic = $topic;
				$i++;
				echo ']' . "\n" . 'lesson[' . $i . ']=["' . $row['lessonName'] . '"';
			}
			else{
				echo ',"' . $row['lessonName'] . '"';
			}
		
		}
		echo ']'; // ends entire lesson[] list
	}
	
	}
	?>
	
		function ShowHide(){
			if(document.getElementById("newtopt").selected){
				document.getElementById('newtdiv').style.display = 'block'
			}
			else{
			document.getElementById('newtdiv').style.display = 'none'
			}
		}
		

	
	
	//shows lessons based on topic selected
	function updatelessons(selectedlessongroup){
		lessonslist.options.length=0
		for (i=0; i<lessons[selectedlessongroup].length; i++)
			lessonslist.options[lessonslist.options.length]=new Option(lessons[selectedlessongroup][i])
		
		lessonslist.options[0].defaultSelected = true
		
	}
	//adds selected lesson to "Selected" field
	function addlesson(topicselection, lessonselection){
		alreadyAdded = false
		for(i=0; i<selectedlist.options.length; i++) {
			if(selectedlist.options[i].text == lessons[topicselection][lessonselection]){
				alreadyAdded = true
			}
		}
		if (alreadyAdded == false) {
			selectedlist.add(new Option(lessons[topicselection][lessonselection]), null)
			selectedlist.options[selectedlist.options.length - 1].defaultSelected = true
		}
	
	
	}
	//removes selected lesson in Selected field from Selected field
	function removelesson(){

		for (var i = selected.options.length-1; i>=0; i--){
			if(selectedlist.options[i].selected){
				selectedlist.remove(selectedlist.options[i])
			}
		}
		
	
	}
	
	function selectAll(){
		for (var i=0; i<selectedlist.options.length; i++) {
			selectedlist.options[i].selected = true;
		}
	}
	

</script>


</body>


</HTML>
