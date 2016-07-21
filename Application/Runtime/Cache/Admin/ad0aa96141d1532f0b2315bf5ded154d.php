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
		    
<form action="/index.php/Admin/Post/edit/<?php echo ($post["PID"]); ?>" method="post">
    <div class="container-fluid">
        <div class="row">
    <div class="col-md-8">
		<ol class="breadcrumb">
  <li><a href="/index.php/Admin/Index">管理首页</a></li>
  <li><a href="/index.php/Admin/Index">文章管理</a></li>
  <?php if($post): ?><li class="active">修改: <?php echo ($post["title"]); ?></li>
  <?php else: ?>
      <li class="active">创建文章</li><?php endif; ?>
  
</ol>
<div class="main">
	<input type="hidden" name="rank" id="" value="<?php echo ($rank); ?>"/>
	<div class="form-group">
			<input type="text" name="title" id="inputName" class="form-control" value="<?php echo ($post["title"]); ?>" placeholder="名称"/>
	</div>
	<div class="post-slug">文章地址：http://<?php echo ($_SERVER['SERVER_NAME']); ?>/index.php/Home/Index/post/<input type="text" name="slug" 
	<?php if($post['slug']): ?>value="<?php echo ($post["slug"]); ?>"
	<?php else: ?>
	value="<?php echo uniqid();?>"<?php endif; ?>
	/></div>
	<div class="form-group">
			<textarea class="form-control" rows="10" name="content"  id="editor" placeholder="Balabala" autofocus><?php echo ($post["content"]); ?></textarea>
			<script>
			var editor = new Simditor({
			    textarea: $('#editor'),
			    //optional options
			    upload : {
			        url : '/index.php/Admin/Media/upload/blogMedia', //文件上传的接口地址
			        params: null, //键值对,指定文件上传接口的额外参数,上传的时候随文件一起提交
			        fileKey: 'blogMedia', //服务器端获取文件数据的参数名
			        connectionCount: 1,
			        leaveConfirm: '正在上传文件'
			        }
			});
			</script>
	</div>
	<?php if($post): ?><bottom type="button" class="btn btn-default" data-toggle="modal" data-target="#exampleModal" data-id="<?php echo ($post["PID"]); ?>">删除</bottom><?php endif; ?>
	<button type="submit" class="btn btn-primary  pull-right">发布文章</button>

	<div style="clear:both"></div>

</div>
</div>

    <div class="col-md-4">
<div class="panel panel-default panel-sortable">
  <div class="panel-heading">
    <h3 class="panel-title">选择一个分类</h3>
  </div>
  <div class="panel-body">
    
	<div class="form-group">
			    <ul>
			    <?php if(is_array($categorys)): foreach($categorys as $key=>$value): ?><li>
			            <?php echo (str_repeat("----",$value["level"])); ?>
			    <input type="checkbox" name="category[]" value="<?php echo ($value["MID"]); ?>"  
			    <?php if($value['checked']): ?>checked="checked"<?php endif; ?>
			  /><?php echo ($value["name"]); ?></li><?php endforeach; endif; ?>
			    </ul>
	</div>
  </div>
</div>
</div>
            
        </div>
    </div>
</form>
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
  console.log("Start")
  var button = $(event.relatedTarget);
  var id = button.data('id');
  var modal = $(this)
  modal.find('.modal-body p').text("你确定删除<<<?php echo ($post["title"]); ?>>>吗？");
  modal.find("#deleteBottom").attr("href","/index.php/Admin/Post/delete/"+id);
})
    $('.panel-sortable').sortable({handle:"h3"});
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