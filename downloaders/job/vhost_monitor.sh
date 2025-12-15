#!/bin/bash

# vHost文件监控脚本
# 监控vhosts目录下的文件变化，如果最近5分钟有新增文件，则重启Apache服务

# 配置变量
VHOSTS_DIR="/home/wwwroot/downloaders/vhosts"
LOG_FILE="/home/wwwroot/downloaders/logs/vhost_monitor.log"
LOCK_FILE="/tmp/vhost_monitor.lock"

# 创建日志目录（如果不存在）
mkdir -p "$(dirname "$LOG_FILE")"

# 记录日志函数
log_message() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" >> "$LOG_FILE"
}

# 检查是否已有脚本在运行
if [ -f "$LOCK_FILE" ]; then
    if kill -0 $(cat "$LOCK_FILE") 2>/dev/null; then
        log_message "监控脚本已在运行，跳过此次执行"
        exit 1
    else
        # 清理无效的锁文件
        rm -f "$LOCK_FILE"
    fi
fi

# 创建锁文件
echo $$ > "$LOCK_FILE"

# 脚本退出时清理锁文件
trap 'rm -f "$LOCK_FILE"' EXIT

# 检查vhosts目录是否存在
if [ ! -d "$VHOSTS_DIR" ]; then
    log_message "错误: vhosts目录不存在: $VHOSTS_DIR"
    exit 1
fi

log_message "开始监控vhosts目录: $VHOSTS_DIR"

# 查找最近5分钟内新增的文件
# -type f: 只查找文件
# -newermt: 查找修改时间比指定时间新的文件
# 使用5分钟前的时间作为基准
FIVE_MINUTES_AGO=$(date -d '5 minutes ago' '+%Y-%m-%d %H:%M:%S')

# 查找新增文件
NEW_FILES=$(find "$VHOSTS_DIR" -type f -newermt "$FIVE_MINUTES_AGO" 2>/dev/null)

if [ -n "$NEW_FILES" ]; then
    log_message "发现最近5分钟内新增的文件:"
    echo "$NEW_FILES" | while read -r file; do
        log_message "  - $file"
    done
    
    log_message "执行Apache重启命令: lnmp httpd graceful"
    
    # 检查lnmp命令是否存在
    if command -v lnmp >/dev/null 2>&1; then
        # 执行Apache优雅重启
        if lnmp httpd graceful >> "$LOG_FILE" 2>&1; then
            log_message "Apache服务重启成功"
        else
            log_message "错误: Apache服务重启失败"
            exit 1
        fi
    else
        log_message "警告: lnmp命令不存在，尝试其他重启方式"
        
        # 备用重启方式
        if systemctl is-active apache2 >/dev/null 2>&1; then
            if systemctl reload apache2 >> "$LOG_FILE" 2>&1; then
                log_message "Apache服务通过systemctl重启成功"
            else
                log_message "错误: Apache服务通过systemctl重启失败"
            fi
        elif systemctl is-active httpd >/dev/null 2>&1; then
            if systemctl reload httpd >> "$LOG_FILE" 2>&1; then
                log_message "Apache服务通过systemctl重启成功"
            else
                log_message "错误: Apache服务通过systemctl重启失败"
            fi
        else
            log_message "错误: 无法找到可用的Apache重启方式"
        fi
    fi
else
    log_message "未发现最近5分钟内的新增文件，无需重启服务"
fi

log_message "监控脚本执行完成"