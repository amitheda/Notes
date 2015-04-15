<?php
namespace Notes\Controller\Web;

use Notes\View\View as View;
use Notes\Service\Session as SessionService;
use Notes\Model\Session as SessionModel;
use Notes\Response\Response as Response;
use Notes\Request\Request as Request;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Session
{
    protected $request;
    protected $view;
    public function __construct($request)
    {
        $this->request = $request;
        $this->view    = new View();
    }
    public function get()
    {
        $this->view->render("Login.php");
    }
    
    public function post()
    {
        $input          = $this->request->getUrlParams();
        $sessionService = new SessionService();
        try {
            $response = $sessionService->login($input);
            
        } catch (\InvalidArgumentException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response($response);
            $this->view->render("Login.php", $objResponse->getResponse());
        } catch (ModelNotFoundException $error) {
            $response    = $error->getMessage();
            $objResponse = new Response($response);
            $this->view->render("Login.php", $objResponse->getResponse());
        }
        if ($response instanceof SessionModel) {
            setcookie('userId', $response->getUserId(), time() + (86400 * 30), "/");
            setcookie('authToken', $response->getAuthToken(), time() + (86400 * 30), "/");
            header('Location: notes');
            exit();
        }
    }
    
    public function logout()
    {
        $sessionModel = new SessionModel();
        $sessionModel->setUserId($this->request->getCookies()['userId']);
        $sessionModel->setAuthToken($this->request->getCookies()['authToken']);
        
        $sessionService = new SessionService();
        if ($sessionService->isValid($sessionModel)) {
            $sessionModel->setIsExpired(1);
            $response = $sessionService->logout($sessionModel);
        }
        if ($response instanceof SessionModel) {
            echo '<script language="javascript">location.href="http://notes.com/login";</script>';
        }
    }
}
