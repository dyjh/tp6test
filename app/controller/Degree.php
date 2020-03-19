<?php


namespace app\controller;


use app\BaseController;
use app\model\ClassNameModel;
use app\model\DegreeModel;
use app\model\StudentModel;
use think\Request;

class Degree extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function getInfo()
    {
        $degree1 = DegreeModel::where('degree_type', 1)->avg('degree');
        $degree2 = DegreeModel::where('degree_type', 2)->avg('degree');
        $degree3 = DegreeModel::where('degree_type', 3)->avg('degree');
        return $this->api(['degree1' => $degree1, 'degree2' => $degree2, 'degree3' => $degree3]);
    }

    public function getList(Request $request)
    {
        $type = $request->param('type');
        if (!$type) {
            return $this->api([], 400);
        }
        $list = DegreeModel::where('degree_type', $type)->select();
        foreach ($list as $val) {
            switch ($val->degree_type) {
                case 1:
                    $val->degree_type = '期初';
                    break;
                case 2:
                    $val->degree_type = '期中';
                    break;
                case 3:
                    $val->degree_type = '期末';
                    break;
            }
            $stu = StudentModel::where('sno', $val->sno)->find();
            if ($stu) {
                $val->sno = $stu->sname;
            } else {
                $val->sno = '数据错误';
            }
            $class = ClassNameModel::where('cno', $val->cno)->find();
            if ($class) {
                $val->cno = $class->cname;
            } else {
                $val->cno = '数据错误';
            }
        }
        return $this->api($list);
    }

    public function add(Request $request) {
        $data = $request->param();
        $stu = StudentModel::where('sname', $data['sname'])->find();
        if (!$stu) {
            return $this->api([], 400, '学员不存在');
        }
        $class = ClassNameModel::where('cname', $data['cname'])->find();
        if (!$class) {
            return $this->api([], 400, '课程不存在');
        }
        $data['sno'] = $stu->sno;
        $data['cno'] = $class->cno;
        dd($data);
        $res = DegreeModel::create($data);
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