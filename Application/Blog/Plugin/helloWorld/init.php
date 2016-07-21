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
    echo "这是这个博客的第一个插件";
    return ;
}