(function () {
    let index = 0
    mostraSlide();
    document.querySelectorAll("a.next")[0].onclick = function () {
        index++;
        mostraSlide();
    }
    document.querySelectorAll("a.prev")[0].onclick = function () {
        index--;
        mostraSlide();
    }

    function mostraSlide() {
        let s = document.querySelectorAll("div .mySlides");

        for (let i=0; i<s.length; i++)
            s[i].style.display = "none";
            
        if(index>=s.length) index=0;
        else if(index<0) index= s.length-1;
        s[index].style.display = "block";
    }
})();