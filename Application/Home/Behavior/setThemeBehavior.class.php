<?php
    namespace Home\Behavior;
    // 读取网站配置
    class setThemeBehavior{
        public function run(&$param){
        $theme=tblog("theme");
        if(!is_dir(APP_PATH."/Home/View/".$theme) or !is_file(APP_PATH."/Home/View/$theme/theme.json")){
            $theme="default";
        }
        C("DEFAULT_THEME",$theme);
        }
    }