<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 18/10/14
 * To change this template use File | Settings | File Templates.
 */
class LavoriController extends  AbstractController
{
    private static $ADMIN_HOME = "admin_home";
    private static $LAVORO_VIEW = "lavoro_view";
    private static $LAVORO_UPDATE = "lavoro_update";
    private static $LAVORO_INSERT = "lavoro_insert";

    private static $temp_dir_lavori = "temp_dir_lavori";
    public function __construct()
    {
        $this->className = get_class($this);
        $this->livelloPagina = self::$LIVELLO_ADM;
    }

    public function listAction(Request $request)
    {

        $lavoriDAO = new lavoriDAO($this->connection);

        $this -> response -> setProperty("lavori",$lavoriDAO->getAllLavori());

        $this->includer->includePage(self::$ADMIN_HOME);
    }
    public function pubblicaAction(Request $request)
    {
        if($request->is_set("id_lavoro"))
        {
            $id_lavoro = $request->get("id_lavoro");
            $lavoriDAO = new lavoriDAO($this->connection);
            if($lavoriDAO->publishLavoroById($id_lavoro))
            {
                $message = "Pubblicazione effettuata!";
                Logger::log(Logger::$INFO,$message);
                $this -> response -> setProperty("message", $message);
            }
            else
            {
                $errorMessage = "Impossibile pubblicare progetto!";
                Logger::log(Logger::$ERROR,$errorMessage);
                $this -> response -> setError("errorMessage", $errorMessage);
            }
        }
        $this->listAction($request);
    }

    public function deleteAction(Request $request)
    {
        if($request->is_set("id_lavoro"))
        {
            $lavoriDAO = new lavoriDAO($this->connection);
            if($lavoriDAO -> deleteLavoroById($request->get("id_lavoro")))
            {
                $message = "Progetto eliminato!!";
                Logger::log(Logger::$DEBUG,$message);
                $this -> response -> setProperty("message", $message);
            }
            else
            {
                $errorMessage = "Impossibile eliminare!";
                Logger::log(Logger::$ERROR,$errorMessage);
                $this -> response -> setError("errorMessage", $errorMessage);
            }

        }
        else
        {
            $errorMessage = "Nessun id progetto";
            Logger::log(Logger::$ERROR,$errorMessage);
            $this -> response -> setError("errorMessage", $errorMessage);
        }

        $this->listAction($request);
    }
    public function saveAction(Request $request)
    {

        if($request->is_set("titolo") && $request->is_set("descrizione")
            && $request->is_set("categoria") && $request->is_set("tags")
            && $request->is_set("status"))
        {
            $lavoro = new lavoriBean();
            Logger::log(Logger::$ERROR,$request->toString());
            if($lavoro->setIdAutore($_SESSION[self:: $user_var_name_id]) &&
                $lavoro->setTitolo($request->get("titolo")) &&
                $lavoro->setDescrizione($request->get("descrizione")) &&
                $lavoro->setCategorie($request->get("categoria")) &&
                $lavoro->setTags($request->get("tags")) &&
                $lavoro->setStatus($request->get("status"))
            )
            {

                $lavoriDAO = new lavoriDAO($this->connection);
                if($lavoro = $lavoriDAO -> insertLavoro($lavoro))
                {
                    Logger::log(Logger::$DEBUG, "ORIGINAL : ./data/images/lavori/".$_SESSION['temp_dir_lavori']);
                    Logger::log(Logger::$DEBUG, "TO BE : ./data/images/lavori/".$lavoro->getIdLavoro());
                    $renameResult = rename('./data/images/lavori/'.$_SESSION['temp_dir_lavori'], './data/images/lavori/'.$lavoro->getIdLavoro()."");
                     Logger::log(Logger::$DEBUG, "RENAME RESULT : ".$renameResult);
                    if($renameResult == true)
                    {
                        $_SESSION['temp_dir_lavori'] = "";

                        $message = "Inserimento Effettuato!";
                        Logger::log(Logger::$ERROR,$message);
                        $this -> response -> setProperty("message", $message);
                        $this->listAction($request);
                        return;
                    }
                    else
                    {

                        $errorMessage = "Problemi nella directory delle immagini de progetto";
                        Logger::log(Logger::$ERROR,$errorMessage);
                        $this -> response -> setError("errorMessage", $errorMessage);
                    }
                }
                else
                {
                    $errorMessage = "Problemi nell'inserimento del lavoro";
                    Logger::log(Logger::$ERROR,$errorMessage);
                    $this -> response -> setError("errorMessage", $errorMessage);
                }
            }
            else
            {
                $errorMessage = "Parametri errati";
                Logger::log(Logger::$ERROR,$errorMessage);
                $this -> response -> setError("errorMessage", $errorMessage);
            }

        }
        else
        {
            $errorMessage = "Parametri Mancanti";
            Logger::log(Logger::$ERROR,$errorMessage);
            $this -> response -> setError("errorMessage", $errorMessage);
        }

        $this->includer->includePage(self::$LAVORO_INSERT);
    }
    public function insertAction(Request $request)
    {
        $_SESSION[self::$temp_dir_lavori] = "";
        $categorieDAO = new categorieDAO($this->connection);
        $this-> response -> setProperty("categorie",$categorieDAO->getAllCategorie());

        $this->includer->includePage(self::$LAVORO_INSERT);
    }

