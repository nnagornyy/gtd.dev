<?php


class gtd_dev extends CModule{

    public $MODULE_ID = "gtd.dev";
    public $MODULE_NAME = "Модуль для полезных фичей разработки";

    public function DoInstall()
    {
        RegisterModule($this->MODULE_ID);
    }
    public function DoUninstall()
    {
        UnRegisterModule($this->MODULE_ID);
    }
}