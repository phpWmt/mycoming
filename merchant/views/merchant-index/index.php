<?php

use yii\helpers\Url;

?>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i></div>
        <div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;">
            <div class="sidebar-collapse" style="width: auto; height: 100%;">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
                                <span><img alt="image" class="img-circle" src="http://ozwpnu2pa.bkt.clouddn.com/profile_small.jpg"></span>

                                <span class="block m-t-xs">
                                    <strong class="font-bold">
                                        <?php if (!empty(Yii::$app->admin->identity)) {
                                            echo Yii::$app->admin->identity->username;
                                        } ?>
                                    </strong>
                                </span>

                                <span class="text-muted text-xs block" style="color: #ffffff">
                                    <?php if (!empty(Yii::$app->admin->identity)) {
                                        $auth = Yii::$app->authManager;
                                        $item=$auth->getAssignments(Yii::$app->admin->id);
                                        $data=$auth->getRole(array_keys($item)[0]);
                                        echo $data->description;
                                    } ?>
                                </span>
                            </a>
                        </div>
                        <div class="logo-element">后台</div>
                    </li>


                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-user fa-lg"></i>
                            <span class="nav-label">客户管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">

                            <li><a class="J_menuItem" href="<?php echo Url::to(['merchant-user/list']) ?>" data-index="0">客户列表</a></li>
                        </ul>
                    </li>

                    <li class="show">
                        <a href="javascript:;">
                            <i class="glyphicon glyphicon-folder-close"></i>
                            <span class="nav-label">订单管理</span>
                            <span class="label label-success pull-right">待发货：<?php \merchant\models\Order::return_goods()?></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li><a class="J_menuItem" href="<?php echo Url::to(['merchant-order/index']) ?>" data-index="1">商品订单</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['merchant-order/comment']) ?>" data-index="1">评论管理</a></li>
                        </ul>
                    </li>


                    <li class="show">
                        <a href="javascript:;">
                            <i class="glyphicon glyphicon-calendar"></i>
                            <span style="color: #92B8B1" class="nav-label">商品库</span>
                            <span class="label label-info pull-right">商品：<?php \merchant\models\Goods::return_goods()?></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-goods/list']) ?>" data-index="1">商品列表</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-goods/create']) ?>" data-index="1">商品添加</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-cate/list']) ?>" data-index="1">商品类型</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-goods/recycle']) ?>" data-index="1">回收站</a>
                            </li>
                        </ul>
                    </li>


                    <li class="show">
                        <a href="javascript:;">
                            <i class="glyphicon glyphicon-list-alt"></i>
                            <span class="nav-label">库存管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-goods/list']) ?>" data-index="1">商品入库</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-warehouse/inventory','id'=>Yii::$app->admin->getIdentity()['entrepot']])?>" data-index="1">商品列表</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-goods/goods-inventory']) ?>" data-index="1">商品库存
                                    <span class="label label-danger pull-right">库存</span>
                                </a>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-goods/list-detail']) ?>" data-index="1">出入库明细</a>


                            </li>
                        </ul>
                    </li>

                    <li class="show">
                        <a href="javascript:;">
                            <i class="glyphicon glyphicon-folder-open"></i>
                            <span class="nav-label">财务统计</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li>

                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-price/list']) ?>" data-index="1">列表</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-price/chart']) ?>" data-index="1">统计图</a>

                            </li>
                        </ul>
                    </li>


                    <li class="show">
                        <a href="javascript:;">
                            <i class="fa fa-cog fa-lg"></i>
                            <span class="nav-label">系统管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-system/entrepot']) ?>" data-index="1">仓库管理</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['merchant-system/account']) ?>" data-index="1">账号管理</a>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
            <div class="slimScrollBar"
                 style="width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 920px; background: rgb(0, 0, 0);"></div>
            <div class="slimScrollRail"
                 style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.9; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right" style="margin-top: 10px;">
                    <li class="hidden-xs">
                        <a href='<?php echo Url::to(['merchant-index/index']) ?>'><i class="fa fa-home"></i>首页</a>
                    </li>
<!--                    <li class="hidden-xs">-->
<!--                        <a id="cache" class="right-sidebar-toggle" aria-expanded="false"><i class="fa fa-rocket"></i>清理缓存</a>-->
<!--                    </li>-->
                    <li><a href='<?php echo Url::to(['merchant-admin/logout']) ?>'><i class="fa fa fa-sign-out"></i> 退出</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%"
                    src='<?php echo Url::to(["merchant-index/home"]) ?>' frameborder="0" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right"></div>
        </div>
    </div>
    <!--右侧部分结束-->
</div>
</body>
<?php
$js = <<<JS
    if (window.top !== window.self) {
        window.top.location = window.location;
    }
        $("#cache").on("click", function () {
        $.ajax({
            type: "post",
            url: "/clear/backend",
            data: {
                '_csrf-backend': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                console.log(data);
                if (data.status === 1) {
                    var s = dialog({content: data.info}).showModal();
                    setTimeout(function () {
                        s.close();
                    }, 800);
                } else {
                    var e = dialog({title: "提示", content: data.info, ok: true}).showModal();
                    setTimeout(function () {
                        e.close();
                    }, 800);
                }
            }
        });
    });
JS;
$this->registerJs($js);
?>
