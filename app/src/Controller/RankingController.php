<?php
/**
 * Ranking controller.
 */
namespace App\Controller;
use App\Entity\Ranking;
use App\Form\RankingType;
use App\Repository\RankingRepository;
use App\Repository\DestinationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class RankingController.
 *
 * @Route("/ranking")
 */
class RankingController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Repository\RankingRepository $repository Repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator  Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     name="ranking_index",
     * )
     */
    public function index(Request $request, RankingRepository $repository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $repository->queryAll(),
            $request->query->getInt('page', 1),
            Ranking::NUMBER_OF_ITEMS
        );
        return $this->render(
            'ranking/index.html.twig',
            ['pagination' => $pagination]
        );
    }
    /**
     * View action.
     *
     * @param \App\Entity\Ranking $ranking Ranking entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     name="ranking_view",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function view(Ranking $ranking): Response
    {
        return $this->render(
            'ranking/view.html.twig',
            ['ranking' => $ranking]
        );
    }

    /**
     * New action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param $destination_id
     * @param DestinationRepository $repositoryDestination
     * @param RankingRepository $repositoryRanking
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route(
     *     "/{destination_id}/new",
     *     methods={"GET", "POST"},
     *     name="ranking_new",
     * )
     */
    public function new(Request $request, $destination_id, DestinationRepository $repositoryDestination,  RankingRepository $repositoryRanking): Response
    {
        $ranking = new Ranking();
        $ranking->setVoter($this->getUser());
        // utworzyc nowa destynacje i podac juz obiekt
        $DestinationById = $repositoryDestination->findOneById($destination_id);
        $ranking->setDestination($DestinationById);

        $form = $this->createForm(RankingType::class, $ranking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $repositoryRanking->save($ranking);
            $this->addFlash('success', 'message.created_successfully');
            return $this->redirectToRoute('destination_index');
        }
        return $this->render(
            'ranking/new.html.twig',
            ['form' => $form->createView(), 'destination' => $destination_id]
        );
    }
    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Ranking                          $ranking       Ranking entity
     * @param \App\Repository\RankingRepository            $repository Ranking repository
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
     *     name="ranking_edit",
     * )
     */
    public function edit(Request $request, Ranking $ranking, RankingRepository $repository): Response
    {
        $form = $this->createForm(RankingType::class, $ranking, ['method' => 'PUT']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($ranking);
            $this->addFlash('success', 'message.updated_successfully');
            return $this->redirectToRoute('ranking_index');
        }
        return $this->render(
            'ranking/edit.html.twig',
            [
                'form' => $form->createView(),
                'ranking' => $ranking,
            ]
        );
    }
    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Ranking                          $ranking       Ranking entity
     * @param \App\Repository\RankingRepository            $repository Ranking repository
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
     *     name="ranking_delete",
     * )
     */
    public function delete(Request $request, Ranking $ranking, RankingRepository $repository): Response
    {
        $form = $this->createForm(FormType::class, $ranking, ['method' => 'DELETE']);
        $form->handleRequest($request);
        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($ranking);
            $this->addFlash('success', 'message.deleted_successfully');
            return $this->redirectToRoute('ranking_index');
        }
        return $this->render(
            'ranking/delete.html.twig',
            [
                'form' => $form->createView(),
                'ranking' => $ranking,
            ]
        );
    }
}