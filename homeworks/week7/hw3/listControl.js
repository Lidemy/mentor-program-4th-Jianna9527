// 添加新事項
const textInput = document.querySelector('.list_input');
const listGroup = document.querySelector('.list_group');
textInput.addEventListener('keydown', (e) => {
  if (e.keyCode === 13) {
    const newItem = document.createElement('li');
    newItem.classList.add('list_item');
    const btnFinished = document.createElement('span');
    btnFinished.classList.add('btn-finished');
    const btnDelete = document.createElement('span');
    btnDelete.classList.add('btn-delete');
    newItem.appendChild(btnFinished);
    newItem.appendChild(document.createTextNode(textInput.value));
    newItem.appendChild(btnDelete);
    listGroup.appendChild(newItem);
    textInput.value = '';
  }
});

// 完成事項 or 取消完成
document.querySelector('.list_group').addEventListener('click', (e) => {
  if (e.target.classList.contains('btn-finished')) {
    e.target.parentNode.classList.toggle('checked');
  }
});

// 刪除事項
document.querySelector('.list_group').addEventListener('click', (e) => {
  if (e.target.classList.contains('btn-delete')) {
    listGroup.removeChild(e.target.parentNode);
  }
});
