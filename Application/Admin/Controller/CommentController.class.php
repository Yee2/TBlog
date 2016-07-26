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
    public function index($post="all",$n=1){
        if($post!=="all"){
            $PID=(int)$post;
            $rs=$this->pdo->query("SELECT * FROM `blog_post` WHERE `PID`='$PID' ")->fetch();
            if($rs==false){
                $this->redirect('/Admin/Comment');
                return ;
                
            }
            $this->assign("post",$rs);
            $post=$PID;
        }
        $n=(int)$n>0?(int)$n:1;
        $pageSize=20;
        $offset=($n-1)*$pageSize;
        if($post!=="all"){
            $q=$this->pdo->query("SELECT `blog_comment`.*,`blog_post`.`title` AS `postTitle` FROM `blog_comment` left join `blog_post` on `blog_comment`.PID=`blog_post`.PID  WHERE `blog_comment`.`PID`='$post' ORDER BY `blog_comment`.`time` DESC LIMIT $offset,$pageSize ");
            $total=$this->pdo->query("select count(*) as total from `blog_comment` WHERE `PID`='$post' ")->fetch()["total"];
        }else{
            $q=$this->pdo->query("SELECT `blog_comment`.*,`blog_post`.`title` AS `postTitle` FROM `blog_comment` left join `blog_post` on `blog_comment`.PID=`blog_post`.PID  ORDER BY `blog_comment`.`time` DESC LIMIT $offset,$pageSize ");
            $total=$this->pdo->query("select count(*) as total from `blog_comment` ")->fetch()["total"];
        }
        $totalPage=ceil($total/$pageSize);
        $pagination='<nav style="text-align:center"><ul class="pagination">';
        if($n>1){
            $pagination.="<li><a href=\"".__APP__."/Admin/Comment/index/{$post}/".($n-1)."\">上一页</a></li>";
        }
        $i=($n-5)>1?($n-5):1;
        for($i;$i<$n;$i++){
            $pagination.="<li><a href=\"".__APP__."/Admin/Comment/index/{$post}/$i\">$i</a></li>";
        }
            $pagination.="<li class='active'><a href=\"".__APP__."/Admin/Comment/index/{$post}/{$n}\">{$n}</a></li>";
        $j=($n+5)<$totalPage?($n+5):$totalPage;
        for($i=$n+1;$i<=$j;$i++){
            $pagination.="<li><a href=\"".__APP__."/Admin/Comment/index/{$post}/{$i}\">{$i}</a></li>";
        }
        if($n<$totalPage){
            $pagination.="<li><a href=\"".__APP__."/Admin/Comment/index/{$post}/".($n+1)."\">下一页</a></li>";
        }
        $pagination.="</li></nav>";
        if($totalPage>1){
            $this->assign("pagination",$pagination);
        }
        
        $list=array();
        while($rs=$q->fetch()){
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