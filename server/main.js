var delayTime = 10000;
function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min)) + min;
}
var images = ["http://www.planwallpaper.com/static/images/6768666-1080p-wallpapers.jpg"];
var ready = function(){
    setTimeout(function changeBackground() {
        document.body.style.background = "url('" + images[getRandomInt(0, images.length)] + "') no-repeat center top";
        setTimeout(changeBackground, delayTime);
    }, 0);
}
document.addEventListener("DOMContentLoaded", ready);
