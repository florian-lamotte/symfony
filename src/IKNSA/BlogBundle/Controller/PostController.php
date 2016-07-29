<?php

namespace IKNSA\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use IKNSA\BlogBundle\Entity\Post;
use IKNSA\BlogBundle\Entity\Comment;
use IKNSA\BlogBundle\Form\PostType;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('IKNSABlogBundle:Post')->getLastInserted('IKNSABlogBundle:Post', 3);

        return $this->render('IKNSABlogBundle:post:index.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Creates a new Post entity.
     *
     */
    public function newAction(Request $request)
    {
        $post = new Post(); // initialise la classe Post de IKNSA/BlogBundle/Entity/Post.php
        // créé le formulaire à partir des champs demandés dans PostType.php et de la classe Post
        $form = $this->createForm('IKNSA\BlogBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setUser($this->getUser()); // mémorise le nom de l'utilisateur qui veux créer le post
            $em->persist($post);
            $em->flush(); // exécute les requêtes

            return $this->redirectToRoute('post_show', array('id' => $post->getId())); // redirection sur le post créé
        }

        if(!$this->getUser()) {
            $this->addFlash('notice', 'You must be identified to access this section');
            return $this->redirectToRoute('post_index');
        }

        // lance le template new.html.twig avec form en variable supplémentaire
        return $this->render('IKNSABlogBundle:post:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     */
    public function showAction(Request $request, Post $post)
    {
        $comment = new Comment();
        $form = $this->createForm('IKNSA\BlogBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setUser($this->getUser());
            $comment->setPost($post);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }

        $deleteForm = $this->createDeleteForm($post);

        $com = $this->getDoctrine()->getManager();
        $comments = $com->getRepository('IKNSABlogBundle:Comment')
                        ->getSelect($post->getId());

        return $this->render('IKNSABlogBundle:post:show.html.twig', array(
            'post' => $post,
            'comments' => $comments,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     */
    public function editAction(Request $request, Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('IKNSA\BlogBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_edit', array('id' => $post->getId()));
        }

        return $this->render('IKNSABlogBundle:post:edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Post entity.
     *
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('post_index');
    }

    /**
     * Creates a form to delete a Post entity.
     *
     * @param Post $post The Post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('post_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function apiIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('IKNSABlogBundle:Post')->getLastInserted('IKNSABlogBundle:Post', 3);
        
        return new JsonResponse(array(
            'posts' => $posts
        ));
    }

    public function apiShowAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('IKNSABlogBundle:Post')->getLastInserted('IKNSABlogBundle:Post', 3);
        
        return new JsonResponse(array(
            'posts' => $posts,
        ));
    }
}
