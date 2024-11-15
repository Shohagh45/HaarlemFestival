<?php
session_start();

use controllers\logincontroller;
use controllers\Logoutcontroller;
use controllers\registercontroller;
use controllers\admincontroller;
use controllers\Dancecontroller;
use controllers\Jazzcontroller;
use controllers\Restaurantcontroller;
use controllers\Historycontroller;
use controllers\accountcontroller;
use controllers\JazzArtistController;
use controllers\JazzEventController;
use controllers\JazzVenueController;
use controllers\Navigationcontroller;
use controllers\overview;
use controllers\Templatecontroller;
use controllers\yummycontroller;
use controllers\Pagecontroller;
use controllers\resetpasswordcontroller;
use controllers\Myprogramcontroller;
use controllers\orderoverviewcontroller;

require_once __DIR__ . '/../controllers/overview.php';
require_once __DIR__ . '/../controllers/myprogramcontroller.php';
require_once __DIR__ . '/../config/constant-paths.php';
require_once __DIR__ . '/../controllers/registercontroller.php';
require_once __DIR__ . '/../controllers/logincontroller.php';
require_once __DIR__ . '/../controllers/logoutcontroller.php';
require_once __DIR__ . '/../controllers/admincontroller.php';
require_once __DIR__ . '/../controllers/accountcontroller.php';
require_once __DIR__ . '/../controllers/restaurantcontroller.php';
require_once __DIR__ . '/../controllers/historycontroller.php';
require_once __DIR__ . '/../controllers/dancecontroller.php';
require_once __DIR__ . '/../controllers/jazzcontroller.php';
require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';
require_once __DIR__ . '/../controllers/templatecontroller.php';
require_once __DIR__ . '/../controllers/yummycontroller.php';
require_once __DIR__ . '/../controllers/resetpasswordcontroller.php';
require_once __DIR__ . '/../controllers/orderoverviewcontroller.php';

require_once __DIR__ . '/../controllers/JazzArtistController.php';
require_once __DIR__ . '/../controllers/JazzVenueController.php';
require_once __DIR__ . '/../controllers/JazzEventController.php';


$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

//Please do not touch this
$editPageID = null;
$sectionEdit = null;
$token = null;
$dancePageID = null;

$queryString = parse_url($request, PHP_URL_QUERY);
$queryParams = [];
if ($queryString !== null) {
    parse_str($queryString, $queryParams);
}
$pageID = htmlspecialchars($queryParams["pageid"] ?? '');

$eventID = null;
if (strpos($request, '/manage-event-details/') === 0) {
    $eventID = htmlspecialchars($queryParams["id"] ?? '');
}
if (strpos($request, '/edit-content/') === 0) {
    $editPageID = htmlspecialchars($queryParams['id'] ?? '');
}
if (strpos($request, '/sectionEdit/') === 0) {
    $sectionEdit = htmlspecialchars($queryParams['section_id'] ?? '');
}
if (strpos($request, '/new-password/') === 0) {
    $token = htmlspecialchars($queryParams["token"] ?? '');
}
if (strpos($request, '/dance/') === 0) {
    $dancePageID = htmlspecialchars($queryParams["artist"] ?? '');
}

//Please do not touch this
if ($request === '/') {
    $pageID = '1';
}

