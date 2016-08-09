<?php
namespace Admin\Controller;
use Think\Controller;
class PhotoController extends Controller {
    private $pdo;
    static $user;
    public function _initialize(){
        $this->pdo=$pdo=db();
        self::$user=my();
        $this->assign("siteTitle","后台管理");

    }
    public function index($metaID=0){
      $this->display();
    }
    public function loading($metaID=0){
        if(($metaID=(int)$metaID)>0){
            $album=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `MID`='$metaID' and `type`='album' ")->fetch();
        }
        if($album===NULL or $album===0){
          $album=array(
            "MID"=>0,
            "name"=>"默认目录",
            "parent"=>0
          );
        }
        $rs=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `type`='album' AND `parent`='$metaID' ");
        $albums=array();
        while ($album_=$rs->fetch()) {
          $albums[]=$album_;
        }
        $rs=$this->pdo->query("SELECT * FROM `blog_relationship` LEFT JOIN `blog_post` ON `blog_relationship`.`post_id`=`blog_post`.`PID` WHERE `blog_post`.`type`='photo' AND `blog_relationship`.`meta_id`='$metaID' ");
        $photos=array();
        while ($photo_=$rs->fetch()) {
          $photos[]=$photo_;
        }
        echo json_encode(array(
          "album"=>$album,
          "albums"=>$albums,
          "photos"=>$photos
        ));
      return ;
    }


    public function editAlbum($metaID=0){
      if(($metaID=(int)$metaID)>0){
          $album=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `MID`='$metaID' and `type`='album' ")->fetch();
          if($album===false){
              echo json_encode(array('result' => "错误请求" ));
              return ;

          }
      }
      $name=$_POST["name"];
      $description=$_POST["description"];
      if($metaID===0){
      }
    }
    public function info($PID=0){
      $PID = (int)$PID;
      $photo=$this->pdo->query("SELECT * FROM `blog_post` WHERE `PID`='$PID' and `type`='photo' ")->fetch();
      if($photo == null){
        echo json_encode(array('result' => "错误请求"));
      }
      $photo["date"]=date("Y-m-d H:i",$photo["time"]);
      echo json_encode(array($photo));
      return ;
    }
    public function newAlbum($parentID=0){
      if(($parentID=(int)$parentID)>0){
          $album=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `MID`='$parentID' and `type`='album' ")->fetch();
          if($album===false){
              echo json_encode(array('result' => "错误请求" ));
              return ;
          }
      }
      $name=htmlspecialchars($_POST["name"]);
      $description=addslashes($_POST["description"]);
      $rs=$this->pdo->exec("INSERT INTO `blog_meta` (`type`,`name`,`description`,`parent`) VALUES ('album','$name','$description','$parentID') ");
      if($rs===1){
        echo json_encode(array("success"=>"添加成功"));
      }else{
        echo json_encode(array("result"=>"添加失败"));
      }
      return ;

    }
    public function upload($metaID=0){
      $metaID=(int)$metaID;
      if($metaID > 0){
        $album=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `MID`='$metaID' and `type`='album' ")->fetch();
        if($album==null){
          echo json_encode(array("error"=>"错误请求"));
          return ;
        }
      }
      $arr=explode('.',$_FILES["photo"]["name"]);
      $ext=strtolower(end($arr));
      if(!in_array($ext,array("png","jpg","gif","bmp","jpeg"))){
        echo json_encode(array("error"=>"禁止上传文件类型"));
        return ;
      }
      $saveDir="./Media/".date("Y/m");
      mkDirs($saveDir);
      $fileName=$saveDir."/".uniqid().".".$ext;
      if(!move_uploaded_file($_FILES["photo"]["tmp_name"],$fileName)){
        echo json_encode(array("error"=>"保存文件失败，请检查是否有权限"));
        return ;
      }
      $time=time();
      $slug=$fileName;
      $title=$_FILES["photo"]["name"];
      $UID=my("UID");
      $res=$this->pdo->exec("INSERT INTO `blog_post` (`UID`,`time`,`slug`,`type`,`title`,`content`) VALUES ('$UID','$time','$slug','photo','$title','') ");
      if($res<0){
        echo json_encode(array("error"=>"写入数据库失败"));
        unlink($fileName);
        return ;
      }
      $post_id=$this->pdo->lastInsertId();
      $this->pdo->exec("INSERT INTO `blog_relationship`(`post_id`,`meta_id`) VALUES ('{$post_id}','{$metaID}') ON DUPLICATE KEY UPDATE `post_id`='{$metaID}' ");
      echo json_encode(array(
        'initialPreviewConfig'=>array(
          'url'=>__APP__."/Admin/Photo/delete/"
        )
      ));
      return ;
    }
}
