<?php
    
    $host = "cdb-6b46bmmg.bj.tencentcdb.com:10130";
    $user = "root";
    $pass = "qingmm521";
    // $db = "db_highcharts";
    $db = "sys";
    $con = new mysqli ( $host, $user, $pass, $db ) or die ( "Unable to connect!" );
    $con->set_charset ( "utf8" );
    ini_set("error_reporting",E_ALL ^ E_NOTICE);
    $c1 = $con->real_escape_string($_GET['s1']);
    $c3 = $con->real_escape_string($_GET['score']);
    $map=array();
    $rslt=array();
    if($c1=='理科'){
        $info = $con->query ("SELECT snum18, srank18 FROM sta_sci WHERE score = '$c3'");
        $q = $info->fetch_assoc ();
        $rslt['l1'] = 511;
        $rslt['l2'] = 358;
        $rslt['num'] = $q['snum18'];
        $rslt['rank']= intval($q['srank18']);
        array_push($map,$rslt);
    }
    else{
        $info = $con->query ("SELECT asnum18, asrank18 FROM sta_art WHERE ascore = '$c3'");
        $q = $info->fetch_assoc ();
        $rslt['l1'] = 559;
        $rslt['l2'] = 441;
        $rslt['num'] = $q['asnum18'];
        $rslt['rank']= intval($q['asrank18']);
        array_push($map,$rslt);
    }
    
    print json_encode ( $map, JSON_NUMERIC_CHECK );
    //$url='../map/map-chart.php';
    //echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
    //header("Location: http://localhost:8080/highcharts/map/map-chart.php");
    
    $con->close ();
    
    ?>

