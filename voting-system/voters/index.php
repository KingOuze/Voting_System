<?php 
    require_once("inc/header.php");
    require_once("inc/navigation.php");



    if(isset($_GET['homePage']))
    {
        require_once("inc/home.php");
    }
    else if(isset($_GET['candidatingPage']))
    {
        require_once("inc/candidating.php");
    }
    else if(isset($_GET['informationPage']))
    {
        require_once("inc/info.php");
    }



    

    require_once("inc/footer.php");
?>