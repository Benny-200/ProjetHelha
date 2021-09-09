$(document).ready(function () {
  $.ajax("afficher.php").done(function (data) {
    $("#commentaire").html(data);
  });
});
