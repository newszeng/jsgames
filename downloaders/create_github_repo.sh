#!/bin/bash

# GitHub仓库创建和推送脚本
# 使用前请确保已经更新了您的GitHub token

echo "==================================="
echo "GitHub 仓库创建助手"
echo "==================================="

# 设置变量
REPO_NAME="youtube-downloader-admin"
GITHUB_USER="newszeng"

# 提示输入新的GitHub Token
echo "请输入您的GitHub Personal Access Token："
echo "（如果还没有创建，请访问: https://github.com/settings/tokens/new）"
echo "需要勾选 'repo' 权限"
read -s GITHUB_TOKEN
echo ""

# 检查是否输入了token
if [ -z "$GITHUB_TOKEN" ]; then
    echo "❌ 错误：Token不能为空"
    exit 1
fi

# 创建.gitignore文件
echo "📝 创建 .gitignore 文件..."
cat > .gitignore << 'EOF'
# 配置文件
config.php
database.php
.env

# 日志文件
*.log
logs/

# 临时文件
*.tmp
temp/
cache/

# 上传文件
uploads/
files/

# 系统文件
.DS_Store
Thumbs.db

# IDE文件
.idea/
.vscode/
*.swp
*.swo

# 敏感信息
*_key.php
*_secret.php
EOF

echo "✅ .gitignore 创建完成"

# 初始化Git仓库
echo ""
echo "🔧 初始化Git仓库..."
git init

# 配置Git用户信息（如果需要）
git config user.name "$GITHUB_USER"
git config user.email "${GITHUB_USER}@users.noreply.github.com"

# 添加所有文件
echo "📦 添加文件到Git..."
git add .

# 创建初始提交
echo "💾 创建初始提交..."
git commit -m "Initial commit: YouTube downloader admin panel with ChatGPT translation

Features:
- YouTube video downloader functionality
- Multi-language support (38 languages)
- ChatGPT translation integration
- Batch translation with progress tracking
- Homepage and tag page management"

# 使用API创建GitHub仓库
echo ""
echo "🌐 在GitHub上创建私有仓库..."
curl -s -H "Authorization: token $GITHUB_TOKEN" \
     -H "Accept: application/vnd.github.v3+json" \
     https://api.github.com/user/repos \
     -d "{\"name\":\"$REPO_NAME\",\"private\":true,\"description\":\"YouTube downloader admin panel with ChatGPT translation support\"}" \
     > /tmp/github_response.json

# 检查是否创建成功
if grep -q "\"full_name\"" /tmp/github_response.json; then
    echo "✅ GitHub仓库创建成功！"
else
    echo "❌ 创建仓库失败。可能是："
    echo "1. Token权限不足（需要repo权限）"
    echo "2. 仓库已存在"
    echo "3. Token无效"
    cat /tmp/github_response.json
    exit 1
fi

# 添加远程仓库
echo ""
echo "🔗 连接到远程仓库..."
git remote add origin "https://${GITHUB_TOKEN}@github.com/${GITHUB_USER}/${REPO_NAME}.git"

# 推送到GitHub
echo "🚀 推送代码到GitHub..."
git branch -M main
git push -u origin main

# 清理临时文件
rm -f /tmp/github_response.json

echo ""
echo "==================================="
echo "✅ 完成！"
echo "==================================="
echo ""
echo "您的仓库地址是: https://github.com/${GITHUB_USER}/${REPO_NAME}"
echo ""
echo "⚠️  重要提醒："
echo "1. 请妥善保管您的GitHub Token"
echo "2. 不要将Token提交到代码仓库"
echo "3. 定期更换Token以确保安全"
echo ""
echo "下次更新代码时，只需运行："
echo "git add ."
echo "git commit -m \"您的提交信息\""
echo "git push"