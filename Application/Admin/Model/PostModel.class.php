<?php
namespace Admin\Model;
use Think\Model;
class PostModel extends Model{
    protected $_validate = array(
        array('title','require','请输入文章标题'),
        array('title',array(1,225),'文章名字太长',1,'length'),
        array('content','require','请输入文章内容'),
        array('slug','','请输入其他slug',1,'unique'),
    );
    protected $slug,$ID;
    public $post;
    public function slug($slug){
        $post = $this->where(' slug="%s" ',$slug)->find();
        if($post === NULL){
            return false;
        }
        $this->post = $post;
        return $post;
    }
    public function id($id){
        $post = $this->where(' PID=%d ',$id)->find();
        if($post === NULL){
            return false;
        }
        $this->post = $post;
        return $post;
    }
}
