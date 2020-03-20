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
        $snos = DegreeModel::group('sno')->column('sno');
        $cnos = DegreeModel::group('cno')->column('cno');
        $list = [];
        foreach ($snos as $sno) {
            foreach ($cnos as $cno) {
                $degree_avg = DegreeModel::where(['sno' => $sno, 'cno' => $cno])->avg('degree');
                $stu = StudentModel::where('sno', $sno)->find();
                if (!$stu) {
                    continue;
                }
                $class = ClassNameModel::where('cno', $cno)->find();
                if (!$class) {
                    continue;
                }
                $list[] = [
                    'cname' => $class->cname,
                    'sname' => $stu->sname,
                    'degree_avg' => $degree_avg
                ];
            }
        }
        return $this->api($list);
    }

    public function getList(Request $request)
    {
        $sname = $request->param('sname');
        $cname = $request->param('cname');
        $stu = StudentModel::where('sname', $sname)->find();
        if (!$stu) {
            return $this->api([], 400, '参数错误');
        }
        $class = ClassNameModel::where('cname', $cname)->find();
        if (!$class) {
            return $this->api([], 400, '参数错误');
        }
        $list = DegreeModel::where(['sno' => $stu->sno, 'cno' => $class->cno])->select();
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
            $val->sno = $sname;
            $val->cno = $cname;
        }
        return $this->api($list);
    }

    public function add(Request $request) {
        $data = $request->param();
//        $stu = StudentModel::where('sname', $data['sname'])->find();
//        if (!$stu) {
//            return $this->api([], 400, '学员不存在');
//        }
//        $class = ClassNameModel::where('cname', $data['cname'])->find();
//        if (!$class) {
//            return $this->api([], 400, '课程不存在');
//        }
       // $data['sno'] = $stu->sno;
        //$data['cno'] = $class->cno;
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