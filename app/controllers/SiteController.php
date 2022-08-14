<?php /** @noinspection PhpUnused */

namespace app\controllers;

use app\core\App;
use app\core\base\BaseController;
use app\core\base\BaseRoute;
use app\core\Environment;
use app\core\exception\AccessDeniedException;
use app\core\exception\NotFoundException;
use app\core\helpers\ResponseHelper;
use app\core\helpers\StudentsSeeder;
use app\core\WebRequest;
use app\model\LoginForm\LoginForm;
use app\model\LoginForm\LoginFormPopulator;
use app\model\User\User;
use app\model\User\UserService;
use JsonException;

class SiteController extends BaseController
{
    /**
     * @throws NotFoundException
     */
    public function actionHomePage(): string
    {
        if ($this->isUserLoggedIn() || $this->autoLoginByCookieIfAny()) {
            return $this->goDashboard();
        }

        return $this->viewHtml('home');
    }

    /**
     * @param ?WebRequest $request
     * @return string
     */
    public function actionAuth(WebRequest $request): string
    {
        if (!$this->isUserLoggedIn()) {
            if (empty($request->getParams())) {
                return $this->goHome();
            }

            $loginForm = new LoginForm();
            LoginFormPopulator::populateFromRequest($loginForm, $request);

            $loginForm->validate();
            if ($loginForm->hasErrors()) {
                return $this->goHome();
            }

            $isLoggedWithCredentials = UserService::signUserByLoginForm($loginForm);
            if ($isLoggedWithCredentials) {
                if ($loginForm->rememberMe) {
                    App::cookie()->setCurrentUser(App::currentUser());
                } else {
                    App::cookie()->setCurrentUser(null);
                }
            } else {
                $this->autoLoginByCookieIfAny();
            }
        }

        if ($this->isUserLoggedIn()) {
            return $this->goDashboard();
        }

        return $this->goHome();
    }

    /**
     * @throws NotFoundException
     */
    public function actionDashboard(): string
    {
        if (!$this->isUserLoggedIn()) {
            return $this->goHome();
        }

        return $this->view('dashboard');
    }

    /**
     * @throws JsonException
     * @throws AccessDeniedException
     */
    public function actionGetUsersList(WebRequest $request): string
    {
        if (!$this->isUserLoggedIn()) {
            throw new AccessDeniedException();
        }

        $pageSize       = Environment::getParam(Environment::KEY_ITEMS2PAGE, 5);
        $params         = $request->getParams();
        $page           = (int) ($params['page'] ?? 1);

        $studentsList   = StudentsSeeder::getTestUsersData();
        $studentsCount  = count($studentsList);
        $pagesCount     = ceil($studentsCount / $pageSize);

        return $this->responseJsonOk([
            'items' => $studentsList,
            'page'  => [
                'index' => $page,
                'count' => $pagesCount
            ]
        ]);
    }

    /**
     * @throws JsonException
     */
    public function actionDeleteAuth(): string
    {
        App::userStorage()->setCurrentUser(null);
        App::cookie()->setCurrentUser(null);

        return $this->responseJsonOk();
    }

    /**
     * @throws NotFoundException
     */
    public function actionPageNotFound(): string
    {
        return $this->viewHtml('not-found');
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function actionFileNotFound(WebRequest $request, BaseRoute $route): string
    {
        return ResponseHelper::showHeaders($route->getHeaders());
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function actionAccessDenied(WebRequest $request, BaseRoute $route): string
    {
        return ResponseHelper::showHeaders($route->getHeaders());
    }

    private function goHome(): string
    {
        return $this->redirect('/');
    }

    private function goDashboard(): string
    {
        return $this->redirect('/dashboard');
    }

    private function autoLoginByCookieIfAny(): ?User
    {
        if ($user = App::cookie()->getCurrentUser()) {
            App::loginAs($user);
        }

        return $user;
    }
}
