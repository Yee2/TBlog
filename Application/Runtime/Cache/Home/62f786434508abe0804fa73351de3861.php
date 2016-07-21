<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="<?php echo C('blogKeyWord');?>"/>
<meta name="description" content="<?php echo C('blogDescription');?>"/>
<title><?php if($pageTitle): echo ($pageTitle); ?>|<?php endif; echo C("blogTitle");?></title>
<link rel="stylesheet" href="/Public/bootstrap-3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="/Application/Home/View/default/Index/style.css">
<script src="/Public/jquery-3.0.0.min.js"></script>
<script src="/Public/bootstrap-3.3.5/js/bootstrap.min.js"></script>
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
	
        <button type="button" class="navbar-toggle" data-toggle="collapse"  
         data-target="#example-navbar-collapse"> 
         <span class="sr-only">切换导航</span> 
         <span class="icon-bar"></span> 
         <span class="icon-bar"></span> 
         <span class="icon-bar"></span> 
        </button>
	</div> 
        <div class="collapse navbar-collapse" id="example-navbar-collapse"> 
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
</div>
</nav>
<header class=" hidden-xs hidden-sm">
<div class="container">
		<h3>
	    <?php if(C('blogLogo')): ?><img src="<?php echo C('blogLogo');?>" class="logo" /><?php endif; echo C("blogTitle");?><br/><small><?php echo C("blogDescription");?></small></h3>
	</div>
</header>
<div class="container">
    <div class="row">
        
        <div class="col-md-8">
            <article class="page">
                <h3>
                        <?php echo ($page["title"]); ?>                    
                </h3>
                <div class="post-content">
                        <?php echo ($page["content"]); ?>                                        
                </div>

            </article>
            <form action="/index.php/Home/Index/respond/<?php echo ($post["PID"]); ?>" method="post">
	<div class="comment-main">
		<?php if($comments): ?><h3>文章评论</h3>
		<ul class="comments" id="comments">
			<?php if(is_array($comments)): foreach($comments as $key=>$c): ?><li>
			<div class="comment-meta">
				<img class="gravatar" src="<?php echo ($c["gravatar"]); ?>"/>
				<h4 style="display:inline-block;"><?php if($c['url']): ?><a href="<?php echo ($c["url"]); ?>"><span class="label label-info"><?php echo ($c["name"]); ?></span></a>
				<?php else: ?>
				<span class="label label-info"><?php echo ($c["name"]); ?></span><?php endif; ?></h4>
				<time><?php echo (date("Y-m-d",$c["time"])); ?></time><br/>
			</div>
			<div class="comment-content">
				<?php echo ($c["content"]); ?>
			</div>
			</li><?php endforeach; endif; ?>
		</ul>
		<?php if(commentLoad): ?><a id="commentLoad" data-page="2" data-post="<?php echo ($PID); ?>"><h3>加载更多</h3></a><?php endif; endif; ?>
		<h3>留个足迹</h3>
		<div class="Input_Box">
			<div class="Input_Head">
				<div>
					名字：<input type="text" name="name" placeholder="" value="<?php echo (cookie('memberName')); ?>" required minlength="1" maxlength="100"/>
				</div>
				<div>
					邮箱：<input type="email" name="email" placeholder="email:123@qq.com"value="<?php echo (cookie('memberEmail')); ?>" required minlength="1" maxlength="100"/>
				</div>
				<div>
					主页：<input type="url" name="url" placeholder="http://" value="<?php echo (cookie('memberURL')); ?>" maxlength="100"/>
				</div>
			</div>
			<textarea class="Input_text" name="content" required></textarea>
			<div class="Input_Foot">
				<button type="submit" class="postBtn">提交</button>
			</div>
		</div>
	</div>
</form>
<script>
    $("#commentLoad").on("click",function(){
        var a=$(this);
        a.html("<h3>加载中。。。<h3>");
        var page=a.data("page");
        var post=a.data("post");
        $.ajax({
		type: 'post',
		url: '/index.php/Home/Index/commentLoad',
		data: {
			post: post,
			page: page
		},
		cache: false,
		dataType: 'json',
		success: function(data) {
			if(data.comments.length>0){
			    $('#commentTemplat').tmpl(data.comments).appendTo('#comments'); 
			 //   $(data.comments).each(function(){
			 //       $("#comments").append(this.content)
			 //   })
			}
		},
		error: function() {
			console.log("网络错误，请重试");
		}
	});
    });
</script>
<script src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
<script id='commentTemplate'  type='text/x-jquery-tmpl'>
    		<li>
			<div class="comment-meta">
				<img class="gravatar" src="${gravatar}"/>
				<h4 style="display:inline-block;"><?php if($c['url']): ?><a href="${url}"><span class="label label-info">${name}</span></a>
				<?php else: ?>
				<span class="label label-info">${name}</span><?php endif; ?></h4>
				<time>${date}</time><br/>
			</div>
			<div class="comment-content">
				${content}
			</div>
			</li>
</script>
            
        </div>
        
        <div class="col-md-4  hidden-xs hidden-sm">
            
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
      

  <footer>
© <?php echo date("Y");?> <?php echo C("blogTitle");?> . Powered by <a href="http://tristana.cn">TBlog</a>.
  </footer>
  </body>
</html>