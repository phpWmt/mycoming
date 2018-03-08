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
                        <h4><strong style="color: #0a6aa1"><i class="fa fa-info-circle" ></i>&nbsp;&nbsp;请选择类型添加管理员。</strong></h4>
                    </a>

                </div>
                <div class="clearfix"></div>

            </div>
        </div>


        <div class="col-sm-5">
            <div class="contact-box">
                <a href="<?php echo Url::to(['admin/create']) ?>">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/adminImg.png">
                        </div>
                    </div>
                </a>
                <div class="col-sm-8">
                    <a href="<?php echo Url::to(['admin/create']) ?>">
                        <h2><strong>总后台管理员</strong></h2>
                    </a>
                    <address>
                        <a>
                            <strong>Baidu, Inc.</strong><br> E-mail:xxx@baidu.com<br> Weibo:
                        </a><a href="">http://weibo.com/xxx</a>
                        <br> <abbr title="Phone">Tel:</abbr> (123) 456-7890
                    </address>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>



        <div class="col-sm-5">
            <div class="contact-box">
                <a href="<?php echo Url::to(['admin/create-entrepot']) ?>">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/img/entrepotImg.png">
                        </div>
                    </div>
                </a><div class="col-sm-8">
                    <a href="<?php echo Url::to(['admin/create-entrepot']) ?>">
                        <h2><strong>仓库管理员</strong></h2>
                    </a>
                    <address>
                        <a>
                            <strong>Baidu, Inc.</strong><br> E-mail:xxx@baidu.com<br> Weibo:
                        </a><a href="">http://weibo.com/xxx</a>
                        <br> <abbr title="Phone">Tel:</abbr> (123) 456-7890
                    </address>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</div>


</body>