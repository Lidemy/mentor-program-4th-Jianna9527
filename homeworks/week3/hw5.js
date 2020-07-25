/* eslint  no-param-reassign: 0 */
const readline = require('readline');
const { sign } = require('crypto');
const { checkServerIdentity } = require('tls');

const rl = readline.createInterface({
  input: process.stdin,
});

const lines = [];

// 讀取到一行，先把這一行加進去 lines 陣列，最後再一起處理
rl.on('line', (line) => {
  lines.push(line);
});

// 自訂 function 放這裡
function compare(a, b, rule) {
  if (a === b) return 'DRAW';
  // 先假設我們都是比大，所以 A 大就回傳 A，B 大就回傳 B
  // 那如果是比小怎麼辦？把 AB 對調就好
  // 假設 A 是 5，B 是 3，我們的邏輯會回傳 A
  // 但如果是比小，把 AB 對調，就會回傳 B 了
  if (rule === '-1') {
    const temp = a;
    a = b;
    b = temp;
  }

  const lengthA = a.length;
  const lengthB = b.length;

  if (lengthA !== lengthB) {
    return lengthA > lengthB ? 'A' : 'B';
  }
  return a > b ? 'A' : 'B';
}

// 上面都不用管，只需要完成這個 function 就好，可以透過 lines[i] 拿取內容
function solve(input) {
  const m = Number(input[0]);
  for (let i = 1; i <= m; i++) {
    const [a, b, rule] = input[i].split(' ');
    console.log(compare(a, b, rule));
  }
}

// 輸入結束，開始針對 lines 做處理
rl.on('close', () => {
  solve(lines);
});
