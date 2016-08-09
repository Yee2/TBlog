<?php
namespace Admin\Controller;
use Think\Controller;
class MediaController extends Controller {
    private $pdo;
    static $user;
    public function _initialize(){
        $this->pdo=$pdo=db();
        $this->assign("siteTitle","后台管理");

    }
    public function upload($key){

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
