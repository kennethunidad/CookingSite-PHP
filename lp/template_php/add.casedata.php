<?









?>

<?
if(isset($_POST['goto'])){
	header("Location:add.casedata.php?sid=".$_POST['subject_id']);
	
}

?>

<?

if(isset($_GET['sid'])){
		include "../inc/questionaire.function.php";
	$sid=$_GET['sid'];
	if(isset($_GET['cid'])){
		
			
			$cid=$_GET['cid'];
			$sql="SELECT * FROM subject_case WHERE subject_id='".$sid."' AND case_id='".$cid."'";
			$query=mysql_query($sql) or die(mysql_error());
			if(mysql_num_rows($query) == 1){
				echo "<h3>Case Questions</h3><br/>";
				$tf=mysql_fetch_array($query);
				echo $tf['case_question']."<br/>";
				$sql="SELECT * FROM case_data WHERE case_id='".$cid."'";
				$q1=mysql_query($sql) or die(mysql_error());
				if(mysql_num_rows($q1) > 0){
					while($nt=mysql_fetch_array($q1)){
						echo $nt['question']."<br/>";
					}
				}else{
					echo "No data";
				}
				echo "<form action='add.casedata.php?sid=".$sid."&amp;cid=".$cid."' method='post'>
				<input type='hidden' name='action' value='20' />
				<input type='hidden' name='auth' value='".$admin_auth."'/>
				<input type='hidden' name='case_id' value='".$cid."'/>
				Questions:<textarea name='question' style='width:200px;height:100px'></textarea>
				<br/>Wrong Choices:(separated by @@)<input type='text' name='wrong_choices' />
				<br/>Correct Answer:<input type='text' name='correct_answer'/>
				<br/><button name='question_submit'>Question Submit</button>
				</form>";
			}else{
				echo "No data";
			}
	}else{ 
		
		$sql="SELECT * FROM subject_case WHERE subject_id='".$sid."'";
		$query=mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($query) > 0){
			while($tf=mysql_fetch_array($query)){
				
			echo "<a href='add.casedata.php?sid=".$sid."&amp;cid=".$tf['case_id']."'>".$tf['case_id']."</a><br/>";
			}
		}else{
			echo "No data";
		}
	}
}else{
	
	include "../inc/case.function.php";
	include "../inc/db.config.php";
	$sql="SELECT * FROM subject";
$query=mysql_query($sql) or die(mysql_error());
	echo "<form action='add.casedata.php' method='post'>
	<input type='hidden' name='auth' value='".$admin_auth."'/>
	<input type='hidden' name='action' value='20' />
Subject:<select name='subject_id'>"; 

 while($tf=mysql_fetch_array($query)){
	 echo "<option value='".$tf['subject_id']."'>".$tf['subject_name']."</option>";
 }


echo "</select><br/>
Case Text: <textarea name='case_question' style='width:200px;height:200px'></textarea>
</br>
<button name='case_submit'>Submit Case</button><br/>
<button name='goto'>View Case</button>
</form>";
}


?>