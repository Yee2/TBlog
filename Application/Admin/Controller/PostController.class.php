<?php
namespace Admin\Controller;
use Think\Controller;
import("Blog.Library.PHPTree");
class PostController extends Controller {
    private $pdo;
    static $user;
    public function _initialize(){
        $this->pdo=$pdo=db();
        self::$user=my();
        $this->assign("siteTitle","后台管理");

    }
    public function index($metaID=0){
        $metaID=(int)$metaID;
        if($metaID>0){
            $rs=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `MID`='$metaID' ");
            $meta=$rs->fetch();
            if($meta===false){
                $this->redirect('/Admin/Post/index');
                return ;
            }
            $this->assign("meta",$meta);
            $q=$this->pdo->query("SELECT * FROM `blog_relationship` LEFT JOIN `blog_post` ON `blog_relationship`.`post_id`=`blog_post`.`PID` LEFT JOIN `blog_user` ON `blog_user`.`UID` = `blog_post`.`UID` WHERE `blog_post`.`type`='post' AND `blog_relationship`.`meta_id`='$metaID' ");
        }else{
            $q=$this->pdo->query("SELECT * FROM `blog_post` LEFT JOIN `blog_user` ON `blog_user`.`UID` = `blog_post`.`UID` WHERE `blog_post`.`type`='post' ");
        }

        $list=array();
        $category=array(
            0=>""
            );
        while($rs=$q->fetch()){
            $rs["title"]=htmlspecialchars($rs["title"]);
            $rs["content"]=htmlspecialchars($rs["content"]);
            $rs["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($rs["email"])))."?s=80&r=G&d=";
            if($rs["MID"]==""){
                $rs["MID"]=0;
            }
                $qq=$this->pdo->query("SELECT * FROM `blog_relationship` LEFT JOIN `blog_meta` ON `blog_relationship`.`meta_id`=`blog_meta`.`MID` WHERE `blog_relationship`.`post_id`='".$rs['PID']."' ");
                while($meta=$qq->fetch()){
                    $rs["categorys"][]=$meta;
                }
            $list[]=$rs;
        }
        $this->assign("rs",$list);
        $this->display();
    }
    public function edit($PID=0){
        if(($PID=(int)$PID)>0){
            $Post = D("Post");
            if($Post->id($PID)==false){
                $this->redirect('/Admin/Index');
                return ;

            }
            $this->assign("post",$Post->post);
        }
        $rs=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `type`='category' ");
            if($rs==false){
                $this->redirect('/Admin/Index');
                return ;
            }
            $relationship=array_column($this->pdo->query("SELECT `meta_id` FROM `blog_relationship` WHERE `post_id`='$PID' ")->fetchAll(),"meta_id");
            while($category=$rs->fetch()){
                if(in_array($category["MID"],$relationship)){
                    $category["checked"]=true;
                }else{
                    $category["checked"]=false;
                }
                $categorys[]=$category;
            }
            $categorys=\PHPTree::makeTreeForHtml($categorys,array(
            'primary_key' 	=> 'MID',
            'parent_key'  	=> 'parent',
            ));
            // var_dump($categorys);
            $this->assign("categorys",$categorys);
        if(!IS_POST){
            $this->display();
            return ;
        }
        // else if(($l=strlen($_POST["title"]))>255){
        //     $this->error("添加失败:标题超过最大长度");
        //     return ;
        // }else if($l<=0){
        //     $this->error("添加失败:请输入标题");
        //     return ;
        //
        // }else if(empty($_POST["content"])){
        //     $this->error("添加失败:请输入内容");
        //     return ;
        //
        // }else if(strlen($_POST["slug"])>255){
        //     $this->error("添加失败:略缩名太长");
        //     return ;
        // }
        $slug=empty($_POST["slug"])?$_POST["title"]:$_POST["slug"];
        $Post = new D("Post");
        $Post->add(array(
            'title'     => $_POST["title"],
            'content'   => $_POST["content"],
            'slug'      => $slug,
        ));
        if($PID>0){
            $q=$this->pdo->query("SELECT * FROM `blog_post` WHERE `slug`='$slug' && `PID`!='$PID' && `type`='post'");
        }else{
            $q=$this->pdo->query("SELECT * FROM `blog_post` WHERE `slug`='$slug'  && `type`='post'");
        }
        if($q->fetch()){
            $slug.=uniqid();
        }
        $MID=(int)$_POST["category"];
        $q=$this->pdo->query("SELECT COUNT(*) as `c` FROM `blog_meta` WHERE `MID`='$MID' ");
        $rs=$q->fetch();
        if(!$rs or $rs["c"]<1){
            $MID=0;
        }
        $title=htmlspecialchars($_POST["title"]);
        $content=addslashes($_POST["content"]);
        $slug=htmlspecialchars($slug);
        $UID=self::$user["UID"];
        $time=time();
        if($PID>0){
            $rs=$this->pdo->exec("UPDATE `blog_post` SET `title`='$title',`content`='$content',`slug`='$slug' WHERE `PID`='$PID' ");
            $this->pdo->exec("DELETE FROM `blog_relationship` WHERE `post_id`='$PID' ");
            $sql="INSERT INTO `blog_relationship`(`post_id`,`meta_id`) VALUES ";
            foreach($_POST["category"] as $meta_id){
                $sql.="('$PID','$meta_id'),";
            }
            $this->pdo->exec(substr($sql,0,-1));
        }else{
            $rs=$this->pdo->exec("INSERT INTO `blog_post` (`UID`,`time`,`slug`,`type`,`title`,`content`) VALUES ('$UID','$time','$slug','post','$title','$content') ");
            $PID=$this->pdo->lastInsertId("PID");
            $sql="INSERT INTO `blog_relationship`(`post_id`,`meta_id`) VALUES ";
            foreach($_POST["category"] as $meta_id){
                $sql.="('$PID','$meta_id'),";
            }
            $this->pdo->exec(substr($sql,0,-1));
        }

        if($rs or $rs===0){
            $this->success("操作成功",__APP__.'/Admin/Index');
        }else{
            $this->error("操作失败");

        }

    }
    public function new(){
        if(!IS_POST){
            $this->display();
            return ;
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
        $q=$this->pdo->query(
            "SELECT * ,(SELECT COUNT( `blog_relationship`.`post_id` ) FROM `blog_relationship` WHERE `blog_relationship`.`meta_id`=`blog_meta`.`MID` ) AS `total` FROM `blog_meta` ");
        $list=array();
        while($rs=$q->fetch()){
            $rs["name"]=htmlspecialchars($rs["name"]);
            $rs["slug"]=htmlspecialchars($rs["slug"]);
            $rs["description"]=htmlspecialchars($rs["description"]);
            $list[]=$rs;

        }
        $list=\PHPTree::makeTreeForHtml($list,array(
            'primary_key' 	=> 'MID',
            'parent_key'  	=> 'parent',
            ));
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
            $meta=$rs->fetch();
            $this->assign("meta",$meta);
            $rs=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `type`='category' AND `MID`!='$MID' ");
        }else{
            $rs=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `type`='category' ");

        }

            if($rs==false){
                $this->redirect('/Admin/Index');
                return ;

            }
            while($category=$rs->fetch()){
                $categorys[]=$category;
            }
        $categorys=\PHPTree::makeTreeForHtml($categorys,array(
            'primary_key' 	=> 'MID',
            'parent_key'  	=> 'parent',
            ));
            $this->assign("categorys",$categorys);

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

        $slug=htmlspecialchars($_POST["slug"]);
        $name=htmlspecialchars($_POST["name"]);
        $description=htmlspecialchars($_POST["description"]);
        $parent=$_POST["parent"];
        $time=time();
        if($MID>0){
            $rs=$this->pdo->exec("UPDATE `blog_meta` SET `name`='$name',`slug`='$slug',`description`='$description',`parent`='$parent' WHERE `MID`='$MID' ");
        }else{
            $rs=$this->pdo->exec("INSERT INTO `blog_meta` (`name`,`slug`,`description`,`type`,`parent`) VALUES ('$name','$slug','$description','category','$parent') ");
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
        if($q->fetch()){
            $this->error("添加失败:请换一个地址");
            return ;
        }

        $title=htmlspecialchars($_POST["title"]);
        $content=addslashes($_POST["content"]);
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
