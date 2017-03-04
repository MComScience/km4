Yii2 Assets
===========
Management Asset for Yii 2.0 Application

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist prawee/yii2-assets "*"
```

or add

```
"prawee/yii2-assets": "*"
```

to the require section of your `composer.json` file.


Usage
-----

- on view 
```php
use prawee\assets\PwAsset;
PwAsset::register($this);
.......
.......
```