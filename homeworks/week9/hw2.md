## 資料庫欄位型態 VARCHAR 跟 TEXT 的差別是什麼
varchar 與 text 最多都可以儲存 65535 個字符。

相較於 char 的長度固定，varchar 的長度是可變動的，可以設置最大長度；而 text 長度雖然也是可變動的，但無需設定最大長度（就算設定了也無效，字串長度超過設定值一樣可寫入）。

varchar 的查詢速度會快於 text，因此大多只有在不知道資料最大長度時才會使用 text。

## Cookie 是什麼？在 HTTP 這一層要怎麼設定 Cookie，瀏覽器又是怎麼把 Cookie 帶去 Server 的？
Cookie 是一個可以幫助瀏覽器記住狀態的東西，因為瀏覽器每一次渲染、每一次發出 request，都將是個新的開始。若我們想讓瀏覽器記住一些資料，則可以使用 cookie。

在瀏覽器與伺服器互動的過程中，伺服器透過 Set-Cookie 這個 header 來設置資訊，當瀏覽器收到這個 response 時，就會將 cookie 儲存起來，並且在發送 request 到伺服器時，一併把 cookie 的資訊發送出去。如此一來，request 之間就有了狀態，也能更便利的開啟或是建立一段 session。

既然提到 cookie 就不會漏掉 session 的實作，因此在這邊記錄一下：
>建立 Session 之後，所儲存的狀態就叫做 Session information，可以翻作 Session 資訊。若是選擇把這些資訊存在 Cookie 裡面，就叫做 Cookie-based session；還有另一種方法則是在 Cookie 裡面只存一個 SessionID，其他的 Session 資訊都存在 Server 端，靠著這個 ID 把兩者關聯起來。
[淺談 Session 與 Cookie：一起來讀 RFC](https://blog.huli.tw/2019/08/09/session-and-cookie-part2/)

## 我們本週實作的會員系統，你能夠想到什麼潛在的問題嗎？
對於資安一直沒有太清楚的概念，只覺得網路世界好可怕，感覺總是有漏洞，也很怕自己寫出來的東西都是漏洞XD
1. 駭客從前端盜取帳號密碼
但我沒想到這應該會如何執行，或許將程式寄生在瀏覽器外掛程式上？
除了盜取帳號密碼外，似乎也有可能盜取 session id？或許 server 端需要更多驗證？
2. 駭客入侵資料庫盜取帳號密碼（明碼儲存）
3. SQL injection
以前有看過類似教學，假設登入驗證的語法如下
```
strSQL = "SELECT * FROM users WHERE (name = '" + userName + "') and (pw = '"+ passWord +"');"
```
則可透過填入 `userName = "1' OR '1'='1";` 及 `passWord = "1' OR '1'='1";`，使語法變為
```
strSQL = "SELECT * FROM users WHERE (name = '1' OR '1'='1') and (pw = '1' OR '1'='1');"
```
達到不需帳號密碼即可登入的效果。
參考資料：[維基百科 - SQL注入](https://zh.wikipedia.org/wiki/SQL%E6%B3%A8%E5%85%A5)