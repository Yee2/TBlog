<?php
    namespace Home\Behavior;
    // 读取网站配置
    class blogInitBehavior{
        public function run(&$param){
            $q=q("SELECT * FROM `blog_setting` ");
            while($rs=$q->fetch()){
                C($rs["key"],$rs["value"]);
            }
            #if(!get_magic_quotes_gpc()){
            #    $_GET=addslashes_array($_GET);
            #}
        }
    }