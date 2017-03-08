<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{
    protected $tableName = 'meta';
    function list(int $pid = 0){
        $categorys = $this->where(' type="category" ')->select();
        if($pid > 0){
            $relationship=array_column(M("relationship")->field("meta_id")->where(
                ["post_id"=>$pid]
                )->select(),"meta_id");
            foreach ($categorys as &$category) {
                if(in_array($category["MID"],$relationship)){
                    $category["checked"]=true;
                }else{
                    $category["checked"]=false;
                }
            }
        }
        $categorys=\PHPTree::makeTreeForHtml($categorys,array(
        'primary_key' 	=> 'MID',
        'parent_key'  	=> 'parent',
        ));
        return $categorys;
    }
}
