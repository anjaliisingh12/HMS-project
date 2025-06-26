<?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $usercontact=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");
    $sqlmain= "select * from patient where pcontact=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$usercontact);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];

    
    if($_GET){
        //import database
        include("../connection.php");
        $id=$_GET["id"];
        $sqlmain= "select * from patient where pid=?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result001 = $stmt->get_result();
        $contact=($result001->fetch_assoc())["pcontact"];

        $sqlmain= "delete from webuser where contact=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$contact);
        $stmt->execute();
        $result = $stmt->get_result();


        $sqlmain= "delete from patient where pcontact=?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$contact);
        $stmt->execute();
        $result = $stmt->get_result();

        //print_r($contact);
        header("location: ../logout.php");
    }


?>