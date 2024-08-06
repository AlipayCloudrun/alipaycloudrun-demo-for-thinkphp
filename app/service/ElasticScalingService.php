<?php
namespace app\service;

class ElasticScalingService
{
    private $cpuCores;

    public function __construct()
    {
        // 获取 CPU 核心数量并确保其为整数
        $this->cpuCores = max(1, (int) trim(shell_exec('nproc')));
    }

    public function cpuUpdate($percentage)
    {
        // 在更新之前先清空之前的进程
        $this->cpuClean();

        if ($this->cpuCores === 1) {
            // 单核系统，使用目标值 70%
            return $this->createSingleCoreProcess();
        } else {
            // 多核系统，使用传入的百分比
            return $this->adjustCpuUsage($percentage);
        }
    }

    public function cpuClean()
    {
        $this->terminateBusyProcesses();
        return ['status' => 'success', 'message' => '所有繁忙等待的进程已终止。'];
    }

    private function adjustCpuUsage($percentage)
    {
        $percentage = max(0, min(100, $percentage)); // 确保百分比在 0 到 100 之间
        $processCount = max(1, $this->calculateProcessCount($percentage));
        $this->createProcesses($processCount);
        return ['status' => 'success', 'message' => "已成功创建 $processCount 个进程。"];
    }

    private function terminateBusyProcesses()
    {
        exec('pkill -f "while :; do :; done"', $output, $return_var);
        // 处理进程终止，不显示错误消息
    }

    private function calculateProcessCount($percentage)
    {
        return max(1, (int)($this->cpuCores * $percentage / 100));
    }

    private function createProcesses($processCount)
    {
        for ($i = 0; $i < $processCount; $i++) {
            exec('( while :; do :; done ) > /dev/null 2>&1 &');
        }
    }

    private function createSingleCoreProcess()
    {
        return ['status' => 'error', 'message' => '请在服务设置中调整实例规格为多核CPU。'];
    }
}
?>