<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo ($siteTitle); ?></title>
    <link rel="stylesheet" href="/Public/bootstrap-3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Application/Admin/View/layout/style.css">
    <script src="/Public/jquery-3.0.0.min.js"></script>
    <script src="/Public/bootstrap-3.3.5/js/bootstrap.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/4.0.0-alpha/js/umd/modal.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/simditor-2.3.6/styles/simditor.css" />
    <script type="text/javascript" src="/Public/simditor-2.3.6/scripts/module.js"></script>
    <script type="text/javascript" src="/Public/simditor-2.3.6/scripts/hotkeys.js"></script>
    <script type="text/javascript" src="/Public/simditor-2.3.6/scripts/uploader.js"></script>
    <script type="text/javascript" src="/Public/simditor-2.3.6/scripts/simditor.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      
<div class="modal fade" id="exampleModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">提示</h4>
			</div>
			<div class="modal-body">
				<p>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				<a class="btn btn-primary" id="deleteBottom">删除</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<nav class="navbar navbar-default">
  <div class="container">
      <h3 class="center-block">不点博客豪华加强版 v9.99999</h3>
    </div>
</nav>
<div class="container">
	<div class="row">
        
		<div class="col-md-8">
		    <ol class="breadcrumb">
  <li><a href="/index.php/Admin/Index">管理首页</a></li>
  <li class="active">网站设置</li>
</ol>
<div class="main">
	<form action="/index.php/Admin/Index/setting" method="post">
	  <div class="form-group">
    <label for="">网站名称：</label>
    <input type="text" class="form-control" name="blogTitle" value="<?php echo C("blogTitle");?>" placeholder="">
  </div>  
  <div class="form-group">
    <label for="">关键词</label>
    <input type="text" class="form-control" name="blogKeyWorld" value="<?php echo C("blogKeyWorld");?>" placeholder="">
  </div>
  <div class="form-group">
    <label for="">网站描述</label>
    <input type="text" class="form-control" name="blogDescription" value="<?php echo C("blogDescription");?>" placeholder="">
  </div>  
  <div class="form-group">
    <label for="">logo地址</label>
    <input type="text" class="form-control" name="blogLogo" value="<?php echo C("blogLogo");?>" placeholder="">
  </div>  
	
	<button type="submit" class="btn btn-primary" id="postDel">保存</button>
	</form>
</div>
		</div>
        
		<div class="col-md-4">
		    <?php if(!$adminLogin): ?><nav class="">
    <ul class="nav nav-pills nav-stacked">
  <li role="presentation"><a href="/index.php/Admin/Index">管理首页</a></li>
  <li role="presentation"><a href="/index.php/Admin/Index/setting">网站设置</a></li>
  <li role="presentation"><a href="/index.php/Admin/Post/edit">撰写文章</a></li>
  <li role="presentation"><a href="/index.php/Admin/Post/meta">分类管理</a></li>
  <li role="presentation"><a href="/index.php/Admin/Comment/index">评论管理</a></li>
  <li role="presentation"><a href="/index.php/Admin/Post/pageIndex">独立页面</a></li>
  <li role="presentation"><a href="/index.php/Admin/Index/changePassword">修改密码</a></li>
  <li role="presentation"><a href="/index.php/Admin/Index/exitAdmin" id="quit">安全退出</a></li>
  <li role="presentation"><a href="/index.php">网站首页</a></li>
</ul>
</nav>
<script>
    $("#quit").on("click",function(){
        return true;
    })
</script><?php endif; ?>
		</div>
	</div>
</div>

  </body>
</html>