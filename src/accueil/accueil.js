
// Override le lien "Accueil"
document.links["active"].href="#desc" ;

// Lorsqu'on tente de scroll manuellement le focus change automatiquement
window.addEventListener('wheel',function(event) {
  window.location.hash = (event.deltaY > 0 ) ? "#desc" : "#menu" ;
});