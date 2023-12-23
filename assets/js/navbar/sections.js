const selectItem = document.querySelector(".optionsxd")
const selectItem2 = document.querySelector(".optionsxd2")
const selectItem3 = document.querySelector(".optionsxd3")
const selectUsuario = document.getElementById("usuario")
const selectSuscrip = document.getElementById("suscripciones")
const selectrAsis = document.getElementById("rAsistencias")
selectUsuario.onclick = () => {
    if (selectItem.style.display === "none") {
        selectItem.style.display = "block";
    } else {
        selectItem.style.display = "none"
    }
}

selectSuscrip.onclick = () => {
    if (selectItem2.style.display === "none") {
        selectItem2.style.display = "block";
    } else {
        selectItem2.style.display = "none"
    }
}

selectrAsis.onclick = () => {
    if (selectItem3.style.display === "none") {
        selectItem3.style.display = "block";
    } else {
        selectItem3.style.display = "none"
    }
}

