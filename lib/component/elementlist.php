<?php

namespace Gtd\Dev\Component;
use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Gtd\Dev\Model\BaseIblockModel;


abstract class ElementList extends ApiComponent{

    protected $data;

    protected $filter;

    protected $order;

    protected $page = 1;

    protected $limit = 20;

    protected $pagination = [];

    protected $elementModelClass = "";

    public function onPrepareComponentParams($arParams)
    {
        $arParams = $this->onPrepareClientComponentParams($arParams);
        if(empty($arParams['IBLOCK_ID'])){
            throw new \Exception('не указан id инфоблока');
        }else{
            $this->filter['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
        }
        if(empty($arParams['MODEL_CLASS'])){
            $this->elementModelClass  = "Gtd\Dev\Model\BaseIblockModel";
        }else{
            //@todo: Нужны проверки на интерфейс и тд
            $this->elementModelClass = $arParams['MODEL_CLASS'];
        }
        return $arParams;
    }

    public function onPrepareClientComponentParams(array $arParams): array
    {
        return $arParams;
    }

    public function beforeExecute(){}

    public function setFilter(){
        $this->filter['CATALOG_AVAILABLE'] = 'Y';
    }

    public function setOrder(){}

    public function setPage(){
        $page = $this->request->getQuery('page');
        if($page !== null & $page > 0){
            $this->page = $page;
        }
    }

    public function getDataFromDb(){
        Loader::includeModule('iblock');
        $res = \CIBlockElement::GetList($this->order,$this->filter,false, ['iNumPage' => $this->page, 'nPageSize' => $this->limit]);
        while ($ob = $res->GetNextElement()){
            $this->data[] = $this->elementModelClass::createInstance($ob);
        }
        $this->setPagination($res);
    }

    public function setPagination(\CIBlockResult $res){
        $this->pagination = [
            'count' => $res->NavRecordCount,
            'perPage' => $res->NavPageSize,
            'cutPage' => $res->NavNum,
            'pages' => $res->NavPageCount
        ];
    }

    public function processData(){
        foreach ($this->data as $item){
            $this->arResult[] = $item->getApiModel();
        }
    }

    public function setResponse(){
        $res = [
            'seo' => [],
            'data' => $this->arResult,
            'pagination' => $this->pagination
        ];
        $this->response->setResult($res);
    }

    public function executeApiComponent()
    {
        $this->beforeExecute();
        $this->setFilter();
        $this->setOrder();
        $this->setPage();
        $this->getDataFromDb();
        $this->processData();
        $this->setResponse();
    }

}