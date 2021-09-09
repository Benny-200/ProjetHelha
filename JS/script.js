$(document).ready(function () {
  $.ajax("MainPage/items.php").done(function (Menu_And_Items_Main_Menu) {
    $("#Menu").html(Menu_And_Items_Main_Menu);
  });
  /*Ajout des donnée dans le panier*/
  $.ajax("../user/Panier.php").done(function (data_Panier) {
    $("#TablePanier").prepend(data_Panier);
  });

  $.ajax("MainPage/pseudo.php").done(function (data_pseudo) {
    $("#pseudoMain").html(data_pseudo);
  });

  $.ajax("MainPage/marqueeFooter").done(function (data_marquee) {
    $("footer").html(data_marquee);
  });
});
