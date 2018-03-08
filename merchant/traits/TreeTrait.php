<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/17
 * Time: 9:46
 */
namespace merchant\traits;
trait TreeTrait{

    public static function generateTree($data, $pid = 0)
    {
        $tree = [];
        if ($data && is_array($data)) {
            foreach ($data as $v) {
                if ($v['pid'] == $pid) {
                    $tree[] = [
                        'id' => $v['id'],
                        'name' => $v['name'],
                        'pid' => $v['pid'],
                        'sort' => $v['sort'],
                        'is_show' => $v['is_show'],
                        'children' => self::generateTree($data, $v['id']),
                    ];
                }
            }
        }
        return $tree;
    }
}