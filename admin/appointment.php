<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

    <title>Appointments</title>
    <style>
    .popup {
        animation: transitionIn-Y-bottom 0.5s;
    }

    .sub-table {
        animation: transitionIn-Y-bottom 0.5s;
    }
    </style>
</head>

<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    
    

    //import database
    include("../connection.php");
    $userrow = "select * from `admin` where aemail='$useremail'";
    $result = mysqli_query($database,$userrow);
    $userfetch=$result->fetch_assoc();
    $username=$userfetch["aname"];

    
    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo $username ?></p>
                                    <p class="profile-subtitle"><?php echo $useremail ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out"
                                            class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu">
                            <div>
                                <p class="menu-text">Dashboard</p>
                        </a>
        </div></a>
        </td>
        </tr>
        <tr class="menu-row">
            <td class="menu-btn menu-icon-doctor ">
                <a href="doctors.php" class="non-style-link-menu ">
                    <div>
                        <p class="menu-text">Doctors</p>
                </a>
    </div>
    </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-schedule ">
            <a href="schedule.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Schedule</p>
                </div>
            </a>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
            <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active">
                <div>
                    <p class="menu-text">Appointment</p>
            </a></div>
        </td>
    </tr>
    <tr class="menu-row">
        <td class="menu-btn menu-icon-patient">
            <a href="patient.php" class="non-style-link-menu">
                <div>
                    <p class="menu-text">Patients</p>
            </a></div>
        </td>
    </tr>

    </table>
    </div>
    <div class="dash-body">
        <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
            <tr>
                <td width="13%">
                    <a href="appointment.php"><button class="login-btn btn-primary-soft btn btn-icon-back"
                            style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px">
                            <font class="tn-in-text">Back</font>
                        </button></a>
                </td>
                <td>
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Appointment Manager</p>

                </td>
                <td width="15%">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                        Today's Date
                    </p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;">
                        <?php 

                        date_default_timezone_set('Asia/Kolkata');

                        echo date('d-m-Y');

                        ?>
                    </p>
                </td>
                <td width="10%">
                    <button class="btn-label" style="display: flex;justify-content: center;align-items: center;"><img
                            src="../img/calendar.svg" width="100%"></button>
                </td>


            </tr>
            <?php
                    if($_POST){
                        //print_r($_POST);
                        // $sqlpt1="";
                        if(!empty($_POST["sheduledate"]) && !empty($_POST["docid"]) ){
                            $sheduledate=$_POST["sheduledate"];
                            $docid=$_POST["docid"];
                            $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate='$sheduledate' and doctor.docid=$docid ";
                        }
                        else{
                            if(!empty($_POST["docid"])){
                                $docid=$_POST["docid"];
                                $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid where doctor.docid=$docid ";
                            }
                            elseif (!empty($_POST["sheduledate"])){
                            $sheduledate=$_POST["sheduledate"];
                            $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate='$sheduledate'";
                            }
                            else{
                                $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  order by schedule.scheduledate asc";
                           
                        }      
                    }                 
                    }else{
                        $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  order by schedule.scheduledate asc";

                    }

                    $result= $database->query($sqlmain);

                ?>

            <!-- <tr>
                <td colspan="4">
                    <div style="display: flex;margin-top: 40px;">
                        <div class="heading-main12"
                            style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49);margin-top: 5px;">Schedule a
                            Appointment</div>
                        <a href="booking.php" class="non-style-link"><button
                                class="login-btn btn-primary btn button-icon"
                                style="margin-left:25px;background-image: url('../img/icons/add.svg');">Book a
                                Appointment</font></button>
                        </a>
                    </div>
                </td>
            </tr> -->
            <tr>
                <td colspan="4" style="padding-top:10px;width: 100%;">

                    <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All
                        Appointments (<?php echo $result->num_rows; ?>)</p>
                </td>

            </tr>
            <tr>
                <td colspan="4" style="padding-top:0px;width: 100%;">
                    <center>
                        <table class="filter-container" border="0">
                            <tr>
                                <td width="10%">

                                </td>
                                <td width="5%" style="text-align: center;">
                                    Date:
                                </td>
                                <td width="30%">
                                    <form action="" method="post">

                                        <input type="date" name="sheduledate" id="date"
                                            class="input-text filter-container-items" style="margin: 0;width: 95%;">

                                </td>
                                <td width="5%" style="text-align: center;">
                                    Doctor:
                                </td>
                                <td width="30%">
                                    <select name="docid" id="" class="box filter-container-items"
                                        style="width:90% ;height: 37px;margin: 0;">
                                        <option value="" disabled selected hidden>Choose Doctor Name from the list
                                        </option><br />

                                        <?php 
                             
                                $list11 = $database->query("select  * from  doctor order by docname asc;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $sn=$row00["docname"];
                                    $id00=$row00["docid"];
                                    echo "<option value=".$id00.">$sn</option><br/>";
                                };


                                ?>

                                    </select>
                                </td>
                                <td width="12%">
                                    <input type="submit" name="filter" value=" Filter"
                                        class=" btn-primary-soft btn button-icon btn-filter"
                                        style="padding: 15px; margin :0;width:100%">
                                    </form>
                                </td>

                            </tr>
                        </table>

                    </center>
                </td>

            </tr>
            


            <tr>
                <td colspan="4">
                    <center>
                        <div class="abc scroll">
                            <table width="93%" class="sub-table scrolldown" border="0">
                                <thead>
                                    <tr>
                                        <th class="table-headin">
                                            Patient name
                                        </th>
                                        <th class="table-headin">

                                            Appointment number

                                        </th>


                                        <th class="table-headin">
                                            Doctor
                                        </th>
                                        <th class="table-headin">


                                            Session Title

                                        </th>

                                        <th class="table-headin" style="font-size:10px">

                                            Session Date & Time

                                        </th>

                                        <th class="table-headin">

                                            Appointment Date

                                        </th>

                                        <th class="table-headin">

                                            Events

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                
                                $result= $database->query($sqlmain);

                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="7">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We  couldnt find anything related to your keywords !</p>
                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $appoid=$row["appoid"];
                                    $scheduleid=$row["scheduleid"];
                                    $title=$row["title"];
                                    $docname=$row["docname"];
                                    $scheduledate=date("d-m-Y",strtotime($row["scheduledate"]));
                                    $scheduletime=date('h:i a ', strtotime($row["scheduletime"]));
                                    $pname=$row["pname"];
                                    $apponum=$row["apponum"];
                                    $appodate=$row["appodate"];
                                    echo '<tr >
                                        <td style="font-weight:600;"> &nbsp;'.
                                        
                                        substr($pname,0,25)
                                        .'</td >
                                        <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                        '.$apponum.'
                                        
                                        </td>
                                        <td>
                                        '.substr($docname,0,25).'
                                        </td>
                                        <td>
                                        '.substr($title,0,15).'
                                        </td>
                                        <td style="text-align:center;font-size:12px;">
                                            '.$scheduledate.' <br>'.$scheduletime.'
                                        </td>
                                        
                                        <td style="text-align:center;">
                                            '.$appodate.'
                                        </td>

                                        <td>
                                        <div style="display:flex;justify-content: center;">
                                       <a href="?action=drop&id='.$appoid.'&name='.$pname.'&session='.$title.'&apponum='.$apponum.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Cancel</font></button></a>
                                       &nbsp;&nbsp;&nbsp;</div>
                                        </td>
                                    </tr>';
                                    
                                }
                            }
                                 
                            ?>

                                </tbody>

                            </table>
                        </div>
                    </center>
                </td>
            </tr>



        </table>
    </div>
    </div>
    <?php
    
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='drop'){
            $nameget=$_GET["name"];
            $session=$_GET["session"];
            $apponum=$_GET["apponum"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Are you sure?</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            You want to delete this record<br><br>
                            Patient Name: &nbsp;<b>'.substr($nameget,0,40).'</b><br>
                            Appointment number &nbsp; : <b>'.substr($apponum,0,40).'</b><br><br>
                            
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

                        </div>
                    </center>
            </div>
            </div>
            '; 
        }
        // elseif($action=='booking-added'){
        //     $id=$_GET["id"];
        //     $list11 = $database->query("select  * from  patient where pid= $id;");
        //     $row00=$list11->fetch_assoc();
        //     $name=$row00["pname"];
        //     echo '
        //     <div id="popup1" class="overlay">
        //             <div class="popup">
        //             <center>
        //             <br><br>
        //                 <h2>Session Placed.</h2>
        //                 <a class="close" href="schedule.php">&times;</a>
        //                 <div class="content">Appointment booked Successfull for 
        //                 '.$name.'.<br><br>
                            
        //                 </div>
        //                 <div style="display: flex;justify-content: center;">
                        
        //                 <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
        //                 <br><br><br><br>
        //                 </div>
        //             </center>
        //     </div>
        //     </div>
        //     ';
        // }
}

    ?>

</body>

</html>