<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskFormType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TaskController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TaskRepository
     */
    private $taskRepository;


    public function __construct(TaskRepository $taskRepository ,EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->taskRepository = $taskRepository;
    }
    /**
     * @Route("/task/", name="task")
     */
    public function index()
    {
        $tasks = $this->taskRepository->findAll();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/task/create/", name="task.create")
     */
    public function create(Request $request)
    {
        $task = new Task();
        $task->setCreatedAt(new \DateTime());

        return $this->handleForm($request, $task);
    }

    /**
     * @Route("/task/{id}/edit/", name="task.edit")
     */
    public function edit(Request $request, $id)
    {
        $task = $this->taskRepository->find($id);

        if($task === null){
            throw $this->createNotFoundException("Task #$id does not exist");
        }

        return $this->handleForm($request, $task);
    }

    /**
     * @Route("/task/{id}/delete/", name="task.delete")
     */
    public function delete(Request $request, $id)
    {
        $task = $this->taskRepository->find($id);

        if($task === null){
            throw $this->createNotFoundException("Task #$id does not exist");
        }

        $this->entityManager->remove($task);
        $this->entityManager->flush();
        return $this->redirect('/task');
    }

    /**
     * @param Request $request
     * @param $task
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handleForm(Request $request, $task)
    {
        $form = $this->createForm(TaskFormType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            return $this->redirect('/task');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView()
        ]);
        exit;
    }
}
