<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 18/10/14
 * To change this template use File | Settings | File Templates.
 */
class SettingsController extends  AbstractController
{
    private static $VIEW_SETTINGS = "admin_settings";

    public function __construct()
    {
        $this->className = get_class($this);
        $this->livelloPagina = self::$LIVELLO_ADM;
    }

    public function viewAction(Request $request)
    {

        $adminDAO = new adminDAO($this->connection);
        $settingsDAO = new settingsDAO($this->connection);

        $this -> response -> setProperty("admins",$adminDAO -> getAllAdmin());
        $this -> response -> setProperty("settings",initConfig::getInstance()->getSettings());

        $this->includer->includePage(self::$VIEW_SETTINGS);
    }


    public function updateAction(Request $request)
    {

        if($request ->is_set('values') && $request->is_set('keys'))
        {
                $path ="";
                $adminDAO = new adminDAO($this->connection);
                $settingsDAO = new settingsDAO($this->connection);

                $this -> response -> setProperty("admins",$adminDAO -> getAllAdmin());
                $this -> response -> setProperty("settings",initConfig::getInstance()->getSettings());

                $settings = initConfig::getInstance()->getSettings();
                $keys = $request->get('keys');
                $values = $request->get('values');
                for($i = 0; $i < count($keys); $i++)
                {

                    if($keys[$i] == "show_logo" && $values[$i] == "true")
                    {

                        $immagine = $_FILES['file_logo'];
                        if($immagine != null && $immagine["size"]!=0)
                        {


                            //controllo che nell'upload non ci siano errori
                            if($immagine['error'] == 0)
                            {
                                $nomeFile = strtolower($immagine['name']);
                                $milliseconds = round(microtime(true) * 1000);

                                $flagExtention = false;
                                $ext = substr($nomeFile,$this->backwardStrpos($nomeFile,".",0)+1, strlen($nomeFile));
                                $extArray = explode(",", $settings['file_allowed_ext']);


                                if(array_search($ext, $extArray) === false)
                                {
                                    $errorMessage = "Logo con estensione .".$ext." non consentito";
                                    $this -> response -> setError("errorMessage", $errorMessage);
                                    $this->includer->includePage(self::$VIEW_SETTINGS);
                                    break;
                                }

                                $tempFile = $this -> ridimensionaFile($immagine['tmp_name'],$ext,700);

                                copy($tempFile, "./../images/loghi/".$milliseconds.".".$ext);
                                unlink($tempFile);
                                $path = "images/loghi/".$milliseconds.".".$ext;
                                Logger::log(Logger::$DEBUG,"Logo caricate con successo!");
                            }
                            else
                            {
                                Logger::log(Logger::$ERROR,"Errore caricamento del logo");
                                $errorMessage = "Errore caricamento del logo ";

                                $this -> response -> setError("errorMessage", $errorMessage);
                                $this->includer->includePage(self::$VIEW_SETTINGS);
                                break;

                            }

                            if($path== null || strlen($path)==0)
                            {
                                Logger::log(Logger::$ERROR,"Errore caricamento del logo");
                                $errorMessage = "Errore caricamento del logo ";
                                $this -> response -> setError("errorMessage", $errorMessage);
                                $this->includer->includePage(self::$VIEW_SETTINGS);
                                break;
                            }

                        }
                    }
                }
                for($i = 0; $i < count($values); $i++)
                {
                    //$values[$i] = $values[$i];

                }
                for($i = 0; $i < count($keys); $i++)
                {
                    if($keys[$i] == "logo_path" && $path != "")
                    {
                        $values[$i] = $path;
                    }
                    if(!$settingsDAO -> updateSettings($keys[$i], $values[$i]))
                    {
                        $errorMessage = "Problema con l'update del campo : ".$keys[$i]." con valore :".$values[$i];
                        $this -> response -> setError("errorMessage", $errorMessage);
                        $this->includer->includePage(self::$VIEW_SETTINGS);
                        break;
                    }
                }

                initConfig::getInstance()->updateSettings();
                $this -> response -> setProperty("settings",initConfig::getInstance()->getSettings());
                $message = "Salvataggio Effettuato!";
                $this -> response -> setProperty("message", $message);
                $this->includer->includePage(self::$VIEW_SETTINGS);
                return;
            }
            else
            {
                $errorMessage = "Parametri mancanti!";
                $this -> response -> setError("errorMessage", $errorMessage);
                $this->includer->includePage(self::$VIEW_SETTINGS);
                return;
            }
    }


