Прмер реализации файла option.php 

```
<?php

use Bitrix\Main\Loader;
use GTD\Dev\Options\Factory;
use GTD\Dev\Options\Entity\Tab;
use GTD\Dev\Options\Entity\InputField;

Loader::includeModule('gtd.dev');

// создаем страницу
$page = new Factory('gtd.smsaero');

// создаем вкладку
$mainTab = new Tab('Подключение');
$messageTab = new Tab('Сообщения');

// регистрируем вкладку
$page
    ->setTab($mainTab)
    ->setTab($messageTab)
;

// Создаем поля для вкладки
$mainTab
    ->setField(
        new InputField('login','Логи')
    )
    ->setField(
        new InputField('API_KEY', 'API Ключ')
    );

$messageTab
    ->setField(
        new InputField('CONFIRM_MESSAGE_TEMPLATE','Шаблон для кода подтверждения')
    );

// вывод страницы
$page->render();
```