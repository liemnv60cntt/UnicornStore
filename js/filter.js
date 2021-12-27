filterSelection('all')

function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("filterDiv");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "show");
    w3RemoveClass(x[i], "show2");
    w3RemoveClass(x[i], "chose");
    if (x[i].className.indexOf(c) > -1){
      w3AddClass(x[i], "show");
      w3AddClass(x[i], "chose");
    } 
  }
}
function filterSelection2(d) {
  var x, i, j, c, l, r;
  c = parseInt(d);
  x = document.getElementsByClassName("chose");
  switch(c){
    case 0:
      l = 1;
      r = 1000000000;
      break;
    case 1:
      l = 1;
      r = 999000;
      break;
    case 2:
      l = 1000000;
      r = 1999000;
      break;
    case 3:
      l = 2000000;
      r = 4999000;
      break;
    case 4:
      l = 5000000;
      r = 9999000;
      break;
    case 5:
      l = 10000000;
      r = 1000000000;
      break;
  }
  for (i = 0; i < x.length; i++) {
    if(parseInt(l) > parseInt(x[i].id) || parseInt(x[i].id) > parseInt(r)){
      w3RemoveClass(x[i], "show");
      w3RemoveClass(x[i], "show2");
    }
    
    if(x[i].className.indexOf("chose") > -1){
      if (parseInt(l) <= parseInt(x[i].id) && parseInt(x[i].id) <= parseInt(r)) {
        w3AddClass(x[i], "show2");    
      } 
    }
     
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}

// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
if(btnContainer != null)
  var btns = btnContainer.getElementsByClassName("btn");
if(btns != null){
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function(){
      var current = btnContainer.getElementsByClassName("active");
      var current2 = btnContainer2.getElementsByClassName("active");
      
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
      for(var j = 0; j <= current2.length; j++){
        current2[j].className = current2[j].className.replace(" active","");
      }
    });
  }
}

var btnContainer2 = document.getElementById("myBtnContainer2");
if(btnContainer2 != null)
  var btns2 = btnContainer2.getElementsByClassName("btn");
if(btns2 != null){
  for (var i = 0; i < btns2.length; i++) {
    btns2[i].addEventListener("click", function(){
      var current = btnContainer2.getElementsByClassName("active");
      if (current.length > 0)
        current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
    });
  }
}
