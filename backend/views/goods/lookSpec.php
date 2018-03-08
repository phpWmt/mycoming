<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品列表</h3>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" width="6%">
                                    <label class="checkbox-inline i-checks">
                                        <input type="checkbox" class="all-checks">
                                    </label>
                                </th>
                                <th class="text-center"><b>商品名称</b></th>
                                <th class="text-center"><b>商品分类</b></th>
                                <th class="text-center"><b>商品品牌</b></th>
                            </tr>
                            </thead>
                            <tbody>
                                    <?php echo \backend\models\Goods::return_spec($spec)?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>