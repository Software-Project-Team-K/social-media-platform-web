$(document).ready(function()
{
    //when click signup, hide login. 
    $("#signup").click(function()
    {
        $("#first").slideUp("slow",function()
        {
            $("#second").slideDown("slow")
        });
    });    


    //when click signin, hide register. 
    $("#signin").click(function()
    {
        $("#second").slideUp("slow",function()
        {
            $("#first").slideDown("slow")
        });
    });    


});