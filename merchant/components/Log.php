<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/20
 * Time: 11:46
 */

namespace merchant\components;

use yii;
use merchant\models\Log as AdminLogModel;
use yii\base\Event;
use yii\db\BaseActiveRecord;

class Log extends \yii\base\Object
{
    /**
     * 通过依赖注入的方式结合AR类save方法产生的事件，给数据库所有所做加上子自定义事件
     */
    public static function LogInit(){
        Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_INSERT, [
            self::className(),
            'create'
        ]);

        Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_UPDATE, [
            self::className(),
            'update'
        ]);

        Event::on(BaseActiveRecord::className(), BaseActiveRecord::EVENT_AFTER_DELETE, [
            self::className(),
            'delete'
        ]);
    }


    /**
     * 数据库新增日志
     *
     * @param $event
     */
    public static function create($event)
    {
        if ($event->sender->className() !== AdminLogModel::className()) {
            $desc = '<br>';
            if ($event->sender->getAttributes()){
                $attributelabel=$event->sender->getAttributes();
            }else{
               $attributelabel=$event->sender->attributes;
            }

            foreach ($attributelabel as $name => $value) {
                $desc .= $event->sender->getAttributeLabel($name) . '(' . $name . ') => ' . $value . ',<br>';
            }
            $desc = substr($desc, 0, -5);
            $model = new AdminLogModel();
            $class = $event->sender->className();
            $id_des = '';

            if (isset($event->sender->id)) {
                $id_des = 'ID为 ' . $event->sender->id;
            }

            $model->description = '管理员 [ ' . yii::$app->admin->identity->username . ' ] 通过 ' . $class . ' [ ' . $class::tableName() . ' ] ' . " 创建 {$id_des} 的记录: " . $desc;
            $model->route = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
            $model->admin_id = yii::$app->admin->id;
            $model->admin_username = yii::$app->admin->identity->username;
            $model->created_at=date('Y-m-d H:i:s',time());
            $model->save(false);
        }
    }



    /**
     * 数据库修改日志
     *
     * @param $event
     */
    public static function update($event)
    {
        if(empty($event->sender->changedAttributes)){
            $changedAttributes=$event->changedAttributes;
        }else{
            $changedAttributes=$event->sender->changedAttributes;
        }

        if ($changedAttributes) {
            $desc = '<br>';
            $oldAttributes = $event->sender->oldAttributes;
            foreach ($changedAttributes as $name => $value) {
                if( $oldAttributes[$name] == $value ) continue;
                $desc .= $event->sender->getAttributeLabel($name) . '(' . $name . ') : ' . $value . '=>' . $event->sender->oldAttributes[$name] . ',<br>';
            }
            $desc = substr($desc, 0, -5);
            $model = new AdminLogModel();
            $class = $event->sender->className();
            $id_des = '';

            if (isset($event->sender->id)) {
                $id_des = 'ID ' . $event->sender->id;
            }
            $model->description = '管理员 [ ' . yii::$app->admin->identity->username . ' ] 通过 ' . $class . ' [ ' . $class::tableName() . ' ] ' . " 修改 {$id_des} 的记录: " . $desc;
            $model->route = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
            $model->admin_id = yii::$app->admin->id;
            $model->admin_username = yii::$app->admin->identity->username;
            $model->created_at=date('Y-m-d H:i:s',time());
            $model->save();
        }
    }



    /**
     * 数据库删除日志
     *
     * @param $event
     */
    public static function delete($event)
    {
        $desc = '<br>';
        if ($event->sender->getAttributes()){
            $attributelabel=$event->sender->getAttributes();
        }else{
            $attributelabel=$event->sender->attributes;
        }
        foreach ($attributelabel as $name => $value) {
            $desc .= $event->sender->getAttributeLabel($name) . '(' . $name . ') => ' . $value . ',<br>';
        }
        $desc = substr($desc, 0, -5);
        $model = new AdminLogModel();
        $class = $event->sender->className();
        $id_des = '';
        if (isset($event->sender->id)) {
            $id_des = 'ID ' . $event->sender->id;
        }
        $model->description = '管理员 [ ' . yii::$app->admin->identity->username . ' ] 通过 ' . $class . ' [ ' . $class::tableName() . ' ] ' . " 删除 {$id_des} 的记录: " . $desc;
        $model->route = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
        $model->admin_id = yii::$app->admin->id;
        $model->admin_username = yii::$app->admin->identity->username;
        $model->created_at=date('Y-m-d H:i:s',time());
        $model->save();
    }

}