
// Override le lien "Accueil"
document.links["active-link"].href="#desc" ;

// Trouver la direction initiale
var direction_down = document.documentElement.scrollTop == 0 && document.body.scrollTop == 0 ;
// J'ai besoin de garder une variable qui contient la direction pour ne pas appeler la fonction lorsque la page est deja en train
// d'etre scrollee
// Lorsqu'on tente de scroll manuellement le focus change automatiquement
window.addEventListener('wheel',function(event) {
  if (event.deltaY > 0 && direction_down) {
    window.scrollTo(0,document.body.scrollHeight) ;
    direction_down = false ;
  } else if (event.deltaY < 0 && !direction_down) {
    window.scrollTo(0,0) ;
    direction_down = true ;
  }
});