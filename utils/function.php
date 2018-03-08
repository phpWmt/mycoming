<?php

use backend\models\User;

//系统推送
//参数：$user_id：用户id $str：内容  $title :标题
function tuisong($user_id,$title,$str,$type){

    $device = User::find()->where(['id'=>$user_id])->asArray()->one();

    if(!empty($device) && $device['device_num']){

                $base64 = base64_encode("ad42b2f571c733d6997d1f2a:9c879e9e3c7d51e5d905fbca");

                $header = array("Authorization:Basic $base64", "Content-Type:application/json");

                $param = '{"platform":"all",

                                "audience":{

                                  "registration_id" : ["' . $device['device_num'] . '"]

                                },

                                "notification" : {

                                   "android" : {

                                         "alert" : "'.$str.'",

                                         "title" : "'.$title.'",

                                         "builder_id" : 3,

                                         "extras" : {

                                           "type" : "'.$type.'",

                                           "skip_id" : "'.$type.'"

                                         }

                                   },

                                   "ios": {

                                        "alert": "'.$str.'",

                                        "sound": "default",

                                        "badge": "0",

                                        "extras": {

                                          "type" : "'.$type.'",

                                          "skip_id" : "'.$type.'"

                                          }

                                     }

                                   }

                                }';


                $url = 'https://api.jpush.cn/v3/push';

                $res = request_post($url, $param, $header);

                $res_arr = json_decode($res, true);

                return $res_arr;
    }


}





//订单推送
//参数：$user_id：用户id $str：内容  $title :标题
function push($user_id,$order_id,$title,$str,$type){

    $device = User::find()->where(['id'=>$user_id])->asArray()->one();

    $datetime = new \DateTime;

    if(!empty($device) && $device['device_num']){


        $base64 = base64_encode("ad42b2f571c733d6997d1f2a:9c879e9e3c7d51e5d905fbca");

        $header = array("Authorization:Basic $base64", "Content-Type:application/json");

        $param = '{"platform":"all",

                                "audience":{

                                  "registration_id" : ["' . $device['device_num'] . '"]

                                },

                                "notification" : {

                                   "android" : {

                                         "alert" : "'.$str.'",

                                         "title" : "'.$title.'",

                                         "builder_id" : 3,

                                         "extras" : {

                                           "type" : "'.$type.'",

                                           "skip_id" : "'.$type.'"

                                         }

                                   },

                                   "ios": {

                                        "alert": "'.$str.'",

                                        "sound": "default",

                                        "badge": "0",

                                        "extras": {

                                          "type" : "'.$type.'",

                                          "skip_id" : "'.$type.'"

                                          }

                                     }

                                   }

                                }';


        $url = 'https://api.jpush.cn/v3/push';

        $res = request_post($url, $param, $header);

        $res_arr = json_decode($res, true);



        //添加系统消息
        Yii::$app->db->createCommand()->insert('dyd_message', [

            'user_id' => $user_id,

            'order_id' => $order_id,

            'type'=>1,

            'title' => "'.$title.'",

            'info' => $str,

            'read' => 0,

            'status' => 1,

            'addTime' => $datetime->format('Y-m-d H:i:s'),

        ])->execute();


        return $res_arr;

    }


}

//CURL
function request_post($url = "", $param = "", $header = "")
{

    if (empty($url) || empty($param)) {

        return false;

    }

    $postUrl = $url;

    $curlPost = $param;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $postUrl);

    curl_setopt($ch, CURLOPT_HEADER, 0);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $data = curl_exec($ch);

    curl_close($ch);

    return $data;

}