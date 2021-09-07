<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadImage
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    // The $fileName is the name given to the FileType  
    public function uploadImg(Form $form, string $fileName)
    {
        $imageFile = $form->get($fileName)->getData();

        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
            try {
                $imageFile->move(
                    'uploads/screenshots',
                    $newFilename
                );
                // Return the name of the image
                return $newFilename;
            } catch (FileException $e) {
                // If not, display an error
            }
        }
        // No image to upload, we return null
        return null;
    }
}
