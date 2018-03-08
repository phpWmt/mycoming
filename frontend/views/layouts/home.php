<?php
use yii\helpers\Url;
/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;

use backend\assets\AppAsset;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html lang="zh-cn">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="renderer" content="webkit">

    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="icon" href="home/default/logo1.ico" type="image/x-icon"/>

    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

    <!-- css-->
    <link rel="stylesheet" href="/home/amazeui/css/amazeui.min.css"/>

    <link rel="stylesheet" href="/home/default/style.css"/>

    <!--js-->

    <script src="/home/amazeui/js/jquery.min.js"></script>

    <script src="/home/amazeui/js/amazeui.min.js"></script>


</head>



<?php $this->beginBody() ?>



<?= $content ?>



<?php $this->endBody() ?>

<!--底部-->
<div data-am-widget="navbar" class="am-navbar am-cf my-nav-footer " id="">
    <ul class="am-navbar-nav am-cf am-avg-sm-4 my-footer-ul">
        <li>
            <a href="<?php echo Yii::$app->params['APP_URL']?>" class=""> <span class="am-icon-home"></span> <span class="am-navbar-label">首页</span>
            </a>
        </li>
        <li>
            <a href="###" class=""> <span class=" am-icon-phone"></span> <span class="am-navbar-label">电话</span>
            </a>
        </li>
        <li>
            <a href="###" class=""> <span class=" am-icon-comments"></span> <span class="am-navbar-label">聊天</span>
            </a>
        </li>
        <li>
            <a href="#" class=""> <span class=" am-icon-map-marker"></span> <span class="am-navbar-label">地图</span>
            </a>
        </li>
        <li style="position:relative"><a href="javascript:;" onClick="showFooterNav();" class=""> <span class="am-icon-user"></span> <span class="am-navbar-label">会员</span> </a>
            <div class="footer-nav" id="footNav">
                <span class=" am-icon-bank">
                    <a href="#">买家中心</a>
                </span>
                <span class="am-icon-suitcase">
                    <a href="#">卖家中心</a></span>
                <span class="am-icon-usd">
                    <a href="#">我的钱包</a>
                </span>
                <span class="am-icon-user">
                    <a href="<?php echo Url::to(['reg/index'])?>">个人资料</a>
                </span>
                <span class="am-icon-th-list">
                    <a href="">帮助中心</a>
                </span>
                <span class="am-icon-comments">
                    <a href="#">消息中心</a></span>
                <span class="am-icon-power-off">
                    <a href="<?php echo Url::to(['public/lout'])?>">安全退出</a>
                </span>
            </div>
        </li>
    </ul>
    <script>
        function showFooterNav() {
            $("#footNav").toggle();
        }
    </script>
</div>
<!--底部-->


</html>



<?php $this->endPage() ?>



