<?php

namespace app\controllers\api;

use yii\web\Controller;
use app\services\TestService;
use app\services\PinyinService;
use app\controllers\ControllerBase;

class TestController extends ControllerBase
{

    public function __construct($id, $module)
    {
        parent::__construct($id, $module);
        $data = [
            'controller' => \Yii::$app->controller->id,
            'action' => \Yii::$app->controller->action->id,
            'parameter/fly-inspection/save-forfeit' => ['FlyInspect', 'edit']
        ];
    }

//    public function getData() {
//        return ['test' => ['index']];
//    }

    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {
        var_dump(PinyinService::encode('明源云'));
        var_dump(PinyinService::encode('明源云', 'all'));
        $result = $this->abc(0) || $this->abc(1) && $this->abc(3);
        var_dump($result);
    }

    public function actionSchedule()
    {
//        $result = TestService::doScheduleLogic();
//        echo $result;
    }

    public function abc($a)
    {
        var_dump($a);
        return $a;
    }

    public function actionIsUpdated()
    {
        $stime = microtime(true);
        $result = TestService::isProcessAcceptDetailUpdated('39ecfe6b-bbe6-3615-b938-6cb33cf8b6d7', '2019-01-11 16:09:34');
//        var_dump($result);
        $etime = microtime(true);
        var_dump($etime - $stime);
    }

}
