<?php

namespace Prolix\SocloneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function indexAction()
    {
        $questions = $this->getDoctrine()
                     ->getRepository('ProlixSocloneBundle:Question')
                     ->getLatestQuestions();

        return $this->render('ProlixSocloneBundle:Homepage:index.html.twig', array(
            'questions' => $questions
        ));
    }
}
