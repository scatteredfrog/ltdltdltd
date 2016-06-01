<?php
	$userArray     = array();
	$dogArray      = array();
	$executeThis   = $_POST['executeThis'];
	$user_name     = $_POST['tfUserName'];
	$user_id       = "0";
	$password      = md5($_POST['tfPassword']);
	$language      = $_POST['pkLanguage'];
	$new_user_name = $_POST['tfUserName'];
	$firstname     = $_POST['tfFirstName'];
	$lastname      = $_POST['tfLastName'];
	$email         = $_POST['tfEmail'];
	$userID        = $_POST['userID'];
	$dogName       = $_POST['dogName'];
	$dogID         = $_POST['dogID'];
	$todaysDate	   = $_POST['todaysDate'];
	$action		   = $_POST['action'];
	$walkNotes	   = $_POST['walkNotes'];
		
	switch ($executeThis)
	{
		case "logOn":
			logOn($user_name,$password);
			break;
		case "checkNewUserName":
			checkNewUserName($user_name);
			break;
		case "createNewUser":
			createNewUser($new_user_name,$firstname,$lastname,$email,$password,$language);
			break;
		case "numberOfDogs":
			numberOfDogs($userID);
			break;
		case "fetchDogNames":
			fetchDogNames($userID);
			break;
		case "fetchDogDetails":
			fetchDogDetails($userID,$dogName);
			break;
		case "numberOfRegistrees":
			numberOfRegistrees($userID,$dogName);
			break;
		case "logWalk":
			logWalk($dogID,$todaysDate,$action,$walkNotes,$userID);
			break;
		case "getLatestPee":
			getLatestPee($dogID);
			break;
		case "getLatestPoop":
			getLatestPoop($dogID);
			break;
		default:
			break;
	}
	
	function getLatestPee($dogID)
	{
		mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		mysql_select_db("fab4it_com") or die(mysql_error());
		$result = mysql_query("SELECT MAX(walkDate) FROM LTDtbWalk WHERE dogID='$dogID' AND action='1'");
		while ($row = mysql_fetch_array($result))
		{
			$userArray['lastPee']=$row['MAX(walkDate)'];
		}
		echo json_encode($userArray);
	}

	function getLatestPoop($dogID)
	{
		mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		mysql_select_db("fab4it_com") or die(mysql_error());
		$result = mysql_query("SELECT MAX(walkDate) FROM LTDtbWalk WHERE dogID='$dogID' AND action='2'");
		while ($row = mysql_fetch_array($result))
		{
			$userArray['lastPoop']=$row['MAX(walkDate)'];
		}
		echo json_encode($userArray);
	}
	
	function logWalk($dogID,$todaysDate,$action,$walkNotes,$userID)
	{
		$mysql_id=mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		$db="fab4it_com";
		mysql_select_db($db,$mysql_id);
		$year = "20".substr($todaysDate,6,2);
		$month = substr($todaysDate,0,2);
		$day = substr($todaysDate,3,2);
		$hour = substr($todaysDate,9,2);
		$minute = substr($todaysDate,12,2);
		$newDate=$year."-".$month."-".$day." ".$hour.":".$minute.":00";
		$timestamp=strtotime($newDate);
		$todaysDate=date('Y-m-d H:i:s',$timestamp);
		$sql="INSERT INTO LTDtbWalk (dogID,walkDate,action,walkNotes,userID) VALUES ('$dogID','$todaysDate','$action','$walkNotes','$userID')";
		$result=mysql_query("$sql",$mysql_id);
		$userArray['result']=$result;
		$userArray['date']=$newDate;
		echo json_encode($userArray);
	}
	
	function numberOfRegistrees($userID,$dogName)
	{
		mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		mysql_select_db("fab4it_com") or die(mysql_error());
		$rowCount=0;
		$rowCount2=0;
		$userArray['dogName']=$dogName;
		$result = mysql_query("SELECT LTDtbDogRegistration.dogID FROM LTDtbDogRegistration,LTDtbDog WHERE LTDtbDog.dogName='$dogName' AND LTDtbDogRegistration.userID='$userID' AND LTDtbDogRegistration.dogID=LTDtbDog.dogID");
		while ($row = mysql_fetch_array($result))
		{
			$rowCount++;
			$userArray['dogID']=$row['dogID'];
		}
		$the_dog_id=$userArray['dogID'];
		$userArray['the_dog_id']=$the_dog_id;
		$result2 = mysql_query("SELECT userID FROM LTDtbDogRegistration WHERE dogID='$the_dog_id'");
		while ($row = mysql_fetch_array($result2))
		{
			$rowCount2++;
		}
		$userArray['numberOfRegistrees']=$rowCount2;
		echo json_encode($userArray);
		
	}
	function numberOfDogs($userID)
	{
		mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		mysql_select_db("fab4it_com") or die(mysql_error());
		$rowCount=0;
		$result = mysql_query("SELECT dogID FROM LTDtbDogRegistration WHERE userID='$userID'");
		while ($row = mysql_fetch_array($result))
		{
			$dogArray[$rowCount]=$row[$rowCount];
			$rowCount++;
		}
		$userArray['numberOfDogs']=$rowCount;
		echo json_encode($userArray);
	}
	
	function fetchDogNames($userID)
	{
		mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		mysql_select_db("fab4it_com") or die(mysql_error());
		$rowCount=0;
		$result = mysql_query("SELECT LTDtbDog.dogID,LTDtbDog.dogName FROM (LTDtbDog,LTDtbDogRegistration) WHERE LTDtbDogRegistration.userID='$userID' AND LTDtbDog.dogID=LTDtbDogRegistration.dogID");
		while ($row = mysql_fetch_array($result))
		{	
			$userArray[$rowCount]['dogName']=$row['dogName'];
			$userArray[$rowCount]['dogID']=$row['dogID'];
			$rowCount++;
		}
		echo json_encode($userArray);
	}
	
	function fetchDogDetails($userID,$dogName)
	{
		mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		mysql_select_db("fab4it_com") or die(mysql_error());
		$result = mysql_query("SELECT gender,spayneuter,breed FROM (LTDtbDog,LTDtbDogRegistration) WHERE LTDtbDogRegistration.userID='$userID' AND LTDtbDog.dogID=LTDtbDogRegistration.dogID AND LTDtbDog.dogName='$dogName'");	
		while ($row = mysql_fetch_array($result))
		{
			$dogArray['gender']=$row['gender'];
			$dogArray['spayneuter']=$row['spayneuter'];
			$dogArray['breed']=$row['breed'];
		}
		echo json_encode($dogArray);
	}
		
	function logOn($user_name,$password)
	{
		$userArray['fired']="fired";
		mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		mysql_select_db("fab4it_com") or die(mysql_error());
		$rowCount=0;
		$result=mysql_query("SELECT * FROM LTDtbUser WHERE username='$user_name' AND password='$password';");
		while ($row=mysql_fetch_array($result))
		{
			$rowCount++;
			$user_id=$row['userID'];
			$firstname=$row['firstName'];
			$lastname=$row['lastName'];
			$email=$row['eMail'];
			$language=$row['language'];
		}

		$userArray['userName']=$user_name;
		$userArray['userID']=$user_id;
		$userArray['firstName']=$firstname;
		$userArray['lastName']=$lastname;
		$userArray['eMail']=$email;
		$userArray['language']=$language;
		if ($rowCount==0)
			$userArray['userID']="-19";
		$userArray['rowCount'] = $rowCount;
		echo json_encode($userArray);
	}
	
	function createNewUser($user_name,$firstname,$lastname,$email,$password,$language)
	{
		$mysql_id=mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		$db="fab4it_com";
		mysql_select_db($db,$mysql_id);
		$sql="INSERT INTO LTDtbUser (username,firstName,lastName,eMail,password,language) VALUES ('$user_name','$firstname','$lastname','$email','$password','$language')";
		$result=mysql_query("$sql",$mysql_id);
		$userArray['result']=$result;
		echo json_encode($userArray);
	}

	function checkNewUserName($user_name)
	{
		mysql_connect("mysql.fab4it.com","fab4itcom","4baf09282004db") or die(mysql_error());
		mysql_select_db("fab4it_com") or die(mysql_error());
		$c=0;
		$UCuser_name=strtoupper($user_name);
		$result=mysql_query("SELECT UPPER(username) FROM LTDtbUser where username='$UCuser_name';");
		while ($row=mysql_fetch_array($result))
		{
			$c++;
		}
		$userArray['c']=$c;
		echo json_encode($userArray);
	}
?>