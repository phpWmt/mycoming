<?php

namespace merchant\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property integer $phone
 * @property string $create_time
 * @property string $last_time
 * @property string $login_ip
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $code;
    public $password2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    public function scenarios()
    {
        return [
            'create' => ['username', 'password', 'password2', 'name', 'phone'],
            'login' => ['username', 'password', 'status','code'],
            'update' => ['password', 'password2','name','phone'],
        ];
    }

    public function rules()
    {
        return [
            ['username','unique','targetClass' =>'\merchant\models\Admin','message'=>'该账号已被占用','on'=>'create'],
            ['phone', 'unique', 'targetClass' =>'\merchant\models\Admin','message' => '该手机号已注册','on'=>'create'],
            ['phone','match','pattern'=>'/^[1][358][0-9]{9}$/','message'=>'请输入正确的手机号','on'=>['create','update']],
            [['username', 'name','password','password2','phone'], 'required','message'=>'此项不可为空','on'=>['login','create']],
            [['name','phone'],'required' ,'message'=>'此项不可为空','on'=>'update'],
            [['username'], 'string', 'length' => [4, 16],'tooLong' => '长度限制为4-16字符', 'tooShort' => '长度限制为4-16字符', 'on' => 'create'],
            ['password', 'validatePass', 'on' => 'login'],
            ['phone', 'validatePhone', 'on' => 'update'],
            ['password2', 'compare', 'compareAttribute'=> 'password', 'message' => "两次密码输入不一致", 'on' => ['create','update']],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'name' => '姓名',
            'phone' => '手机号',
            'create_time' => '创建时间',
            'last_time' => '最后登录时间',
            'login_ip' => '最后登录IP',
        ];
    }


    public function Login($data, $scenario = 'login'){
        $this->scenario = $scenario;
        if ($this->load($data) && $this->validate()) {
            return Yii::$app->admin->login($this->getAdmin());
        } else {
            return false;
        }
    }



    public function Create($data, $scenario = 'create'){
        $this->scenario = $scenario;
        if ($this->load($data) && $this->validate()) {
            $this->password=Yii::$app->getSecurity()->generatePasswordHash($this->password);
            $this->create_time=date('Y-m-d H:i:s',time());
            $this->status=2;
            if ($this->save(false)){
                return true;
            }
        } else {
            return false;
        }
    }


    public function validatePass()
    {
        $data = self::find()->where(['username' => $this->username])->asArray()->one();

        if (!empty($data)) {
            if ($data['status']!=2){
                $this->addErrors(['username'=>'该账户已被禁用，请与网站超级管理员联系!']);
            }
        }else{
            $this->addErrors(['password'=>'用户名或密码错误！','username'=>'用户名或密码错误！']);
        }
        if (!$this->hasErrors()) {
            if (!Yii::$app->getSecurity()->validatePassword($this->password, $data['password'])) {
                $this->addErrors(['password'=>'用户名或密码错误！','username'=>'用户名或密码错误！']);
            }
        }
    }


    public function validatePhone()
    {
        $count = self::find()->where(['phone' => $this->phone])->count();
        if ($count>0) {
            $this->addError('phone','手机号已被注册');
        }
    }



    /**
     * @param array $data请求过来的post数据
     * @param string $scenario 场景默认update
     * @return bool
     */
    public function Update($data=[], $scenario = 'update'){
        $this->scenario = $scenario;
        if ($this->load($data) && $this->validate()) {
            if (empty($this->password)){
                $admin=array_filter($data['Admin']);
               $model=self::findOne($data['Admin']['id']);
                return (bool)$model->updateAll($admin,['id' => $data['Admin']['id']]);
            }else{
                $password=Yii::$app->getSecurity()->generatePasswordHash($this->password);
                return (bool)$this->updateAll(['password' => $password],  ['id' => $data['Admin']['id']]);
            }
        } else {
            return false;
        }
    }


    public function getAdmin(){
        return self::find()->where(['username'=>$this->username])->one();
    }


    public static function getUser(){

    }


    //返回这个管理员实例
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }


    //返回管理员ID
    public function getId()
    {
        return $this->id;
    }

    public function getCity(){

    }


    //cooklie验证时用到
    public  function getAuthKey()
    {
        return '';
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }


}
