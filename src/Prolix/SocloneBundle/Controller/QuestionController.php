<?php

namespace Prolix\SocloneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MakerLabs\PagerBundle\Pager;
use MakerLabs\PagerBundle\Adapter\DoctrineOrmAdapter;

class QuestionController extends Controller
{
    public function indexAction($page, $limit)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $qb = $em->getRepository('ProlixSocloneBundle:Question')->createQueryBuilder('q');

        return $this->render('ProlixSocloneBundle:Question:index.html.twig', array(
            'pager' => $pager
        ));
    }

    /**
     * Show a question entry
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $question = $em->getRepository('ProlixSocloneBundle:Question')->find($id);

        if (!$question) {
            throw $this->createNotFoundException('Unable to find Question to show.');
        }

        return $this->render('SocloneBundle:Question:show.html.twig', array(
            'questions'      => $question,
        ));
    }
}
