<?php
    $con = mysqli_connect('localhost','root');

    if($con){
        echo "Connection Successful";
    }
    else{
        echo "Connection Failed";
    }

    mysqli_select_db($con, 'plot_path');

    $direction = $_POST['d'];
    $length = $_POST['l'];

    $query = "INSERT INTO path (direction, length) VALUES ('$direction',$length)";

    mysqli_query($con,$query);
    
    header('location:plot.php');
    
?>