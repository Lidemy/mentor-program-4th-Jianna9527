## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
### 文字格式系列
斜體字：`<i>文字</i>`
底線：`<u>文字</u>`
上標字：`<sup>文字</sup>`
下標字：`<sub>文字</sub>`
### 選單
可透過 `<select></select>` 搭配 `<option></option>`，做出下拉式及多欄式選單。
```htmlmixed
<select name="data">
<option value="1">文字1</option>
<option value="2">文字2</option>
<option value="3">文字3</option>
</select>
```
### dialog（感覺不太實用呢...）
利用 `<dialog>` 標籤來定義對話框、確認框等。
```htmlmixed
<dialog open>This is an open dialog window</dialog>
```
`open` 屬性用來表示 dialog 元素是有效的。

## 請問什麼是盒模型（box modal）
HTML 的元素都可以看作一個盒模型，基本上包括 content、padding、border 及 margin。
通常當我們在設置寬高時，調整的只有 content 的大小，若要計算整個元素的長度及寬度，則需要再加上 padding、border 以及 margin，計算出的數值才會是正確的。
若不想要一個一個慢慢算，可以使用 `box-sizing: border-box` 語法，再設定元素的總寬度與總高度、以及想要的 padding、border 與 margin 大小，瀏覽器就會根據條件，為元素調整出合適的 content 大小。

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
### block
元素會以區塊元素的方式作呈現，預設寬度會占滿整個外容器（父元素）。若有兩個區塊元素相鄰，則會自動換行。
### inline
行內元素，不能設定寬高，元素寬高由內容撐開。可以設定 margin 及 padding，但上下的設定不影響元素位置改變，元素仍在行內，且有可能蓋過其他行內容。
### inline-block
行內區塊元素，以inline的方式呈現，但同時擁有block的特性。可設定寬高、margin 及 padding，排版仍呈現行內元素，不會占滿整個外容器（父元素）。

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？
### static
預設定位方式，元素不會特別定位，而是依照瀏覽器的配置自動排版在頁面上。
### relative
使用 relative 定位方式的元素，如果有添加 top、right、bottom 或 left 屬性，則會依照各個屬性的直，相對原先的位置來進行移動。而元素雖然有進行移動，可是卻不會影響到其他元素的排列方式。
### absolute
使用 absolute 方式定位的元素，會根據上層非 static 定位的父元素為定位基準。若上層所有父元素都是預設的 static 定位，則會根據 body 定位。
### fixed
使用 fixed 來定位的元素，會根據設定的值固定在瀏覽器的畫面上，無論視窗怎麼滾動，該元素都會維持在同樣的位置上。