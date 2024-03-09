<?php

namespace controllers;

use services\pageservice;
use model\Carousel;
use model\Editor;
use model\Section;
use model\Image;
use PDOException;
use Exception;
use services\ContentService;

require_once __DIR__ . "/../services/pageservice.php";
require_once __DIR__ . "/../services/contentservice.php";
require_once __DIR__ . "/../model/carousel.php";
require_once __DIR__ . "/../model/editor.php";
require_once __DIR__ . "/../model/image.php";
require_once __DIR__ . "/../model/section.php";



class Pagecontroller
{
    private $pageService;
    private $carouselModel;
    private $editorModel;
    private $sectionModel;
    private $imageModel;
    private $contentService;

    public function __construct()
    {
        $this->pageService = new Pageservice();
        $this->contentService = new ContentService();
    }

    public function editContent()
    {
        $allSections = $this->getSectionsFromPageID();
        $pageDetails = $this->getPageDetails();
        require_once __DIR__ . "/../views/admin/page-managment/editPageOverview.php";
    }


    public function editSectionContent()
    {
        $sectionID = htmlspecialchars($_GET["section_id"] ?? '');
        $sectionTitle = $this->pageService->getSectionTitle($sectionID);
      
        $sectionData = $this->pageService->getSectionContentImagesCarousel($sectionID)[0] ?? null;

        $editorContent = null;
        $imageFilePath = null;
        $carouselItems = $this->getCarouselImagesForHistory($sectionID);
        if ($sectionData) {
            $editorContent = $sectionData['editor_content'] ?? null;
            $imageFilePath = $sectionData['image_file_path'] ?? null;
        }

        require_once __DIR__ . "/../views/admin/page-managment/editSection.php";
    }


    public function updateContent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section_id'])) {

            $sectionID = $_POST['section_id'];
            $content = empty($_POST['content']) ? null : $_POST['content'];
            $title = $_POST['sectionTitle'];

            $newImage = $_FILES['newImage'] ?? null;
            $path = '/img/uploads/';

            $carouselImages = $_FILES['carouselImage'] ?? [];
            $carouselLabels = $_POST['carouselLabel'] ?? [];
            $carouselIds = $_POST['carouselId'] ?? [];
        
            foreach ($carouselIds as $index => $carouselId) {
                $newCarouselImage = $carouselImages[$index] ?? null;
                $newCarouselLabel = $carouselLabels[$index] ?? '';
            
                if ($newCarouselImage && $newCarouselImage['error'] == UPLOAD_ERR_OK) {
                    $newImagePath = $this->uploadImage($newCarouselImage, $path);
                    $this->contentService->updateCarouselItem($carouselId, $carouselImages, $newCarouselLabel);
                } else {
                    $this->contentService->updateCarouselLabel($carouselId, $newCarouselLabel);
                }
            }

            if ($newImage && $newImage['error'] == UPLOAD_ERR_OK) {
                $image = $this->uploadImage($newImage, $path);
            } else {
                $image = null;
            }

            $sanitizedSectionID = filter_var($sectionID, FILTER_SANITIZE_NUMBER_INT);

            try {

                $this->pageService->updateSectionContent($sanitizedSectionID, $content, $newImage);
                $this->pageService->updateSectionTitle($sectionID, $title);
                $pageID = $this->pageService->getSectionPageId($sanitizedSectionID);

                if ($pageID !== null) {
                    header('Location: /edit-content/?id=' . $pageID);
                    exit();
                } else {
                    throw new Exception("Page ID not found for section ID: " . $sanitizedSectionID);
                }
            } catch (Exception $e) {
                var_dump("" . $e->getMessage());
                error_log($e->getMessage());

            }
        }
    }

    private function uploadImage($imageFile, $uploadDirectory)
    {

        if (isset($imageFile) && $imageFile['error'] == UPLOAD_ERR_OK) {
            $imageFileName = basename($imageFile['name']);
            $absoluteUploadPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDirectory . $imageFileName;

            if (move_uploaded_file($imageFile['tmp_name'], $absoluteUploadPath)) {
                return $uploadDirectory . $imageFileName;
            } else {
                throw new Exception('Failed to upload image.');
            }
        }
        return null;
    }

    public function deleteSection()
    {
        $sectionID = htmlspecialchars($_GET["section_id"] ?? '');


        if (!$sectionID) {
            error_log('Section ID is missing.');
            return;
        }

        $sanitizedSectionID = filter_var($sectionID, FILTER_SANITIZE_NUMBER_INT);
        $pageID = $this->pageService->getSectionPageId($sanitizedSectionID);

        try {
            $this->pageService->deleteSection($sanitizedSectionID);
            echo '<script>alert("Section deleted.");</script>';
            header('Location: /edit-content/?id=' . $pageID);
        } catch (PDOException $e) {
            error_log('Failed to delete section: ' . $e->getMessage());

        } catch (Exception $e) {
            error_log($e->getMessage());

        }
    }

    public function deletePage()
    {
        $pageID = htmlspecialchars($_GET['id'] ?? '');


        if (!$pageID) {
            error_log('Page ID is missing.');
            return;
        }

        $sanitizedPageID = filter_var($pageID, FILTER_SANITIZE_NUMBER_INT);

        try {
            $this->pageService->deletePage($sanitizedPageID);
            echo '<script>alert("Page deleted.");</script>';
            header('Location: /admin/page-management/editfestival');
        } catch (PDOException $e) {
            error_log('Failed to delete section: ' . $e->getMessage());

        } catch (Exception $e) {
            error_log($e->getMessage());

        }
    }

    public function getSectionsFromPageID()
    {
        $page = htmlspecialchars($_GET['id']);
        $allSections = $this->pageService->getAllSections($page);
        return $allSections;
    }

    public function getPageDetails()
    {
        $page = htmlspecialchars($_GET['id']);
        $pageDetails = $this->pageService->getPageDetails($page);
        return $pageDetails;
    }

    public function getContentAndImagesByPage()
    {
        $pageId = htmlspecialchars($_GET['pageid']);
        $sections = $this->pageService->getSectionContentImages($pageId);
        $contentData = [];
        foreach ($sections as $section) {
            $sectionData = [
                'title' => $section['title'],
                'content' => $section['editor_content'] ?? null,
                'image' => $section['image_file_path'] ?? null,
            ];
            $contentData[] = $sectionData;
        }
        return $contentData;
    }

    public function getCarouselImagesForHistory($sectionID)
    {
        $carouselItems = $this->contentService->getCarouselItemsBySectionId($sectionID);
        $all = [];

        foreach ($carouselItems as $item) {
            $imageData = $this->contentService->getImageById($item->getImageId());
            if ($imageData) {
                $all['carouselItems'][] = [
                    'image' => $imageData->getFilePath(),
                    'label' => $item->getLabel(),
                    'carousel_id' => $item->getCarouselId(),
                ];
            }
        }

        return $all;
    }
}
