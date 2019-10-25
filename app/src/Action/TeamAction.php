<?php
namespace App\Action;

use Slim\Views\Twig;
use App\Models\Team;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Log\LoggerInterface;

final class TeamAction
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
        $this->logger->info("Team page action dispatched");

        $teams = Team::getAll();

        $this->view->render($response, 'team.twig', $teams);

        return $response;
    }

    /**
    * @param Request $request
    */
    public function add(Request $request)
    {
        $requestData = $request->getParsedBody();

        Team::add($requestData['teamName']);
    }
}
