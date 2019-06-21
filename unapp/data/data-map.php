<?php

    $host = "http://cdb-6b46bmmg.bj.tencentcdb.com:10130";
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
    $c4="";
    $c5="";
    $set1=0;
    $set2=0;
    if($c1=='理科'){
        $info = $con->query ("SELECT snum18, srank18 FROM sta_sci WHERE score = '$c3'");
        $q = $info->fetch_assoc ();
        $c5 = intval($q['snum18']);
        $c4 = intval($q['srank18']);
        if($c4<=37000){
            $result = $con->query ( "SELECT * FROM science,college WHERE (18rank BETWEEN '$c4'-'$c5'* 5 AND '$c4'+ '$c5'* 15) AND science.university = college.uname ORDER BY 18score DESC" );
            $set1=3;
            $set2=10;
        }
        if($c4 >78000){
            $result = $con->query ( "SELECT * FROM science,college WHERE (18rank BETWEEN '$c4'-'$c5'* 7 AND '$c4'+ '$c5'* 25) AND science.university = college.uname ORDER BY 18score DESC" );
            $set1=7;
            $set2=15;
        }
        else{
            $result = $con->query ( "SELECT * FROM science,college WHERE (18rank BETWEEN '$c4'-'$c5'* 5 AND '$c4'+ '$c5'* 20) AND science.university = college.uname ORDER BY 18score DESC" );
            $set1=3;
            $set2=10;
        }
        
    }
    else{
        $info = $con->query ("SELECT asnum18, asrank18 FROM sta_art WHERE ascore = '$c3'");
        $q = $info->fetch_assoc ();
        $c5 = intval($q['asnum18']);
        $c4 = intval($q['asrank18']);
        if($c4<=23000){
            $result = $con->query ( "SELECT * FROM art,college WHERE (18rank BETWEEN '$c4'-'$c5'* 5 AND '$c4'+ '$c5'* 15) AND art.university = college.uname ORDER BY 18score DESC" );
            $set1=3;
            $set2=10;
        }
        if($c4 >46000){
            $result = $con->query ( "SELECT * FROM art,college WHERE (18rank BETWEEN '$c4'-'$c5'* 10 AND '$c4'+ '$c5'* 25) AND art.university = college.uname ORDER BY 18score DESC" );
            $set1=10;
            $set2=15;
        }
        else{
            $result = $con->query ( "SELECT * FROM art,college WHERE (18rank BETWEEN '$c4'-'$c5'* 10 AND '$c4'+ '$c5'* 20) AND art.university = college.uname ORDER BY 18score DESC" );
            $set1=3;
            $set2=10;
        }
    }
    
    while ( $r = $result->fetch_assoc () ) {
        if($c4-$r['18rank'] >= 0 OR $r['18rank']-$c4 <= $set1*$c5){
            $rslt['t']='冲刺';
        }
        if($r['18rank']-$c4 > $set2*$c5){
            $rslt['t']='保底';
        }
        if($r['18rank']-$c4 > $set1*$c5 AND $r['18rank']-$c4 <= $set2*$c5){
            $rslt['t']='稳妥';
        }
        $rslt['name']= $r['university'];
        $rslt['batch']= $r['batch'];
        $rslt['s18']= $r ['18score'];
        $rslt['r18']=$r['18rank'];
        $rslt['s17']= $r ['17score'];
        $rslt['r17']=$r['17rank'];
        $rslt['s16']= $r ['16score'];
         $rslt['r16']= $r ['16rank'];
        $rslt['loca']=$r['location'];
        $rslt['level']=$r['level'];
        $rslt['type']=$r['type'];
        $rslt['depa']=$r['department'];
        $rslt['cat']=$r['cate'];
        $rslt['link']=$r['link'];
        array_push($map,$rslt);
    }
    print json_encode ( $map, JSON_NUMERIC_CHECK );
    //$url='../map/map-chart.php';
    //echo "<meta http-equiv='Refresh' content='0;URL=$url'>";
    //header("Location: http://localhost:8080/highcharts/map/map-chart.php");

$con->close ();

?>
