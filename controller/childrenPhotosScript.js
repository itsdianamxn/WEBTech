function loadHighResImage(imgSrc, title) {
    var highResImg = document.getElementById("hires-img");
    if (highResImg == null) {
        highResImg = document.createElement("img");
        highResImg.id = "hires-img";
        highResImg.style.position = "fixed";
        highResImg.style.top = "50%";
        highResImg.style.left = "50%";
        highResImg.style.transform = "translate(-50%, -50%)";
        highResImg.style.maxWidth = "100%";
        highResImg.style.maxHeight = "100%";
        document.body.appendChild(highResImg);
        highResImg.onclick = function() {
            document.body.removeChild(highResImg);
        };
    }
    highResImg.src = imgSrc;
    highResImg.alt = title;
}