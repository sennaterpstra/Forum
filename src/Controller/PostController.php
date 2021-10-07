<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\CreatePostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PostController extends AbstractController
{
    /**
     * @Route("/homepage/{id}", name="topic")
     */
    public function index(Request $request, UserInterface $user, string $id): Response
    {
        $post = new Post();
        $form = $this->createForm(CreatePostType::class, $post);

        $repotopic = $this->getDoctrine()->getRepository(Topic::class);
        $topic = $repotopic->findOneBy([
            'id' => $id,
        ]);

        $repo = $this->getDoctrine()->getRepository(Post::class);

        $posts = $repo->findBy(array('topic_id' => $topic->getId()));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $post->setUserId($user->getUserId());
            $post->setCreatedAt(time());
            $post->setTopicId($topic->getId());
            $post->setUsername($user->getUserIdentifier());

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            //add +1 in topic table by the topic.
            $repotopic = $this->getDoctrine()->getRepository(Topic::class);
            $topic = $repotopic->findOneBy(array('id' => $post->getTopicId()));
            $currentamount = $topic->getAmountofposts();
            $newamount = $currentamount + 1;
            $topic->setAmountofposts($newamount);
            $em->flush();

            unset($post);
            unset($form);
            $post = new Post();
            $form = $this->createForm(CreatePostType::class, $post);

            return $this->redirectToRoute('topic', ['id'=> $id]);
        }

        return $this->renderForm('post/index.html.twig', [
            'posts' => $posts,
            'form' => $form,
            'topic' => $topic,
        ]);
    }
}
