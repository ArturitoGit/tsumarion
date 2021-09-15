// La page de garde monte toute seule lorsqu'on scroll
window.onscroll = function () {scrollFunction()} ;

// Override le lien "Accueil"
document.links["active"].href="#desc" ;

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20 ) {
    document.getElementById('bg').style.top = "-100vh" ;
    document.getElementById('titre').style.top = "-100vh" ;
  } else {
    document.getElementById('bg').style.top = "0" ;
    document.getElementById('titre').style.top = "" ;
  }
}