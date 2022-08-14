<?php

namespace app\core\base;

use app\core\App;
use app\core\Environment;
use app\core\exception\NotFoundException;
use app\core\helpers\FileHelper;
use JsonException;

abstract class BaseController
{
    public function isUserLoggedIn(): bool
    {
        return (bool) App::currentUser();
    }

    /**
     * @throws NotFoundException
     */
    private function showHtmlFile($htmlFileName): string
    {
        if (file_exists($htmlFileName)) {
            return file_get_contents($htmlFileName);
        }

        $htmlFileNameShort = FileHelper::getFileNameWithoutPath($htmlFileName);
        throw new NotFoundException("File $htmlFileNameShort is not found");
    }

    /**
     * @throws NotFoundException
     */
    public function viewHtml($htmlFileName): string
    {
        $viewPath = __DIR__ . '/../../../' . Environment::getParam(Environment::KEY_VIEW_PATH);
        return $this->showHtmlFile("$viewPath/$htmlFileName.html");
    }

    /**
     * @throws NotFoundException
     */
    private function showTemplate($templateFileName, $data): string
    {
        if (file_exists($templateFileName)) {
            extract($data, EXTR_SKIP);
            return require($templateFileName);
        }

        $templateFileNameShort = FileHelper::getFileNameWithoutPath($templateFileName);
        throw new NotFoundException("Template $templateFileNameShort is not found");
    }

    /**
     * @throws NotFoundException
     */
    public function view($templateName, $data = []): string
    {
        $viewPath = __DIR__ . '/../../../' . Environment::getParam(Environment::KEY_VIEW_PATH);
        return $this->showTemplate("$viewPath/$templateName.php", $data);
    }

    /**
     * @throws JsonException
     */
    public function responseJson($data): string
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_THROW_ON_ERROR);
        return '';
    }

    /**
     * @throws JsonException
     */
    public function responseJsonOk($data = []): string
    {
        $response = ['status' => 'ok'];
        if (!empty($data)) {
            $response['result'] = $data;
        }

        return $this->responseJson($response);
    }

    public function redirect($url): string
    {
        header('location: ' . $url);
        return '';
    }
}
