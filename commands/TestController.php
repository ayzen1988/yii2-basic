<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class HelloController extends Controller
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
            'task_worker_num' => 1,
            'daemonize' => false,
            'heartbeat_check_interval' => 60,
            'heartbeat_idle_time' => 600,
//            'log_file' => '/data/dt/swoole/error/' . LOG_NAME
        ));
        $serv->on('connect', array($this, 'connect'));
        $serv->on('receive', array($this, 'receive'));
        $serv->on('task', array($this, 'task'));
        $serv->on('finish', array($this, 'finish'));
        $serv->on('close', array($this, 'close'));
        $serv->start();
    }

    public function connect($serv, $fd)
    {
        
    }

    public function receive($serv, $fd, $from_id, $data)
    {
        $serv->task(array('fd' => $fd, 'data' => $data));
    }

    public function task($serv, $task_id, $from_id, $data)
    {
        var_dump($data);
    }

    public function finish($serv, $task_id, $data)
    {
        
    }

    public function close($serv, $fd)
    {
        
    }

}
