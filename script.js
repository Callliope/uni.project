window.onload = function () {
	document.querySelectorAll (".subject-input").forEach (item => item.addEventListener ("change", showinput));
	function showinput () {
        console.log (this);
        if (this.checked) {
            document.querySelector (`#${this.id}block`).classList.remove ("inactive");
            document.querySelector (`#${this.id}input`).setAttribute ("required", true);
        } else {
            document.querySelector (`#${this.id}block`).classList.add ("inactive");
            document.querySelector (`#${this.id}input`).removeAttribute ("required");
        }
	}
	function Check(){
	    let data = {};

	        if (document.getElementById("city").value =='')
	        {
	                alert('Введите значение в поле "Город"!');
	                return false;
	        }
	}

}