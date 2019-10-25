<?php
namespace App\Action;

use Slim\Views\Twig;
use App\Models\Team;
use App\Models\Image;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Question;
use Psr\Log\LoggerInterface;

final class DoodlesAction
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
        $this->logger->info("Doodles page action dispatched");

        $this->view->render($response, 'doodles.twig');

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return string
     */
    public function getDoodlesData(Request $request, Response $response)
    {
        $data = Team::getAllTeams();

        return $this->view->render($response, 'doodles.twig', $data);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return string json response
     */
    public function getDates(Request $request, Response $response)
    {
        $requestData = $request->getParsedBody();

        $data = Image::getAllDates($requestData['id']);

        return $response->withJson($data);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return string json response
     */
    public function getQuestions(Request $request, Response $response)
    {
        $requestData = $request->getParsedBody();

        $data = Question::getQuestions($requestData['date']);

        return $response->withJson($data);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return string json response
     */
    public function getDrawings(Request $request, Response $response)
    {
        $requestData = $request->getParsedBody();

        return $response->withJson(
            glob(
                'uploads/' . $requestData['team'] . '/' . $requestData['date'] . '/question' . $requestData['id'] . '/*.png'
            )
        );
    }
}
