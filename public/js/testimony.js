let togg1 = document.getElementById("btn_testimony");
let togg2 = document.getElementById("togg2");
let d1 = document.getElementById("testimony");
let d2 = document.getElementById("d2");
togg1.addEventListener("click", () => {
  if(getComputedStyle(testimony).display != "none"){
    testimony.style.display = "none";
  } else {
    testimony.style.display = "block";
  }
})

function togg(){
  if(getComputedStyle(d2).display != "none"){
    d2.style.display = "none";
  } else {
    d2.style.display = "block";
  }
};
togg2.onclick = togg;