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

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

<title>仓库后台 - 登录</title>
<meta name="keywords" content="">
<meta name="description" content="">
<link href="/new/bootstrap.min.css" rel="stylesheet">
<link href="/new/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
<link href="/new/animate.min.css" rel="stylesheet">
<link href="/new/style.min.css" rel="stylesheet">
<link href="/new/login.min.css" rel="stylesheet">
<!--[if lt IE 9]>
<meta http-equiv="refresh" content="0;ie.html" />
<![endif]-->
<script>
    if(window.top!==window.self){window.top.location=window.location};
</script>

<body class="signin">
<div class="signinpanel">
    <div class="row">
        <div class="col-sm-7">
            <div class="signin-info">
                <div class="logopanel m-b">
                    <h1>[ 订易点 ]</h1>
                </div>
                <div class="m-b"></div>
                <h4>欢迎进入 <strong>订易点 仓库后台</strong></h4>

                <strong><a href="#"></a></strong>
            </div>
        </div>
        <div class="col-sm-5">
            <form method="post" action="">
                <h4 class="no-margins">登录：</h4>
                <p class="m-t-md">登录到订易点仓库后台</p>
                <!-- 开始表单组件-->
                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['admin/login']), //提交路径
                    'validateOnBlur'=>false,//关闭失去焦点验证
                    'enableAjaxValidation'=>true, //开启Ajax验证
                    'fieldConfig' => [
                        'template' => '<div class="form-group">{input}{error}</div>',
                    ]
                ]);?>
                <!--表单条目-->
                <?= $form->field($model, 'username')->textInput(['placeholder' => '用户名', 'required'=>'required','class' => 'form-control uname']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => '密码','required'=>'required', 'class' => 'form-control pword m-b']) ?>

                <!--提交按钮-->
                <?= Html::submitButton('登录', ['class' => 'btn btn-success btn-block']) ?>

                <!--结束表单组件-->
                <?php ActiveForm::end();?>

            </form>
        </div>
    </div>
    <div class="signup-footer">
        <div class="pull-left">
            &copy; <?php echo date('Y-m-d H:i:s',time()); ?>
        </div>
    </div>
</div>
</body>




