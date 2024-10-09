<?php
/**
 * 数据库配置文件
 * */
function table_sql($sql){
    $host = "localhost";
    $username = "root";
    $passwd = "123456";
    $dbname = "phpci7firyg";
    $mysqlport = "3306";
    // 创建连接
    // MySQL
    $conn = new \mysqli($host, $username, $passwd, $dbname, $mysqlport);
    $conn->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);
    $conn->query("SET NAMES 'UTF8'");
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    
    $result = $conn->query($sql);
    if (!$result) {
        die("连接失败: " . $conn->error);
    }
    $conn->close();
    return $result;
}

