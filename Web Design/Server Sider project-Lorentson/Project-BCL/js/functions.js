function getPhoto()
{
    document.getElementById("puppyPhoto").src = "images/" + document.getElementById("photoFile").innerHTML;
    //window.alert(document.getElementById("photoFile").innerHTML);
    //return "images/" + fn;
}

function showData(id)
{
   // window.alert(document.getElementById(id + "fname").value);
   
   var pNumber = document.getElementById(id + "number").value; 
   var pName = document.getElementById(id + "name").value;

    var pPrice = document.getElementById(id + "price").value;
    var rDate = document.getElementById(id + "releaseDate").value;
    var pDesc = document.getElementById(id + "desc").value;
    var pLogo = document.getElementById(id + "logo").value;

    document.getElementById("consoleName").innerHTML = pName;
    document.getElementById("price").innerHTML = pPrice;
    document.getElementById("releaseDate").innerHTML = rDate;
    document.getElementById("desc").innerHTML = pDesc;
    document.getElementById("consoleLogo").src = "images/" + pLogo;
    document.getElementById("divPanelRight").style.visibility = "visible";
}


