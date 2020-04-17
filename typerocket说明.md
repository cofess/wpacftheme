## typerocket 核心改动
样式表改动

```
typerocket/wordpress/assets/typerocket/css/core.css
```

# Custom Resources

### Register a Resource

In your main business logic add the following code:

```
tr_resource_pages('Test')->setIcon('line-chart');
```

### 创建数据表（SQL）

```
CREATE TABLE `wp_tests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 创建模型与控制器

```
php galaxy make:model -c base Test
```

## 自定义分类

### 添加自定义分类

```
// 为自定义内容类型"book"添加自定义分类"publisher"
<?php // functions.php

$pub = tr_taxonomy(__('Publisher'), __('Publishers'));
$pub->setId('publisher');
$pub->addPostType('book');
```

### 自定义分类添加字段

如果要为自定义分类添加自定字段，需要先创建控制器和模型（基于[Galaxy CLI](https://typerocket.com/docs/v3/galaxy-cli/)） ，否则无法保存自定义字段值

```
php galaxy make:model -c term Publisher
```

温馨提示：

- Galaxy CLI需要先安装[Composer](https://getcomposer.org/)

- 分类名称必须为英文否则无法保存自定义字段，如果要实现中文，务必使用wordpress系统多语言机制

  ```
  tr_taxonomy(__('Download category','BT_TEXTDOMAIN'), __('Download categories','BT_TEXTDOMAIN'))->setId('download_category');
  ```

  ​

