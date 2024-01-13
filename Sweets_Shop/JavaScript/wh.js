//ウィンドウの高さを設定
let wh = window.innerHeight;
let whElm = document.getElementById("wh");

window.addEventListener("load", ()=>{
    whElm.style.height = wh + "px";
}, false);

window.addEventListener("resize", ()=>{
    whElm.style.height = wh + "px";
}, false);