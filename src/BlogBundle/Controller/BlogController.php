<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use BlogBundle\Entity\Category;

class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig', array('name' => 'Mehmet'));
    }

    public function detailAction($Id)
    {
        $post = $this->getDoctrine()
            ->getRepository('BlogBundle:BlogPost')->find($Id);

        return $this->render('BlogBundle:Default:blog_detail.html.twig', array('post' => $post));
    }

    public function createAction()
    {

        $post = new BlogPost();
        $post->setTitle("Örnek Post");
        $post->setContent("Örnek İçerik 2");
        $post->setCreatedAt(new \DateTime());

        $categoryRepository = $this->getDoctrine()->getRepository("BlogBundle:Category");

        /** @var Category $category1 */
        $category1 = $categoryRepository->find(1);

        /** @var Category $category2 */
        $category2 = $categoryRepository->find(2);

        dump($category1);
        dump($category2);

        $post->addCategories($category1);
        $post->addCategories($category2);

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        dump($post);

        return new JsonResponse(array('status' => 'ok'));
    }
}
