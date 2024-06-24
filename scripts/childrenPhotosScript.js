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
function loadVideo(videoSrc, title) {
    var highResVideo = document.getElementById("hires-video");
    if (highResVideo == null) {
        highResVideo = document.createElement("video");
        highResVideo.id = "hires-video";
        highResVideo.controls = true;

        highResVideo.style.position = "fixed";
        highResVideo.style.top = "50%";
        highResVideo.style.left = "50%";
        highResVideo.style.transform = "translate(-50%, -50%)";
        highResVideo.style.maxWidth = "100%";
        highResVideo.style.maxHeight = "100%";
        document.body.appendChild(highResVideo);
        highResVideo.onclick = function() {
            highResVideo.stop();
            document.body.removeChild(highResVideo);
        };
        highResVideo.ondblclick = function() {
            document.body.removeChild(highResVideo);
            highResVideo.stop();

        };
    }
    highResVideo.src = videoSrc;
    highResVideo.type = 'video/avi';
    highResVideo.alt = title;
}


function confirmDelete(_id) {    
    if (confirm("Are you sure you want to delete this photo?")) {
        urlParams = new URLSearchParams(window.location.search);

        location.href='../controller/deletePhoto.php?ID=' +  _id + "&children=" + urlParams.get('children');
    }
}

function addToTimeline(_id) {    
    var msg = prompt("Please enter the event description");
    if (msg)
    {
        window.parent.location.href='../controller/addToTimeline.php?ID=' +  _id + "&msg=" + encodeURIComponent(msg);
    }
}

function checkImageSet()
{
  if (document.getElementById('fileToUpload').value != "")
  {
    document.getElementById('submitChildPic').click();
    return;
  }
  setTimeout(checkImageSet, 500);
}