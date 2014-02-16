<?php

namespace Afup\DirectoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Template()
     * @Route("/")
     */
    public function indexAction()
    {
        return array('companies' => $this->getDoctrine()->getManager()->getRepository('AfupDirectoryBundle:Member')->findAll());
    }
}
