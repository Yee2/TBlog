<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    private $pdo;
    static $user;
    static public function isAdmin(){
        
    }
    public function _initialize(){
        $this->pdo=$pdo=db();
        $this->assign("siteTitle","后台管理");
        
    }
    public function login(){
        if(!IS_POST){
            $this->assign("adminLogin",true);
            C('LAYOUT_ON',false);
            $this->display();
            return ;
        }
        $name=addslashes($_POST["name"]);
        $password=md5($_POST["password"]);
        $rs=$this->pdo->query("SELECT * FROM  `blog_user` WHERE `name`='$name' and `password`='$password' ");
        if($rs->rowCount()<=0){
            $this->error("用户名或密码错误");
            return ;
        }
        $user=$rs->fetch();
        $_SESSION["UID"]=$user["UID"];
        $_SESSION["password"]=$user["password"];
        $this->success("登陆成功",__APP__."/Admin/Index/index");
    }
    public function index(){
        $this->display();
    }
    public function exitAdmin(){
        unset($_SESSION["password"]);
        $this->success("正在返回首页",__APP__);
    }
    public function changePassword(){
        if(!IS_POST){
            $this->display();
            return ;
        }
            if($_POST["password"]==""){
                $this->error("密码不能为空");
                
            }else{
                $password=md5($_POST["password"]);
                $UID=self::$user['UID'];
                $this->pdo->exec("UPDATE `blog_user` SET `password`='$password' WHERE `UID`='$UID' " );
                $this->success("请重新登陆",__APP__."/Admin/Index/index");
                
            }
        
    }
    public function info(){
        $this->display();
    }
    public function setting(){
        if(IS_POST){
            $blogTitle=htmlspecialchars($_POST["blogTitle"]);
            $blogKeyWorld=htmlspecialchars($_POST["blogKeyWorld"]);
            $blogDescription=htmlspecialchars($_POST["blogDescription"]);
            $s="REPLACE INTO `blog_setting` (`key`,`value`) VALUES ('blogTitle','$blogTitle'),('blogLogo','$blogLogo'),('blogKeyWorld','$blogKeyWorld'),('blogDescription','$blogDescription')";
            if($rs=db()->exec($s)){
                $this->success("正在返回");
                
            }else{
                $this->error("修改失败：".db()->errorInfo()[2]);
            }
            return ;
        }
        $this->display();
    }
}