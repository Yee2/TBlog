<?php
namespace Blog\TagLib\Admin;
use Blog\TagLib\Admin;
/**
 * CX标签库解析类
 */
class post extends \Think\Template\TagLib {
    protected $tags   =  array(
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'categorys'     =>  array('attr'=>'item,pid','level'=>3),
        );
    public function _categorys($tags,$content){
        $item       =   $tags['item'];
        $parseStr   =   '';
        $pid = $tags['pid']?(int)$tags['pid']:0;
        $parseStr  .=   '<?php $list=D("Category")->list('.$pid.');if(is_array($list)): foreach($list as $'.$item.'): ?>';
        $parseStr  .=   $this->tpl->parse($content);
        $parseStr  .=   '<?php endforeach; endif;?>';
        return $parseStr;
    }

}
