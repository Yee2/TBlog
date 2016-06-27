<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="<?php echo C('blogKeyWord');?>"/>
<meta name="description" content="<?php echo C('blogDescription');?>"/>
<title><?php if($pageTitle): echo ($pageTitle); ?>|<?php endif; echo C("blogTitle");?></title>
<link rel="stylesheet" href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="/Application/Home/View/default/Index/style.css">
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/4.0.0-alpha/js/umd/modal.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body  data-spy="scroll" data-target="#navbar-example">
<nav class="navbar navbar-default navbar-inverse">
<div class="container">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<a class="navbar-brand" href="/index.php">首页</a>
	</div>
	<ul class="nav navbar-nav">
		<?php $f=function(){ $rs=q("SELECT * FROM `blog_post` WHERE `type`='page' "); while($p=$rs->fetch()){ $p["title"]=htmlspecialchars($p["title"]); ?>
        <li role="presentation" <?php if(isset($page) && $page['slug']==$p['slug']): ?>class="active"<?php endif; ?> ><a href="/index.php/Home/Index/page/<?php echo ($p["slug"]); ?>"><?php echo ($p["title"]); ?></a></li>
<?php } }; $f(); ?>
	</ul>
	<form class="navbar-form navbar-right" role="search" action="/index.php/Home/Index/search" method="get">
  <div class="form-group input-group-sm">
    <input type="text" class="form-control" placeholder="Search" name="key">
  </div>
  <button type="submit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
</form>
</div>
</nav>
<header>
<div class="container">
		<h3>
	    <?php if(C('blogLogo')): ?><img src="<?php echo C('blogLogo');?>" class="logo" /><?php endif; echo C("blogTitle");?><br/><small><?php echo C("blogDescription");?></small></h3>
	</div>
</header>
<div class="container">
    <div class="row">
        
        <div class="col-md-8">
            <?php if($rs): ?><h4>包含“<?php echo ($key); ?>”的文章</h4>
            <ul class="l">
                <?php if(is_array($rs)): foreach($rs as $key=>$post): ?><li>
                        <h3><a href="/index.php/Home/Index/post/<?php echo ($post["slug"]); ?>"><?php echo ($post["title"]); ?></a></h3>
                        <?php echo (mb_substr(strip_tags($post["content"]),0,200,"UTF8")); ?>
                        <div style="clear:both"></div>
                        <time><?php echo ($post["date"]); ?></time>
                        
                    </li><?php endforeach; endif; ?>
            </ul>
            <nav><?php echo ($pagination); ?></nav>
            <?php else: ?>
                <h4>未找到包含<?php echo ($key); ?>的文章</h4><?php endif; ?>
        </div>
        
        
        <div class="col-md-4"  id="navbar-example">
            
<nav class="">
    <h4>最新</h4>
    <ul class="nav nav-pills nav-stacked blog_nav">
<?php $f=function(){ $rs=q("SELECT * FROM `blog_post` WHERE `type`='post' LIMIT 0,5"); while($p=$rs->fetch()){ $p["title"]=htmlspecialchars($p["title"]); ?>
        <li>
<a href="/index.php/Home/Index/post/<?php echo ($p["slug"]); ?>"><?php echo ($p["title"]); ?></a>
</li>
<?php } }; $f(); ?>
</ul>
    <h4>分类</h4>
    <ul class="nav nav-pills nav-stacked blog_nav">
<?php $f=function(){ $rs=q("SELECT * FROM `blog_meta` WHERE `type`='category' ORDER BY `order` "); while($p=$rs->fetch()){ $p["name"]=htmlspecialchars($p["name"]); ?>
        <li>
<a href="/index.php/Home/Index/category/<?php echo ($p["slug"]); ?>"><?php echo ($p["name"]); ?></a>
</li>
<?php } }; $f(); ?>
</ul>
</nav>
<nav class="">
    <h4>其他</h4>
    <ul class="nav nav-pills nav-stacked blog_nav">
  <li role="presentation"><a href="/index.php">Home</a></li>
  <li role="presentation"><a href="/index.php/Admin">Admin</a></li>
</ul>
</nav>
        </div>
    </div>
</div>
      

  </body>
  <footer>
      @Tristana.CN
  </footer>
</html>