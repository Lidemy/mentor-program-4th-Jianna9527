# 教你朋友 CLI
## Command Line 是什麼？
~~就是一個畫面黑黑的，可以用來對電腦下指令的東西啦！~~
Command Line 通常被稱為 **命令行** 或 **命令行介面（Command Line Interface，CLI）**，相較於圖形使用者介面（Graphical User Interface，GUI），這是一個以文字為主的應用程式，可以單純使用文字指令來對電腦進行操作。
## Command Line 怎麼用？
首先要打開 Command Line。
因為每個作業系統的語法多少會有些差異，因此如果作業系統是 Windows，建議下載 [Git 的應用程式](https://git-scm.com/)，打開 git-bash 輸入指令就能操作電腦了。若使用的是蘋果相關產品，則可以使用內建的 terminal。

h0w 哥我麻吉，我知道他很懶，所以這裡教他一些基本語法就好。
| 指令 | 作用 | 完整名稱 | 用法 |
| -------- | -------- | -------- | -------- |
| pwd | 印出目前所在位置 | print working directory |  |
| cd | 切換資料夾 | change directory | `cd 同層其它資料夾名稱` / `cd 絕對路徑` / `cd ..` 回到上一層 / `cd /` 移動到根目錄 |
| ls | 列出現在位置所有檔案 | list | `ls -a` 列出隱藏檔案 / `ls -l` 列出詳細資訊 / `ls -al` 列出所有檔案包括詳細資訊 |
| touch | 建立 / 修改檔案 |  | 檔案不存在則建立檔案；檔案存在則更改最後修改時間 |
| rm    | 刪除 | remove | `rm -r` 刪除資料夾 / `rm -f` 強制刪除 |
| rmdir | 刪除資料夾 |  | 僅能刪除空資料夾 |
| mkdir | 建立資料夾 | make directory |  |
| mv | 移動檔案或改名 | move | `mv 檔名 路徑位置` / `mv 原檔名 新檔名` |
## 建立 wifi 資料夾，並在裡面建立 afu.js 檔案
1. 首先，可以先用 `pwd` 來確認現在的所在位置，是否是你想要建立wifi 資料夾的位置。（為什麼有種繞口令的感覺）
2. 承上，是的話請跳 3 ；不是的話，請用 `cd` 切換到你想建立資料夾的地方。
3. 輸入 `mkdir wifi` 建立 wifi 資料夾。可以用 `ls` 查看檔案列表，來檢查是否建立成功。
4. 因為要在 wifi 資料夾內建立檔案，因此我們需要先透過 `cd wifi` 將所在位置移到 wifi 資料夾。
5. 切換位置後，輸入 `touch afu.js` 指令，就成功建立檔案啦！