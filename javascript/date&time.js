// DISPLAY DATE AND TIME
function displayDateTime() {
    var now = new Date();
    var date = now.toLocaleDateString();
    var time = now.toLocaleTimeString();
    document.getElementById('datetime').innerHTML = '<strong>' + date + '</strong> ' + time;
}
window.onload = displayDateTime;
setInterval(displayDateTime, 1000); // Update every second
