<?php
namespace Home\TagLib;
use Home\TagLib;
/**
 * CX标签库解析类
 */
class page extends \Think\Template\TagLib {
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'list'        =>  array('attr'=>'item','level'=>2),
        );
    function _list($tags,$content){
    $val=$tags["item"];
    $code=<<<CODE
<?php \$f=function(){
    \$rs=q("SELECT * FROM `blog_post` WHERE `type`='page' ");
    while(\${$val}=\$rs->fetch()){
        \${$val}["title"]=htmlspecialchars(\$p["title"]);
        ?>
        {$content}
<?php } }; \$f(); ?>
CODE;
return $code;
}
    
}