# 交作業流程
## 交作業
1. 首次需要先把建立好的 Github 第四期專案 clone 至本地端
```
git clone https://github.com/Lidemy/mentor-program-4th-Jianna9527.git
```
2. 新開一個 branch 並切換過去
```
git checkout -b week1
```
3. 將寫完的作業 commit（如有新檔案記得`git add`）
```
git commit -am 'message'
```
4. 接著將本地端檔案 push 上 Github
```
git push origin week1
```
5. 到 Github 上選擇 **Pull requests**、對出現的提示點擊 **Compare & pull requests**
如果沒有自動出現提示，點擊 new pull request 並選擇 branch。
6. 將 week1 merge 到 master
下方可以確認改動的內容，確認作業都有成功 push 上來後，點擊 Create pull request。
7. 到學習系統上新增作業，選擇週次並貼上 **Pull requests** 連結


## 助教改完作業後
1. 兩端同步：本地端切到 master，將遠端資料 pull 下來
```
git checkout master
git pull origin master
```
2. 把本地的 brnch 刪除
```
git branch -d week1
```
## 其他：與老師 master 同步
1. 確認自己本地端檔案都已 commit
2. 切換到 master 的 branch
3. 將老師的 master pull 下來，再 push 回自己的遠端 master
```
git pull https://github.com/Lidemy/mentor-program-4th.git master
git push origin master
```