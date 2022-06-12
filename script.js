function showinput(sender) {
    if (math.checked) {
        document.getElementById("mathblock").style.display = "block";
    }
    if (informatic.checked) {
        document.getElementById("infoblock").style.display = "block";
    }
}
function Check(){
        if (document.getElementById("city").value =='')
        {
                alert('Введите значение в поле "Город"!');
                return false;
        }
}
