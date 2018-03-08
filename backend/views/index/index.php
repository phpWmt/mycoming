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

                                <span class="text-muted text-xs block">
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
                            <i class="glyphicon glyphicon-off"></i>
                            <span class="nav-label">权限管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li><a class="J_menuItem" href="<?php echo Url::to(['admin/list']) ?>" data-index="0">管理员列表</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['admin/index']) ?>" data-index="0">添加管理员</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['rbac/roles-index']) ?>" data-index="1">角色列表</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['rbac/index']) ?>" data-index="2">权限列表</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-user fa-lg"></i>
                            <span class="nav-label">客户管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li><a class="J_menuItem" href="<?php echo Url::to(['user/list']) ?>" data-index="0">客户列表</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['user/feedback']) ?>" data-index="0">意见反馈</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['user/list-delete']) ?>" data-index="0">回收站</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="javascript:;">
                            <i class="glyphicon glyphicon-folder-close"></i>
                            <span class="nav-label">优惠卷</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li><a class="J_menuItem" href="<?php echo Url::to(['coupon/add']) ?>" data-index="0">添加优惠卷</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['coupon/list']) ?>" data-index="0">优惠卷列表</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['coupon/chart']) ?>" data-index="0">优惠卷统计</a></li>
                        </ul>
                    </li>


                    <li class="show">
                        <a href="javascript:;">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            <span class="nav-label">订单管理</span>
                            <span class="label label-success pull-right">待发货：<?php \backend\models\Order::return_goods()?></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li><a class="J_menuItem" href="<?php echo Url::to(['order/index']) ?>" data-index="1">商品订单</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['order/comment']) ?>" data-index="1">订单评论</a></li>
                        </ul>
                    </li>

                    <li class="show">
                        <a href="javascript:;">
                            <i class="glyphicon glyphicon-home"></i>
                            <span class="nav-label">仓库管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li>
                                <a class="J_menuItem" href="<?php echo Url::to(['warehouse/index']) ?>" data-index="1">仓库列表</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['warehouse/add']) ?>" data-index="1">仓库添加</a>
                            </li>
                        </ul>
                    </li>


                    <li class="show">
                        <a href="javascript:;">
                            <i class="glyphicon glyphicon-calendar"></i>
                            <span style="color: #92B8B1" class="nav-label">商品库</span>
                            <span class="label label-info pull-right">商品：<?php \backend\models\Goods::return_goods()?></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li>
                                <a class="J_menuItem" href="<?php echo Url::to(['goods/list']) ?>" data-index="1">商品列表</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['goods/create']) ?>" data-index="1">商品添加</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['cate/list']) ?>" data-index="1">商品类型</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['goods/recycle']) ?>" data-index="1">回收站</a>
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
                                <a class="J_menuItem" href="<?php echo Url::to(['goods/list']) ?>" data-index="1">商品入库</a>

                                <a class="J_menuItem" href="<?php echo Url::to(['cate/godown-type']) ?>" data-index="1">库存类型</a>
                                <a class="J_menuItem" href="<?php echo Url::to(['goods/goods-inventory']) ?>" data-index="1">商品库存
                                    <span class="label label-danger pull-right">库存</span>
                                </a>
                                <a class="J_menuItem" href="<?php echo Url::to(['goods/list-detail']) ?>" data-index="1">出入库明细</a>


                            </li>
                        </ul>
                    </li>


                    <li class="show">
                        <a href="javascript:;">
                            <i class="glyphicon glyphicon-tasks"></i>
                            <span class="nav-label">物流管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li><a class="J_menuItem" href="<?php echo Url::to(['order/courier']) ?>" data-index="1">物流公司</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-edit fa-lg"></i>
                            <span class="nav-label">文章管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li><a class="J_menuItem" href="<?php echo Url::to(['article/list']) ?>" data-index="0">文章列表</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['article/create']) ?>" data-index="0">文章添加</a></li>
                            <li><a class="J_menuItem" target="_blank" href="<?php echo Url::to(['article/content']) ?>" data-index="0">文章预览</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;">
                            <i class="fa fa-cog fa-lg"></i>
                            <span class="nav-label">系统管理</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
<!--                            <li><a class="J_menuItem" href="--><?php //echo Url::to(['operation/setting']) ?><!--" data-index="0">站点设置</a></li>-->
                            <li><a class="J_menuItem" href="<?php echo Url::to(['operation/pay']) ?>" data-index="0">开发设置</a></li>
                            <li><a class="J_menuItem" href="<?php echo Url::to(['seo/index']) ?>" data-index="0">SEO设置</a>
                            </li>


                            <li>
                                <a href="javascript:;">
                                    <i class="fa fa-file-text fa-lg"></i>
                                    <span class="nav-label">日志管理</span>
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="nav nav-second-level collapse">
                                    <li><a class="J_menuItem" href="<?php echo Url::to(['log/list']) ?>" data-index="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日志列表</a></li>
                                </ul>
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
                        <a style="color: #0a6aa1" target="_blank" href='<?php echo Url::to(['merchant/']) ?>'><i class="glyphicon glyphicon-home"></i>仓库端</a>
                    </li>
                    <li class="hidden-xs">
                        <a href='<?php echo Url::to(['index/index']) ?>'><i class="fa fa-home"></i>首页</a>
                    </li>
                    <li class="hidden-xs">
                        <a id="cache" class="right-sidebar-toggle" aria-expanded="false"><i class="fa fa-rocket"></i>
                            清理缓存</a>
                    </li>
                    <li><a href='<?php echo Url::to(['admin/logout']) ?>'><i class="fa fa fa-sign-out"></i> 退出</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%"
                    src='<?php echo Url::to(["index/home"]) ?>' frameborder="0" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">
            </div>
        </div>
    </div>
    <!--右侧部分结束-->
<!--    <div class="gohome" style="padding: 200px"><a class="animated bounceInUp" href="--><?php //echo Url::to(['index/index']) ?><!--" title="返回首页"><i class="fa fa-home"></i></a></div>-->
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
