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
<nav class="navbar navbar-default nomargin">
  <div class="container">
      <h3 class="center-block">TBlog beta v0.1
      <button type="button" class="navbar-toggle" data-toggle="collapse"  
         data-target="#navbar-collapse"> 
         <span class="sr-only">切换导航</span> 
         <span class="icon-bar"></span> 
         <span class="icon-bar"></span> 
         <span class="icon-bar"></span> 
        </button></h3>
    </div>
</nav>
<div class="sidebar-nav" id="navbar-collapse">
    <ul>
	<li><a href="#" data-target="#defaultList" class="nav-header" data-toggle="collapse"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>默认列表</a></li>
	<li>
	<ul class="nav nav-pills nav-stacked collapse in" id="defaultList">
		<li><a href="/index.php/Admin/Index"> 管理首页</a></li>
		<li><a href="/index.php/Admin/Index/setting"> 网站设置</a></li>
		<li><a href="/index.php/Admin/Post/edit"> 撰写文章</a></li>
		<li><a href="/index.php/Admin/Post/meta"> 分类管理</a></li>
		<li><a href="/index.php/Admin/Comment/index"> 评论管理</a></li>
		<li><a href="/index.php/Admin/Post/pageIndex"> 独立页面</a></li>
		<li><a href="/index.php/Admin/Index/changePassword"> 修改密码</a></li>
		<li id="quit" class="collapse"><a href="/index.php/Admin/Index/exitAdmin">退出登录</a></li>
		<li><a href="/index.php"> 网站首页</a></li>
	</ul>
	</li>
</ul>
<script>
    $("#quit").on("click",function(){
        return true;
    })
</script>
</div>
<div class="content">
    
<div class="content-main">
	<div class="row">
        
		<div class="col-md-8">
		    <ol class="breadcrumb">
  <li><a href="/index.php/Admin/Index">管理首页</a></li>
  <li class="active">评论管理</li>
</ol>
<div class="main">
        
<?php if($comments): ?><form action="/index.php/Admin/Comment/delete" method="post">
	<table class="table">
	<tr>
		<th></th>
		<th>作者</th>
		<th>内容</th>
	</tr>
	<?php if(is_array($comments)): foreach($comments as $key=>$value): ?><tr>
		<td>
			<input type="checkbox" class="" name="arr[]" value="<?php echo ($value["CID"]); ?>">
		</td>
		<td>
		    <?php echo ($value["name"]); ?><br>
		    
		</td>
		<td class="comments-td">
			于<?php echo ($value["date"]); ?>在<a href="/index.php/Admin/Post/edit/<?php echo ($value["PID"]); ?>"><?php echo ($value["postTitle"]); ?></a><br/>评论：<?php echo ($value["content"]); ?>
			<div class="do"><a href="/index.php/Admin/Comment/delete/<?php echo ($value["CID"]); ?>">删除</a></div>
		</td>
	</tr><?php endforeach; endif; ?>
	</table>
	
	<button type="submit" class="btn btn-primary" id="commentDel" style="display:none;">删除选中</button>
	</form>

	<a class="btn btn-default" href="#" id="delButton"  data-toggle="modal" data-target="#exampleModal" role="button">删除选中</a>
	<div style="clear:both"></div>
	<?php else: ?>
	    <h3>目前还没有任何评论</h3><?php endif; ?>
</div>
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
  console.log("Start")
  var modal = $(this)
  modal.find('.modal-body p').text("你确定删除选中项吗？");
  modal.find("#deleteBottom").on("click",function(){
      $("#commentDel").trigger("click");
      return false;
  });
})
</script>
		</div>
	</div>
</div>
</div>

  </body>
</html>