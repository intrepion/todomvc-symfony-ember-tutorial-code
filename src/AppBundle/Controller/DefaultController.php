<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
<<<<<<< HEAD
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
=======
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

>>>>>>> a112b0bb58c938271078e9d7ed7640f3f71afb94
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
<<<<<<< HEAD
=======

    /**
     * @Route("/login_check", name="security_login_check")
     * @codeCoverageIgnore
     */
    public function loginCheckAction()
    {
        // will never be executed
    }
>>>>>>> a112b0bb58c938271078e9d7ed7640f3f71afb94
}
