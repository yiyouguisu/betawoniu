<?php
namespace Admin\Model;
use  Admin\Model\CommonModel;
class PageModel extends CommonModel {
     //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
          array('title', 'require', '请输入标题！', 1, 'regex', 3),
         array('content', 'require', '请输入正文内容！', 1, 'regex', 3),
    );

   
}