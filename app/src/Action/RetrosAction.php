<?php
namespace App\Action;

use Slim\Views\Twig;
use App\Models\Retro;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Log\LoggerInterface;

final class RetrosAction
{
    private $view;
    private $logger;

    /**
     * @param Twig $view
     * @param LoggerInterface $logger
     */
    public function __construct(Twig $view, LoggerInterface $logger)
    {
        $this->view = $view;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $this->logger->info("Retros page action dispatched");

        $retros = $this->displayRetros($request->getUri()->getBasePath());
        $random = Retro::getRandom();

        $this->view->render($response, 'retros.twig', [
            'random' => $random['id'],
            'retroName' => $random['retroName'],
            'retros' => $retros
        ]);

        return $response;
    }

    private function displayRetros($url)
    {
        $retros = Retro::getRetros();

        $html = '<ul>';
        foreach ($retros as $id => $name) {
            $html .= '<li><a href="' . $url . '/retro/' . $id . '">' . $name . '</a></li>';
        }

        $html .= '</ul>';

        return $html;
    }

    /**
    * @param Request $request
    */
    public function addRetro(Request $request)
    {
        $requestData = $request->getParsedBody();

        Retro::saveRetro(
            $requestData['retroName'],
            $requestData['retroDescription']
        );
    }

    /**
    * @param Request $request
    */
    public function deleteRetro(Request $request)
    {
        Retro::deleteRetro(
            $requestData['id']
        );
    }

    /**
    * @param Request $request
    */
    public function getRetro(Request $request, Response $response)
    {
        $requestData = implode($request->getAttribute('routeInfo')[2]);

        $data = Retro::getRetro($requestData);

        $this->view->render($response, 'retro.twig', [
            'Name' => $data['retro_name'],
            'Description' => $data['retro_description']
        ]);

        return $response;
    }
}
