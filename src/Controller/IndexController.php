<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class IndexController extends AbstractController
{

    function getData($url) {

        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
            throw new NotFoundHttpException("Try again later!");
        } else {
            return $content = $response->getContent();
        }

    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', array(
            'content' => json_decode($this->getData('https://www.openligadb.de/api/getmatchdata/bl1'))
        ));
    }

    /**
     * @Route("/alleSaisonSpiele", name="alleSaisonSpiele")
     */
    public function alleSaisonSpiele()
    {
        return $this->render('alleSaisonSpiele.html.twig', array(
            'content' => json_decode($this->getData('https://www.openligadb.de/api/getmatchdata/bl1/2019'))
        ));
    }

    /**
     * @Route("/goalGetter", name="goalGetter")
     */
    public function goalGetter()
    {
        return $this->render('goalGetter.html.twig', array(
            'content' => json_decode($this->getData('https://www.openligadb.de/api/getgoalgetters/bl1/2019'))
        ));
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request)
    {
        if ($searchValue = $request->request->get('searchValue')) {
            return $this->render('goalGetter.html.twig', array(
                'content' => json_decode($this->getData('https://www.openligadb.de/api/getgoalgetters/bl1/2019')),
                'name' => $searchValue
            ));
        } else {
            throw new \Exception('Please check your input!');
        }
    }

    /**
     * @Route("/listGoalGetter", name="listGoalGetter")
     */
    public function listGoalGetter()
    {
        return $this->render('listGoalGetter.html.twig', array(
            'content' => json_decode($this->getData('https://www.openligadb.de/api/getgoalgetters/bl1/2019'))
        ));
    }
}
