//alert("Alphabarre");

/*************************************************
 *
 *************************************************/
function alphabarre_onclick(event,ob){
var target = event.target || event.srcElement;
  letter = target.getAttribute('letter');
  if(!letter) return false;
  page = target.getAttribute('page');
  if (!page) page = 0;
  url = ob.getAttribute('href')
  var n = url.indexOf("?"); 
  sep = ((n < 0) ? '?' : '&');
  url += sep + "letter=" + letter + "&page=" + page + "&extrabarre=" ;
  //alert(ob.id + ":" + url + "-" + letter + '-' + page );
  //alert(url);
  window.location.href=url;
  return true;
}
/*************************************************
 *
 *************************************************/
function alphabarre_submit(event,ob){
var target = event.target || event.srcElement;
  letter = target.getAttribute('letter');
  if(!letter) return false;
  page = target.getAttribute('page');
  if (!page) page = 0;
  url = ob.getAttribute('href')
  var n = url.indexOf("?"); 
  sep = ((n < 0) ? '?' : '&');
  url += sep + "letter=" + letter + "&page=" + page;
  //alert(ob.id + ":" + url + "-" + letter + '-' + page );
  
  obLetter = document.getElementById("alphaBarre_letter");
  obLetter.value = letter;
 
  obPage = document.getElementById("alphaBarre_page");
  obPage.value = page;
 
  alert(url);
  ob=target;
  while (ob.tagName.toLowerCase() != 'form'){
  //alert(ob.tagName);
    ob = ob.parentNode;
  }
  alert(ob.tagName + " | " + ob.name);
  
  //ob.submit();
  document.recheche_sommaire.submit();
  //window.location.href=url;
  return false;
}

/*************************************************
 *
 *************************************************/
function alphabarre_submit2(idForSubmit, letter, page, extrabarre){
  
    ob_extrabarre = document.getElementById(idForSubmit + "_extrabarre");
    if(ob_extrabarre){
      ob_extrabarre.value = (extrabarre) ? extrabarre : '';
    }

  alphabarre_submit3(idForSubmit, letter, page);
  return false;


}
function alphabarre_submit3(idForSubmit, letter, page){

//alert(idForSubmit);
  obLetter = document.getElementById(idForSubmit + "_letter");
  obLetter.value = letter;
 
  obPage = document.getElementById(idForSubmit + "_page");
  obPage.value = page;

   ob=obLetter;
   while (ob.tagName.toLowerCase() != 'form'){
    //alert(ob.tagName);
    ob = ob.parentNode;
  }
  //alert(ob.tagName + " | " + ob.id);
              
  ob.submit();
  //document.recheche_sommaire.submit();
  //window.location.href=url;
  return false;


}
/*************************************************
 *
 *************************************************/
function alphabarre_submit_extrabarre(idForSubmit, letter, page, extrabarre, prompt_lib){

  if (prompt_lib == ''){
    var answer = '0';
  }else{
    var answer = prompt(prompt_lib + " ?","");
  }
 
//alert (idForSubmit + " | letter =  " + letter + " | page = " + page + " | extrabarre = " + extrabarre + " | prompt_lib = " + prompt_lib);
  
  if (answer){
  
    ob_extrabarre = document.getElementById(idForSubmit + "_extrabarre");
    ob_extrabarre.value = extrabarre + "|" + answer;
    
    
    //alert (idForSubmit + " - You answer : " + answer);
    alphabarre_submit3(idForSubmit, letter, page);
  }
  //alert(idForSubmit + "|" + extrabarre + "|" + caption);
}
/*************************************************
 *
 *************************************************/
function get_alphabarre_page(){
    return get_alphabarre_info("page");
}
/*************************************************
 *
 *************************************************/
function get_alphabarre_letter(){
    return get_alphabarre_info("letter");
}
/*************************************************
 *
 *************************************************/
function get_alphabarre_maxPage(){
    return get_alphabarre_info("maxPage");
}
/*************************************************
 *
 *************************************************/
function get_alphabarre_nbPages(){
    return get_alphabarre_info("nbPages");
}

/*************************************************
 *
 *************************************************/
function get_alphabarre_info(idName){
    ob = document.getElementById("alphaBarre_" + idName);
    v = ob.value;
  //alert(idForSubmit + idName"=" + v);
    return v;
}
