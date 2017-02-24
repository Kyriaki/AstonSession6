<?php

namespace IKNSA\PostBundle\Controller;

use IKNSA\PostBundle\Entity\Post;
use IKNSA\PostBundle\Entity\Comments;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{
    /**
     * Lists all post entities.
     *
     */

    public function ajaxAction(Request $request)
    {
        if($request->isXMLHttpRequest()){
            $db = $this->get('database_connection');
            $query = "select * from post";
            $rows = $db->fetchAll($query);
            return new JsonResponse(array('data' => json_encode($rows)));
        }
        return new Response("Ajax request error", 400);
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $size = 0;
        $allPosts = $em->getRepository('IKNSAPostBundle:Post')->findAll();

        foreach ($allPosts as $post) {
            $size++;
        }

        for($i=$size-3; $i<$size; $i++){
            $posts[$i] = $allPosts[$i];
        }
    
        return $this->render('IKNSAPostBundle::index.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Creates a new post entity.
     *
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('IKNSA\PostBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if(!$this->getUser()){
            $this->addFlash('notice', 'You must be identified to access this section');
            return $this->redirectToRoute('post_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setUser($this->getUser());
            $post->setAuthor($this->getUser());
            $em->persist($post);
            $em->flush($post);

            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }



        return $this->render('IKNSAPostBundle::new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a post entity.
     *
     */
    public function showAction(Request $request, Post $post)
    {
        
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($post);

        $comments = new Comments();
        $commentForm = $this->createForm('IKNSA\PostBundle\Form\CommentsType', $comments);        
        $commentForm->handleRequest($request);

        if(!$this->getUser()){
            $this->addFlash('notice', 'You must be identified to access this section');
            return $this->redirectToRoute('post_index');
        }

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $comments->setUser($this->getUser());
            $comments->setAuthor($this->getUser());
            $comments->setPost($post);
            $em->persist($comments);
            $em->flush($comments);

            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }

        $allComments = $em->getRepository('IKNSAPostBundle:Comments')->findAll();

        $i=0;
        foreach($allComments as $comment){
            $deleteComment = $this->createDeleteComment($comment, $post);
        }

        return $this->render('IKNSAPostBundle::show.html.twig', array(
            'post' => $post,
            'comments' => $allComments,
            'delete_form' => $deleteForm->createView(),
            'delete_comment' => $deleteComment->createView(),
            'comment_form' => $commentForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     */
    public function editAction(Request $request, Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('IKNSA\PostBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if(!$this->getUser()){
            $this->addFlash('notice', 'You must be identified to access this section');
            return $this->redirectToRoute('post_index');
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_edit', array('id' => $post->getId()));
        }

        return $this->render('IKNSAPostBundle::edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if(!$this->getUser()){
            $this->addFlash('notice', 'You must be identified to access this section');
            return $this->redirectToRoute('post_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush($post);
        }

        return $this->redirectToRoute('post_index');
    }

    public function deleteCommentAction(Request $request, Comments $comment, Post $post)
    {

        $form = $this->createDeleteComment($comment, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush($comment);
        }

        return $this->redirectToRoute('post_show', array('id' => $post->getId()));
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
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

    /**
     * Creates a form to delete a post entity.
     *
     * @param Comments $comment The comment entity
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteComment(Comments $comment, Post $post)
    {   
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId(), 'post_id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
