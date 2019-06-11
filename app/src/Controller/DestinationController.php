<?php
/**
 * Destination controller.
 */

namespace App\Controller;

use App\Entity\Destination;
use App\Form\DestinationType;
use App\Form\DestinationTypeNew;
use App\Repository\DestinationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class DestinationController.
 *
 * @Route("/destination")
 */
class DestinationController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\DestinationRepository $repository Repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator  Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="destination_index",
     * )
     */
    public function index(Request $request, DestinationRepository $repository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
           # $repository->average_destination(),
            $request->query->getInt('page', 1),
            Destination::NUMBER_OF_ITEMS
        );

        return $this->render(
            'destination/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * IndexByAuthor action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\DestinationRepository $repository Repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator  Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/by_author",
     *     name="destination_index_by_author",
     * )
     */
    public function indexbyauthor(Request $request, DestinationRepository $repository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryByAuthor($this->getUser()),
            $request->query->getInt('page', 1),
            Destination::NUMBER_OF_ITEMS
        );

        return $this->render(
            'destination/index.html.twig',
            ['pagination' => $pagination]
        );
    }



    /**
     * View action.
     *
     * @param \App\Entity\Destination $destination Destination entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     name="destination_view",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function view(Destination $destination): Response
    {
        return $this->render(
            'destination/view.html.twig',
            ['destination' => $destination]
        );
    }

    /**
     * New action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\DestinationRepository            $repository Destination repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/new",
     *     methods={"GET", "POST"},
     *     name="destination_new",
     * )
     */
    public function new(Request $request, DestinationRepository $repository): Response
    {

        $destination = new Destination();
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $destination->setAuthor($this->getUser());
            $repository->save($destination);

            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('destination_index');
        }

        return $this->render(
            'destination/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Destination                          $destination       Destination entity
     * @param \App\Repository\DestinationRepository            $repository Destination repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="destination_edit",
     * )
     */
    public function edit(Request $request, Destination $destination, DestinationRepository $repository): Response
    {
        if (($destination->getAuthor() !== $this->getUser()) || !($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))) {

            $form = $this->createForm(DestinationType::class, $destination, ['method' => 'PUT']);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $repository->save($destination);

                $this->addFlash('success', 'message.updated_successfully');

                return $this->redirectToRoute('destination_index');
            }

            return $this->render(
                'destination/edit.html.twig',
                [
                    'form' => $form->createView(),
                    'destination' => $destination,
                ]
            );

        } else {
            $this->addFlash('warning', 'message.item_not_found');
            return $this->redirectToRoute('destination_index');
        }


    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Destination                          $destination       Destination entity
     * @param \App\Repository\DestinationRepository            $repository Destination repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="destination_delete",
     * )
     */
    public function delete(Request $request, Destination $destination, DestinationRepository $repository): Response
    {

        if ($destination->getAuthor() !== $this->getUser() or isGranted('ROLE_ADMIN')) {
            $this->addFlash('warning', 'message.item_not_found');
            return $this->redirectToRoute('destination_index');
        }

        $form = $this->createForm(FormType::class, $destination, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($destination);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('destination_index');
        }

        return $this->render(
            'destination/delete.html.twig',
            [
                'form' => $form->createView(),
                'destination' => $destination,
            ]
        );
    }
}