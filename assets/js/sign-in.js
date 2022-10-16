$(function(){

    listenSigninGoogle();
    listenSignupFacebook();

})

function listenSigninGoogle(){
    $(".btn-google").on("click", function(event){
        preventDefault(event);
        toggleLoader(true);

        $.ajax({
            method: "post",
            url: "/api/sign-in/google-url",
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

function listenSignupFacebook(){
    $(".btn-facebook").on("click", function(event){
        preventDefault(event);
        toggleLoader(true);

        FB.getLoginStatus(function(response){
            if(response.status === "connected"){
                postFacebookOAuth(response);
            }
            else {
                FB.login(function(state){
                    if(state.status === "connected"){
                        postFacebookOAuth(state);
                    }
                    else {
                        toggleLoader(false);
                        // TODO: show error
                    }
                }, 
                { 
                    scope: 'email,public_profile' 
                });
            }
        });
    })
}

function postFacebookOAuth(response){
    var url = "/api/sign-up/facebook-post";
    var data = json_encode(response);

    $(`
        <form action="${url}" method="post">
            <input name="data" value='${data}'>
        </form>
    `)
    .appendTo(document.body)
    .trigger("submit");
}