if ($pageID || $eventID || $editPageID || $sectionEdit || $token || $dancePageID) {
    //this has to do with the editing of event details
    if ($eventID) {
        switch ($eventID) {
            case EVENT_ID_DANCE:
                $controller = new Dancecontroller();
                if ($method === 'GET') {
                    $controller->editEventDetails();
                }
                break;
            case EVENT_ID_JAZZ:
                $controller = new Jazzcontroller();
                if ($method === 'GET') {
                    $controller->showEventDetails();
                }
                break;
            case EVENT_ID_RESTAURANT:
                $controller = new Restaurantcontroller();
                if ($method === 'GET') {
                    $controller->editEventDetails();
                }
                break;
            case EVENT_ID_HISTORY:
                $controller = new Historycontroller();
                if ($method === 'GET') {
                    $controller->showeditEventDetails();
                }
                break;
            default:
                break;
        }
        exit;
    } elseif ($pageID) {
        //this has to with our own pages
        switch ($pageID) {
            case PAGE_ID_HOME:
                $controller = new overview();
                $controller->show();
                break;
            case PAGE_ID_HISTORY:
                $controller = new Historycontroller();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
            case PAGE_ID_DANCE:
                $controller = new Dancecontroller();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
            case PAGE_ID_JAZZ:
                $controller = new Jazzcontroller();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
            case PAGE_ID_YUMMY:
                $controller = new yummycontroller();
                if ($method === 'GET') {
                    $controller->showYummyOverview();
                }
                break;
            default;
                $controller = new TemplateController();
                if ($method === 'GET') {
                    $controller->show();
                }
                break;
        }
        exit;
    } elseif ($editPageID) {
        //this has to with editing pages overview
        switch ($editPageID) {
            default;
                $controller = new Pagecontroller;
                if ($method === 'GET') {
                    $controller->editContent();
                } else if ($method === 'POST') {
                    $controller->deleteSection();
                }
                break;
        }
        exit;
    } elseif ($sectionEdit) {
        //this has to with editing section content
        switch ($sectionEdit) {
            default;
                $controller = new Pagecontroller;
                if ($method === 'GET') {
                    $controller->editSectionContent();
                } else if ($method === 'POST') {
                    $controller->updateContent();
                }
                break;
        }
        exit;
    } elseif ($token) {
        switch ($token) {
            default;
                $controller = new resetpasswordcontroller();
                if ($method === 'GET' && $token !== null) {
                    $controller->showNewPasswordForm();
                }
                break;
        }
        exit;
    } elseif ($dancePageID) {
        switch ($dancePageID) {
            default;
                $controller = new Dancecontroller();
                if ($method === 'GET') {
                    $controller->showArtist($dancePageID);
                }
                break;
        }
        exit;
    }
}

if (strpos($request, '/share-cart/') === 0) {
    $encodedCart = htmlspecialchars($queryParams["cart"] ?? '');
    $hash = htmlspecialchars($queryParams["hash"] ?? '');

    $controller = new Myprogramcontroller();
    if ($method === 'GET' && $encodedCart !== null && $hash !== null) {
        $controller->showSharedCart($encodedCart, $hash);
    }
    exit;
}


if (preg_match("/^\/restaurant\/details\/(\d+)$/", $request, $matches)) {
    $restaurantId = $matches[1]; // This captures the numeric ID from the URL.
    $controller = new yummycontroller();
    if ($method === 'GET') {
        $controller->showChoseResturant($restaurantId);
    }
    exit;
}


if (preg_match('/^\/events\/jazz-details\?id=(\d+)$/', $request, $matches)) {
    $controller = new Jazzcontroller();
    if ($method === 'GET') {
        $eventId = $matches[1];
        $controller->showEventDetails($eventId);
    }
    exit;
}

if (preg_match('/^\/artist\/details\?id=(\d+)$/', $request, $matches)) {
    $controller = new Jazzcontroller();
    if ($method === 'GET') {
        $artistId = $matches[1];
        $controller->showArtistDetails($artistId);
    }
    exit;
}

