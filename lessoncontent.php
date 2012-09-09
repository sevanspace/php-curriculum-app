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

$tableReturn = false;
$lessonName = "";
$checked = "";

if(isset($_POST['lesson'])){
    $lessonName = $_POST['lesson'];
   
}
else{
    if(isset($_GET['editid'])){ //if coming from table, set true
       $lessonid = $GET['editid'];
     //   $lessonName = $_GET['editid'];
       $tableReturn = true;
     
     
       $text = mysql_query("SELECT text FROM lessons WHERE id = $lessonid");
       $type = substr($text,0,1);
       $text = substr($text,1,strlen($text)-1);
    }
    if(isset($_GET['lesson'])){//if coming back from lessonsubmit
       $lessonName = $_GET['lesson'];
       
       
       $text = mysql_query("SELECT text FROM lessons WHERE lessonName = $lessonName");
    }
}








?>

<HTML>
<HEAD>


</HEAD>


<body onload="javascript:CheckDefault(<? echo $type; ?>)">
<form name="classic" action="lessonsubmit.php" method="post" enctype="multipart/form-data">
Select method of lesson content entry:
<br>
<input type="radio" name="choice" multiple="false" value="1" id="1" onselect ="javascript:ShowHide(1)"/> Text <br>
<input type="radio" name="choice" multiple="false" value="2" id="2" onselect ="javascript:ShowHide(2)"/> File <br>
<input type="radio" name="choice" multiple="false" value="3" id="3" onselect ="javascript:ShowHide(3)"/> Link <br>

<!-- not needed anymore
<br>
<a onclick ="javascript:ShowHide(0)" href="javascript:;" >Enter Text</a>
<br>
<a onclick ="javascript:ShowHide(1)" href="javascript:;" >Submit File</a>
<br>
<a onclick ="javascript:ShowHide(2)" href="javascript:;" >Enter Link</a>
<br>
<br>
<br>
-->
<br>
<div class="mid" id=1 style="DISPLAY: none" >
<textarea name="lessontext" rows = 30 cols = 80 
    <? 
        if(isset($text)){
            echo 'value="' . $text . '"';
        }
    ?>
></textarea> 
</div>


<div class="mid" id=2 style="DISPLAY: none">
<input type="file" name="file" id="file">
</div>

<div class="mid" id=3 style="DISPLAY: none">
<input type="text" name="lessonlink">
</div>

<script language="JavaScript">
function ShowHide(divId){
	if(document.getElementById(divId).style.display == 'none'){
		document.getElementById(divId).style.display='block'
		for(i=1; i<10; i++){
			if(document.getElementById(i) != document.getElementById(divId)){
				document.getElementById(i).style.display = 'none'
			}
		}
	}
};	
//NOT NEEDED b/c the submit will only accept whatever choise is selected
//function clearContents(element1, element2) {
//	element1.value= "";
//	element2.value= "";
//}

function CheckDefault(type){ //set default selected input if sent from page
      loadradio = document.getElementById(type)
      loadradio.checked = "yes"
          
    
}


</script>

<br><br>	
<?php
echo ' <input type="hidden" name="lessonName" value="' . $lessonName . '"/>';
?>
<br>
<br>
<input type="submit" value="Next" name="Next"/>
	<br>
	<br>
	

<!--
<a onclick ="javascript:ShowHide("HiddenText")" href="javascript:;" >Enter Text</a>

<div id="HiddenText" class="mid"  style="DISPLAY: none" >
	<br>
	Hello Text
	<textarea name="lessontext" rows = 30 cols = 80></textarea> 
	<br>
</div>

<script language="JavaScript">
	function ShowHide(divName) {
		document.getElementByID(divName).style.display = "block"
		//for (i==0; i<10; i++) {
		//	if(document.getElementsByName(divName).id != i){
		//		document.getElementsById(i).style.display = "none"
		//	}
		// }
	}
</script> -->
</form>

</body>


</HTML>
