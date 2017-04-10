<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DefaultController extends Controller
{

    /**
     * @Route("/users")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {

    }

    /**
     * @Route("/users/{id}")
     * @Method({"GET","HEAD"})
     */
    public function showAction($id)
    {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:Users')
            ->find($id);

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($user, 'json'));
        return $response;
    }

    /**
     * @Route("/users")
     * @Method({"POST"})
     */
    public function postAction()
    {

    }

    /**
     * @Route("/users/{id}")
     * @Method({"PUT"})
     */
    public function updateAction($id)
    {

    }

    /**
     * @Route("/users/{id}")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {

    }
}
