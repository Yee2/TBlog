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
    <script type="text/javascript" src="/Public/html5sortable-master/jquery.sortable.min.js"></script>
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
<nav class="navbar navbar-default nomargin">
  <div class="container">
      <h3 class="center-block">TBlog beta v0.1</h3>
    </div>
</nav>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
				 <div class="panel panel-default login">
        <p class="panel-heading no-collapse">管理员登陆</p>
        <div class="panel-body">
            <form action="/index.php/Admin/Index/login" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control span12" name="name">
                </div>
                <div class="form-group">
                <label>Password</label>
                    <input type="password" class="form-control span12 form-control" name="password" >
                </div>
                <button type="submit" class="btn btn-primary pull-right">Login</button>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
		</div>
	</div>
</div>

  <footer>
© <?php echo date("Y");?> <?php echo C("blogTitle");?> . Powered by <a href="http://tristana.cn">TBlog</a>.
  </footer>
  </body>
</html>