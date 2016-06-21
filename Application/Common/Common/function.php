<?php 
#返回数据库连接
function db(){
    static $pdo=null;
    if($pdo==null){
        $mysql=C("mysqlInfo");
        $dsn = "mysql:host={$mysql['host']};dbname={$mysql['database']}";
        $pdo = new \PDO($dsn, $mysql['user'], $mysql['pass']);
        if(!$pdo){
            E($pdo->errorInfo()[2]);
            return ;
        }
        $pdo->query('set names utf8mb4');
    }
    return $pdo;
}
#数据库查询
function q($t){
    if(!is_string($t)){
        return ;
    }
    return db()->query($t);
}