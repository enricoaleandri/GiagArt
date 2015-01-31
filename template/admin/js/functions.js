/**
 * Created with JetBrains PhpStorm.
 * User: Enrico
 * Date: 18/12/14
 * Time: 1.28
 * To change this template use File | Settings | File Templates.
 */
window.confirmDelete = function(id)
{
    var valore = confirm("Sei sicuro di voler eliminare definitivamente questo progetto?");
    if(valore)
    {
        window.location=host+"/lavori/delete/?id_lavoro="+id;
    }
}