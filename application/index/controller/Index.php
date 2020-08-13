<?php
namespace app\index\controller;
use think\Controller; // 控制器
use think\facade\Session; // 使用Session类
use app\common\lib\Util; // 公共方法
use app\common\lib\Aes; // 加密解密
use think\facade\Env; // 系统变量
use think\Db; // 数据库
use think\Model; // 模型

class Index extends Controller {
    // 定义控制器初始化方法initialize，
    // 该方法会在调用控制器的方法之前首先执行
    // initialize方法不需要任何返回值
    public function initialize() {
        $isLogin = Util::isLogin();
        if(!$isLogin){ // 判断是否登录
            $login_url = url('index/login/index', 'time='.time());
            $this->redirect($login_url); // 跳转至登录页
        }
    }


    // 首页
    public function index() {
        // $meid = base64_encode(Aes::encrypt($user['id'])); // ID加密
        // 登录用户的工作记录数据
        $user = Session::get(config('redis.login_key'));
        // 判断今日是否已经提交过工作记录
        $today_start_time = mktime(0, 0, 0, date('m'), date('d'), date('Y')); // 今日开始时间戳
        $today_end_time = mktime(0, 0, 0, date('m'), date('d')+1, date('Y'))-1; // 今日结束时间戳
        $today_data = Db::table('work_logs')
                        ->field('id, work_content, notes, finished')
                        ->where(['uid'=>$user['id'], 'status'=>1])
                        ->where('create_time', 'between time', [$today_start_time, $today_end_time])
                        ->find();
        if(!empty($today_data)){ // 今日记录已提交 
            // htmlspecialchars
            // htmlspecialchars_decode 
            // html_entity_decode
            // htmlentities()
            $today_data['title'] = '更 新 今 日 工 作 记 录';
            $today_data['flag'] = 1;
        }else{
            $today_data['title'] = '添 加 今 日 工 作 记 录';
            $today_data['flag'] = 0;
        }
        /*
        $work_logs = Db::table('work_logs')
                        ->field('*')
                        ->where(['uid'=>$user['id'], 'status'=>1])
                        ->order('id DESC')
                        ->select();
        foreach($work_logs as &$val){
            $val['finished'] = ($val['finished']==1) ? '进行中' : '已完成';
            $val['create_time'] = date('Y-m-d', $val['create_time']);
            $val['notes'] = $val['notes'] ? ($val['notes']): '';
        }
        */

        $param = request()->param();
        $condition = ' and l.status=1';
        if(!empty($param['finished'])){ // 完成情况的查询
          $condition .= ' and l.finished='.intval($param['finished']);
        }
        if(!empty($param['stime']) && !empty($param['etime'])){ // 按时间查询
            $stime = strtotime($param['stime']);
            $etime = strtotime($param['etime'].' 23:59:59');
            $condition .= ' and l.create_time between '.$stime.' and '.$etime;
        }
        if(!empty($user['is_manger']) && !empty($param['username'])){ // 按姓名查询
            if($param['username'] == 'all'){ // 所在部门所有员工记录
                $condition .= ' and l.dep_id='.$user['dep_id'];
            }else{
                $condition .= ' and u.dep_id='.$user['dep_id'].' and u.name="'.trim($param['username']).'"';
            }
        }
        
        $sql = 'u.id='.$user['id'].$condition;
        if(!empty($user['is_manger']) && !empty($param['username'])){
            $sql = '1 '.$condition;
        }
        $logs_list = Db::name('logs')
                ->alias('l')
                ->leftJoin('user u','l.uid = u.id')
                ->where($sql)
                ->field('l.*, u.name, u.station')
                ->order('l.id DESC')
                ->paginate(30, false, ['query'=>$param]) // 分页
                ->each(function($item, $key){
                    $item['finished'] = ($item['finished']==1) ? '进行中' : '已完成';
                    $item['create_time'] = date('Y-m-d', $item['create_time']);
                    $item['notes'] = $item['notes'] ? ($item['notes']): '';
                    return $item;
                });
        // var_dump(Db::getLastSql());        
        $page = $logs_list->render();
        $this->assign('page', $page); // 分页
        $this->assign('param', $param);  // 查询参数 

        $post_url = url('index/index/logs'); // 新增更新数据提交地址
        $login_out_url = url('index/login/out'); // 退出
        $this->assign('user', $user);
        $this->assign('today_data', $today_data);
        $this->assign('logs_list', $logs_list);
        $this->assign('root_path', config('user.host'));
        $this->assign('post_url', $post_url);
        $this->assign('login_out_url', $login_out_url);
        
        /*
        // 判断是否是手机端
        if($request->isMobile){
            return view('index');
        }else{
           // return view('index_pc'); // pc端 
          return view('index'); // 不分手机还是电脑端
        }
        */
        return view('index');
        exit;
    }
    
    
    // 新增和更新 logs 数据
    public function logs(){
        $me = Session::get(config('redis.login_key'));
        $post = request()->post();

        if(!empty($post) && !empty($post['work_content']) && !empty($post['finished'])){
            if(empty($post['id'])){ // 新增
                $data = array(
                    'dep_id' => $me['dep_id'],
                    'uid' => $me['id'],
                    'work_content' => trim($post['work_content']),
                    'finished' => intval($post['finished']),
                    'notes' => trim($post['notes']) ? trim($post['notes']) : '0',
                    'status' => 1,
                    'create_time' => time(),
                    'update_time' => 0
                );
                $res = Model('Logs')->add($data); 
                if(!empty($res)){
                    return Util::show(config('code.success'), '恭喜，添加成功');
                }else{
                    return Util::show(config('code.error'), '抱歉，添加失败，请稍后重试');
                }

            }else{ // 更新
                $data = array(
                    'work_content' => trim($post['work_content']),
                    'finished' => intval($post['finished']),
                    'notes' => trim($post['notes']) ? trim($post['notes']): '0',
                    'update_time' => time()
                );
                $param = array('id' => intval($post['id']));
                $res = Model('Logs')->updateLogsData($data, $param);  
                if(!empty($res)){
                    return Util::show(config('code.success'), '恭喜，修改成功');
                }else{
                    return Util::show(config('code.error'), '抱歉，修改失败，请稍后重试');
                }
            }
        }else{
            return Util::show(config('code.error'), 'POST 数据有误');
        }
    }

}
