<?php
    namespace Admin\Behavior;
    class adminBehavior{
        public function run(&$param){
            if(APP_NAME=="Index" or ACTION_NAME == "login"){
                return ;
            }
            if(session_status() ===PHP_SESSION_NONE){
               session_start(); 
            }
            if(!isset($_SESSION["UID"])){
                header('Location: '.__APP__.'/Admin/Index/login');
                exit();
            }
            $UID=(int)$_SESSION["UID"];
            $user=q("SELECT * FROM  `blog_user` WHERE `UID`='$UID' ")->fetch();
            if($user===false or $user["password"]!=$_SESSION["password"]){
                header('Location: '.__APP__.'/Admin/Index/login');
                exit();
            }
            my($user);
            return ;
        }
    }