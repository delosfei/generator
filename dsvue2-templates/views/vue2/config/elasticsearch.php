<?php
return [
    //是否开启ES
    'enable' => true,

    //主机
    'hosts' => explode(',', env('ES_HOSTS'))
];
