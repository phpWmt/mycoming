<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/7
 * Time: 13:12
 */
$css=<<<CSS
.setting_logo{
    width: 50px;
    height: 40px;
}
h3 {
    color: #000;
    font-weight: 600;
}
CSS;
$this->registerCss($css);
?>
<?= \common\widgets\Alert::widget() ?>
<div class="col-sm-12">
    <div class="panel blank-panel">

        <div class="panel-heading">
            <div class="panel-title m-b-md">
                <h3><i class="fa fa-cog">　</i>开发设置</h3>
            </div>
            <div class="panel-options">

                <ul class="nav nav-tabs">
                    <li class="">
                        <a data-toggle="tab" href="#wechat" aria-expanded="false">
                            <img class="setting_logo" src="/img/svg/wechat.svg"/>微信配置
                        </a>
                    </li>

                    <li class="active">
                        <a data-toggle="tab" href="#alipay" aria-expanded="true">
                            <img class="setting_logo" src="/img/svg/alipay.svg"/>支付宝配置
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#yunzhixun" aria-expanded="false">
                            <img class="setting_logo" src="/img/svg/sms_yzx.svg"/>云之讯配置
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <!-- 微信设置页面start-->
        <div class="panel-body">
            <div class="tab-content">

                <div id="wechat" class="tab-pane">
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <h3>微信支付设置</h3>
                            <div class="ibox-content">
                                <form role="form" method="get" action="<?php echo \yii\helpers\Url::to(['operation/wechat'])?>" class="form-horizontal">
                                    <h3>APP</h3><br>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">APPID</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="AppId" class="form-control" value="<?php echo $wechat['AppId']?>">

                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">PartnerId(商户号)</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="PartnerId" class="form-control" value="<?php echo $wechat['PartnerId']?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">AppSecret(应用密钥)</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="AppSecret" class="form-control" value="<?php echo $wechat['AppSecret']?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <h3>微信公众号</h3><br>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">公众账号ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="CommonAppId" class="form-control" placeholder="微信支付分配的公众账号ID（企业号corpid即为此appId）" value="<?php echo $wechat['CommonAppId']?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Mch_ID(商户号)</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="MchId" class="form-control" placeholder="微信支付分配的商户号"  value="<?php echo $wechat['MchId']?>">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">保存内容</button>
                                            <button class="btn btn-white" type="submit">取消</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--微信页面stop-->


                <!-- 支付宝设置页面start-->
                <div id="alipay" class="tab-pane active">
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <h3>支付宝支付设置</h3>
                            <div class="ibox-content">
                                <form role="form" method="get" action="<?php echo  \yii\helpers\Url::to(['operation/alipay'])?>" class="form-horizontal">
                                    <!--PC端-->
                                    <h3>PC</h3><br>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">PID:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="Pid" value="<?php echo $alipay['Pid']?>" class="form-control" placeholder="合作者伙伴身份ID">
                                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 支付宝即时到账接口必须参数，<a target="_blank" href="https://docs.open.alipay.com/common/104739">详情移步</a></span>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">支付宝公钥:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="RsaPrivateKey" value="<?php echo $alipay['RsaPrivateKey']?>" class="form-control">
                                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 建议密钥rsa加密方式，<a target="_blank" href="https://doc.open.alipay.com/doc2/detail?treeId=58&articleId=103543&docType=1">详情移步</a></span>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <h3>APP</h3><br>
                                    <!--App配置-->

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">APP_ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="AppId" value="<?php echo $alipay['AppId']?>" class="form-control" placeholder="应用ID">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">ALIPAY_PUBLIC_KEY</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="AliPayPublicKey" value="<?php echo $alipay['AliPayPublicKey']?>" class="form-control" placeholder="支付宝公钥，由支付宝生成">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">APP_PRIVATE_KEY</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="AppPrivateKey" value="<?php echo $alipay['AppPrivateKey']?>" class="form-control" placeholder="开发者应用私钥，由开发者自己生成">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">保存内容</button>
                                            <button class="btn btn-white" type="button">取消</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 支付宝设置页面stop-->
                <!--云之讯短信配置-->
                <div id="yunzhixun" class="tab-pane">
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <h3>云之讯短信设置</h3>
                            <div class="ibox-content">
                                <form role="form" method="get" action="<?php echo \yii\helpers\Url::to(['operation/yun'])?>" class="form-horizontal">
                                    <!--PC端-->

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">AccountSid:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="AccountSid" value="<?php echo $yun['AccountSid']?>" class="form-control" placeholder="开发者账号ID">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">ToKen:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="Token" value="<?php echo $yun['Token']?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>



                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">APPID</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="AppId" value="<?php echo $yun['AppId']?>" class="form-control" placeholder="APPID">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">保存内容</button>
                                            <button class="btn btn-white" type="button">取消</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--云之讯短信配置结束-->


            </div>
        </div>

    </div>
</div>
