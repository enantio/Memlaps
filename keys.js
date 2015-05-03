

var map = [];
window.addEventListener("keydown",
    function(e){
        map[e.keyCode] = true;
        multiKeys(e);
    },
false);


window.addEventListener('keyup',
    function(e){
        map[e.keyCode] = false;
    },
false);



function multiKeys(e){
    
/*CTRL + S save macro with title*/
if(map[17] && map[83]){ // ctrl+s = save	
	if ($('#entitled').val() === ""){
		var title = prompt("Give this note a title", "");
        if (title === ""){
			//do not save;
			alert("Note was not saved.");
		}
        else {
			$('#entitled').val(title);
			//$('form').submit();
		}
	}  
    e.preventDefault();
    return false;
}

}//end multiKeys(e)


