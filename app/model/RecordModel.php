<?php

namespace app\model;

use think\facade\Db;
use think\facade\Log;
use app\common\GetStrForLog;
use Exception;

class RecordModel
{
    //查询多条记录
    public function queryList()
    {
        $begin = time();
        $log = new GetStrForLog();
        $result = [];
        $rs = 'Y';
        try {
            $result = Db::table('record_info')->field('id,record,gmt_create')->limit(10)->select();
        } catch (Exception $e) {
            $rs = 'N';
            $result = null;
            Log::channel('ERR-LOGGER')->error($e->getMessage());
        }
        $str = $log->getStr($begin, $rs);
        Log::channel('DAL-LOGGER')->INFO($str);

        return $result;
    }


    //新增一条记录
    public function addRecord($record)
    {
        $begin = time();
        $log = new GetStrForLog();
        $result = '';
        $rs = 'Y';
        try {
            $data = ['record' => $record];
            $result = Db::table("record_info")->insert($data);
        } catch (Exception $e) {
            $rs = 'N';
            $result = null;
            Log::channel('ERR-LOGGER')->error($e->getMessage());
        }
        $str = $log->getStr($begin, $rs);
        Log::channel('DAL-LOGGER')->INFO($str);
        return $result;
    }


    //删除记录
    public function deleteRecord($id)
    { {
            $begin = time();
            $log = new GetStrForLog();
            $result = '';
            $rs = 'Y';
            try {
                $result = Db::table("record_info")->where('id', $id)->delete();
            } catch (Exception $e) {
                $rs = 'N';
                $result = null;
                Log::channel('ERR-LOGGER')->error($e->getMessage());
            }
            $str = $log->getStr($begin, $rs);
            Log::channel('DAL-LOGGER')->INFO($str);
        }

        return $result;
    }
}
