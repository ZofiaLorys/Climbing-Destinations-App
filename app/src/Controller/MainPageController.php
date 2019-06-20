<?php
/**
 * MainPage controller.
 */

namespace App\Controller;

use App\Entity\Destination;
use App\Repository\DestinationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainPageController.
 *
 */
class MainPageController extends AbstractController
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
     *     name="MainPage_index",
     * )
     */
    public function index(Request $request, DestinationRepository $repository, PaginatorInterface $paginator): Response
    {
        if($this->isGranted('ROLE_USER')){
            return $this->redirectToRoute('destination_index');
        }

        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            Destination::NUMBER_OF_ITEMS
        );

        return $this->render(
            'index.html.twig',
            ['pagination' => $pagination]
        );
    }









}