<?php
/**
 * Country controller.
 */

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CountryController.
 *
 * @Route("/country")
 */
class CountryController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\CountryRepository $repository Repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator  Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="country_index",
     * )
     */
    public function index(Request $request, CountryRepository $repository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            Country::NUMBER_OF_ITEMS
        );

        return $this->render(
            'country/index.html.twig',
            ['pagination' => $pagination]
        );
    }



    /**
     * View action.
     *
     * @param \App\Entity\Country $country Country entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     name="country_view",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function view(Country $country): Response
    {
        return $this->render(
            'country/view.html.twig',
            ['country' => $country]
        );
    }

    /**
     * New action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\CountryRepository            $repository Country repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/new",
     *     methods={"GET", "POST"},
     *     name="country_new",
     * )
     */
    public function new(Request $request, CountryRepository $repository): Response
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($country);

            $this->addFlash('success', 'message.created_successfully');

            return $this->redirectToRoute('country_index');
        }

        return $this->render(
            'country/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Country                          $country       Country entity
     * @param \App\Repository\CountryRepository            $repository Country repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="country_edit",
     * )
     */
    public function edit(Request $request, Country $country, CountryRepository $repository): Response
    {
        $form = $this->createForm(CountryType::class, $country, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($country);

            $this->addFlash('success', 'message.updated_successfully');

            return $this->redirectToRoute('country_index');
        }

        return $this->render(
            'country/edit.html.twig',
            [
                'form' => $form->createView(),
                'country' => $country,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Country                          $country       Country entity
     * @param \App\Repository\CountryRepository            $repository Country repository
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
     *     name="country_delete",
     * )
     */
    public function delete(Request $request, Country $country, CountryRepository $repository): Response
    {
        $form = $this->createForm(FormType::class, $country, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($country);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('country_index');
        }

        return $this->render(
            'country/delete.html.twig',
            [
                'form' => $form->createView(),
                'country' => $country,
            ]
        );
    }
}