<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Comment controller.
 *
 * @Route("comments")
 */
class CommentsController extends Controller
{
    /**
     * Lists all comment entities.
     *
     * @Route("/", name="comments_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('AppBundle:Comments')->findAll();

        return $this->render('comments/index.html.twig', array(
            'comments' => $comments,
        ));
    }

    /**
     * Creates a new comment entity.
     *
     * @Route("/new", name="comments_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $comment = new Comments();
            $comment->setAuthor($request->request->get('author'));
            $comment->setContent($request->request->get('content'));
            $comment->setType($request->request->get('type'));
            $comment->setEntityId($request->request->get('entity_id'));
            $comment->setCreatedAt(new \DateTime('now'));

            $validator = $this->get('validator');
            $errors = $validator->validate($comment);
            if(count($errors)){
                $messages = [];
                foreach ($errors as $violation) {
                    $messages[$violation->getPropertyPath()] = $violation->getMessage();
                }
                return new JsonResponse(['error'=>1, 'messages'=>$messages]);
            }else{

                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                return new JsonResponse([
                    'error'=>0,
                    'template'=>$this->renderView('comments/show.html.twig',[
                        'author'=>$request->request->get('author'),
                        'content'=>$request->request->get('content')
                    ])
                ]);

            }
        }
    }

    /**
     * Finds and displays a comment entity.
     *
     * @Route("/{id}", name="comments_show")
     * @Method("GET")
     */
    public function showAction(Comments $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('comments/show.html.twig', array(
            'comment' => $comment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing comment entity.
     *
     * @Route("/{id}/edit", name="comments_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comments $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('AppBundle\Form\CommentsType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_edit', array('id' => $comment->getId()));
        }

        return $this->render('comments/edit.html.twig', array(
            'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a comment entity.
     *
     * @Route("/{id}", name="comments_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comments $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comments_index');
    }

    /**
     * Creates a form to delete a comment entity.
     *
     * @param Comments $comment The comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comments $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comments_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
