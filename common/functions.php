<?php
date_default_timezone_set('Asia/Shanghai');
include "db2.php";

function isAdd($outerIp, $status, $referer='', $innerIp='', $ua='', $os=''){
    global $db;
    $date = date("Y-m-d H:i:s",time());
    if($status == 'isVisit'){
        $sql = "INSERT INTO GoFish_people VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, NULL);";
        $statement = $db->prepare($sql);
	var_dump("INSERT INTO GoFish_people VALUES(NULL, '$outerIp', '$innerIp', '$ua','$os', 1,'$referer', '$date', '$status';");
        $result = $statement->execute(array($outerIp, $innerIp, $ua, $os, 1, $referer, $date, $status));
    }else if($status == 'isDownload'){
        $sql = "INSERT INTO GoFish_people VALUES(NULL, ?, '', '', '', 1, '', ?, ?, NULL); ";
        $statement = $db->prepare($sql);
        $result = $statement->execute(array($outerIp, $date, $status));
    }else if($status == 'isOpen'){
        $sql = "INSERT INTO GoFish_people VALUES(NULL, ?, '', '', '', 1, '', ?, ?, NULL); ";
        $statement = $db->prepare($sql);
        $result = $statement->execute(array($outerIp, $date, $status));
    }else{

    }
    if($result){
        return 0;
    }else{
        return -1;
    }
}

function isVisit($outerIp, $os, $ua, $innerIp, $referer){
    global $db;
    if($outerIp <> ""){ //  || ($os <> "" && $ua <> "" && $innerIp <> "")
        $sql = "select outerIp,count from GoFish_people where outerIp = ? and status = 'isVisit'";
        $statement = $db->prepare($sql);
        $statement->execute(array($outerIp));
        $result = $statement->fetch();
        if(!$result){
	    #var_dump(1);
            if(isAdd($outerIp, 'isVisit', $referer, $innerIp, $ua, $os) == 0) {
                return 0;
            }else{
	        var_dump(2);
                return -1;
            }
            #$db = null;
        }else{
            // 已经存在，这里只需需要添加访问的次数，count字段 自增1 并且更新访问的时间
            $date = date("Y-m-d H:i:s",time());
            $count = (int)$result['count'];
            $count++;
            $sql = "update GoFish_people set count = ?, time = ? where outerIp = ? and status = 'isVisit'";
            $statement = $db->prepare($sql);
            $result = $statement->execute(array($count,$date, $outerIp));
            #$db = null;
            if($result){
                return 0;
            }else{
                return -1;
            }
        }

    }else{
        return -1;
    }

    return 0;
}

function isDownload($outerIp){
    global $db;
    if($outerIp <> ""){ //  || ($os <> "" && $ua <> "" && $innerIp <> "")
        $sql = "select outerIp,count from GoFish_people where outerIp = ? and status = 'isDownload'";
        $statement = $db->prepare($sql);
        $statement->execute(array($outerIp));
        $result = $statement->fetch();
        if(!$result){
            if(isAdd($outerIp, 'isDownload', '', '' ,'' ,'') == 0) {
                return 0;
            }else{
                return -1;
            }
            $db = null;
        }else{
            // 已经存在，这里只需需要添加访问的次数，count字段 自增1 并且更新访问的时间
            $date = date("Y-m-d H:i:s",time());
            $count = (int)$result['count'];
            $count++;
            $sql = "update GoFish_people set count = ?, time = ? where outerIp = ? and status = 'isDownload'";
            $statement = $db->prepare($sql);
            $result = $statement->execute(array($count,$date, $outerIp));
            $db = null;
            if($result){
                return 0;
            }else{
                return -1;
            }
        }

    }else{
        return -1;
    }

    return 0;

}

function isOpen($outerIp){
    global $db;
    if($outerIp <> ""){ //  || ($os <> "" && $ua <> "" && $innerIp <> "")
        $sql = "select outerIp,count from GoFish_people where outerIp = ? and status = 'isOpen'";
        $statement = $db->prepare($sql);
        $statement->execute(array($outerIp));
        $result = $statement->fetch();
        if(!$result){
            if(isAdd($outerIp, 'isOpen', '', '' ,'' ,'') == 0) {
                return 0;
            }else{
                return -1;
            }
            #$db = null;
        }else{
            // 已经存在，这里只需需要添加访问的次数，count字段 自增1 并且更新访问的时间
            $date = date("Y-m-d H:i:s",time());
            $count = (int)$result['count'];
            $count++;
            $sql = "update GoFish_people set count = ?, time = ? where outerIp = ? and status = 'isOpen'";
            $statement = $db->prepare($sql);
            $result = $statement->execute(array($count,$date, $outerIp));
            #$db = null;
            if($result){
                return 0;
            }else{
                return -1;
            }
        }

    }else{
        return -1;
    }

    return 0;

}

function isDelete($id){
    global $db;
    $sql = "delete from GoFish_people where id = ?";
    $statement = $db->prepare($sql);
    $result = $statement->execute(array($id));
    $db = null;
    if($result){
        return 0;
    }else {
        return -1;
    }
}


function isSelect(){
    global $db;
    $sql = "select outerIp from GoFish_target";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    #$db = null;
    if($result){
        return $result;
    }
    //默认没有目标 则返回会空
    return '';
}

function isCloseTarget($outerIp){
    global $db;
    $sql = "delete from GoFish_target where outerIp = ?";
    $statement = $db->prepare($sql);
    $result = $statement->execute(array($outerIp));
    #var_dump($result);
    
    #$db = null;
    if($result){
        return 0;
    }else {
        return -1;
    }
}



