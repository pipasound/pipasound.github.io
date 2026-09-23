# Zotero + ZCode 配置说明与使用教程

> 配置日期：2026-09-22 ｜ 适用：Windows + Zotero 10.0.3 + ZCode

## 一、这次装了什么

### Zotero 侧（2 个新插件，需重启 Zotero 生效）

| 插件 | 用途 | 官网 |
|---|---|---|
| **Better BibTeX** v9.0.64 | 学术写作核心插件：为每条文献生成稳定的引用键（`@key`），支持 LaTeX/BibTeX 导出、Word 快速引用、一键生成参考文献列表 | github.com/retorquere/zotero-better-bibtex |
| **茉莉花 Jasminum** v1.1.39 | 中文文献神器：知网（CNKI）元数据抓取、学位论文 PDF 重命名、中文作者姓名拆分 | github.com/l0o0/jasminum |

两个安装包都是通过国内镜像下载的，且 SHA-256 与 GitHub 官方摘要逐字节一致（可核验）。

你原本已装的 3 个插件（未动）：**Zotero Addons**（插件市场）、**ZoteroGPT**（AI 对话）、**ZoteroPDFTranslate**（PDF 翻译）。

### ZCode 侧

| 组件 | 用途 |
|---|---|
| **zotero-cli** 工具 + 配套技能 | 让我（AI 助手）能直接搜索、读取、批注、导出你的 Zotero 文献库，写综述时不用你手动复制粘贴文献清单 |
| 可选 MCP 服务器（默认关闭） | 在「设置 → MCP → zotero」里可一键启用；默认关闭是为了省 token（其工具定义每个请求约吃 1.4 万 token），日常用上面的技能路线更划算 |
| awesome-literature-review 技能 | 上一步已装了的中文文献综述流程 skill，专门配合 Zotero 使用 |
| document-skills 文档技能 | docx / xlsx / pdf 输出能力（综述 Word 版、文献清单 Excel 导出） |

## 二、需要你动手的 3 步

1. **重启 Zotero**（完全退出再打开）。启动后在「工具 → 插件」里应能看到：
   - Better BibTeX for Zotero 9.0.64
   - Jasminum 1.1.39
   如果没有自动出现，在插件窗口点齿轮 → 「Install Plugin From File…」→ 选择下面这两个文件之一手动安装：
   - `C:\Users\Lenovo\.zcode\cli\artifacts\zotero-plugins\better-bibtex.xpi`
   - `C:\Users\Lenovo\.zcode\cli\artifacts\zotero-plugins\jasminum.xpi`

2. **重启 ZCode**（托盘右键退出 → 重开）。新会话里「/」菜单的 Skills 组会出现 `zotero-cli`；不出现也不影响，直接说「查一下我的 Zotero 文献库」我就会主动用它。

3. **（可选，推荐）开启 Zotero 本地通信**：Zotero → 设置 → 高级 → 勾选「允许本机其他应用与 Zotero 通信」。这样 zotero-cli 除了能读，还能帮你往里写（添加文献、打标签、建立笔记），配合第一次写操作时弹出的授权窗口点「Always Allow」。

## 三、Zotero 日常用法（配合新插件）

### Better BibTeX —— 引用键与参考文献

- **引用键**：安装后每条文献自动有稳定的引用键（默认格式 `作者姓氏 + 年份 + 词`，如 `mattar2025space`）。
- **复制引用键**：在文献上右键 → Better BibTeX → 复制引用键（`@mattar2025space`）。
- **导出 BibTeX**：右键 → 导出文献 → 格式选 `Better BibTeX`（或 `Better BibTeX CSL JSON`）→ 直接得到 .bib 文件，LaTeX 里 `\cite{mattar2025space}` 即用。
- **Word 引用**：安装 LibreOffice 的引用插件后（工具 → 插件 → Better BibTeX → 安装 Zotero LibreOffice 插件），Word 里插入引用、文末自动生成参考文献列表。
- **推荐设置**（Better BibTeX 偏好 → 导出）：引用键格式建议 `[auth:lower][year]` 或保持默认；勾选「每次导出自动更新」。

### 茉莉花 Jasminum —— 知网中文文献

- 在知网选中文献 → 点浏览器插件（Zotero Connector）→ 自动抓取标题、作者、期刊、摘要到 Zotero。
- 茉莉花会自动把中文作者姓与名分拆正确、为学位论文 PDF 补充元数据（把 PDF 拖进对应条目即可）。
- 抓不到的字段（如部分库的页码）可手动补，正文引用时以 Zotero 里保存的信息为准。

## 四、写综述时怎么让 ZCode 用上你的文献库

直接说人话，例如：

- 「帮我写一篇关于 XXX 的文献综述，**文献从我的 Zotero 里拉**，先列清单给我核验」
- 「搜一下我 Zotero 里 2023 年以后有关 XXX 的文献」
- 「把 Zotero 里这几篇的 BibTeX 导出来」

我会用 zotero-cli 实时查你的库，把条目（标题/作者/年份/DOI/摘要）做成清单给你确认，再按 awesome-literature-review 的流程一次性成稿。文献真实性和证据分级（A/B 级）都会按 skill 的规则执行。

典型工作流：

1. Zotero 里用 Connector 把知网/Web of Science 的文献收进库（三十篇左右，中英各半）。
2. 打开 ZCode 新会话 → 「帮我写 X 的文献综述，文献用我 Zotero 里的」，我先拉清单。
3. 你核验/删改清单 → 我写正文（研究背景与目的 → 文献梳理 → 现状评述 → 参考文献）。
4. 要 Word 版就说「输出成 Word」，要 LaTeX 就说「输出 LaTeX + 用 Better BibTeX 的引用键」。

## 五、可选：打开 Zotero MCP 通道

如果哪天你希望**每个会话都常驻** Zotero 工具（而不是按需调用）：
「设置 → MCP → zotero → 启用」→ 重启会话即可。代价是每个请求都会多带约 1.4 万 token 的工具定义，一般没必要。

## 六、安全提醒

- `config.json` 与 Zotero 的 `prefs.js` 里存有明文 API Key（含您 PDF 翻译插件里配置的 ChatGPT Key）。请勿把这两份文件发给别人。
- 曾在本聊天中完整出现过的中转站 Key（小白、硅基流动、Earth-api），建议在各自后台重置。

## 七、回滚

- Zotero 插件：删除 `C:\Users\Lenovo\AppData\Roaming\Zotero\Zotero\Profiles\k1u9j5fu.default\extensions\` 下 `better-bibtex@iris-advies.com.xpi` 与 `jasminum@linxzh.com.xpi`。
- ZCode MCP：编辑 `C:\Users\Lenovo\.zcode\cli\config.json`，删除 `mcp` 段。
- zotero-cli：`pip uninstall zotero-mcp-server`，删除 `C:\Users\Lenovo\.zcode\skills\zotero-cli`。
