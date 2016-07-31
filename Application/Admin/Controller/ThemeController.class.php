<?php
namespace Admin\Controller;
use Think\Controller;
class ThemeController extends Controller {
    private $pdo;
    public function _initialize(){
        $this->pdo=$pdo=db();
        $this->assign("siteTitle","后台管理");
        
    }
    public function index(){
        $themes=array();
        $themeDir=APP_PATH."/Home/View/";
        $arr=scandir($themeDir);
        foreach($arr as $theme){
            if($theme==".." || $theme=="."){
                continue ;
            }
            $dir=$themeDir.$theme;
            if(!is_dir($dir) or !is_file($dir."/theme.json")){
                 continue;
            }
            $info=json_decode(file_get_contents($dir."/theme.json"),true);
            if($info==null){
                continue ;
            }
            $info["package"]=$theme;
            $themes[$theme]=$info;
        }
        $this->assign("themes",$themes);
        $this->display();
    }
    public function set($package){
            $dir=APP_PATH."/Home/View/".$package;
            if(!is_dir($dir) or !is_file($dir."/theme.json")){
            $this->redirect('/Admin/Theme/index');
                 return ;
            }
            $this->pdo->exec("UPDATE `blog_setting` SET `value`='$package' WHERE `key`='theme' ");
            $this->redirect('/Admin/Theme/index');
                 return ;
            
    }
    public function uninstall($package){
        function rm_rf($path){
             if(is_dir($path)){
                 $file_list= scandir($path);
                 foreach ($file_list as $file){
                     if( $file!='.' && $file!='..'){
                         if(!rm_rf($path.'/'.$file)){
                             return false;
                         }
                     }
                 }
                 return rmdir($path);
             } else {
                 return unlink($path);
             }
        }
        $path=APP_PATH."/Home/View/".$package;
        if(is_dir($path)){
            if(!rm_rf($path)){
                $this->error("卸载失败，请手动删除",'/Admin/Theme/index');
            }
        }
        $this->redirect('/Admin/Theme/index');
        return ;
    }
}