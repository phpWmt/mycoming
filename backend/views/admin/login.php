<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\captcha\Captcha;
$css=<<<CSS
    #admin-code{
        width:50%;
        float: left;
    }
    #code img{
        border-radius: 3px;
        margin-left: 3.4rem;
    }
CSS;
$this->registerCss($css);
?>
<body class="gray-bg">
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name" style="margin-top:200px;"></h1>
        </div>
        <h2>登录界面</h2>
        <?php
        $form = ActiveForm::begin([

            'action' => Url::to(['admin/login']),
            'validateOnBlur'=>false,//关闭失去焦点验证
            'enableAjaxValidation'=>true, //开启Ajax验证
            'fieldConfig' => [
                'template' => '<div class="form-group">{input}{error}</div>',
            ]
        ]);
        ?>
        <?= $form->field($model, 'username')->textInput(['placeholder' => '用户名', 'class' => 'form-control']) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码', 'class' => 'form-control']) ?>

        <?= Html::submitButton('登录', ['class' => 'btn btn-primary block full-width m-b']) ?>
        <?php
        ActiveForm::end();
        ?>
        </p>
    </div>
</div>
</body>

