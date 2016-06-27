<?php
namespace Home\TagLib;
use Home\TagLib;
/**
 * CX标签库解析类
 */
class post extends \Think\Template\TagLib {
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'new'        =>  array('attr'=>'item,size','level'=>2),
        'category'        =>  array('attr'=>'item','level'=>2),
        );
    function _new($tags,$content){
    $val=$tags["item"];
    $size=(int)$tags["size"];
    $code=<<<CODE
<?php \$f=function(){
    \$rs=q("SELECT * FROM `blog_post` WHERE `type`='post' LIMIT 0,$size");
    while(\${$val}=\$rs->fetch()){
        \${$val}["title"]=htmlspecialchars(\$p["title"]);
        ?>
        {$content}
<?php } }; \$f(); ?>
CODE;
return $code;
}
    function _category($tags,$content){
    $val=$tags["item"];
    $code=<<<CODE
<?php \$f=function(){
    \$rs=q("SELECT * FROM `blog_meta` WHERE `type`='category' ORDER BY `order` ");
    while(\${$val}=\$rs->fetch()){
        \${$val}["name"]=htmlspecialchars(\$p["name"]);
        ?>
        {$content}
<?php } }; \$f(); ?>
CODE;
return $code;
        
    }
}