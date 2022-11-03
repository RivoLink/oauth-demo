$(function(){

    listenDeleteAccount();

})

function listenDeleteAccount(){
    $(".btn-delete-account").on("click", function(event){
        preventDefault(event);

        var del = confirm("Are you sure you want to delete your Account ?");

        if(del){
            $('.form-delete-account').trigger("submit");
        }
    })
}
