<?php

namespace merchant\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $create_time
 * @property integer $cate_id
 * @property string $admin_username
 * @property integer $admin_id
 * @property string $update_time
 * @property string $status
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    public function getArticleCate(){
        return $this->hasOne(ArticleCate::className(),['id'=>'cate_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'status'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['cate_id', 'admin_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['admin_username'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'create_time' => '创建时间',
            'cate_id' => '分类ID',
            'admin_username' => '管理员',
            'admin_id' => 'Admin ID',
            'update_time' => '修改时间',
            'status' => '状态',
        ];
    }
}
