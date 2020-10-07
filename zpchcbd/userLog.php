<?php

include "../common/db2.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        table {
            border-collapse: collapse;
            margin: 0 auto;
            border: none;
            width: 1200px;
        }

        th, td {
            border: solid #000 1px;
            text-align: center;
            width: 100px
        }
    </style>

</head>
<body>

<table>
    <tr>
        <!--<th>id</th>-->
        <th>inner ip</th>
        <th>outer ip</th>
        <th>ua</th>
        <th>os</th>
        <th>count</th>
        <th>referer</th>
        <th>time</th>
        <th>status</th>
        <th>备注</th>
	<th>操作</th>
    </tr>
    <?php
    global $db;
    #$sql = "select * from GoFish_people as a order by a.time asc;";#,a.count desc;";
    $sql = "select * from GoFish_people as a order by a.count desc;";
    $statement = $db->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    for($i=0;$i<$statement->rowCount();$i++){
        #echo "<tr><td>" .$result[$i]['id']. "</td>";
        echo "<td>" .$result[$i]['innerIp']. "</td>";
        echo "<td>" .$result[$i]['outerIp']. "</td>";
        echo "<td>" .$result[$i]['ua']. "</td>";
        echo "<td>" .$result[$i]['os']. "</td>";
        echo "<td>" .$result[$i]['count']. "</td>";
        echo "<td>" .$result[$i]['referer']. "</td>";
        echo "<td>" .$result[$i]['time']. "</td>";
        echo "<td>" .$result[$i]['status']. "</td>";
	echo "<td>" .$result[$i]['remarks']. "</td>";
        echo "<td><a href=javascript:void(0); onclick=del(".$result[$i]['id'].")>删除</a></td></tr>";
    }

    ?>
</table>


<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript">
function del(id) {

    $.get("/index.php?m=api&a=isDelete", {
        id: id,
    }, function (data) {
        if (data.isDelete == 1) {
            setTimeout(function () {
                window.location.reload();
            }, 1e3)
        }
    }, 'json');

}
</script>
</body>
</html>
