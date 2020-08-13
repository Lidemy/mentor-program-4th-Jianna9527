const request = require('request');
const process = require('process');

const API_URL = 'https://restcountries.eu/rest/v2';

getInfo(process.argv[2]);

function getInfo(keyWord) {
  if (!keyWord) {
    console.log('請輸入要查詢的國家');
    return;
  }

  request(`${API_URL}/name/${keyWord}`, (err, res, body) => {
    if (err) {
      console.log('抓取失敗', err);
      return;
    }
    let data;
    try { // 以防 response 不是一個合法的 JSON 字串
      data = JSON.parse(body);
      if (data.status === 404) {
        console.log('找不到國家資訊');
        return;
      }
    } catch (error) {
      console.log(error);
      return;
    }
    const line = '============';
    for (let i = 0; i < data.length; i++) {
      console.log(`${line}\n國家：${data[i].name}\n首都：${data[i].capital}\n貨幣：${data[i].currencies[0].code}\n國碼：${data[i].callingCodes[0]}`);
    }
  });
}