    public function updateAction(Request $request)
    {
        if($request->is_set("id_lavoro"))
        {
            $id_lavoro = $request -> get("id_lavoro");
            $lavoriDAO = new lavoriDAO($this->connection);
            $categorieDAO = new categorieDAO($this->connection);

            if($lavoro = $lavoriDAO -> getLavoroById($id_lavoro))
            {

                $this -> response -> setProperty("lavoro",$lavoro);
                $_SESSION[self::$temp_dir_lavori] =$lavoro->getIdLavoroParent() != "-1" ? $lavoro->getIdLavoroParent() : $lavoro->getIdLavoro();
                $this-> response -> setProperty("categorie",$categorieDAO->getAllCategorie());

                $this->includer->includePage(self::$LAVORO_UPDATE);
            }
            else
            {
                $this->listAction($request);
            }
        }
        else
        {
            $this->listAction($request);
        }

    }
    public function saveupdateAction(Request $request)
    {

        if($request->is_set("titolo") && $request->is_set("descrizione")
            && $request->is_set("categoria") && $request->is_set("tags")
            && $request->is_set("status"))
        {
            $lavoro = new lavoriBean();

            Logger::log(Logger::$ERROR,$request->toString());
            if($lavoro->setTitolo($request->get("titolo")) &&
                $lavoro->setDescrizione($request->get("descrizione")) &&
                $lavoro->setCategorie($request->get("categoria")) &&
                $lavoro->setTags($request->get("tags")) &&
                $lavoro->setIdLavoroParent($request->get("id_lavoro_parent") != "-1" ? $request->get("id_lavoro_parent") : $request->get("id_lavoro")) &&
                $lavoro->setStatus($request->get("status")) &&
                $lavoro->setIdAutore($request->get("id_autore"))
            )
            {

                $lavoriDAO = new lavoriDAO($this->connection);
                if($lavoro = $lavoriDAO -> updateLavoro($lavoro))
                {
                    $_SESSION['temp_dir_lavori'] = "";

                    $message = "Aggiornamento Effettuato!";
                    Logger::log(Logger::$ERROR,$message);
                    $this -> response -> setProperty("message", $message);
                    $request->set("id_lavoro",$lavoro->getIdLavoro());
                    $this->viewAction($request);
                    return;

                }
                else
                {
                    $errorMessage = "Problemi nell'inserimento del lavoro";
                    Logger::log(Logger::$ERROR,$errorMessage);
                    $this -> response -> setError("errorMessage", $errorMessage);
                }
            }
            else
            {
                $errorMessage = "Parametri errati";
                Logger::log(Logger::$ERROR,$errorMessage);
                $this -> response -> setError("errorMessage", $errorMessage);
            }

        }
        else
        {
            $errorMessage = "Parametri Mancanti";
            Logger::log(Logger::$ERROR,$errorMessage);
            $this -> response -> setError("errorMessage", $errorMessage);
        }

        $this->includer->includePage(self::$LAVORO_INSERT);
    }
    public function uploadcoverAction(Request $request)
    {

        if(!isset($_SESSION[self::$temp_dir_lavori]) || $_SESSION[self::$temp_dir_lavori] == "")
            $_SESSION[self::$temp_dir_lavori] = time();

        $options = array(
            'script_url' => $this->response->getProperty("full_url").'/lavori/uploadcover/',
            'upload_dir' => dirname($request->getServerVar('SCRIPT_FILENAME')).'/data/images/lavori/'.$_SESSION[self::$temp_dir_lavori]."/cover/",
            'upload_url' => $this->response->getProperty("full_url").'/data/images/lavori/'.$_SESSION[self::$temp_dir_lavori]."/cover/");

        $upload_handler = new UploadHandler($options);
    }

    public function uploadimagesAction(Request $request)
    {
        if(!isset($_SESSION[self::$temp_dir_lavori]) || $_SESSION[self::$temp_dir_lavori] == "")
            $_SESSION[self::$temp_dir_lavori] = time();

        $options = array(
            'script_url' => $this->response->getProperty("full_url").'/lavori/uploadimages/',
            'upload_dir' => dirname($request->getServerVar('SCRIPT_FILENAME')).'/data/images/lavori/'.$_SESSION[self::$temp_dir_lavori]."/",
            'upload_url' => $this->response->getProperty("full_url").'/data/images/lavori/'.$_SESSION[self::$temp_dir_lavori]."/");

        $upload_handler = new UploadHandler($options);
    }
    public function viewAction (Request $request)
    {
        if($request->is_set("id_lavoro"))
        {
            $id_lavoro = $request -> get("id_lavoro");
            $lavoriDAO = new lavoriDAO($this->connection);
            $this -> response -> setProperty("lavoro",$lavoriDAO -> getLavoroById($id_lavoro));
            $this->includer->includePage(self::$LAVORO_VIEW);
        }
        else
        {
            $this->listAction($request);
        }
    }




}
