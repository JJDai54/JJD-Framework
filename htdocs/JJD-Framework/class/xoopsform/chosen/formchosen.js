

/***************************************************************
 *
 ***************************************************************/
function chosen_clear_criteres(sName){
  if (sName[0] != '#' && sName[0] != '.') sName = "." + sName;

  obj=$(sName)[0]; 
  var ddlSitesID = obj.length;
  var nbItemUpdated = 0;
  if (ddlSitesID) {
      for (var i = ddlSitesID-1; i>=0; i--) {
          if (obj[i].selected) {
          //alert(i + "-" + obj[i].value);
            obj[i].selected = false;
            nbItemUpdated++;
          }
      }
  }

  //mise a jour du composant chosen
  $(sName).trigger("chosen:updated");
  //chosen_update_width(sName);
}

/***************************************************************
 *
 ***************************************************************/
function chosen_update_width(sName){
  if (sName[0] != '#' && sName[0] != '.') sName = "." + sName;
  //$(sName).parent().children().filter("div").css( "width",  "400px") ;
  $parent=$(sName).parent();
  $parent.children().filter("div").css( "width",  $parent.attr('width_default')) ;   
}
