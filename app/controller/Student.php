<?php


namespace app\controller;


use app\BaseController;
use app\model\StudentModel;
use think\Request;

class Student extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function getList()
    {
        $list = StudentModel::select();
        return $this->api($list);
    }

    public function add(Request $request) {
        //$data = Request::param(['ssex', 'sname', 'sbrithday', 'classes']);
        $data = $request->param();
        $data['ssex'] = (int)$data['ssex'];
        $data['class'] = $data['classes'];
        $res = StudentModel::create($data);
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