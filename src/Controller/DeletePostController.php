<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeletePostController extends AbstractController
{
    /**
     * @Route("/homepage/delete/post/{id}", name="delete_post")
     */
    public function index($id): Response
    {
        $repopost = $this->getDoctrine()->getRepository(Post::class);
        $repotopic = $this->getDoctrine()->getRepository(Topic::class);
        $post = $repopost->findOneBy(['id'=>$id]);

        $em = $this->getDoctrine()->getManager();
        $topicid = $repotopic->findOneBy(['id'=>$post->getTopicId()]);

        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true)) {
            $em->remove($post);
            $em->flush();

            //add +1 in topic table by the topic.
            $repotopic = $this->getDoctrine()->getRepository(Topic::class);
            $topic = $repotopic->findOneBy(array('id' => $post->getTopicId()));
            $currentamount = $topic->getAmountofposts();
            $newamount = $currentamount - 1;
            $topic->setAmountofposts($newamount);
            $em->flush();
        }

        //return $this->redirectToRoute('homepage', ['id' => $post->getTopicId()]);
        return $this->redirectToRoute('topic', ['id'=> $post->getTopicId()]);
    }
}
