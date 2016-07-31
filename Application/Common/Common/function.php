<?php 
#返回数据库连接
function db(){
    static $pdo=null;
    if($pdo==null){
        $mysql=C("MYSQL");
        $dsn = "mysql:host={$mysql['host']};dbname={$mysql['data']}";
        $pdo = new \PDO($dsn, $mysql['user'], $mysql['pass']);
        if(!$pdo){
            E($pdo->errorInfo()[2]);
            return ;
        }
        $pdo->query('set names utf8mb4');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
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
function addslashes_array($a){
        if(is_array($a)){
            foreach($a as $n=>$v){
                $b[$n]=addslashes_array($v);
            }
            return $b;
        }else{
            return addslashes($a);
        }
}
function plugin($tag,&$args=null){
    \Blog\Library\Plugin::listen($tag,$args);
}
function my($key=null){
    static $myself = array();
    if(is_array($key)){
        $myself=array_merge($myself,$key);
        return ;
    }
    $key=(string)$key;
    if(empty($key)){
        return $my;
    }
    return isset($myself[$key])?$myself[$key]:null;
}
function tblog($key=null){
    static $tblog = array();
    if(is_array($key)){
        $tblog=array_merge($tblog,$key);
        return ;
    }
    $key=(string)$key;
    if(empty($key)){
        return $tblog;
    }
    return isset($tblog[$key])?$tblog[$key]:null;
}