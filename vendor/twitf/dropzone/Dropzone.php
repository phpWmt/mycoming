<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/11
 * Time: 13:33
 */

namespace twitf\dropzone;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\InputWidget;
class Dropzone extends InputWidget{

    /**
     * 配置选项，
     * 详情参阅dropzone官网文档 http://www.dropzonejs.com/#configuration-options
     */
    public $clientOptions = [];

    //默认配置
    protected $_options;

    public function init()
    {
        if (isset($this->options['id'])) {
            $this->id = $this->options['id'];
        } else {
            $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->id;
        }

        $this->_options = [
            'url'=> Url::to(['upload']),
            'delUrl'=>Url::to(['delete']),
            'parallelUploads'=> 2,//一次请求提交文件的数量
            'uploadMultiple'=> true,//是否在一个请求中发送多个文件
            'autoProcessQueue'=> false, //自动上传
            'maxFilesize'=> get_cfg_var ("post_max_size")?(int)get_cfg_var ("post_max_size"):0,
        ];
        //合并参数
        $this->clientOptions = ArrayHelper::merge($this->_options, $this->clientOptions);
        parent::init();
    }

    public function run()
    {
        $this->registerClientScript();

        return Html::tag('div', '<button type="button" id="upload_img" class="btn btn-primary pull-right" style="position: absolute;right: 0.5rem;top: 0.5rem;">提交</button>',['id' => $this->id]);
    }

    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()

    {
        DropzoneAsset::register($this->view);
        $clientOptions = Json::encode($this->clientOptions);
        $script ="createDropzone(".$clientOptions.");";
        $this->view->registerJs($script, View::POS_READY);
    }
}