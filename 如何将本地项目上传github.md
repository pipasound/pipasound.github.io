# 如何将本地项目上传github

# 第1步：进入项目目录

在项目文件夹空白右键 → Git Bash Here，黑色窗口就打开了。

# 第2步：初始化本地Git仓库

```
git init
```

# 第3步：把所有文件加入暂存区

```
git add .
```

# 第4步：提交到本地仓库（写备注）

```
git commit -m "初始提交，上传项目全部文件"
```

# 第5步：关联远程GitHub仓库

把下面链接替换成你刚才复制的仓库HTTPS地址，执行：

```
git remote add origin [https://github.com/你的用户名/仓库名.git](https://github.com/%E4%BD%A0%E7%9A%84%E7%94%A8%E6%88%B7%E5%90%8D/%E4%BB%93%E5%BA%93%E5%90%8D.git)
```

新建仓库，拿到远程仓库地址

你现在在GitHub主页（Dashboard）

1. 点页面右上角 + 加号图标 → 点  New repository （新建仓库）

2. 填写仓库信息：

- Repository name：仓库名字，英文，比如 pentest-lab （和你本地文件夹名字一致就行）
- Description：可以空着
- 选 Public（公开仓库）
- ❗不要勾选 Add a README file，不要勾选 .gitignore
- 点最下方绿色按钮 Create repository

3. 创建完成后，页面会出现代码块，找到 HTTPS 链接，复制它

格式类似： [https://github.com/你的用户名/pentest-lab.git](https://github.com/%E4%BD%A0%E7%9A%84%E7%94%A8%E6%88%B7%E5%90%8D/pentest-lab.git)

4. 回到Git Bash窗口，输入这条命令，粘贴你复制的链接：

```
git remote add origin [https://github.com/你的用户名/pentest-lab.git](https://github.com/%E4%BD%A0%E7%9A%84%E7%94%A8%E6%88%B7%E5%90%8D/pentest-lab.git)
```

# 第6步：把本地分支改成main（GitHub默认分支名）

```
git branch -M main
```

# 第7步：推送到GitHub远程仓库（上传！）

```
git push -u origin main
```

出现弹窗

✅ 这个弹窗是GitHub登录验证，选最简单的方式：Sign in with your browser

1. 点蓝色按钮 Sign in with your browser

2. 会自动跳浏览器打开GitHub网页

3. 在网页登录你的GitHub账号，授权这个Git程序访问仓库