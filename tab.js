$(document).ready(function(){

$('.nicEdit-main').keydown(function(e) {
    if(e.keyCode === 9) { //tab
		e.preventDefault();
		document.execCommand('indent',true,null);
        return false;
    }
    
});

});
