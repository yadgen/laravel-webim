<?php

if (! function_exists('hello')) {
    function hello()
    {
        $strTimeToString = "000111222334455556666667";
        $strWenhou = array('夜深了，', '凌晨了，', '早上好！', '上午好！', '中午好！', '下午好！', '晚上好！', '夜深了，');
        echo $strWenhou[(int)$strTimeToString[(int)date('G',time())]];
    }
}