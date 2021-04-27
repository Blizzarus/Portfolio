function getPhoto()
{
    document.getElementById("puppyPhoto").src = "images/" + document.getElementById("photoFile").innerHTML;
    //window.alert(document.getElementById("photoFile").innerHTML);
    //return "images/" + fn;
}

function showData(id)
{
   // window.alert(document.getElementById(id + "fname").value);
   
    var pname = " for " +  document.getElementById(id + "name").value;

    var pGenderName=""; 
    var pGender = document.getElementById(id + "gender").value;
    if (pGender == "M")
    {
      pGenderName = "Male";
    }
    else if (pGender == "F")
    {
      pGenderName = "Female";
    }

    var bdate = document.getElementById(id + "birthDate").value;
    var pDesc = document.getElementById(id + "desc").value;
    var pBreed = document.getElementById(id + "breed").value;
    var pColor = document.getElementById(id + "color").value;
    var pPhoto = document.getElementById(id + "photo").value;

    document.getElementById("puppyName").innerHTML = pname;
    document.getElementById("gender").innerHTML = pGenderName;
    document.getElementById("birthdate").innerHTML = bdate;
    document.getElementById("desc").innerHTML = pDesc;
    document.getElementById("breed").innerHTML = pBreed;
    document.getElementById("color").innerHTML = pColor;
    document.getElementById("puppyPhoto").src = "images/" + pPhoto;
    document.getElementById("divPanelRight").style.visibility = "visible";
}


