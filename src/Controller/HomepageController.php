<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\CreateTopicType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class HomepageController extends AbstractController
{
    /**
     * @Route("/homepage", name="homepage")
     */
    public function index(Request $request, UserInterface $user): Response
    {
        $repo = $this->getDoctrine()->getRepository(Topic::class);
        $topics = $repo->findAll();
        $getuser = $this->getUser();

        $topic = new Topic();
        $form = $this->createForm(CreateTopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topic = $form->getData();

            $topic->setCreatedAt(time());
            $topic->setAmountofposts(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('homepage/index.html.twig', [
            'topics' => $topics,
            'user'=> $getuser,
            'form'=> $form->createView()
        ]);
    }
}
