<?php
namespace Blog\TagLib\Admin;
use Blog\TagLib\Admin;
/**
 * CX标签库解析类
 */
class common extends \Think\Template\TagLib {
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'widget'        =>  array('level'=>2),
        );
    function _widget($tags,$content){
    $val=$tags["item"];
    $code=<<<CODE
<?php \Think\Hook::listen("adminWidget",array()); ?>
CODE;
return $code;
}
    
}