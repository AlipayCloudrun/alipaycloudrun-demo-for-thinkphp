<?php

namespace app\controller;

use Exception;
use app\model\RecordModel;
use think\response\Html;
use think\response\Json;
use think\facade\Log;
use app\common\GetStrForLog;
use think\facade\Cache;

class Index
{

    /**
     * 主页静态页面
     * @return Html
     */
    public function index(): Html
    {
        $begin = time();
        $log = new GetStrForLog();
        try {
            # html路径: ../view/index.html
            $resp = response(file_get_contents(dirname(dirname(__FILE__)) . '/view/index.html'));
            $str = $log->getStr($begin, 'Y');
            Log::channel('MVC-LOGGER')->INFO($str);
            return $resp;
        } catch (Exception $e) {
            Log::channel('ERR-LOGGER')->error($e->getMessage());
        }
    }

    /**
     * 获取当前时刻
     * @return Json
     */
    public function getNowTime(): Json
    {
        $begin = time();
        $log = new GetStrForLog();
        $res = [];
        $rs = 'Y';
        try {
            $time = date('Y-m-d H:i:s', time());
            $hostName = getenv('HOSTNAME') == null ? 'thinkphp_demo' : getenv('HOSTNAME');
            $serviceVersion = getenv('PUB_SERVICE_REVISION') == null ? 'thinkphp_demo' : getenv('PUB_SERVICE_REVISION');
            $str = '欢迎使用云托管!服务版本：' . $serviceVersion . ' 实例主机：' . $hostName . ' 当前时间：' . $time;
            $res = [
                "success" => true,
                "data" => $str,
                "errorCode" => "",
                "errorMessage" => ""
            ];
        } catch (Exception $e) {
            Log::channel('ERR-LOGGER')->error($e->getMessage());
            $res = [
                "success" => false,
                "data" => $str,
                "errorCode" => "",
                "errorMessage" => $e->getMessage()
            ];
            $rs = 'N';
        }
        $st = $log->getStr($begin, $rs);
        Log::channel('MVC-LOGGER')->INFO($st);
        return  json($res);
    }

    /**
     * 获取记录列表
     * @return Json
     */
    public function getList(): Json
    {
        $begin = time();
        $log = new GetStrForLog();
        $res = [];
        $rs = 'Y';
        try {
            $recordModel = new RecordModel();
            $rows = $recordModel->queryList();
            $res = [
                "success" => true,
                "data" => $rows,
                "errorCode" => "",
                "errorMessage" => ""
            ];
        } catch (Exception $e) {
            Log::channel('ERR-LOGGER')->error($e->getMessage());
            $res = [
                "success" => false,
                "data" => $e->getMessage(),
                "errorCode" => "",
                "errorMessage" => ""
            ];
            $rs = 'N';
        }
        $st = $log->getStr($begin, $rs);
        Log::channel('MVC-LOGGER')->INFO($st);
        return  json($res);
    }

    /**
     * 插入记录
     * @return Json
     */
    public function addRecord(): Json
    {
        $begin = time();
        $log = new GetStrForLog();
        $res = [];
        $rs = 'Y';
        try {
            $inputjson = file_get_contents('php://input');
            $obj = json_decode($inputjson);
            $record = $obj->record;
            $recordModel = new RecordModel();
            $result = $recordModel->addRecord($record);
            $res = [
                "success" => true,
                "data" => $result,
                "errorCode" => "",
                "errorMessage" => ""
            ];
        } catch (Exception $e) {
            Log::channel('ERR-LOGGER')->error($e->getMessage());
            $res = [
                "success" => false,
                "data" => $e->getMessage(),
                "errorCode" => "",
                "errorMessage" => ""
            ];
            $rs = 'N';
        }
        $st = $log->getStr($begin, $rs);
        Log::channel('MVC-LOGGER')->INFO($st);
        return  json($res);
    }

    /**
     * 删除记录
     * @return Json
     */
    public function deleteRecord($id): Json

    {

        $begin = time();
        $log = new GetStrForLog();
        $res = [];
        $rs = 'Y';
        try {
            $record = new RecordModel();
            $result = $record->deleteRecord($id);
            $res = [
                "success" => true,
                "data" => $result,
                "errorCode" => "",
                "errorMessage" => ""
            ];
        } catch (Exception $e) {
            Log::channel('ERR-LOGGER')->error($e->getMessage());
            $res = [
                "success" => false,
                "data" => $e->getMessage(),
                "errorCode" => "",
                "errorMessage" => ""
            ];
            $rs = 'N';
        }
        $st = $log->getStr($begin, $rs);
        Log::channel('MVC-LOGGER')->INFO($st);
        return  json($res);
    }


    /**
     * 缓存取值
     * @return Json
     */
    public function getKey($key): Json
    {
        $begin = time();
        $log = new GetStrForLog();
        $res = [];
        $rs = 'Y';
        try {
            $val = Cache::store('redis')->get($key);
            $res = [
                "success" => true,
                "data" => $val == '' ? 'nil' : $val,
                "errorCode" => "",
                "errorMessage" => ""
            ];
        } catch (Exception $e) {
            Log::channel('ERR-LOGGER')->error($e->getMessage());
            $rs = 'N';
            $res = [
                "success" => false,
                "data" => "取值失败",
                "errorCode" => "",
                "errorMessage" => ""
            ];
        }
        $st = $log->getStr($begin, $rs);
        Log::channel('MVC-LOGGER')->INFO($st);
        return  json($res);
    }


    /**
     * 缓存赋值
     * @return Json
     */
    public function setKV($key, $value): Json
    {
        $begin = time();
        $log = new GetStrForLog();
        $res = [];
        $rs = 'Y';
        try {
            Cache::store('redis')->set($key, $value);
            $res = [
                "success" => true,
                "data" => "赋值成功",
                "errorCode" => "",
                "errorMessage" => ""
            ];
        } catch (Exception $e) {
            Log::channel('ERR-LOGGER')->error($e->getMessage());
            $rs = 'N';
            $res = [
                "success" => false,
                "data" => "赋值失败",
                "errorCode" => "",
                "errorMessage" => ""
            ];
        }
        $st = $log->getStr($begin, $rs);
        Log::channel('MVC-LOGGER')->INFO($st);
        return  json($res);
    }
}
