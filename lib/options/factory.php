<?php

namespace GTD\Dev\Options;

use Bitrix\Main\Application;use GTD\Dev\Options\Entity\Tab;
use CAdminTabControl;use http\Client\Request;

class Factory{

    /* @var Tab[]*/
    private $tabs;
    private $html = "";


    public function __construct($module_id)
    {
        define('PAGE_BUILDER_MODULE_ID',$module_id);
    }


    /**
     * @return mixed
     */
    public function getModuleId()
    {
        return PAGE_BUILDER_MODULE_ID;
    }

    public function setTab(Tab $tab){
        $this->tabs[] = $tab;
        return $this;
    }

    public function getTabsArrayForTabControl(){
        $arTab = [];
        foreach ($this->tabs as $tab){
            $arTab[] = [
                'DIV' => $tab->getId(),
                'TAB' => $tab->getTitle()
            ];
        }
        return $arTab;
    }

    protected function beforeRender(){
        $request = Application::getInstance()->getContext()->getRequest();
        if($request->isPost() && $request->getPost('Update')){
            foreach ($this->tabs as $tab){
                foreach ($tab->fields as $field){
                    if($val = $request->getPost($field->getId())){
                        \COption::SetOptionString($this->getModuleId(),$field->getId(), $val);
                    }
                }
            }
        }
    }

    public function startForm(){
        global $APPLICATION;
        ?>
        <form method="POST" name="b1team_kvant_options" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialchars($this->getModuleId())?>&amp;lang=<?=LANGUAGE_ID?>">
        <?
    }

    public function endForm(){
        echo "</form>";
    }

    public function render(){
        $this->beforeRender();
        $tabControl = new CAdminTabControl("tabControl", $this->getTabsArrayForTabControl());
        $tabControl->Begin();
        $this->startForm();
        foreach ($this->tabs as $tab){
            $tabControl->BeginNextTab();
            $tab->getHtml();
        }

        $tabControl->Buttons();
        ?>
        <input  type="submit" name="Update" value="<?=GetMessage("MAIN_SAVE")?>" title="<?=GetMessage("MAIN_OPT_SAVE_TITLE")?>">
        <?if(strlen($_REQUEST["back_url_settings"])>0):?>
            <input  type="button" name="Cancel" value="<?=GetMessage("MAIN_OPT_CANCEL")?>" title="<?=GetMessage("MAIN_OPT_CANCEL_TITLE")?>" onclick="window.location='<?echo htmlspecialchars(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'">
            <input type="hidden" name="back_url_settings" value="<?=htmlspecialchars($_REQUEST["back_url_settings"])?>">
        <?endif?>
        <?=bitrix_sessid_post();?>
        <?
        $tabControl->End();
        $this->endForm();
    }
}