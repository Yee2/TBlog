<?php
/*
    package:helloWorld
    author:Tblog
    version:1.0
    link:http://tristana.cn
    description:这是这个博客的第一个插件
 */
\Blog\Library\Plugin::add("adminWidget","helloWorld");
function helloWorld($args=array()){
    $totalPost=q("select count(*) as total from `blog_post` where `type`='post' ")->fetch()["total"];
    $totalComment=q("select count(*) as total from `blog_comment`  ")->fetch()["total"];
    echo <<<HTML
    <div class="panel panel-default grid-item">
  <div class="panel-heading">
    <h3 class="panel-title">统计</h3>
  </div>
  <div class="panel-body">
    总文章数：{$totalPost}<br>
    总评论数：{$totalComment}<br>
  </div>
</div>
HTML;
    return ;
}