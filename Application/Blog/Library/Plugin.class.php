<?php
// 考虑到thinkphp自带的hook插件后缀有点长，所以自己编写插件类代替hook
namespace Blog\Library;
class Plugin{
    static private $tags=array();
    static function add($tag,$func){
        if(is_array($func)){
            self::$tags[$tag]   =   array_merge(self::$tags[$tag],$func);
        }else{
            self::$tags[$tag][] =   $func;
        }
        return ;
    }
    static function listen($tag,&$args=null){
        if(!is_array(self::$tags[$tag])){
            return ;
        }
        foreach (self::$tags[$tag] as $func) {
            $func($args);
            // code...
        }
    }
}