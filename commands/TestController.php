<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class TestController extends Controller
{

    private $_register = false;

    public function actionIndex()
    {
        $this->getInstance();
    }

    public function getInstance()
    {
        if ($this->_register) {
            return;
        }
        $this->_register = true;
        $serv = new swoole_server("127.0.0.1", 6789);
        $serv->set(array(
            'worker_num' => 1,
            'task_worker_num' => 3,
            'daemonize' => false,
//            'heartbeat_check_interval' => 60,
//            'heartbeat_idle_time' => 600,
//            'log_file' => '/data/dt/swoole/error/' . LOG_NAME
        ));
        $serv->on('connect', array($this, 'connect'));
        $serv->on('receive', array($this, 'receive'));
        $serv->on('task', array($this, 'task'));
        $serv->on('finish', array($this, 'finish'));
        $serv->on('close', array($this, 'close'));
        $serv->on('workerStart', array($this, 'workerStart'));
        $serv->start();
    }

    public function connect($serv, $fd)
    {
        
    }

    public function receive($serv, $fd, $from_id, $data)
    {
        $serv->close($fd);
    }

    public function task($serv, $task_id, $from_id, $data)
    {
        echo (date('Y-m-d H:i:s')) . ' Start Handle Task from_id=' . $from_id . "\r\n";
        sleep(3);
        echo 'data=' . json_encode($data) . ' from_id=' . $from_id . "\r\n";
        echo (date('Y-m-d H:i:s')) . ' End Handle Task from_id=' . $from_id . "\r\n";
    }

    public function finish($serv, $task_id, $data)
    {
        
    }

    public function close($serv, $fd)
    {
        
    }

    public function workerStart($serv, $worker_id)
    {
        if ($worker_id === 0) {
            for ($i = 0; $i < 10; ++$i) {
                echo (date('Y-m-d H:i:s')) . ' Start Push Task i=' . $i . "\r\n";
                $serv->task(['i' => $i, 'rand' => rand()]);
                echo (date('Y-m-d H:i:s')) . ' End Push Task i=' . $i . "\r\n";
            }
        }
    }

}
