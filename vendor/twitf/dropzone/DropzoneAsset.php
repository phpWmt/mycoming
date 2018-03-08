<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/11
 * Time: 13:45
 */
namespace twitf\dropzone;
use yii\web\AssetBundle;
class DropzoneAsset extends AssetBundle
{
    public $js = [
        'dropzone.js',
        'dropzone_demo.js',
    ];

    public $css=[
        'basic.css',
        'dropzone.css',
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
    }
}