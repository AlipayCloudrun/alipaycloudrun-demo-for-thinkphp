<?php
namespace app\controller;

use think\Request;

class ElasticScalingController {

    protected $elasticScalingService;

    public function __construct() {
        $this->elasticScalingService = new \app\service\ElasticScalingService();
    }

    public function memoryUpdate(Request $request) {
        try {
            $percentage = $request->get('percentage');
            if (is_null($percentage)) {
                throw new \Exception("Missing 'percentage' parameter");
            }
            $load = intval($percentage);
            if ($load < 0 || $load > 80) {
                throw new \Exception("Percentage 应位于 0-80");
            }
            $result = $this->elasticScalingService->cpuUpdate($load);
            return json($result);
        } catch (\Exception $e) {
            return json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function memoryClean() {
        $result = $this->elasticScalingService->cpuClean();
        return json($result);
    }
}
?>