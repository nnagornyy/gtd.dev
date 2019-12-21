<?php

namespace Gtd\Dev\Model;

interface IblockModelInterface{

    /**
     * Карта для преобразования свойств , должен быть пустой для вывода без применениие карты
     * @return array
     */
    public function getMap():array;

    public static function createInstance(\_CIBElement $ob);

    public function getApiModel():array;

}