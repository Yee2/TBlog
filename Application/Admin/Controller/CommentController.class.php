<?php
namespace Admin\Controller;
use Think\Controller;
class CommentController extends Controller {
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
        $user=$rs->fetch(\PDO::FETCH_ASSOC);
        if($user["password"]!=$_SESSION["password"] && ACTION_NAME  != "login"){
            $this->redirect('/Admin/Index/login');
            return ;
        }
        self::$user=$user;
        $this->assign("siteTitle","后台管理");
        
    }
    public function index(){
        $q=$this->pdo->query("SELECT `blog_comment`.*,`blog_post`.`title` AS `postTitle` FROM `blog_comment` left join `blog_post` on `blog_comment`.PID=`blog_post`.PID ");
        $list=array();
        while($rs=$q->fetch(\PDO::FETCH_ASSOC)){
            $rs["name"]=htmlentities($rs["name"]);
            $rs["content"]=htmlentities($rs["content"]);
            $rs["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($rs["email"])))."?s=80&r=G&d=";
            $rs["date"]=date("Y-m-d",$rs["time"]);
            $list[]=$rs;
        }
        //var_dump($list);
        $this->assign("comments",$list);
        $this->display();
    }
    public function delete($CID){
        
        if(isset($_POST["arr"])){
            if(!is_array($_POST["arr"]) or ($t=COUNT($_POST["arr"]))<1){
                $this->error("删除失败，删除内容不存在",__APP__."/Admin/Index/index");
                return ;
                
            }
            $s="DELETE FROM `blog_comment` WHERE `CID` IN (";
            for($i=0;$i<$t;$i++){
                $p=(int)$_POST["arr"][$i];
                if(($i+1)<$t){
                    $s.="$p,";
                }else{
                    $s.="$p)";
                }
            }
            $rs=$this->pdo->exec($s);
            if($rs>0){
                $this->success("删除{$rs}条记录",__APP__."/Admin/Comment/index");
                return ;
            }else{
                $this->error("删除失败，删除内容不存在".$s);
            }
        }
        $CID=(int)$CID;
        $rs=$this->pdo->exec("DELETE FROM `blog_comment` WHERE `CID`='$CID'");
        if($rs<=0){
                $this->error("删除失败，删除内容不存在");
            
        }else{
                $this->success("操作成功",__APP__."/Admin/Comment/index");
            
        }
        return ;
    }
}