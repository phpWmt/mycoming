<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%log}}".
 *
 * @property string $id
 * @property string $admin_id
 * @property string $route
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $admin_username
 * @property string $status
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id'], 'required'],
            [['admin_id'], 'integer'],
            [['description', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['route', 'admin_username'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'guan',
            'route' => 'Route',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'admin_username' => 'Admin Username',
            'status' => 'Status',
        ];
    }

    //重写afterSave
    public function afterSave($insert, $changedAttributes){
        return false;
    }

//    public function afterDelete()
//    {
//        return false;
//    }
}

