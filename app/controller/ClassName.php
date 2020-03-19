<?php


namespace app\controller;


use app\BaseController;
use app\model\ClassNameModel;
use app\model\StudentModel;
use think\Request;

class ClassName extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function getList()
    {
        $list = ClassNameModel::select();
        return $this->api($list);
    }

    public function add(Request $request) {
        //$data = Request::param(['ssex', 'sname', 'sbrithday', 'classes']);
        $data = $request->param();
        $res = ClassNameModel::create($data);
        if ($res) {
            return $this->api([]);
        } else {
            return $this->api([], 400, '添加失败');
        }
    }
    
    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}