//Add routes for actions or admin routes that do not have to do with displaying detail pages or overview pages for your individual events
switch ($request) {
    case '/login':
        $controller = new logincontroller();
        if ($method === 'GET') {
            $controller->show();
        } elseif ($method === 'POST') {
            $controller->loginAction();
        }
        break;
    case '/reset-password':
        $controller = new resetpasswordcontroller();
        if ($method === 'GET') {
            $controller->showResetPasswordForm();
        } elseif ($method === 'POST') {
            $controller->resetpasswordAction();
        }
        break;

    case '/new-password':
        $controller = new resetpasswordcontroller();
        if ($method === 'GET') {
            $controller->showNewPasswordForm();
        } else if ($method === 'POST') {
            $controller->updatePasswordAction();
        }
        break;

    case '/success-reset-password':
        $controller = new resetpasswordcontroller();
        if ($method === 'GET') {
            $controller->successfulNewPassword();
        }
        break;

    case '/register':
        $controller = new registercontroller();
        if ($method === 'GET') {
            $controller->show();
        } elseif ($method === 'POST') {
            $controller->registerAction();
        }
        break;

    case '/logout':
        $logoutController = new Logoutcontroller();
        $logoutController->logout();
        break;
    case '/dance/addNewEvent':
        $controller = new Dancecontroller();
        $controller->addNewEvent();
        break;
    case '/dance/updateEvent':
        $controller = new Dancecontroller();
        $controller->updateEvent();
        break;
    case '/dance/addNewArtist':
        $controller = new Dancecontroller();
        $controller->addNewArtist();
        break;
    case '/dance/updateArtist':
        $controller = new Dancecontroller();
        $controller->updateArtist();
        break;
    case '/dance/deleteArtist':
        $controller = new Dancecontroller();
        $controller->deleteArtist();
        break;
    case '/dance/deleteEvent':
        $controller = new Dancecontroller();
        $controller->deleteEvent();
        break;
    case '/dance/addNewVenue':
        $controller = new Dancecontroller();
        $controller->addVenue();
        break;
    case '/dance/updateVenue':
        $controller = new Dancecontroller();
        $controller->updateVenue();
        break;
    case '/dance/deleteVenue':
        $controller = new Dancecontroller();
        $controller->deleteVenue();
        break;
    case '/admin/dashboard':
        $controller = new admincontroller();
        if ($method === 'GET') {
            $controller->show();
        }
        break;
    case '/admin/manage-users':
        $controller = new admincontroller();
        if ($method === 'GET') {
            $controller->manageUsers();
        }
        break;
    case '/admin/delete-user':
        $controller = new admincontroller();
        if ($method === 'POST' && isset($_POST['user_id'])) {
            $controller->deleteUsers();
        }
        break;
    case '/admin/filter-users':
        $controller = new admincontroller();
        if ($method === 'POST') {
            $controller->filterUsers();
        }
        break;
    case '/admin/fetch-all-users':
        $controller = new admincontroller();
        if ($method === 'GET') {
            $controller->getAllUsers();
        }
        break;
    case '/account':
        $controller = new accountcontroller();
        $controller->show();
        break;
    case '/admin/add-user':
        $controller = new admincontroller();
        if ($method === 'POST') {
            $controller->addUsers();
        }
        break;
    case '/admin/edit-user':
        $controller = new admincontroller();
        if ($method === 'POST') {
            $controller->editUsers();
        }
        break;
    case '/admin/managefestival':
        $controller = new admincontroller();
        if ($method === 'GET') {
            $controller->manageFestivals();
        }
        break;
    case '/admin/page-management/editfestival':
        $controller = new admincontroller();
        if ($method === 'GET') {
            $controller->editFestivals();
        }
        break;
    case '/admin/orders':
        $controller = new admincontroller();
        if ($method === 'GET') {
            $controller->manageOrders();
        }
        break;
    case '/editDetailsHistory/addNewTimeSlot':
        $controller = new Historycontroller();
        if ($method === 'POST') {
            $controller->addNewTimeSlot();
        }
        break;
    case '/editDetailsHistory/editEventDetails':
        $controller = new Historycontroller();
        if ($method === 'POST') {
            $controller->editEventDetails();
        }
        break;
    case '/editDetailsHistory/deleteTimeSlot':
        $controller = new Historycontroller();
        if ($method === 'POST') {
            $controller->removeTimeslot();
        }
        break;
    case '/modify-navigation/edit-navigation':
        $controller = new Navigationcontroller();
        if ($method === 'GET') {
            $controller->modifyNavigationPage();
        }
        break;
    case '/edit-navigation/modified':
        $controller = new Navigationcontroller();
        if ($method === 'POST') {
            $controller->updateNavigation();
        }
        break;
    case '/add-page':
        $controller = new Pagecontroller();
        if ($method === 'POST') {
            $controller->addNewPage();
        }
        break;
    case '/sectionDelete':
        $controller = new Pagecontroller();
        if ($method === 'POST') {
            $controller->deleteSection();
        }
        break;
    case '/delete-page':
        $controller = new Pagecontroller();
        if ($method === 'POST') {
            $controller->deletePage();
        }
        break;
    case "/editResturantDetails/updateRestaurantDetails":
        $controller = new Restaurantcontroller();
        if ($method === 'POST') {
            $controller->updateRestaurantDetails();
        }
        break;
    case "/editResturantDetails/addTimeSlot":
        $controller = new Restaurantcontroller();
        if ($method === 'POST') {
            $controller->addTimeSlot();
        }
        break;
    case '/admin/add-section':
        $controller = new Pagecontroller();
        if ($method === 'POST') {
            $controller->addNewSection();
        }
        break;
    case '/submit-reservation':
        $controller = new Myprogramcontroller();
        if ($method === 'POST') {
            $controller->createReservation();
        }
        break;
    case '/my-program':
        $controller = new Myprogramcontroller();
        if ($method === 'GET') {
            $controller->show();
        }
        break;
    case '/modifyQuantity':
        $controller = new Myprogramcontroller();
        if ($method === 'POST') {
            $controller->modifyItemQuantity();
        }
        break;
    case '/deleteItem':
        $controller = new Myprogramcontroller();
        if ($method === 'POST') {
            $controller->deleteItemFromCart();
        }
        break;
    case '/getTotalCartPrice':
        $controller = new Myprogramcontroller();
        if ($method === 'GET') {
            $controller->updateTotalCartPrice();
        }
        break;
    case '/get-share-link':
        $controller = new Myprogramcontroller();
        if ($method === 'GET') {
            $controller->generateShareableLink();
        }
        break;
    case '/my-program/payment':
        $controller = new Myprogramcontroller();
        if ($method == 'GET') {
            $controller->showPayment();
        }
        break;
    case '/create-payment':
        $controller = new Myprogramcontroller();
        if ($method == 'POST') {
            $controller->initiatePayment();
        }
        break;
    case '/my-program/payment-success':
        $controller = new Myprogramcontroller();
        if ($method == 'GET') {
            $controller->paymentSuccess();
        }
        break;
    case '/my-program/order-confirmation':
        $controller = new Myprogramcontroller();
        if ($method == 'GET') {
            $controller->showSuccess();
        }
        break;
    case '/admin/order-overview':
        $controller = new orderoverviewcontroller();
        if ($method == 'GET') {
            $controller->showOverviewTable();
        }
        break;

    case '/admin/order-overview/export':
        $controller = new orderoverviewcontroller();
        if ($method == 'POST') {
            $controller->exportExcel();
        }
        break;
    case '/my-program/payment-failure':
        $controller = new Myprogramcontroller();
        if ($method == 'GET') {
            $controller->showFailure();
        }
        break;
        //Artist    
    case '/artists/create':
        $controller = new JazzArtistController();
        if ($method == 'POST') {
            $controller->store();
        }
        break;
    case '/artists/edit':
        $controller = new JazzArtistController();
        if ($method === 'POST') {
            $controller->update();
        }
        break;
    case '/artists/delete':
        $controller = new JazzArtistController();
        if ($method === 'POST') {
            $controller->delete();
        }
        break;

        //Venues    
    case '/venues/create':
        $controller = new JazzVenueController();
        if ($method == 'POST') {
            $controller->store();
        }
        break;
    case '/venues/edit':
        $controller = new JazzVenueController();
        if ($method === 'POST') {
            $controller->update();
        }
        break;
    case '/venues/delete':
        $controller = new JazzVenueController();
        if ($method === 'POST') {
            $controller->delete();
        }
        break;

        //Events    
    case '/events/create':
        $controller = new JazzEventController();
        if ($method == 'POST') {
            $controller->store();
        }
        break;
    case '/events/edit':
        $controller = new JazzEventController();
        if ($method === 'POST') {
            $controller->update();
        }
        break;
    case '/events/delete':
        $controller = new JazzEventController();
        if ($method === 'POST') {
            $controller->delete();
        }
        break;
    case '/events/by-date':
        $controller = new JazzEventController();
        if ($method === 'POST') {
            $controller->getEventsByDate();
        }
        break;
    default:
        http_response_code(404);
        $navigation = new Navigationcontroller();
        $navigation->displayHeader();
        require __DIR__ . '/../views/404.php';
        break;
}
