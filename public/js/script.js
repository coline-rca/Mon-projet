// NAVBAR

let burger = document.querySelector('ul.burger');
let liens = document.querySelector('ul.liens');

    // On regarde la taille de l'écran quand on arrive sur le site, si le menu burger est actif, on le ferme
    if(window.matchMedia("(max-width:768px)").matches) {
            liens.classList.add('close');
    }

    // Si on ajuste l'écran après être arriver sur le site, le menu burger s'active si l'écran est >768px
    window.addEventListener("resize", function(){
        if(window.matchMedia("(max-width:768px)").matches) {
            liens.classList.add('close');
        } else {
            liens.classList.remove('close');
            liens.classList.remove('navcolor');
        }
    });
    
    // Le menu burger s'ouvre et se ferme lors du click sur le bouton
    burger.addEventListener('click', function() {
        if (liens.classList.contains("close")) {
            liens.classList.remove('close');
            liens.classList.add('navcolor');
        } else {
            liens.classList.add('close');
            liens.classList.remove('navcolor');
        }
    }); 


// MAIN

// L'icone du coeur change de couleur au click
let wishlist = document.querySelectorAll('.fa-heart');
        
wishlist.forEach(item => {
    item.addEventListener('click', function() {
        if (item.classList.contains("fa-regular")) {
            item.classList.remove('fa-regular');
            item.classList.add('fa-solid');
        } else {
            item.classList.remove('fa-solid');
            item.classList.add('fa-regular');
        }
    }) 
});