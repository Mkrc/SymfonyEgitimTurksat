<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use BlogBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;

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

        $posts = $this->getDoctrine()
            ->getRepository('BlogBundle:BlogPost')->getAllPosts();

        return $this->render('BlogBundle:Default:blog_detail.html.twig',
            array('post' => $post, 'other_posts' => $posts));
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

    public function formAction(Request $request) {

        $form = $this->createFormBuilder(null, array('csrf_protection' => false))
            ->add('title', TextType::class, array('label' => 'Title'))
            ->add('content', TextareaType::class)
            ->add('status', ChoiceType::class, array(
                'choices'  => array(
                    'Passive' => 0,
                    'Active' => 1,
                    'Canceled' => -1,
                ),
                'required' => true,
            ))
            ->add('save', SubmitType::class, array('label' => 'Create Post'))
            ->getForm();

        $form->handleRequest($request);

        $render = array(
            'form' => $form->createView(),
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $render['formData'] = $form->getData();
        }
        
        return $this->render('BlogBundle:Default:form.html.twig', $render);
    }
}
