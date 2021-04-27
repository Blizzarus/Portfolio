//In this file: JS window.onscroll method

window.onscroll = function() {scrollFunction()};

function scrollFunction() 
{
  if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) 
  {
    document.getElementById("myVideo").style.position = "fixed";
    document.getElementById("myVideo").style.right = "10%";
    document.getElementById("myVideo").style.top = "50%";
    document.getElementById("myVideo").style.maxHeight = "640px";
    document.getElementById("myVideo").style.maxWidth = "480px";
  } 
  else 
  {
    document.getElementById("myVideo").style.position = "unset";
    document.getElementById("myVideo").style.maxHeight = "100%";
    document.getElementById("myVideo").style.maxWidth = "100%";
  }
}