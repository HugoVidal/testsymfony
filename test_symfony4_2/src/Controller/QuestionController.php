<?php

    namespace App\Controller;

    use App\Entity\Question;
    use App\Repository\QuestionRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class QuestionController extends AbstractController {

        /**
         * @var QuestionRepository
         */
        private $repository;
        /**
         * @var EntityManagerInterface
         */
        private $entityManager;

        public function __construct(QuestionRepository $repository, EntityManagerInterface $entityManager) {
            $this->repository = $repository;
            $this->entityManager = $entityManager;
        }

        /**
         * @Route("/questions", name="questions")
         * @return Response
         */
        public function index(): Response {
            $questions = $this->repository->findAll();
            return $this->render('pages/question.html.twig', ['questions' => $questions]);
        }

        /**
         * @Route("/question/delete/{id}", name="question.delete")
         * @param Question $question
         * @return \Symfony\Component\HttpFoundation\RedirectResponse
         */
        public function delete(Question $question) {
            $this->entityManager->remove($question);
            $this->entityManager->flush();
            return $this->redirectToRoute('questions');
        }
    }
