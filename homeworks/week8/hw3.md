## 什麼是 Ajax？
Ajax（Asynchronous JavaScript and XML）是瀏覽器上常用的非同步技術，可以在發出 request 後，無需等待結果回傳，繼續執行後續的程式碼。

```javascript
const request = new XMLHttpRequest(); // XHR
// open 代表要發 request 到這個地方
request.open('GET', url, true); // 第三個參數代表是否非同步
// request.addEventListener('load', function(){})
request.onload = function(){
    if(request.status >= 200 && request.status < 400){
        console.log(request.responseText); // 純文字記得要轉 JSON 格式使用
    }else{
        console.log('err');
    }
}
request.onerror = function(){
    console.log('error')
}

request.send(); // 記得要 send
```

使用時需要特別注意，非同步的 function 不能直接透過 return 來回傳結果，因為程式碼在發出 request 後，就會直接往下執行，在 return 時根本還沒收到回傳的 response。因此可以透過 Callback Function（回呼函式）來處理，當非同步的操作完成時，就會呼叫 callback function 並把得到的資料帶入。

```javascript
sendRequest(API_URL, callMe);

function callMe (response) {
  console.log(response);
}

// 或者寫成匿名函式
sendRequest(API_URL, function (response) {
  console.log(response);
});
```
## 用 Ajax 與我們用表單送出資料的差別在哪？
1. Ajax 需要透過程式碼操作才可以執行，表單送出資料則是單純透過 Html 語法就可以傳送資料。
2. Ajax 可以在不換頁的情況下發出 request 與伺服器交換資料，若使用表單的方式則需要換頁。

## JSONP 是什麼？
JSONP（JSON with Padding）是 JSON 的一種使用模式，可以讓一個網頁從其他的網域（cross-domain）請求資料。它利用了 `script` 標籤可以跨網域請求的特性，解決 AJAX 因為有瀏覽器安全性限制而無法跨網域使用的問題。

整個 JSONP 過程的步驟大概像是：

1. 用 JavaScript 建立一個 `script` 標籤元素，並指定好 src 指向一個跨網域的網址。
2. 遠端伺服器接收到請求後會返回一個 JavaScript 檔案 (application/javascript)，該 JavaScript 檔案中會直接執行一個 JavaScript function，而這個 function 的傳入參數就是想要請求的資料結果。此外，執行的 function 名稱通常是可以透過請求的 URL 參數指定的。
3. 最後在 callback function 中就可以對 server 返回的資料做任何事啦～

## 要如何存取跨網域的 API？
由於瀏覽器預設把不同源的 response 擋掉，這時候就需要跨來源共用（CORS）。

要使用跨來源共用則需要在發出 request 時，在 request 的 header 中進行相關設定，待瀏覽器判斷條件符合後，則可以成功跨域存取 API。

## 為什麼我們在第四週時沒碰到跨網域的問題，這週卻碰到了？
有別於第四週時在 node.js 上面執行 JavaScript，本週透過瀏覽器發送 request 與接收 response。在瀏覽器上進行操作會有安全性的相關限制（如：同源政策），因此遇到了跨網域的問題。