<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">

        <div class="col-sm-12">
            <div class="contact-box">
                <div class="col-sm-8">
                    <a>
                        <h4><strong style="color: #0a6aa1"><i class="fa fa-info-circle" ></i>&nbsp;&nbsp;请选择权限类型。</strong></h4>
                    </a>

                </div>
                <div class="clearfix"></div>

            </div>
        </div>


        <div class="col-sm-5">
            <div class="contact-box">
                <a href="<?php echo Url::to(['rbac/permissions','status'=>1]) ?>">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/rbacImg.png">
                        </div>
                    </div>

                <div class="col-sm-8">

                        <h2><strong>总后台权限列表</strong></h2>

                    <address>

                        <a href="<?php echo Url::to(['rbac/permissions','status'=>1]) ?>">订易点后台权限</a>
                        <br> <abbr title="Phone">time &nbsp;</abbr> <?php echo date('Y-m-d H:i:s',time())?>
                    </address>
                </div>
                <div class="clearfix"></div>
                </a>
            </div>
        </div>



        <div class="col-sm-5">
            <div class="contact-box">
                <a href="<?php echo Url::to(['rbac/permissions','status'=>2]) ?>">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/rbac1Img.png">
                        </div>
                    </div>

                <div class="col-sm-8">
                    <h2><strong>仓库权限列表</strong></h2>
                    <address>
                        <a href="<?php echo Url::to(['rbac/permissions','status'=>2]) ?>">订易点仓库权限</a>
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