<?php
/**
 * Created by PhpStorm.
 * User: damai
 * Date: 2017/9/9
 * Time: 8:36
 */

namespace backend\traits;

use backend\models\Config;

trait AdminTrait
{
    public $session;

    public function init()
    {
        $this->session = \Yii::$app->session;
    }

    /**获取配置信息
     *
     * @param string $name 配置名称
     *
     * @return mixed|null 不存在返回 null
     */
    public function getConfig($name)
    {
        
        $config = Config::find()->where(['name' => $name])->asArray()->one();
        if (is_null($config)) {
            return null;
        } else {
            return json_decode($config['info'],true);
        }

    }

    /**
     * 获取配置信息 在页面调用使用此方式
     * trait特性（不是通过控制器调用，只能实现为静态方法）
     * @param $name要获取值的名称
     * @return mixed|null 返回数组
     */
    public static function web_getConfig($name)
    {
        $config = Config::find()->where(['name' => $name])->asArray()->one();
        if (is_null($config)) {
            return null;
        } else {
            return json_decode($config['info'],true);
        }
    }

}