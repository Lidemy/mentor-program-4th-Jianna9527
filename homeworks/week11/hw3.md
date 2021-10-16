## 請說明雜湊跟加密的差別在哪裡，為什麼密碼要雜湊過後才存入資料庫
### 雜湊
* 雜湊無論原文長短，輸出後都會是固定的長度，輸出長度不受原文長度影響
* 雜湊是單向的，無法從輸出推斷出原文
* 不同的原文可能產出相同的雜湊值（雜湊碰撞），但機率極低
* 可能會被暴力破解法、彩虹表查表法破解
### 加密
* 過程透過加密、解密演算法處理，並使用金鑰進行加密、解密
* 一旦金鑰被盜取，便可以破解原文
* 非對稱式加密（透過公鑰加密內容，私鑰解密）可增強安全性

因為密碼屬於高安全性且僅需個人知道即可，因此不需要具有可逆性，最適合使用雜湊。
若密碼沒有經過雜湊變存入資料庫，即為明碼儲存，一旦被駭客盜取就可以成功駭入使用者的帳戶。如果該使用者在各大網站都使用相同的密碼進行登入，將可以一次盜取多個平台的帳戶。

![](https://obs.line-scdn.net/0hWhry46ouCEdPAB5C-lF3EHVWCyh8bBtEKzZZRAxuVnBjN0xCemdAdG5VV3BrNk8ZJmdAIm0HE3Y3OBtEJzFA/w1200)
[圖片來源：BluesBear 星座小熊](https://today.line.me/tw/v2/article/Q5kGYV)

## `include`、`require`、`include_once`、`require_once` 的差別
include 和 require 都可以在 server 執行當前文件之前，將其他 php 檔案引入。
不同之處在於發生錯誤時，使用 require 會跳 error，且終止程式；而 include 僅會發出 warning，且繼續執行。

而 include_once 與 include 功能相同，差別在於 include_once 會先檢查是否已引入過指定的檔案，若有則不會再重複引入。
require_once 與 require 亦同。

## 請說明 SQL Injection 的攻擊原理以及防範方法
SQL Injection 也時常被稱為駭客的填字遊戲，意即透過任何能讓使用者在網頁上進行輸入的地方（包括任何輸入框，甚至是使用 get 方法在網址後面帶的參數）填入適合的程式碼，造成原程式碼執行時遭到竄改，進而執行植入的程式碼。若原程式剛好有操作資料庫的行為，一旦被植入的程式執行後，將會對資料庫進行非預期的操作，攻擊者便可透過此方法取得、竄改、刪除資料庫內容。

在撰寫程式時，應完全使用參數化查詢（Parameterized Query）的方式來進行資料庫的操作，處理字串時也應檢查是否有特殊字元、跳脫字元等。

##  請說明 XSS 的攻擊原理以及防範方法
XSS（Cross Site Scripting）即透過網頁漏洞，將程式碼注入網頁中。常見的方法也是透過任何能讓使用者在網頁上進行輸入的地方，將程式碼當作字串存入目標網站資料庫，一旦資料庫的內容顯示在頁面上，就會直接執行該程式。再者，也能透過 url 參數（或 img element 的 src）執行其他惡意程式，或將使用者導向惡意網站。

在設計網頁程式時，應注意對任何輸入值、導出值進行特殊字元的檢查，此外也能指定 HTTP Header 的解析方式與編碼，以免內容被非預期的方式解析。

## 請說明 CSRF 的攻擊原理以及防範方法
CSRF（Cross-site request forgery）藉由跨站的方式，讓使用者在不知不覺中將自己瀏覽器中的 cookie 導向其他網站進行操作。比如使用者在 A 網站尚未登出，而在使用 B 網站時，經由惡意程式讓瀏覽器對 A 網站發出 request，並依據瀏覽器帶上相同 domain cookie 的特性，A 網站 server 將會判斷使用者為本人且為登入狀態，使駭客能輕易的藉由惡意程式偽造自己的身份在 A 網站進行操作。

最簡單的預防方式就是使用者在每次使用後都記得登出，不過這樣實在是太不方便了，所以在 server 端進行防範才是最佳的方式。
* **檢查request header referer，確認 request 是否從合法 domain 發出**
難以完全防範、request 不一定會帶 referer
* **使用圖形驗證碼、簡訊驗證碼**
* **使用 CSRF token**
由 server 隨機產生並儲存於 session 中，每當接受 request 便檢查 client 端的 CSRF token 是否與 server 端相同
* **Double Submit Cookie**
server 檢查 cookie 內的 CSRF token 與 form 裡面的 CSRF token 是否有值且相等，但可能透過 subdomain 破解。
* **SameSite cookie（Google 已有）**