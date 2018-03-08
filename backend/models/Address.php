<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%user_address}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $phone
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $info
 * @property string $name
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['phone'], 'string', 'max' => 11],
            [['province', 'city', 'area'], 'string', 'max' => 32],
            [['info'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'phone' => '手机号',
            'province' => '省份',
            'city' => '城市',
            'area' => '县区',
            'info' => '详细地址',
            'name' => '收件人',
        ];
    }
}
