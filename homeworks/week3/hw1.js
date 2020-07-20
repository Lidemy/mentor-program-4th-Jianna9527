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

// 輸入結束，開始針對 lines 做處理
rl.on('close', () => {
  solve(lines);
});

// 上面都不用管，只需要完成這個 function 就好，可以透過 lines[i] 拿取內容
function solve(input) {
  const n = Number(input[0]);
  let result = '';

  for (let i = 1; i <= n; i++) {
    if (i === n) {
      result += printStar(i);
    } else {
      result += `${printStar(i)}\n`;
    }
  }
  console.log(result);
}

function printStar(n) {
  let star = '';
  for (let i = 1; i <= n; i++) {
    star += '*';
  }
  return star;
}
