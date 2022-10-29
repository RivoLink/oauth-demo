$(function(){

    window.preventDefault = function(event){
        event.preventDefault();
    }

    window.toggleLoader = function(show){
        $(".loader").toggleClass("d-none", show !== true)
    }
    
    window.json_decode = function(str){
        try {
            var result = JSON.parse(str);
            return result;
        }
        catch(error){
            return null;
        }
    }

    window.json_encode = function(obj){
        var result = JSON.stringify(obj);
        return result;
    }
    
})
