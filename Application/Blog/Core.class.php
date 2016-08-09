<?php
namespace Blog;
define('BLOG_PATH',str_replace('\\','/',__DIR__));
class core{
    //  array(
    //      "pluginName"=>array(
    //          //pluginInfo
    //          )
    // );
    static $plugins=array();
    function app_begin(){
        $q=q("SELECT * FROM `blog_setting` ");
        while($rs=$q->fetch()){
            tblog(array($rs["key"]=>$rs["value"]));
        }
        import("Blog.Library.Plugin");
        $this->plugin();
        return ;
    }
    private function plugin(){
        $this->pluginLoad();
        foreach (self::$plugins as $plugin) {
            include(BLOG_PATH."/Plugin/".$plugin."/init.php");
            // code...
        }
        return ;
    }
    private function pluginLoad(){
        $plugins=unserialize(tblog("plugins"));
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
