$(function(){

    listenSignupGoogle();

})

function listenSignupGoogle(){
    $(".btn-google").on("click", function(event){
        preventDefault(event);
        toggleLoader(true);

        $.ajax({
            method: "post",
            url: "/api/sign-up/google-url",
        })
        .always(function({content}){
            if(content && content.url){
                location.href = content.url;
            }
            else {
                toggleLoader(false);
            }
        });
    })
}
