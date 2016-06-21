<?php
namespace Admin\Controller;
use Think\Controller;
class PostController extends Controller {
    private $pdo;
    static $user;
    public function _initialize(){
        $mysql=C("mysqlInfo");
        $dsn = "mysql:host={$mysql['host']};dbname={$mysql['database']}";
        $pdo = new \PDO($dsn, $mysql['user'], $mysql['pass']);
        $pdo->query('set names utf8mb4');
        $this->pdo=$pdo;
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
    public function edit($PID=0){
        if(($PID=(int)$PID)>0){
            $rs=$this->pdo->query("SELECT * FROM `blog_post` WHERE `PID`='$PID' and `type`='post' ");
            if($rs==false){
                $this->redirect('/Admin/Index');
                return ;
                
            }
            $post=$rs->fetch(\PDO::FETCH_ASSOC);
            $this->assign("post",$post);
        }
        $rs=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `type`='category' ");
            if($rs==false){
                $this->redirect('/Admin/Index');
                return ;
                
            }
            while($category=$rs->fetch(\PDO::FETCH_ASSOC)){
                $categorys[]=$category;
            }
            $this->assign("categorys",$categorys);
        if(!IS_POST){
            $this->display();
            return ;
        }else if(($l=strlen($_POST["title"]))>255){
            $this->error("添加失败:标题超过最大长度");
            return ;
        }else if($l<=0){
            $this->error("添加失败:请输入标题");
            return ;
            
        }else if(empty($_POST["content"])){
            $this->error("添加失败:请输入内容");
            return ;
            
        }else if(empty($_POST["slug"])){
            $this->error("添加失败:请输入略缩名");
            return ;
            
        }else if(!preg_match('#^\w{2,225}$#i',$_POST["slug"])){
            $this->error("添加失败:略缩名不符合规则（#^\w{2,225}$#i）");
            return ;
        }
        $slug=$_POST["slug"];
        if($PID>0){
            $q=$this->pdo->query("SELECT * FROM `blog_post` WHERE `slug`='$slug' && `PID`!='$PID' && `type`='post'");
        }else{
            $q=$this->pdo->query("SELECT * FROM `blog_post` WHERE `slug`='$slug'  && `type`='post'");
        }
        if($q->fetch(\PDO::FETCH_ASSOC)){
            $this->error("添加失败:请换一个地址");
            return ;
        }
        $MID=(int)$_POST["category"];
        $q=$this->pdo->query("SELECT COUNT(*) as `c` FROM `blog_meta` WHERE `MID`='$MID' ");
        $rs=$q->fetch(\PDO::FETCH_ASSOC);
        if(!$rs or $rs["c"]<1){
            $MID=0;
        }
        if(get_magic_quotes_gpc()){
            $title=$_POST["title"];
            $content=$_POST["content"];
        }else{
            $title=str_replace(array("'","\"","\n","\r"."\t"),array("\\'","\\\"","","",""),$_POST["title"]);
            $content=str_replace(array("'","\"","\n","\r"),array("\\'","\\\"","\\n",""),$_POST["content"]);
        }
        $UID=self::$user["UID"];
        $time=time();
        if($PID>0){
            $rs=$this->pdo->exec("UPDATE `blog_post` SET `title`='$title',`content`='$content',`MID`='$MID',`slug`='$slug' WHERE `PID`='$PID' ");            
        }else{
            $rs=$this->pdo->exec("INSERT INTO `blog_post` (`UID`,`MID`,`time`,`slug`,`type`,`title`,`content`) VALUES ('$UID','$MID','$time','$slug','post','$title','$content') ");            
        }

        if($rs){
            $this->success("操作成功",__APP__.'/Admin/Index');
        }else{
                            
            $this->error("操作失败:".$this->pdo->errorInfo()[2]);
        
        }
        
    }
    public function delete($PID=null){
        if(isset($_POST["arr"])){
            if(!is_array($_POST["arr"]) or ($t=COUNT($_POST["arr"]))<1){
                $this->error("删除失败，删除内容不存在",__APP__."/Admin/Index/index");
                return ;
                
            }
            $s="DELETE FROM `blog_post` WHERE `type`='post' and `PID` IN (";
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
                $this->success("删除{$rs}条记录",__APP__."/Admin/Index/index");
                return ;
            }else{
                $this->error("删除失败，删除内容不存在");
            }
        }
        $PID=(int)$PID;
        $rs=$this->pdo->exec("DELETE FROM `blog_post` WHERE `PID`='$PID' && `type`='post' ");
        if($rs<=0){
                $this->error("删除失败，删除内容不存在");
            
        }else{
                $this->success("操作成功",__APP__."/Admin/Index/index");
            
        }
        return ;
        
    }
    public function meta($MID=0){
        
        $q=$this->pdo->query("SELECT * FROM `blog_meta` ");
        $list=array();
        while($rs=$q->fetch()){
            $rs["name"]=htmlentities($rs["name"]);
            $rs["slug"]=htmlentities($rs["slug"]);
            $rs["description"]=htmlentities($rs["description"]);
            $list[]=$rs;
        }
        //var_dump($list);
        $this->assign("rs",$list);
        $this->display();
        
    }
    public function metaEdit($MID=0){
        if(($MID=(int)$MID)>0){
            $rs=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `MID`='$MID'");
            if($rs==false){
                $this->redirect('/Admin/Index');
                return ;
                
            }
            $meta=$rs->fetch(\PDO::FETCH_ASSOC);
            $this->assign("meta",$meta);
        }
        
        if(!IS_POST){
            $this->display();
            return ;
        }else if(($l=strlen($_POST["name"]))>255){
            $this->error("添加失败:名称超过最大长度");
            return ;
        }else if($l<=0){
            $this->error("添加失败:请输入名称");
            return ;
            
        }else  if(($l=strlen($_POST["slug"]))>255){
            $this->error("添加失败:略缩名超过最大长度");
            return ;
        }else if($l<=0){
            $this->error("添加失败:请输入略缩名");
            return ;
            
        }else if(!preg_match('#^\w{2,255}$#i',$_POST["slug"])){
            $this->error("添加失败:略缩名不符合规则（#^\w{2,225}$#i）");
            return ;
        }
        
        if(get_magic_quotes_gpc()){
            $name=$_POST["name"];
            $slug=$_POST["slug"];
            $description=$_POST["description"];
        }else{
            $slug=str_replace(array("'","\"","\n","\r"."\t"),array("\\'","\\\"","","",""),$_POST["slug"]);
            $name=str_replace(array("'","\"","\n","\r"."\t"),array("\\'","\\\"","","",""),$_POST["name"]);
            $description=str_replace(array("'","\"","\n","\r"),array("\\'","\\\"","\\n",""),$_POST["description"]);
        }
        
        $time=time();
        if($MID>0){
            $rs=$this->pdo->exec("UPDATE `blog_meta` SET `name`='$name',`slug`='$slug',`description`='$description' WHERE `MID`='$MID' ");            
        }else{
            $rs=$this->pdo->exec("INSERT INTO `blog_meta` (`name`,`slug`,`description`,`type`) VALUES ('$name','$slug','$description','category') ");            
        }

        if($rs){
            $this->success("操作成功",__APP__.'/Admin/Post/meta');
        }else{
                            
            $this->error("操作失败:".$this->pdo->errorInfo()[2]);
        
        }
        
    }
    public function metaDelete($MID,$array=null){
        $MID=(int)$MID;
        $rs=$this->pdo->exec("DELETE FROM `blog_meta` WHERE `MID`='$MID' ");
        if($rs<=0){
                $this->error("删除失败，删除内容不存在");
            
        }else{
                $this->success("操作成功",__APP__."/Admin/Post/meta");
            
        }
        return ;
        
    }
    public function pageIndex(){
        $q=$this->pdo->query("SELECT * FROM `blog_post` WHERE `type`='page' ORDER BY `order` ASC ");
        $list=array();
        while($rs=$q->fetch()){
            $list[]=$rs;
        }
        if(count($list)>0){
            $this->assign("rs",$list);
        }
        $this->display();
    }
    public function pageEdit($PID=0){
        $PID=(int)$PID;
        if($PID>0){
            $q=$this->pdo->query("SELECT * FROM `blog_post` WHERE `type`='page' and `PID`='$PID' ");
            if(!$rs=$q->fetch()){
                $this->redirect('/Admin/Index');
                return ;
            }
            $this->assign("page",$rs);
        }
        if(!IS_POST){
            $this->display();
            return ;
        }else if(($l=strlen($_POST["title"]))>255){
            $this->error("添加失败:标题超过最大长度");
            return ;
        }else if($l<=0){
            $this->error("添加失败:请输入标题");
            return ;
            
        }else if(empty($_POST["content"])){
            $this->error("添加失败:请输入内容");
            return ;
            
        }else if(empty($_POST["slug"])){
            $this->error("添加失败:请输入略缩名");
            return ;
            
        }else if(!preg_match('#^\w{2,225}$#i',$_POST["slug"])){
            $this->error("添加失败:略缩名不符合规则（#^\w{2,225}$#i）");
            return ;
        }
        $slug=$_POST["slug"];
        if($PID>0){
            $q=$this->pdo->query("SELECT * FROM `blog_post` WHERE `slug`='$slug' && `PID`!='$PID' && `type`='page'");
        }else{
            $q=$this->pdo->query("SELECT * FROM `blog_post` WHERE `slug`='$slug'  && `type`='page'");
        }
        if($q->fetch(\PDO::FETCH_ASSOC)){
            $this->error("添加失败:请换一个地址");
            return ;
        }
        
        if(get_magic_quotes_gpc()){
            $title=$_POST["title"];
            $content=$_POST["content"];
        }else{
            $title=str_replace(array("'","\"","\n","\r"."\t"),array("\\'","\\\"","","",""),$_POST["title"]);
            $content=str_replace(array("'","\"","\n","\r"),array("\\'","\\\"","\\n",""),$_POST["content"]);
        }
        $UID=self::$user["UID"];
        $time=time();
        if($PID>0){
            $rs=$this->pdo->exec("UPDATE `blog_post` SET `title`='$title',`content`='$content',`slug`='$slug' WHERE `PID`='$PID' ");            
        }else{
            $rs=$this->pdo->exec("INSERT INTO `blog_post` (`UID`,`MID`,`time`,`slug`,`type`,`title`,`content`) VALUES ('$UID','0','$time','$slug','page','$title','$content') ");            
        }

        if($rs){
            $this->success("正在返回",__APP__.'/Admin/Post/pageIndex');
        }else{
                            
            $this->error("操作失败:".$this->pdo->errorInfo()[2]);
        
        }
    }
    public function pageSort(){
        if(empty($_POST["sortData"]) or !($arr=json_decode($_POST["sortData"]))){
            $this->error("请求错误");
            return ;
        }
        $s="UPDATE `blog_post` SET `order` = CASE `PID` ";
        foreach ($arr as $k=>$v) {
            $s.=" WHEN $v THEN $k \n";
        }
        $s.="END WHERE `type`='page' ";
        $rs=$this->pdo->exec($s);
        if($rs !==false ){
            $this->success("操作成功",__APP__."/Admin/Post/pageIndex");
            return ;
        }else{
            $this->error("错误:".$this->pdo->errorInfo()[2]);
            return ;
        }
    }
    public function pageDelete($PID,$array=null){
        $PID=(int)$PID;
        $rs=$this->pdo->exec("DELETE FROM `blog_post` WHERE `PID`='$PID' && `type`='page' ");
        if($rs<=0){
                $this->error("删除失败，删除内容不存在");
            
        }else{
                $this->success("操作成功",__APP__."/Admin/Post/pageIndex");
            
        }
        return ;
        
    }
}