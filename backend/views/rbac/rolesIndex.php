<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\bootstrap\Alert;

if( Yii::$app->getSession()->hasFlash('success') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', //这里是提示框的class
        ],
        'body' => Yii::$app->getSession()->getFlash('success'), //消息体
    ]);
}

?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">

        <div class="col-sm-12">
            <div class="contact-box">
                <div class="col-sm-8">
                    <a>
                        <h4><strong style="color: #0a6aa1"><i class="fa fa-info-circle" ></i>&nbsp;&nbsp;请选择角色类型。</strong></h4>
                    </a>

                </div>
                <div class="clearfix"></div>

            </div>
        </div>


        <div class="col-sm-5">
            <div class="contact-box">
                <a href="<?php echo Url::to(['rbac/roles','data'=>1]) ?>">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/rbacImg.png">
                        </div>
                    </div>

                <div class="col-sm-8">

                        <h2><strong>总后台角色列表</strong></h2>

                    <address>

                        <a>总后台角色</a>
                        <br> <abbr title="Phone">time &nbsp;</abbr> <?php echo date('Y-m-d H:i:s',time())?>
                    </address>
                </div>
                <div class="clearfix"></div>
                </a>
            </div>
        </div>



        <div class="col-sm-5">
            <div class="contact-box">
                <a href="<?php echo Url::to(['rbac/roles','data'=>2]) ?>">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/rbac1Img.png">
                        </div>
                    </div>

                <div class="col-sm-8">

                        <h2><strong>仓库角色列表</strong></h2>

                    <address>

                        <a>仓库角色</a>
                        <br> <abbr title="Phone">time &nbsp;</abbr> <?php echo date('Y-m-d H:i:s',time())?>
                    </address>
                </div>
                <div class="clearfix"></div>

                </a>

            </div>
        </div>
    </div>
</div>


</body>