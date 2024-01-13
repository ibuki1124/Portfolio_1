window.addEventListener('scroll',() => {
    const pageTop = document.getElementById('page-top'); //トップに戻るボタンのidを取得
    if(window.scrollY >= 400) {  //上から400px以上スクロールしたら
      pageTop.classList.add('fadein'); //aタグにfadeinクラスを与える
    } else {
      pageTop.classList.remove('fadein');//aタグからfadeinクラスをはずす
    }
  });