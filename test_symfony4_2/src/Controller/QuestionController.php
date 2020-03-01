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
            $new_questions = $this->repository->findBy(['isTreated' => 0]);
            $treated_questions = $this->repository->findBy(
                ['isTreated' => 1],
                ['id' => 'DESC']
            );
            return $this->render('pages/question.html.twig', [
                'new_questions' => $new_questions,
                'treated_questions' => $treated_questions
            ]);
        }

        /**
         * @Route("/question/treat/{id}", name="question.treat")
         * @param Question $question
         * @return \Symfony\Component\HttpFoundation\RedirectResponse
         */
        public function treatQuestion(Question $question) {
            $question->setIsTreated(true);
            $this->entityManager->flush();
            return $this->redirectToRoute('questions');
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
