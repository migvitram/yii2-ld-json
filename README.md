Simple ld-json widget for Yii2
==========================
Widget to add ld-json micro markup to head of HTML document (or on the page).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist migvitram/yii2-ld-json "*"
```

or add

```
"migvitram/yii2-ld-json": "*"
```

to the require-dev section of your `composer.json` file.


Usage
-----

If it is needed only widget, it is need to add to the main template layout:

```
use migvitram\ldJson\JsonLDWidget;

<?php echo JsonLDWidget::widget([]); ?>
```

It will make json data output. And than add the next, everywhere

```
<?php

use migvitram\ldJson\JsonLDWidget;

JsonLDWidget::widget([
    'inputData' => [ ... ], // data of the project
    'type' => JsonLDWidget::TYPE_PRODUCT,
]);
 
?>
```

In case JsonLD module needed, modify the web.php config file, modules section:

```php
 'modules' => [
    ...
    'ldJson' => [
        'class' => 'migvitram\ldJson\...',
    ]
 ]
```

