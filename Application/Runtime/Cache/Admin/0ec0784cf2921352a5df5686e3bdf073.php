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
<nav class="navbar navbar-inverse noMargin noRadius">
  <div class="container">
      <h3>TBlog beta v0.1
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-0"> 
         <span class="sr-only">切换导航</span> 
         <span class="icon-bar"></span> 
         <span class="icon-bar"></span> 
         <span class="icon-bar"></span> 
        </button></h3>
    </div>
</nav>
<div class="sidebar-nav collapse navbar-collapse" id="navbar-collapse-0">
    <ul class="menu" id="menu">
	<li>
	    <a href="#" data-target="#defaultList" class="menu-header" data-toggle="collapse">
	        <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>设置
	   </a>
	</li>
	<li>
	<ul class="menu-list collapse in" id="defaultList">
		<li><a href="/index.php/Admin/Index/index"> 仪盘表</a></li>
		<li><a href="/index.php/Admin/Index/setting"> 网站设置</a></li>
		<li><a href="/index.php/Admin/Plugin/index"> 插件管理</a></li>
		<li><a href="/index.php/Admin/Post/pageIndex"> 独立页面</a></li>
		<li><a href="/index.php/Admin/Index/changePassword"> 修改密码</a></li>
		<li id="quit" class="collapse"><a href="/index.php/Admin/Index/exitAdmin">退出登录</a></li>
		<li><a href="/index.php"> 网站首页</a></li>
	</ul>
	</li>
	<li>
	    <a href="#" data-target="#blogMain" class="menu-header" data-toggle="collapse">
	        <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>博客
	   </a>
	</li>
	<li>
	<ul class="menu-list collapse in" id="blogMain">
		<li><a href="/index.php/Admin/Post/index"> 文章管理</a></li>
		<li><a href="/index.php/Admin/Post/edit"> 撰写文章</a></li>
		<li><a href="/index.php/Admin/Post/meta"> 分类管理</a></li>
		<li><a href="/index.php/Admin/Comment/index"> 评论管理</a></li>
	</ul>
	</li>
</ul>
<script>
    $("#quit").on("click",function(){
        return true;
    })
    $("#menu a").each(function(){
        var href=$(this).attr("href");
        if(href=="/index.php"){
            return ;
        }
        if(window.location.pathname.substring(0,href.length)==href){
            console.log($(this))
            $(this).parent().addClass("menu-active");
        }; 
    });
</script>
</div>
<div class="content">
    
<div class="content-main">
	<div class="row">
        
		<div class="col-md-8 col-sm-12">
		    <ol class="breadcrumb">
  <li><a href="/index.php/Admin/Index">管理首页</a></li>
  <?php if($meta): ?><li><a href="/index.php/Admin/Post/index">文章管理</a></li>
      <li><?php echo ($meta["name"]); ?></li>
    <?php else: ?>
  <li class="active">文章管理</li><?php endif; ?>
</ol>
<div class="main">
	<form action="/index.php/Admin/Post/delete" method="post">
	<table class="table">
	<tr>
		<th></th>
		<th>标题</th>
		<th>作者</th>
		<th>分类</th>
		<th>日期</th>
	</tr>
	<?php if(is_array($rs)): foreach($rs as $key=>$value): ?><tr>
		<td>
			<input type="checkbox" class="" name="arr[]" value="<?php echo ($value["PID"]); ?>">
		</td>
		<td>
			<a href="/index.php/Admin/Post/edit/<?php echo ($value["PID"]); ?>"><?php echo ($value["title"]); ?></a>
		</td>
		<td><?php echo ($value["name"]); ?></td>
		<td>
		    <?php if(is_array($value["categorys"])): foreach($value["categorys"] as $key=>$category): ?><a href="/index.php/Admin/Post/index/<?php echo ($category["MID"]); ?>"><?php echo ($category["name"]); ?></a>,<?php endforeach; endif; ?></td>
		<td><?php echo (date("m-d H:i",$value["date"])); ?></td>
	</tr><?php endforeach; endif; ?>
	</table>
	
	<button type="submit" class="btn btn-primary" id="postDel" style="display:none;">删除选中</button>
	</form>

	<a class="btn btn-default" href="#" id="delButton"  data-toggle="modal" data-target="#exampleModal" role="button">删除选中</a>
</div>
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
  console.log("Start")
  var modal = $(this)
  modal.find('.modal-body p').text("你确定删除选中项吗？");
  modal.find("#deleteBottom").on("click",function(){
      $("#postDel").trigger("click");
      return false;
  });
})
</script>
		</div>
	</div>
</div>
</div>

  <footer>
© <?php echo date("Y");?> <?php echo C("blogTitle");?> . Powered by <a href="http://tristana.cn">TBlog</a>.
  </footer>
  </body>
</html>