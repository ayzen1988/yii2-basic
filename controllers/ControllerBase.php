<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii\web\Controller;

/**
 * Description of ControllerBase
 *
 * @author zhangb14
 */
class ControllerBase extends Controller {

    public function __construct($id, $module) {
        parent::__construct($id, $module);
//        var_dump($this->getData());
    }

    public function getData() {
        return [];
    }

}
