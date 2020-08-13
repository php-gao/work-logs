<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Logs extends Model {

    // 数据入库【新增】
    public function add($data) {
        if(!is_array($data)){
            exception('提交数据不合法');
        }
        $this->allowField(true)->save($data);
        return $this->id;
    }

    
    // 更新数据
	public function updateLogsData($data, $condition) {
		if(!is_array($data)){
            exception('提交数据不合法');
        }
        //$res = $this->allowField(true)->saveAll($data, $condition);
        
        // 使用静态方法 调用数据库的方法直接更新数据 数据库的update方法返回影响的记录数
        $res = Logs::where($condition)->update($data); 
        return $res;
	}
    
}
