const request = require('request');

const API_URL = 'https://lidemy-book-store.herokuapp.com';

request(`${API_URL}/books?_limit=10`, (err, res, body) => {
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