    public function adduserAction(Request $request)
    {

        if($request ->is_set('password') && $request->is_set('username'))
        {
            $username = $request->get('username');
            $password = $request->get('password');
            if(strlen($username) < 3 || strlen($password[0]) < 3 || strlen($password[1]) < 3)
            {
                $errorMessage = "Parametri troppo corti controllare!";
                $this -> response -> setError("errorMessage", $errorMessage);
                $this->viewAction($request);
                return;
            }
            else
            {
                $adminDAO = new adminDAO($this->connection);
                $resulSet = $adminDAO->getAdminByUser($username);

                if($resulSet)
                {
                    $errorMessage = "Utente esistente!";
                    $this -> response -> setError("errorMessage", $errorMessage);
                    $this->viewAction($request);
                    return;
                }
                else
                {

                    if($password[0] != $password[1])
                    {
                        $errorMessage = "Le password non combaciano!";
                        $this -> response -> setError("errorMessage", $errorMessage);
                        $this->viewAction($request);
                        return;
                    }
                    else
                    {
                        if($adminDAO -> insertAdmin($username,md5($password[0])))
                        {
                            $message = "Utente Aggiunto!";
                            $this -> response -> setProperty("message", $message);
                            $this->viewAction($request);
                            return;
                        }
                        else
                        {
                            $errorMessage = "Impossibile inserire l'utente!";
                            $this -> response -> setError("errorMessage", $errorMessage);
                            $this->viewAction($request);
                            return;
                        }
                    }
                }
            }

        }
        else
        {
            $errorMessage = " Parametri mancanti per l'inserimento di un utenti";
            $this -> response -> setError("errorMessage", $errorMessage);
            $this->viewAction($request);
            return;
        }
    }

    public function changepasswordAction(Request $request)
    {

        if($request ->is_set('password') && $request->is_set('username'))
        {
            $username = $request->get('username');
            $password = $request->get('password');
            if(strlen($username) < 3 || strlen($password[0]) < 3 || strlen($password[1]) < 3)
            {
                $errorMessage = "Parametri troppo corti controllare!";
                $this -> response -> setError("errorMessage", $errorMessage);
                $this->viewAction($request);
                return;
            }
            else
            {
                $adminDAO = new adminDAO(initConfig::getInstance()->getConnect());
                $resulSet = $adminDAO->getAdminByUser($username);

                if(!$resulSet)
                {
                    $errorMessage = "Utente inesistente!";
                    $this -> response -> setError("errorMessage", $errorMessage);
                    $this->viewAction($request);
                    return;
                }
                else
                {

                    if($password[0] != $password[1])
                    {
                        $errorMessage = "Le password non combaciano!";
                        $this -> response -> setError("errorMessage", $errorMessage);
                        $this->viewAction($request);
                        return;
                    }
                    else
                    {
                        if($adminDAO -> updateAdmin($username,md5($password[0])))
                        {
                            $message = "Utente Aggiornato!";
                            $this -> response -> setProperty("message", $message);
                            $this->viewAction($request);
                            return;
                        }
                        else
                        {
                            $errorMessage = "Impossibile aggiornare utente!";
                            $this -> response -> setError("errorMessage", $errorMessage);
                            $this->viewAction($request);
                            return;
                        }
                    }
                }
            }
        }
        else
        {
            $errorMessage = " Parametri mancanti per la modifica della password!";
            $this -> response -> setError("errorMessage", $errorMessage);
            $this->viewAction($request);
            return;
        }
    }
}
