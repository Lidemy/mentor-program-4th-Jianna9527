const request = require('request');
const process = require('process');

const API_URL = 'https://lidemy-book-store.herokuapp.com';
const req = process.argv[2];
const params = process.argv[3];
const name = process.argv[4];

switch (req) {
  case 'list':
    listBooks();
    break;
  case 'read':
    if (!params) { // 檢查書本id
      console.log('請提供書本 id');
      break;
    }
    readBook(params);
    break;
  case 'delete':
    if (!params) { // 檢查書本id
      console.log('請提供書本 id');
      break;
    }
    deleteBook(params);
    break;
  case 'create':
    createBook(params);
    break;
  case 'update':
    if (!params) { // 檢查書本id
      console.log('請提供書本 id');
      break;
    }
    if (!name) { // 檢查書本id
      console.log('請提供新的書名');
      break;
    }
    updateBook(params, name);
    break;
  default: console.log('指令錯誤');
}

function listBooks() {
  request(`${API_URL}/books?_limit=20`, (err, res, body) => {
    if (err) {
      console.log('抓取失敗', err);
      return;
    }
    let data;
    try { // 以防 response 不是一個合法的 JSON 字串
      data = JSON.parse(body);
    } catch (error) {
      console.log(error);
      return;
    }
    for (let i = 0; i < data.length; i++) {
      console.log(`${data[i].id} ${data[i].name}`);
    }
  });
}

function readBook(bookID) {
  request(`${API_URL}/books/${bookID}`, (err, res, body) => {
    if (err) {
      console.log('抓取失敗', err);
      return;
    }
    let data;
    try { // 以防 response 不是一個合法的 JSON 字串
      data = JSON.parse(body);
    } catch (error) {
      console.log(error);
      return;
    }
    console.log(`${data.id} ${data.name}`);
  });
}

function deleteBook(bookID) {
  request.delete(`${API_URL}/books/${bookID}`, (err, res) => {
    if (err) {
      console.log('刪除失敗', err);
      return;
    }
    console.log(`書本 ${bookID} 已成功刪除`);
  });
}

function createBook(bookName) {
  request.post({
    url: `${API_URL}/books`,
    form: {
      name: bookName,
    },
  }, (err, res) => {
    if (err) {
      console.log('新增失敗', err);
      return;
    }
    console.log(`${bookName} 已成功新增`);
  });
}

function updateBook(bookID, newName) {
  request.patch({
    url: `${API_URL}/books/${bookID}`,
    form: {
      name: newName,
    },
  }, (err, res) => {
    if (err) {
      console.log('更新失敗', err);
      return;
    }
    console.log(`書本 ${bookID} 已更名為 ${newName}`);
  });
}
