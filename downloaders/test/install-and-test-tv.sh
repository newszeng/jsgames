#!/bin/bash

echo "🚀 YouTube TV 客户端安装和测试脚本"
echo "=========================================="

# 检查 Node.js 是否安装
if ! command -v node &> /dev/null; then
    echo "❌ Node.js 未安装，请先安装 Node.js"
    exit 1
fi

echo "✅ Node.js 版本: $(node --version)"

# 检查 npm 是否安装
if ! command -v npm &> /dev/null; then
    echo "❌ npm 未安装，请先安装 npm"
    exit 1
fi

echo "✅ npm 版本: $(npm --version)"

# 初始化 package.json（如果不存在）
if [ ! -f "package.json" ]; then
    echo "📦 初始化 package.json..."
    npm init -y > /dev/null 2>&1
fi

# 安装 youtubei.js
echo "📥 安装 youtubei.js 模块..."
npm install youtubei.js

# 检查安装是否成功
if [ $? -eq 0 ]; then
    echo "✅ youtubei.js 安装成功"
else
    echo "❌ youtubei.js 安装失败"
    exit 1
fi

echo ""
echo "🧪 开始测试 TV 客户端..."
echo "=========================================="

# 运行 TV 客户端测试
node tv.js