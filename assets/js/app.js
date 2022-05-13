const formTweet = document.getElementById("form-tweet");
const tweetList = document.getElementById("tweet-list");
const modalTweet = document.getElementById("modalTweet");
const idEdit = document.getElementById("form-edit-id");
const textAreaEdit = document.getElementById("form-edit-text");
const btnSaveEdit = document.getElementById("btnSaveEdit");
const keyList = "tweetList";

document.addEventListener("DOMContentLoaded", function() {
    //Agregar evento al formulario
    // formTweet.addEventListener("submit", submitTweet);

    getTweets();

    let modals = document.getElementsByClassName("modal");

    for(var i = 0; i < modals.length; i++) {
        modals[i].addEventListener("click", function(e) {
            if(e.target === this){
                this.classList.remove("show");
            }
        });
    }

    // btnSaveEdit.addEventListener("click", saveEdit);
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

function paintTweets(list) {
    let html = '';

    for(var i = 0; i < list.length; i++) {
        html += 
            `<div class="card" id="${list[i].id}">
                <div class="card-img">
                    <img src="https:\\picsum.photos/600" alt="" class="img-fluid">
                </div>
                <div class="card-text">
                    ${list[i].text}
                </div>
                <div class="options">
                    <button class="btn-option" onclick="editTweet(${list[i].id})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn-option" onclick="deleteTweet(${list[i].id})">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>`;
    }

    tweetList.innerHTML = html;
}

function getTweets() {
    let xhttp = new XMLHttpRequest();

    xhttp.open("GET", "../controllers/tweetsController.php", true);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                let list = JSON.parse(this.responseText);

                paintTweets(list);
            }
            else {
                console.log("Error");
            }
        }
    };

    xhttp.send();

    return [];
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

function editTweet(id) {
    let xhttp = new XMLHttpRequest();

    xhttp.open("GET", "../controllers/tweetsController.php?id=" + id, true);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                let tweet = JSON.parse(this.responseText);

                idEdit.value = tweet.id;
                textAreaEdit.value = tweet.text;

                btnSaveEdit.setAttribute("onclick", "saveEdit(" + tweet.id + ")");
                modalTweet.classList.add("show");
            }
            else {
                console.log("Error");
            }
        }
    };

    xhttp.send();
}

function saveEdit(id) {
    let xhttp = new XMLHttpRequest();

    xhttp.open("POST", "../controllers/tweetsController.php", true);

    xhttp.setRequestHeader("Content-type", "application/json");

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                if (this.responseText === "Registro guardado") {
                    getTweets();
                    modalTweet.classList.remove("show");
                }
            }
            else {
                console.log("Error");
            }
        }
    };

    let data = {
        _method: 'PUT',
        id: id,
        text: textAreaEdit.value
    };

    xhttp.send(JSON.stringify(data));
}