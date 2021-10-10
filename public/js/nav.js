function setTheme(cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (30 * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = "theme=" + cvalue + ";" + expires + ";path=/";
    location.reload();
    // console.log('chamou a função', cvalue);
}