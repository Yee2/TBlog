<?php
namespace Blog;
define('BLOG_PATH',__DIR__);
class core{
    //  array(
    //      "pluginName"=>array(
    //          //pluginInfo
    //          )
    // );
    static $plugins=array();
    function app_begin(){
        import("Blog.Library.Plugin");
        self::plugin();
        return ;
    }
    function plugin(){
        self::pluginLoad();
        foreach (self::$plugins as $plugin) {
            include(BLOG_PATH."/Plugin/".$plugin."/init.php");
            // code...
        }
        return ;
    }
    function pluginLoad(){
        $plugins=unserialize(q("SELECT * FROM `blog_setting` WHERE `key`='plugins' ")->fetch()["value"]);
        foreach($plugins as $plugin=>$set){
            $dir=BLOG_PATH."/Plugin/".$plugin;
            if(!is_dir($dir) or !is_file($dir."/init.php") or $set["status"]!=="open"){
                 continue;
            }
            self::$plugins[]=$plugin;
        }
        return ;
    }
}