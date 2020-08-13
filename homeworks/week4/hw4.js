const request = require('request');

const API_URL = 'https://api.twitch.tv/kraken/games/top';
const CLIENT_ID = 'k19jvag1apshgazx2t86g5lni21p43';

request({
  url: API_URL,
  headers: {
    'Client-ID': CLIENT_ID,
    Accept: 'application/vnd.twitchtv.v5+json',
  },
}, (err, res, body) => {
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
  for (let i = 0; i < data.top.length; i++) {
    console.log(`${data.top[i].viewers} ${data.top[i].game.name}`);
  }
  // 參考寫法
  // const games = data.top
  // for(let game of games) {
  //   console.log(game.viewers + ' ' + game.game.name)
  // }
});
