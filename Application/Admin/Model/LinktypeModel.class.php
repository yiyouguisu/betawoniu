<?php
namespace Admin\Model;
use  Admin\Model\CommonModel;
class LinktypeModel extends CommonModel {
     //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
         array('catid', 'require', '请选择链接类型！', 1, 'regex', 3),
          array('title', 'require', '请输入链接标题！', 1, 'regex', 3),
        
    );
    public function config_cache() {
        $data = $this->order(array('listorder'=>'desc','id'=>'desc'))->select();
        F("linktype", $data);
        return $data;
    }

    /**
     * 后台有更新/编辑则删除缓存
     * @param type $data
     */
    public function _before_write($data) {
        parent::_before_write($data);
        F("linktype", NULL);
    }

    //删除操作时删除缓存
    public function _after_delete($data, $options) {
        parent::_after_delete($data, $options);
        $this->config_cache();
    }

    //更新数据后更新缓存
    public function _after_update($data, $options) {
        parent::_after_update($data, $options);
        $this->config_cache();
    }

    //插入数据后更新缓存
    public function _after_insert($data, $options) {
        parent::_after_insert($data, $options);
        $this->config_cache();
    }
  
   
}
