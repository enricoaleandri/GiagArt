/**
 * Created with JetBrains PhpStorm.
 * User: Enrico
 * Date: 10/12/14
 * Time: 3.22
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function()
{
    $(".clickable").click(function()
    {
        var id_lavoro = $(this).parent("tr").attr("data-id-lavoro");
        window.location = host + "/lavori/view/?id_lavoro="+id_lavoro;
    })

    $("#background_home .row .elimina_progetto").click(function(){

        var id_lavoro = $(this).parent().parent("tr").attr("data-id-lavoro");
        window.confirmDelete(id_lavoro);
    });

    $("#background_home .row .modifica_progetto").click(function(){

        var id_lavoro = $(this).parent().parent("tr").attr("data-id-lavoro");
        window.location = host + "/lavori/update/?id_lavoro="+id_lavoro;
    });

    $("#background_home .row .pubblica").click(function(){

        var id_lavoro = $(this).parent().parent("tr").attr("data-id-lavoro");
        window.location = host + "/lavori/pubblica/?id_lavoro="+id_lavoro;
    });


    $("#uploadcover .fileinput-button").click(function()
    {
        if($("#uploadcover").find(".table.table-striped .fade").size() > 0)
            return false;
    })

});