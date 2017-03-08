<?php
if(file_exists("lock.txt")){
    exit(file_get_contents("lock.txt"));
}
function step0(){
    if(version_compare(PHP_VERSION,'5.3.0','<')){
        echo '<h3>equire PHP > 5.3.0 !</h3>';
        return ;
    }
    step1();
}
function step1($do=true){
    if(!isset($_POST['host'])){
        $_POST['host']="localhost";
    }
    if(!isset($_POST['user'])){
        $_POST['user']="root";
    }
$code1=<<<HTML
        <div class="page-header">
            <h4>设置数据库地址</h4>
        </div>
				<form action="index.php?step=1" method="post">
					<div class="form-group">
						<input type="text" name="host" class="form-control" placeholder="数据库地址" value="{$_POST['host']}" required="required" />
					</div>
					<div class="form-group">
						<input type="text" name="user" class="form-control" placeholder="用户名" value="{$_POST['user']}" required="required" />
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="密码" name="pass" value="{$_POST['pass']}"/>
					</div>
					<div class="form-group">
						<input type="text" name="data" class="form-control" placeholder="数据库名" value="{$_POST['data']}" required="required" />
					</div>
					<button type="submit" class="btn btn-primary pull-right" name="enter">下一步</button><div style="clear:both;"></div>
				</form>
HTML;
if(isset($_POST["enter"])  && $do){
        $dsn = "mysql:host={$_POST['host']};dbname={$_POST['data']}";
        if(empty($_POST["data"])){
            $msg="请输入数据库名称";
        }elseif(empty($_POST["user"])){
            $msg="请输入数据库用户名称";
        }else{
            try {
                $pdo= new PDO($dsn, $_POST['user'], $_POST['pass']);
                $pdo->query('set names utf8mb4');
                $c="<?php\nreturn ".var_export(array_merge(include("config.default.php"),array(
                        "MYSQL"=>array(
                                "host"=>$_POST['host'],
                                "user"=>$_POST['user'],
                                "pass"=>$_POST['pass'],
                                "data"=>$_POST['data'],
                            ),
                        "DB_CONFIG2"=>sprintf('mysql://%s:%s@%s:3306/%s#utf8',$_POST['user'],$_POST['pass'],$_POST['host'],$_POST['data'])
                    )),true).";";
                file_put_contents("../Application/Common/Conf/config.php",$c);
                $pdo->exec(file_get_contents("TBlog.sql"));
                step2(false);
                return ;
            } catch (PDOException $e) {
                $msg='Connection failed: ' . $e->getMessage();

            }


        }
}
echo $code1;
    if(isset($msg)){
        echo '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
    }
}
function step2($do=true){
    if(!isset($_POST['name'])){
        $_POST['name']="admin";
    }
$code=<<<HTML
        <div class="page-header">
            <h4>设置管理员账户</h4>
        </div>
				<form action="index.php?step=2" method="post">
					<div class="form-group">
						<input type="text" name="name" class="form-control" placeholder="用户名" value="{$_POST['name']}" required="required"/>
					</div>
					<div class="form-group">
						<input type="text" name="pass" class="form-control" placeholder="密码" value="{$_POST['pass']}" required="required"/>
					</div>
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="邮箱地址" value="{$_POST['email']}" required="required"/>
					</div>
					<button type="submit" name="enter" class="btn btn-primary pull-right">下一步</button><div style="clear:both;"></div>
				</form>
HTML;
if(isset($_POST["enter"]) && $do){
    if(!preg_match("/^[a-z0-9xa1-xff_]{3,10}$/",$_POST["name"])){
        $msg="管理员名称格式不对";
    }elseif(!preg_match("/^[a-z0-9_]{5,33}$/",$_POST["pass"])){
        $msg="管理员密码格式不对";
    }else{

    $m=include("../Application/Common/Conf/config.php");
    $m=$m["MYSQL"];
    $dsn = "mysql:host={$m['host']};dbname={$m['data']}";
            try {
                $pdo= new PDO($dsn, $m['user'], $m['pass']);
                $pdo->query('set names utf8mb4');
            } catch (PDOException $e) {
                header('Location: index.php');
                return ;
            }
            $name=$_POST['name'];
            $pass=md5($_POST['pass']);
            $email=$_POST['email'];
    $r=$pdo->exec("REPLACE INTO `blog_user` (`UID`,`name`,`password`,`email`) VALUES (1,'$name','$pass','$email')");
    if($r>0){
        step3();
        return ;
    }else{
        $msg=$pdo->errorInfo()[2];
    }
    }

}
echo $code;
    if(isset($msg)){
        echo '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
    }
}
function step3(){
$code=<<<HTML
        <div class="page-header">
            <h4>欢迎使用Tblog</h4>
        </div>
        你的博客已经搭建好了，开始你的博客之旅吧；
        <a class="btn btn-default" href="../index.php/Admin" role="button">进入后台</a>
HTML;
echo $code;
file_put_contents("lock.txt","TBlog beta 20160701，重装请删除install/lock.txt");
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>不点儿程序安装器</title>
<link rel="stylesheet" href="../Public/bootstrap-3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="../Application/Home/View/default/Index/style.css">
<script src="../Public/jquery-3.0.0.min.js"></script>
<script src="../Public/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
        <?php if($_GET["step"]=="1"){ step1(); }elseif($_GET["step"]=="2"){ step2(); }elseif($_GET["step"]=="3"){step3();}else{step0(); } ?>
        </div>
    </div>
</div>
</body>
</html>
