<?php
namespace Admin\Model;
use  Admin\Model\CommonModel;
class ArticleModel extends CommonModel {
     //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
          array('title', 'require', '请输入标题！', 1, 'regex', 3),
        array('thumb', 'require', '请上传封面图片！', 1, 'regex', 3),
    );

   
}
