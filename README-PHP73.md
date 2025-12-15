# PHP 7.3 兼容性说明

## 版本要求
- **PHP版本**: >= 7.3.0
- **无需Composer**: 本项目已包含简单模板引擎，无需安装外部依赖

## 使用说明

### 1. 直接运行
本项目已包含所有必需的文件，可以直接在 PHP 7.3+ 环境中运行：

```bash
# 直接访问
http://your-domain/

# 后台管理
http://your-domain/admin/
```

### 2. 登录信息
- **用户名**: admin
- **密码**: password

### 3. 调试模式
支持调试访问模式：
```
http://your-domain/index.php?domain=wordly-game.com&lang=en
```

## 技术特性

### 自动回退机制
系统会自动检测是否有 Composer 依赖：
- **有vendor目录**: 使用 Twig 模板引擎
- **无vendor目录**: 使用内置简单模板引擎

### PHP 7.3 兼容特性
- ✅ 使用兼容的语法
- ✅ 避免 PHP 7.4+ 特性
- ✅ 支持 null 合并操作符 (??)
- ✅ 兼容数组语法
- ✅ 标准 PSR-4 自动加载

## 文件结构

```
/
├── index.php              # 前台入口 (兼容 PHP 7.3)
├── admin/                 # 后台管理
├── simple_template.php    # 简单模板引擎 (备用)
├── tpl/                   # 模板文件
├── i18n/                  # 语言包
├── static/                # 静态资源
└── composer.json          # Composer配置 (可选)
```

## 部署建议

### 方式一: 不使用 Composer (推荐)
直接上传所有文件到服务器即可运行。

### 方式二: 使用 Composer (可选)
如果服务器支持，可以运行：
```bash
composer install --no-dev
```

## 故障排除

### 模板错误
如果遇到模板相关错误：
1. 确保 `tpl/` 目录可读
2. 检查模板文件是否存在
3. 查看错误日志

### 权限问题
确保以下目录可写：
- `admin/data/`
- `static/`

## 性能优化
- 开启 OPcache
- 使用 Apache/Nginx 缓存静态文件
- 配置适当的 PHP 内存限制