<?php

namespace Gtd\Dev\Component;

use CBitrixComponent;
use Gtd\Dev\HttpResponse\Json;

abstract class ApiComponent extends CBitrixComponent{

    /** @var $response Json */
    protected $response;

    private function construct(){
        $this->response = new Json();
    }

    final public function executeComponent()
    {
        $this->construct();
        $this->executeApiComponent();
        $this->response->show();
    }

    abstract public function executeApiComponent();
}