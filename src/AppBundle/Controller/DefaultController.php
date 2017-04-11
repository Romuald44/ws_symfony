<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:Users')
            ->findAll();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($user, 'json'));
        return $response;
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
    public function postAction(Request $request)
    {
        $user = new Users();
        $user->setUsername($request->get('username'));
        $user->setUserEmail($request->get('user_email'));
        $user->setUserRole($request->get('user_role'));
        $user->setUserStatus($request->get('user_status'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent('Enregistrement : '.$serializer->serialize($user, 'json'));
        return $response;
    }

    /**
     * @Route("/users/{id}")
     * @Method({"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:Users')
            ->find($id);

        $user->setUsername($request->get('username'));
        $user->setUserEmail($request->get('user_email'));
        $user->setUserRole($request->get('user_role'));
        $user->setUserStatus($request->get('user_status'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent('Mise a jour : '.$serializer->serialize($user, 'json'));
        return $response;
    }

    /**
     * @Route("/users/{id}")
     * @Method({"DELETE"})
     */
    public function deleteAction($id)
    {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:Users')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $response = new Response();
        $response->setContent('Suppression de l\'enregistrement numero : '.$id);
        return $response;
    }
}
