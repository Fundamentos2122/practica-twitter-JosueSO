const formTweet = document.getElementById("form-tweet");
const tweetList = document.getElementById("tweet-list");
const keyList = "tweetList";

document.addEventListener("DOMContentLoaded", function() {
    //Agregar evento al formulario
    formTweet.addEventListener("submit", submitTweet);

    paintTweets();
});

function submitTweet(e) {
    e.preventDefault();
    e.stopPropagation();

    let tweet = {
        id: Date.now(),
        text: formTweet["tweet"].value
    };

    let list = getTweets();

    list.push(tweet);

    localStorage.setItem(keyList, JSON.stringify(list));

    paintTweets();
}

function paintTweets() {
    let list = getTweets();

    let html = '';

    for(var i = 0; i < list.length; i++) {
        html += 
            `<div class="card" id="${list[i].id}">
                <div class="card-img">
                    <img src="https:\\picsum.photos/600" alt="">
                </div>
                <div class="card-text">
                    ${list[i].text}
                </div>
                <button class="close" onclick="deleteTweet(${list[i].id})">X</button>
            </div>`;
    }

    tweetList.innerHTML = html;
}

function getTweets() {
    let list = JSON.parse(localStorage.getItem(keyList));

    if (list === null) {
        return [];
    }
    else {
        return list;
    }
}

function deleteTweet(id) {
    let list = getTweets();

    list = list.filter(i => i.id !== id);

    localStorage.setItem(keyList, JSON.stringify(list));

    let tweet = document.getElementById(id);

    tweet.className += ' hide';

    setTimeout(() => {
        tweet.remove();
    }, 300);
}