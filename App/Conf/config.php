<?php
define('URL_CALLBACK', 'http://www.xiaojiaqian.com/index.php?m=Login&a=callback&type=');
return array (
  'load_ext_config' => 
  array (
    'home' => 'home',
  ),
  'active_plugin' => '',
  'official_website' => 'http://data.jdcms.com/',
  'cms_name' => '简单CMS',
  'cms_domain' => 'http://127.0.0.1/xiaojiaqian/',
  'cms_versions' => 'V1.3',
  'web_path' => '/xiaojiaqian/',
  'db_host' => 'localhost',
  'db_port' => '3306',
  'db_user' => 'root',
  'db_pwd' => '',
  'db_name' => 'xiaojiaqian',
  'db_prefix' => 'xjq_',
  'site_name' => '简单CMS',
  'site_domain' => 'http://127.0.0.1/xiaojiaqian/',
  'site_title' => '简单CMS_全球最大的中国女性购物社区，分享网购乐趣，发现潮流精品。',
  'site_keyword' => '购物，交友，分享社区。',
  'site_description' => '简单CMS官方网站，全球最大的中的女性购物社区，上千万女性会员一起发现时尚至IN的扮美单品，交流最新最热的时尚穿搭，分享在各大购物网站的网购经验。',
  'default_kw' => '宝贝、专辑...',
  'site_icp' => '',
  'statistics_code' => '<script src="http://s13.cnzz.com/stat.php?id=4511326&web_id=4511326&show=pic" language="JavaScript"></script>',
  'record' => 'copyright ©2012 All Rights Reserved.',
  'site_status' => '1',
  'comments_status' => '0',
  'items_status' => '0',
  'album_status' => '0',
  'down_status' => '0',
  'article_show' => '0',
  'tmpl_action_error' => './App/Tpl/Admin/jump.html',
  'tmpl_action_success' => './App/Tpl/Admin/jump.html',
  'sina_appkey' => '662835029',
  'sina_appsecret' => 'e3b92626b30b1a58795daf312e21df31',
  'taobao_appkey' => '21108506',
  'taobao_appsecret' => '5f29c86c15cf8e79c095c01416574a89',
  'taobaoke_nick' => '',
  'taobaoke_pid' => '33618674',
  'qq_appkey' => '100321020',
  'qq_appsecret' => 'efc7939403fdda2dca7a7b5d5b198bcc',
  'paipaike_pid' => '',
  'follow_us' => '<a href=\'http://weibo.com/jdcms\'>新浪微博</a>',
  'follow_us2' => '',
  'follow_us3' => '',
  'follow_us4' => '',
  'follow_us5' => '',
  'follow_us6' => '',
  'new_visit' => '1',
  'push_request' => '{"cate":"\\u8863\\u670d-1-1 \\u978b\\u5b50-2-1 \\u5305\\u5305-3-1 \\u914d\\u9970-4-1 \\u7f8e\\u5986-5-1 \\u5bb6\\u5c45-6-1","cps":"0","price":"0","nums":"100","auto_push":"1"}',
  'spread_status' => '0',
  'spread_position' => '1',
  'filter' => '走私,混蛋',
  'login_key' => 'ca1d13a25043c4d7dbe2f389aa6381bd',
  //腾讯QQ登录配置
  'THINK_SDK_QQ' => array(
    'APP_KEY'    => '100495724', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '8a23d856fe2dab2699027c7ad8424c16', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'qq',
  ),
  //腾讯微博配置
  'THINK_SDK_TENCENT' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'tencent',
  ),
  //新浪微博配置
  'THINK_SDK_SINA' => array(
    'APP_KEY'    => '3594894371', //应用注册成功后分配的 APP ID
    'APP_SECRET' => 'a68616542eb78e05ad2f88e2483d1eb5', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'sina',
  ),
  //网易微博配置
  'THINK_SDK_T163' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 't163',
  ),
  //人人网配置
  'THINK_SDK_RENREN' => array(
    'APP_KEY'    => '5e4ab91c2a6e458a944362a717171ecb', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '572c9d0ce18942389e2aaacbfbf32355', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'renren',
  ),
  //360配置
  'THINK_SDK_X360' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'x360',
  ),
  //豆瓣配置
  'THINK_SDK_DOUBAN' => array(
    'APP_KEY'    => '0d02c2bbce55cdd3270848336b016979', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '0cfba46950761311', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'douban',
  ),
  //Github配置
  'THINK_SDK_GITHUB' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'github',
  ),
  //Google配置
  'THINK_SDK_GOOGLE' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'google',
  ),
  //MSN配置
  'THINK_SDK_MSN' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'msn',
  ),
  //点点配置
  'THINK_SDK_DIANDIAN' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'diandian',
  ),
  //淘宝网配置
  'THINK_SDK_TAOBAO' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'taobao',
  ),
  //百度配置
  'THINK_SDK_BAIDU' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'baidu',
  ),
  //开心网配置
  'THINK_SDK_KAIXIN' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'kaixin',
  ),
  //搜狐微博配置
  'THINK_SDK_SOHU' => array(
    'APP_KEY'    => '', //应用注册成功后分配的 APP ID
    'APP_SECRET' => '', //应用注册成功后分配的KEY
    'CALLBACK'   => URL_CALLBACK . 'sohu',
  ),
);
?>