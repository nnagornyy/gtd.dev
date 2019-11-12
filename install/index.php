<?php
use Bitrix\Main\Localization\Loc;

class gtd_dev extends CModule{

    public $MODULE_ID = "gtd.dev";
    public $MODULE_NAME = "";

    public function __construct()
    {
        $this->MODULE_NAME = Loc::getMessage("GTD_DEV_MODULE_NAME");
    }

    public function DoInstall()
    {
        RegisterModule($this->MODULE_ID);
    }
    public function DoUninstall()
    {
        UnRegisterModule($this->MODULE_ID);
    }
}