const API_URL = 'https://api.twitch.tv/kraken';
const CLIENT_ID = 'k19jvag1apshgazx2t86g5lni21p43';
const STREAM_TEMPLATE = `<div class="streams_preview" style="background-image:url($preview)"></div>
<div class="streams_info">
    <div class="streams_img" style="background-image:url($logo)"></div>
    <div class="streams_text">
        <div class="streams_title">$title</div>
        <div class="streams_streamer">$streamer</div>
        </div>
        </div>`;

getGames(function (games) {
    let gamesName = games[0].game.name;
    for (let game of games) {
        let element = document.createElement('li');
        element.innerText = game.game.name;
        document.querySelector('.top5-games').appendChild(element);
    }
    changeGame(gamesName);
});

// 點擊遊戲tag
document.querySelector('.top5-games').addEventListener('click', e => {
    const gamesName = e.target.innerText;
    changeGame(gamesName);
});

// 取得遊戲清單
function getGames(callback) {
    const request = new XMLHttpRequest();
    request.open('GET', `${API_URL}/games/top?limit=5`, true); // true才會非同步
    request.setRequestHeader('Client-ID', CLIENT_ID)
    request.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json')
    request.onload = function () {
        if (request.status >= 200 && request.status < 400) {
            const games = JSON.parse(request.response).top;
            callback(games);
        }
    }
    request.send();
}

// 更換遊戲
function changeGame(gamesName) {
    document.querySelector('h1').innerText = gamesName;
    document.querySelector('.streams').innerHTML = '';
    getStreams(gamesName, function (streams) {
        appendStream(streams);
    });
}

// 取得遊戲實況
function getStreams(gamesName, callback) {
    const request = new XMLHttpRequest();
    request.open('GET', `${API_URL}/streams?game=${encodeURIComponent(gamesName)}&limit=20`, true); // true才會非同步
    request.setRequestHeader('Client-ID', CLIENT_ID)
    request.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json')
    request.onload = function () {
        if (request.status >= 200 && request.status < 400) {
            const streams = JSON.parse(request.response).streams;
            callback(streams);
        }
    }
    request.send();
}

// 添加實況元件
function appendStream(streams) {
    for (let stream of streams) {
        let element = document.createElement('div');
        element.className = 'streams_block';
        document.querySelector('.streams').appendChild(element);
        element.innerHTML = STREAM_TEMPLATE
            .replace('$preview', stream.preview.large)
            .replace('$logo', stream.channel.logo)
            .replace('$title', stream.channel.status)
            .replace('$streamer', stream.channel.display_name);
    }
}