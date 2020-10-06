/*
-----可優化部分-----
1. 欄位名稱自動爬
2. inputResult 輸出格式可修改
3. alert 應該連同非 required 欄位一同顯示(?)
*/

const tableColumn = [
  'nickName',
  'email',
  'phone',
  'type',
  'howToKnow',
];

const inputResult = {};

function isValid(column) {
  let result = true;
  for (let i = 0; i < column.length; i++) {
    const { value } = document.forms.apply_form.elements[column[i]].value;
    const element = document.querySelector(`input[name=${column[i]}]`);
    if (!value) {
      element.parentElement.nextElementSibling.classList.remove('hidden');
      result = false;
    } else {
      inputResult[column[i]] = value;
      element.parentElement.nextElementSibling.classList.add('hidden');
    }
  }

  if (!result) {
    return false;
  }
  return true;
}

const btnSubmit = document.querySelector('.apply_form');
btnSubmit.addEventListener('submit', (e) => {
  e.preventDefault();
  if (isValid(tableColumn)) {
    alert(JSON.stringify(inputResult));
  }
});
