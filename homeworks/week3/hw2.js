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
function numPow(n) {
  const str = n.toString();
  const len = str.length;
  let result = 0;
  for (let i = 0; i < len; i++) {
    result += Number(str[i]) ** len;
  }
  return result;
}

// 上面都不用管，只需要完成這個 function 就好，可以透過 lines[i] 拿取內容
function solve(input) {
  const num = input[0].split(' ');

  for (let i = Number(num[0]); i <= Number(num[1]); i++) {
    if (i === numPow(i)) {
      console.log(i);
    }
  }
}

// 輸入結束，開始針對 lines 做處理
rl.on('close', () => {
  solve(lines);
});
