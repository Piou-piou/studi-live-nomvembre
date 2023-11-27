<?php

namespace App\Controller;

use App\Entity\File;
use App\File\FileUploader;
use App\Form\FileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function home(EntityManagerInterface $em): Response
    {
        $files = $em->getRepository(File::class)->findAll();

        return $this->render('pages/file/list.html.twig', [
            'files' => $files
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $em, Request $request, FileUploader $uploader, ParameterBagInterface $parameterBag): Response
    {
        $form = $this->createForm(FileType::class);
        $form->add('save', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var File $file */
            $file = $form->getData();

            if ($parameterBag->get('file_upload.enabled')) {
                if ($uploadedFile = $form->get('file')->getData()) {
                    $filename = $uploader->upload($uploadedFile);
                    $file->setFilename($filename);
                }
            }

            $em->persist($file);
            $em->flush();
        }

        return $this->render('pages/file/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/display-image/{filename}', name: 'display_image')]
    public function displayImage(string $filename = null)
    {
//        if (!$this->getUser()->getRoles()) {
//            return new Response();
//        }

        if ($filename === null) {
            return new Response();
        }

        $image = $this->getParameter('upload_directory').'/'.$filename;

        if (!file_exists($image)) {
            return new Response();
        }
//        test later is it's not an image do not display
//        if (!in_array($this->getMimeType($image), ['jpeg', 'png', 'svg'])) {
//            return new Response();
//        }

        header("Content-type: ".$this->getMimeType($image));
        header("Content-Disposition: inline; filename=".basename($image));

        readfile($image);

        return new Response();
    }

    private function getMimeType($file): string
    {
        $guesser = new MimeTypes();
        return $guesser->guessMimeType($file);
    }

}
