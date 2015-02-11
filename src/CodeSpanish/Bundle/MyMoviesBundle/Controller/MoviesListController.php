<?php

namespace CodeSpanish\Bundle\MyMoviesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CodeSpanish\Bundle\MyMoviesBundle\Entity\MoviesList;
use CodeSpanish\Bundle\MyMoviesBundle\Form\MoviesListType;

/**
 * MoviesList controller.
 *
 * @Route("/movieslist")
 */
class MoviesListController extends Controller
{

    /**
     * Lists all MoviesList entities.
     *
     * @Route("/", name="movieslist")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CodeSpanishMyMoviesBundle:MoviesList')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MoviesList entity.
     *
     * @Route("/", name="movieslist_create")
     * @Method("POST")
     * @Template("CodeSpanishMyMoviesBundle:MoviesList:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MoviesList();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('movieslist_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MoviesList entity.
     *
     * @param MoviesList $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MoviesList $entity)
    {
        $form = $this->createForm(new MoviesListType(), $entity, array(
            'action' => $this->generateUrl('movieslist_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MoviesList entity.
     *
     * @Route("/new", name="movieslist_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MoviesList();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MoviesList entity.
     *
     * @Route("/{id}", name="movieslist_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CodeSpanishMyMoviesBundle:MoviesList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MoviesList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MoviesList entity.
     *
     * @Route("/{id}/edit", name="movieslist_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CodeSpanishMyMoviesBundle:MoviesList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MoviesList entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a MoviesList entity.
    *
    * @param MoviesList $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MoviesList $entity)
    {
        $form = $this->createForm(new MoviesListType(), $entity, array(
            'action' => $this->generateUrl('movieslist_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MoviesList entity.
     *
     * @Route("/{id}", name="movieslist_update")
     * @Method("PUT")
     * @Template("CodeSpanishMyMoviesBundle:MoviesList:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CodeSpanishMyMoviesBundle:MoviesList')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MoviesList entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('movieslist_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MoviesList entity.
     *
     * @Route("/{id}", name="movieslist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CodeSpanishMyMoviesBundle:MoviesList')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MoviesList entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('movieslist'));
    }

    /**
     * Creates a form to delete a MoviesList entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movieslist_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
