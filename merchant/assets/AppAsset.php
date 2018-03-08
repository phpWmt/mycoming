<?php

namespace merchant\assets;

use yii\web\AssetBundle;

/**
 * Main merchant application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        '/css/font-awesome-4.7.0/css/font-awesome.min.css',
        '/css/bootstrap.min14ed.css?v=3.3.6',
        '/css/animate.min.css',
        '/css/style.min.css?v=4.1.0',
        '/css/ui-dialog.css',
        '/css/plugins/iCheck/custom.css',
        '/js/plugins/fancybox/jquery.fancybox.css',
        '/css/validform.css',
        '/css/my.css',
    ];
    public $js = [
//        '/js/jquery.min.js?v=2.1.4',
        '/js/bootstrap.min.js?v=3.3.6',
        '/js/content.min.js?v=1.0.0',
        '/js/plugins/metisMenu/jquery.metisMenu.js',
        '/js/plugins/slimscroll/jquery.slimscroll.min.js',
        '/js/plugins/layer/layer.min.js',
        '/js/jquery.form.js',
        '/js/validform.js',
        '/js/hplus.min.js?v=4.1.0',
        '/js/contabs.min.js',
        '/js/plugins/pace/pace.min.js',
        '/js/dialog-plus.js',
        '/js/plugins/iCheck/icheck.min.js',
        '/js/plugins/nestable/jquery.nestable.js',
        '/js/plugins/fancybox/jquery.fancybox.js',
        '/js/plugins/peity/jquery.peity.min.js',
        '/js/demo/peity-demo.min.js',
        '/js/plugins/prettyfile/bootstrap-prettyfile.js',
        '/plugins/laydate/laydate.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * 自定义按需加载JS方法，注意加载顺序在最后
     * @param $view 当前视图对象
     * @param $file_path 文件路径
     */
    public static function addJs($view, $file_path) {
        $view->registerJsFile($file_path, [AppAsset::className(), "depends" => "merchant\assets\AppAsset"]);
    }

    /**
     * 自定义按需加载css方法，注意加载顺序在最后
     * @param $view 当前视图对象
     * @param $file_path 文件路径
     */
    public static function addCss($view, $file_path) {
        $view->registerCssFile($file_path, [AppAsset::className(), "depends" => "merchant\assets\AppAsset"]);
    }
}
