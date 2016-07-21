<?php
namespace Admin\Controller;
use Think\Controller;
class MediaController extends Controller {
    private $pdo;
    static $user;
    public function _initialize(){
        $this->pdo=$pdo=db();
        if(!isset($_SESSION["UID"]) && ACTION_NAME  != "login"){
            $this->redirect('/Admin/Index/login');
            return ;
        }
        $UID=(int)$_SESSION["UID"];
        $rs=$pdo->query("SELECT * FROM  `blog_user` WHERE `UID`='$UID' ");
        if($rs->rowCount()<=0 && ACTION_NAME  != "login"){
            $this->redirect('/Admin/Index/login');
            return ;
        }
        $user=$rs->fetch();
        if($user["password"]!=$_SESSION["password"] && ACTION_NAME  != "login"){
            $this->redirect('/Admin/Index/login');
            return ;
        }
        self::$user=$user;
        $this->assign("siteTitle","后台管理");
        
    }
    public function upload($key){
        function mkDirs($dir){
            if(!is_dir($dir)){
                if(!mkDirs(dirname($dir))){
                    return false;
                }
                if($dir==null){
                    return true;
                }
                if(!mkdir($dir,0777)){
                    return false;
                }
            }
            return true;
        }
        if(!isset($_FILES[$key])){
            echo json_encode(array('msg' =>"选择上传的文件" ));
            return ;
        }
        $file=$_FILES[$key];
        $ext=explode(".",$file["name"]);
        $ext=end($ext);
        if(!in_array($ext,array("jpg","png","jpeg","gif","bmp"))){
            echo json_encode(array('msg' =>"禁止上传非法文件" ));
            return ;
        }
        $saveDir="./Media/".date("Y/m");
        mkDirs($saveDir);
        $fileName=$saveDir."/".uniqid().".".$ext;
        move_uploaded_file($file["tmp_name"],$fileName);
        echo json_encode(array(
            "success"=>true,
            "file_path"=>"/".$fileName,
            ));
        return ;
    }
}