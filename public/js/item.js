
let content = document.querySelector(".content");
let heightMobile = document.querySelector(".height-mobile");
let height = document.querySelector(".height");

// console.log(heightMobile);

if(window.matchMedia("(min-width:768px)").matches) {
    heightMobile.remove();
}

// Si on ajuste l'écran après être arriver sur le site, les taille se créer si l'écran est >768px
window.addEventListener("resize", function(){
if(window.matchMedia("(min-width:768px)").matches) {
    heightMobile.remove();
    content.insertBefore(height, content.childNodes[2]);
} else {

    content.insertBefore(heightMobile, content.childNodes[2]);
    height.remove();
}
});

let link = document.querySelectorAll('.img');
let img = document.querySelector('.img-p');

link.forEach(element => {

    element.addEventListener("click", () => {
        img.src = element.src;
    });
    
});





// logo.src = "img/rm2.png";
