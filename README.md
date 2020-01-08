laravel Multi Language
======

## 安装

```
composer require deepcode-tech/laravel-multi-language
```
## 发布配置文件
```
php artisan vendor:publish --provider="Deepcode\MultiLanguage\MultiLanguageServiceProvider"

```

## 配置
需要调用中间件 `lang:xxx`,`xxx`对应该`config/lang.php`中每类配置

In `config/lang.php`

```
    [
        'enable'=>true,
        'defautl' => [
            'enable' => true,
             //cookie path
            'path'  => '/',
            // the key should be same as var locale in config/app.php
            // the value is used to show
            'languages' => [
                'en' => 'English',
                'zh-CN' => '简体中文',
            ],
            // default locale
            'default' => 'zh-CN',
        ],
    ],
```

### 在laravel-admin中的配置

Then, add except route to auth

In `config/admin.php`, add `locale` to `auth.excepts`

```
    'auth' => [
        ...
        // The URIs that should be excluded from authorization.
        'excepts' => [
            'auth/login',
            'auth/logout',
            // add this line !
            'locale',
        ],
    ],

```

In `laravel-admin/bootstrap.php`, 添加语言切换菜单:
```
Encore\Admin\Facades\Admin::navbar()->add(new LanguageMenu());
```
登陆界面添加语言选择下拉

复制当前包中 `views/login.blade.php` 到 `resources/views/vendor/admin/` 中


## ScreenShots

![login](https://user-images.githubusercontent.com/20313390/60640921-ff109480-9e5b-11e9-8ec8-aee897a8bdcb.jpg)
![login1](https://user-images.githubusercontent.com/20313390/60640924-0041c180-9e5c-11e9-8a2d-539d6214d069.jpg)
![language](https://user-images.githubusercontent.com/20313390/60640919-fc15a400-9e5b-11e9-962d-175fb2f24da1.jpg)
