
$(document).ready(function(){

$('body').addClass('bground9');
$('.nicEdit-main').toggleClass('tground0');

$('.nicEdit-main').keydown(function(e) {
    
    if(e.keyCode === 9) { //tab
		e.preventDefault();
		document.execCommand('indent',true,null);
        return false;
    }
    
});


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

///////////////////////////////////multiKeys
function multiKeys(e){
if(map[17] && map[69]){ // ctrl+ e
	$('.nicEdit-main').toggleClass('tground1');
    e.preventDefault();
    return false;
}



/*PAGE BACKGROUND CHANGER*/
else if(map[17] && map[49]){ // ctrl+1 
	$('body').removeClass();
	$('body').addClass('bground1');
	//newBground();
    e.preventDefault();
    return false;
}

else if(map[17] && map[50]){ // ctrl+2 
	$('body').removeClass();
	$('body').addClass('bground0');
	//oldBground();
    e.preventDefault();
    return false;
}

/*TEXTAREA BACKGROUND CHANGER*/
else if(map[17] && map[51]){ // ctrl+3 
	$('body').removeClass();
	$('body').addClass('bground3');
	//newTground();
    e.preventDefault();
    return false;
}

else if(map[17] && map[52]){ // ctrl+4 
	$('body').removeClass();
	$('body').addClass('bground4');
	//oldTground();
    e.preventDefault();
    return false;
}
else if(map[17] && map[53]){ // ctrl+5 
	$('body').removeClass();
	$('body').addClass('bground5');
	//oldTground();
    e.preventDefault();
    return false;
}
else if(map[17] && map[54]){ // ctrl+6 
	$('body').removeClass();
	$('body').addClass('bground6');
	//oldTground();
    e.preventDefault();
    return false;
}
else if(map[17] && map[55]){ // ctrl+7 
	$('body').removeClass();
	$('body').addClass('bground7');
	//oldTground();
    e.preventDefault();
    return false;
}
else if(map[17] && map[56]){ // ctrl+8 
	$('body').removeClass();
	$('body').addClass('bground8');
	//oldTground();
    e.preventDefault();
    return false;
}
else if(map[17] && map[57]){ // ctrl+9 
	$('body').removeClass();
	$('body').addClass('bground2');
	//oldTground();
    e.preventDefault();
    return false;
}

else if(map[17] && map[48]){ // ctrl+0 
	$('body').removeClass();
	$('body').addClass('bground9');
	//oldTground();
    e.preventDefault();
    return false;
}

}//end multiKeys






});

