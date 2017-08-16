<?php

// 站点问候语
if (! function_exists('hello')) {
    function hello()
    {
        $strTimeToString = "000111222334455556666667";
        $strWenhou = array('夜深了，', '凌晨了，', '早上好！', '上午好！', '中午好！', '下午好！', '晚上好！', '夜深了，');
        echo $strWenhou[(int)$strTimeToString[(int)date('G',time())]];
    }
}

// 用户头像
if (! function_exists('user_avatar')) {
    function user_avatar()
    {
        $mt_rand = mt_rand(1, 90);
        $md5 = md5($mt_rand);
        $first_dir = substr($md5, 0, 2);
        $second_dir = substr($md5, 2, 2);
        $count = $mt_rand * 100;
        $image = mt_rand($count - 100, $count) . '_64.png';
        $user_avatar = asset('images/avatar/monsterid/' . $first_dir . '/' . $second_dir . '/' . $image);

        return $user_avatar;
    }
}

// 封装json_encode输出
if (! function_exists('json_en')) {
    function json_en($value, $options = \JSON_UNESCAPED_UNICODE, $depth = 512)
    {
        return json_encode($value, $options, $depth);
    }
}