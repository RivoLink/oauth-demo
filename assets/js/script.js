$(function(){

    window.preventDefault = function(event){
        event.preventDefault();
    }

    window.toggleLoader = function(show){
        $(".loader").toggleClass("d-none", show !== true)
    }
    
})
