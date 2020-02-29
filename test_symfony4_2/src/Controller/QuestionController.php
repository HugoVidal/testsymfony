<?php

    namespace App\Controller;

    use App\Repository\QuestionRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class QuestionController extends AbstractController {

        /**
         * @var QuestionRepository
         */
        private $repository;

        public function __construct(QuestionRepository $repository) {
            $this->repository = $repository;
        }

        /**
         * @Route("/questions", name="questions")
         * @return Response
         */
        public function index(): Response {
            $questions = $this->repository->findAll();
            return $this->render('pages/question.html.twig', ['questions' => $questions]);
        }
    }
