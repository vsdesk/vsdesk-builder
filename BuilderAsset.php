<?php

namespace vsdesk\builder;

use yii\web\AssetBundle;

class BuilderAsset extends AssetBundle
{
    public $sourcePath = '@vsdesk/builder/assets';
    public $css = [
        'site.css',
        'main.css',
    ];
    public $js = [
        'main.js',
        'console.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'vsdesk\builder\FlatUIAsset',
    ];
}
