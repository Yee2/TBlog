<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    private $pdo;
    public function _initialize(){
        $this->pdo=db();
        $this->assign("siteTitle","心情日记");
    }
    public function index($n=0){
        $n=(int)$n>0?(int)$n:1;
        $pageSize=5;
        $offset=($n-1)*$pageSize;
        $q=$this->pdo->query("SELECT * FROM `blog_post` LEFT JOIN `blog_user` ON `blog_user`.`UID` = `blog_post`.`UID` WHERE `blog_post`.`type`='post'  ORDER BY `time` DESC LIMIT $offset,$pageSize");
        $total=$this->pdo->query("select count(*) as total from `blog_post` where `type`='post' ")->fetch()["total"];
        $totalPage=ceil($total/$pageSize);
        $pagination='<ul class="pagination">';
        if($n>1){
            $pagination.="<li><a href=\"".__APP__."/Home/Index/index/".($n-1)."\">上一页</a></li>";
        }
        $i=($n-5)>1?($n-5):1;
        for($i;$i<$n;$i++){
            $pagination.="<li><a href=\"".__APP__."/Home/Index/index/$i\">$i</a></li>";
        }
            $pagination.="<li class='active'><a href=\"".__APP__."/Home/Index/index/$n\">$n</a></li>";
        $j=($n+5)<$totalPage?($n+5):$totalPage;
        for($i=$n+1;$i<=$j;$i++){
            $pagination.="<li><a href=\"".__APP__."/Home/Index/index/$i\">$i</a></li>";
        }
        if($n<$totalPage){
            $pagination.="<li><a href=\"".__APP__."/Home/Index/index/".($n+1)."\">下一页</a></li>";
        }
        $pagination.="</li>";
        if($totalPage>1){
            $this->assign("pagination",$pagination);
        }
        $list=array();
        while($rs=$q->fetch()){
            $rs["title"]=htmlspecialchars($rs["title"]);
            $rs["slug"]=urlencode($rs["slug"]);
            #$rs["content"]=htmlspecialchars($rs["content"]);
            $rs["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($rs["email"])))."?s=80&r=G&d=";
            $rs["date"]=date("Y-m-d",$rs["time"]);
            
                $qq=$this->pdo->query("SELECT * FROM `blog_relationship` LEFT JOIN `blog_meta` ON `blog_relationship`.`meta_id`=`blog_meta`.`MID` WHERE `blog_relationship`.`post_id`='".$rs['PID']."' ");
                while($meta=$qq->fetch()){
                    $rs["categorys"][]=$meta;
                }
            $list[]=$rs;
        }
        $this->assign("rs",$list);
        $this->display();
    }
    private function comments($PID,$n=1){
        $n=(int)$n>0?(int)$n:1;
        $pageSize=10;
        $offset=($n-1)*$pageSize;
        $total=$this->pdo->query("select count(*) as total from `blog_comment` where `PID`='$PID' ")->fetch()["total"];
        // if($offset>$total){
        //     $offset=0;
        // }
        $rs=$this->pdo->query("SELECT * FROM `blog_comment` WHERE `PID`='$PID' ORDER BY `time` DESC LIMIT $offset,$pageSize");
        $comments=array();
        while($c=$rs->fetch()){
                $c["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($c["email"])))."?s=80&r=G&d=";
                $c["date"]=date("Y-m-d H:i:s",$c["time"]);
                $comments[]=$c;
        };
        $totalPage=ceil($total/$pageSize);
        $prev=($n>1)?$n-1:false;
        $next=$n<$totalPage?$n+1:false;
        $this->assign("PID",$PID);
        return array(
            "comments"=>$comments,
            "page"=>array(
                "page"=>$n,
                "total"=>$totalPage,
                "next"=>$next,
                "prev"=>$prev,
                ),
            "total"=>$total,
            );
    }
    public function commentLoad(){
        $PID=(int)$_POST["post"];
        $n=(int)$_POST["page"];
        $rs=$this->comments($PID,$n);
            echo json_encode(array(
                "comments"=>$rs["comments"],
                "next"=>$rs["page"]["next"],
                "total"=>$rs["page"]["total"]
                ));
        
        return ;
    }
    public function post($slug){
        if(!preg_match("#(\w+)#",$slug,$s)){
            $this->error("文章未找到");
            return ;
        }
        $s=$s[1];
        $rs=$this->pdo->query("SELECT * FROM `blog_post` LEFT JOIN `blog_user` ON `blog_user`.`UID` = `blog_post`.`UID` WHERE `blog_post`.`type`='post' and `blog_post`.`slug`='$slug' ");
        if(!($post=$rs->fetch())){
            $this->error("文章未找到");
            return ;
        }
        
            $post["title"]=htmlspecialchars($post["title"]);
            $post["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($post["email"])))."?s=80&r=G&d=";
            $post["date"]=date("Y-m-d",$post["time"]);
            $qq=$this->pdo->query("SELECT * FROM `blog_relationship` LEFT JOIN `blog_meta` ON `blog_relationship`.`meta_id`=`blog_meta`.`MID` WHERE `blog_relationship`.`post_id`='".$post['PID']."' ");
                while($meta=$qq->fetch()){
                    $post["categorys"][]=$meta;
                }
        $this->assign("pageTitle",$post["title"]);
        $this->assign("post",$post);
        $rs=$this->pdo->query("SELECT * FROM `blog_user` WHERE `UID`='".$post["UID"]."' ");
        if($user=$rs->fetch()){
            $user["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($user["email"])))."?s=80&r=G&d=";
            $this->assign("author",$user);
        }else{
            $this->assign("author",array(
                "name"=>"匿名用户",
                "url"=>"/",
                "gravatar"=>"http://www.w3school.com.cn/i/compatible_chrome.gif"));
        }
        $comment=$this->comments($post["PID"]);
        if($comment["total"]){
            $this->assign("comments",$comment["comments"]);
            if($comment["page"]["next"]){
                $this->assign("commentLoad",2);
            }
        }
        $_SESSION["rand"]=md5(uniqid());
        $this->display();
    }
    public function respond($PID,$CID=null){
        $PID=(int)$PID;
        $rs=$this->pdo->query("SELECT * FROM `blog_post` WHERE `PID`='$PID' ");
        if(!($post=$rs->fetch())){
            $this->error("404");
            return ;
        }
        if(!$_SESSION["rand"] or $_SESSION["rand"]!==$_POST["rand"]){
            header('Location:'.$_SERVER['HTTP_REFERER']);
            return ;
        }
        $email=$_POST["email"];
        $name=$_POST["name"];
        $url=$_POST["url"];
        $content=$_POST["content"];
        $IP=$_SERVER["REMOTE_ADDR"];
        $time=time();
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->error("添加失败:错误的邮箱地址");
            return ;
        }
        if(!checkdnsrr(array_pop(explode("@",$email)),"MX")){
            $this->error("添加失败:请输入正确的邮箱地址");
            return ;
        }
        if(strlen($name)>255){
            $this->error("添加失败:第一格长度超过限制");
            return ;
            
        }
        if(strlen($name)===0){
            $this->error("添加失败:不支持匿名评论");
            return ;
            
        }
        if(strlen($content)>2048){
            $this->error("添加失败:第三格长度超过限制");
            return ;
            
        }
        if(strlen($content)===0){
            $this->error("添加失败:请输入评论内容");
            return ;
            
        }
        if($url!=null && !preg_match("#^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)?((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.[a-zA-Z]{2,4})(\:[0-9]+)?(/[^/][a-zA-Z0-9\.\,\?\'\\/\+&amp;%\$#\=~_\-@]*)*$#i",$url)){
            $this->error("添加失败:请输入正确的url");
            return ;
            
        }
        if($this->pdo->query("INSERT INTO `blog_comment` (`PID`,`upCID`,`UID`,`time`,`IP`,`name`,`email`,`url`,`content`) VALUES ('$PID','0','0','$time','$IP','$name','$email','$url','$content')")){
            $this->success("正在返回",$_SERVER['HTTP_REFERER']);
            unset($_SESSION["rand"]);
            cookie("memberName",$name);
            cookie("memberEmail",$email);
            cookie("memberURL",$url);
            return ;
        }else{
            $this->error("添加失败");
            return ;
            
        }
        
    }
    public function page($slug){
        if(!preg_match("#(\w+)#",$slug,$s)){
            $this->error("404");
            return ;
        }
        $s=$s[1];
        $rs=$this->pdo->query("SELECT * FROM `blog_post` WHERE `slug`='$slug' and `type`='page' ");
        if(!($page=$rs->fetch())){
            $this->error("404");
            return ;
        }
        $page["title"]=htmlspecialchars($page["title"]);
        $this->assign("pageTitle",$page["title"]);
        $this->assign("page",$page);
        $comment=$this->comments($post["PID"]);
        if($comment["total"]){
            $this->assign("comments",$comment["comments"]);
            if($comment["page"]["next"]){
                $this->assign("commentLoad",2);
            }
        }
        $_SESSION["rand"]=md5(uniqid());
        $this->display();
    }
    public function category($slug){
        if(!preg_match("#(\w+)#",$slug,$s)){
            $this->error("404");
            return ;
        }
        $s=$s[1];
        $category=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `slug`='$s' and `type`='category' ")->fetch();
        if(!$category){
            $this->error("404");
            return ;
        }
        $category["name"]=htmlspecialchars($category["name"]);
        $this->assign("category",$category);
        $MID=$category["MID"];
        $q=$this->pdo->query("SELECT `blog_post`.*,u.`name`,u.`email`,u.`url` FROM `blog_relationship`LEFT JOIN `blog_post` ON `blog_post`.`PID` = `blog_relationship`.`post_id` LEFT JOIN `blog_user` AS u ON u.`UID`=`blog_post`.`UID` WHERE `blog_relationship`.`meta_id`='$MID' AND `blog_post`.`type`='post'  ");
        $list=array();
        while($rs=$q->fetch()){
            $rs["title"]=htmlspecialchars($rs["title"]);
            #$rs["content"]=htmlspecialchars($rs["content"]);
            $rs["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($rs["email"])))."?s=80&r=G&d=";
            $list[]=$rs;
        }
        $this->assign("rs",$list);
        $this->display();
    }
    public function search($key){
        $this->assign("key",htmlspecialchars($key));
        $key=addslashes(htmlspecialchars($key));
        $rs=$this->pdo->query("SELECT * FROM `blog_post` LEFT JOIN `blog_user` ON `blog_user`.`UID` = `blog_post`.`UID` 
        WHERE `blog_post`.`type`='post' AND `blog_post`.`title` LIKE '%$key%' OR `blog_post`.`content` LIKE '%$key%' ");
        $list=array();
        while($post=$rs->fetch()){
        
            $post["title"]=htmlspecialchars($post["title"]);
            $post["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($post["email"])))."?s=80&r=G&d=";
            $post["date"]=date("Y-m-d",$post["time"]);
        if($post["MID"]!=0 && $c=$this->pdo->query("SELECT * FROM `blog_meta` WHERE `type`='category' and `MID`='".$post["MID"]."' ")){
            $post["category"]=$c->fetch();
            
        }
            $list[]=$post;
        }
        $this->assign("rs",$list);
        $this->display();
        
    }
}