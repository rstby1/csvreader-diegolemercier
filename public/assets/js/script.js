var fileInput = document.getElementById('fileCSV');
var labelFile = document.getElementById('labelFile');
const fileSelected = document.getElementById('fileSelected');

fileInput.addEventListener('change', function () {
    if (fileInput.files.length > 0) {
        console.log(fileInput.files[0].name);
        fileSelected.textContent = "File selected: " + fileInput.files[0].name;
    }
});
/*
fileInput.addEventListener('change', function () {
    if (fileInput.files.length > 0) {
        console.log(fileInput.files[0].name);
        labelFile.childNodes[0].textContent = "File selected: " + fileInput.files[0].name;
    } else {
        labelFile.childNodes[0].textContent = "Search file";
    }
});*/