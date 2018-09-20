<?php

class Config
{
    public $enableProdMode=false;
    public $offline = false;
    public $offlineMessage = 'This site is down for maintenance.<br />Please check back again soon.';
    public $displayOfflineMessage = true;
    public $offline_image = '';
    public $sitename = 'airCore';
    public $captcha = '0';
    public $list_limit = '20';
    public $access = '1';
    public $debug = '0';
    public $debug_lang = '0';

    public $live_site = 'http://127.0.0.1/framework/';
    public $cdn = '';
    public $secret = 'Pi1gS3vrtWvNq3O0';

    public $airJax = 1;
    public $cors = ['127.0.0.1'];
}
