function refreshIframe() { 
    var webpageUrl = "../controller/timelineController.php?children=";
    var childrenNode = document.getElementById("all-children");
    var selectedChildren = [];

    for (var i = 0; i < childrenNode.children.length; i++) {
        if (!childrenNode.children[i].id.startsWith("child-")) {
            continue;
        }
        var id = childrenNode.children[i].id.substring("child-".length);
        var check = document.getElementById(id + "-checkbox");
        var thumb = document.getElementById("child-" + id);
        thumb.style.backgroundColor = check.checked ? "#9ccfff99" : "#ffcc9c73";

        if (check.checked) {
            selectedChildren.push(id);
        }
    }

    if (selectedChildren.length > 0) {
        webpageUrl += selectedChildren.join(",");
    }

    var iframe = document.getElementById("webpage-iframe");
    iframe.src = webpageUrl;
}

function updatePictures(clickChild) {
    var check = document.getElementById(clickChild + "-checkbox");
    check.checked = !check.checked;
    refreshIframe();
}
function share() {
    refreshIframe();
}
