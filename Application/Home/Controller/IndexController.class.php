<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    private $pdo;
    public function _initialize(){
        $this->pdo=db();
        $this->assign("siteTitle","心情日记");
    }
    public function index(){
        $q=$this->pdo->query("SELECT * FROM `blog_post` LEFT JOIN `blog_user` ON `blog_user`.`UID` = `blog_post`.`UID` WHERE `blog_post`.`type`='post'  ORDER BY `time` DESC ");
        $list=array();
        while($rs=$q->fetch()){
            $rs["title"]=htmlentities($rs["title"]);
            #$rs["content"]=htmlentities($rs["content"]);
            $rs["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($rs["email"])))."?s=80&r=G&d=";
            $list[]=$rs;
        }
        //var_dump($list);
        $this->assign("rs",$list);
        $this->display();
    }
    public function post($slug){
        if(!preg_match("#(\w+)#",$slug,$s)){
            $this->error("文章未找到");
            return ;
        }
        $s=$s[1];
        $rs=$this->pdo->query("SELECT * FROM `blog_post` WHERE `slug`='$slug' and `type`='post' ");
        if(!($post=$rs->fetch())){
            $this->error("文章未找到");
            return ;
        }
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
        $PID=$post["PID"];
        $rs=$this->pdo->query("SELECT * FROM `blog_comment` WHERE `PID`='$PID' ");
        if($c=$rs->fetch()){
            $comments=array();
            do{
                $c["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($c["email"])))."?s=80&r=G&d=";
                $comments[]=$c;
            }while($c=$rs->fetch());
            $this->assign("comments",$comments);
        }
        $this->display();
    }
    public function respond($PID,$CID=null){
        $PID=(int)$PID;
        $rs=$this->pdo->query("SELECT * FROM `blog_post` WHERE `PID`='$PID' ");
        if(!($post=$rs->fetch())){
            $this->error("404");
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
        $this->assign("page",$page);
        $PID=$page["PID"];
        $rs=$this->pdo->query("SELECT * FROM `blog_comment` WHERE `PID`='$PID' ");
        if($c=$rs->fetch()){
            $comments=array();
            do{
                $c["gravatar"]="http://cdn.v2ex.com/gravatar/".md5(strtolower( trim($c["email"])))."?s=80&r=G&d=";
                $comments[]=$c;
            }while($c=$rs->fetch());
            $this->assign("comments",$comments);
        }
        $this->display();
    }
}