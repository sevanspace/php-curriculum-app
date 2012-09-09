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

//get lesson Name identifier
$lessonName = $_POST['lessonName'];
//determine the choice of format
$choice = $_POST["choice"];
echo "Choice:" . $choice . "<br>";
$text = "";

?>
<html>
    <body>
    

<?php
//choice 0-text, 1-file, 2-link
if ($choice == "1"){
	$text = "1" . $_POST["lessontext"];
	echo "<br>Text submitted.<br>"; 
}

if ($choice == "2"){
echo "<br>File uploaded.<br>";
//upload file
if (
 ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 200000)) //img under .2 mb
|| ((($_FILES["file"]["type"] == "text/rtf")
|| ($_FILES["file"]["type"] == "text/doc"))
&& ($_FILES["file"]["size"] < 20000)) //text under 20 kb
|| ((($_FILES["file"]["type"] == "audio/mp3")
|| ($_FILES["file"]["type"] == "video/mpg"))
&& ($_FILES["file"]["size"] < 5000000))  ) //audio/video under 5 mb
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
	
	$fileName = $_FILES["file"]["name"];
	echo "File Name:" . $fileName . "<br>";
	
    if (file_exists("upload/" . $_FILES["file"]["name"])){
      $i=1;
      $finished = false;
      
      // divide file name from .type (lego.jpg --> lego, .jpg
      $strLength = strlen($fileName); //gets length of filename
  
      $type = strrchr($fileName, "."); //returns substr after/including "."
      $titleLength = $strLength - strlen($type);
      $title = substr($fileName,0,$titleLength); //file Name
           
      while(! $finished){
       	if(file_exists("upload/" . $title . $i . $type)){
       		$i++;
       	}
       	else {
       	$finished = true;
       	//insert # into file name (christianity3.jpg)
       	$fileName= $title . $i . $type;
       	move_uploaded_file($_FILES["file"]["tmp_name"],
      	"upload/" . $fileName);
    	  echo "Stored in: " . "upload/" . $fileName;
    	}
       }//endwhile
     }//end if file_exists
      //echo $_FILES["file"]["name"] . " already exists. ";
    else
      {
      $fileName = $_FILES["file"]["name"];
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      } //end else file_exists
      
	$text= "2" . $fileName;
    } //end else if files error > )
  }//end if file types
else
  {
  echo "Invalid file";
  }//end else file types
//upload finished

} //end if choice = 1

//check for link
if ($choice == "3"){
	echo "<br>Link submitted.<br>";
	$text = "3" . $_POST["lessonlink"];
}

//send text to data table
//mysql_query("INSERT INTO lessons (text) VALUES ('$text')")
mysql_query("UPDATE lessons
			SET text='$text'
			WHERE lessonName='$lessonName'
			")
	or die(mysql_error());


echo "<br><br>Values added<br>";

$result = mysql_query("SELECT * FROM lessons");

echo "<table border='1'>
<tr>
<th>topic</th>
<th>lessonName</th>
<th>prereqs</th>
<th>text</th>
<th>quiz</th>
<th>rewardFile</th>
</tr>";

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



?>
        <form>
            <br><br>
            <?php
                if(isset($lessonName)){//make sure a lesson is in progress
                    echo ' <input type="hidden" name="lessonName" value="' . $lessonName . '"/>';
                   echo ' <input type="submit" value="Next" name="Next"/>';
                   echo '<br><br><input type="button" value="Change Submission" name="change" onclick="window.location.href="lessoncontent.php?lesson=' . $lessonName . '">';
                }
                else{
                   echo 'No lesson submission currently in progress.';
                }
            ?>
            <br><br>
            <INPUT TYPE="BUTTON" VALUE="View All Lessons" ONCLICK="window.location.href='tableview1.php'">
        </form>
    
    </body>
</html>
