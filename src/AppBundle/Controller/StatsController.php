<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Stats;


class StatsController  extends Controller
{

    public function indexAction()
    {
        $browsers = $this->getDoctrine()->getManager()->getRepository(Stats::class)->getBrowsers();

        return $this->render(
            'stats/index.html.twig',
            ['browsers' => $browsers]
        );
    }

}