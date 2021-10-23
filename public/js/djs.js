function checkFileExist(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD',urlToFile, false);
    xhr.send();
    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
}