function refreshIframe() { 
    var webpageUrl = "childrenPhotos.php?children=";

    var childrenNode = document.getElementById("all-children");
    for (var i = 0; i < childrenNode.children.length; i++) {
        if (!childrenNode.children[i].id.startsWith("child-")) {
            continue;
        }
        var id = childrenNode.children[i].id.substring("child-".length);
        // Do something with each child element
        var check = document.getElementById(id + "-checkbox");
        var thumb = document.getElementById("child-" + id);
        thumb.style.backgroundColor = check.checked ? "#9ccfff99" : "#ffcc9c73";
        if (check.checked) 
            webpageUrl += id + ",";
    }

    // Get a reference to the iframe element
    var iframe = document.getElementById("webpage-iframe");

    // Set the src property of the iframe to the URL of the webpage
    iframe.src = webpageUrl;
}
function updatePictures(clickChild)
{
    var check = document.getElementById(clickChild+"-checkbox");
    check.checked = !check.checked;
    refreshIframe();
}