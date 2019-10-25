<?php
namespace App\Action;

use Slim\Views\Twig;
use App\Models\Team;
use App\Models\Image;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Question;
use Psr\Log\LoggerInterface;

final class DoodleAction
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
        $this->logger->info("Doodle page action dispatched");

        $this->view->render($response, 'doodle.twig');

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return string
     */
    public function getDoodleData(Request $request, Response $response)
    {
        $questions = Question::getAllQuestions();

        $teams = Team::getAllTeams();

        $data = array_merge($questions, $teams);

        return $this->view->render($response, 'doodle.twig', $data);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function uploadDrawings(Request $request)
    {
        $requestData = $request->getParsedBody();

        Image::saveDoodle(
            $requestData['image'],
            $requestData['name'],
            $requestData['teamName'],
            $requestData['team'],
            $requestData['question']
        );
    }
}
