let togg1 = document.getElementById("btn_testimony");

let d1 = document.getElementById("testimony");

togg1.addEventListener("click", () => {
  if(getComputedStyle(testimony).display != "block"){
    testimony.style.display = "block";
  } else {
    testimony.style.display = "none";
  }
})

