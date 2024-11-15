<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Darumadrop+One&display=swap" rel="stylesheet">
    <title>HAARLEM FESTIVALS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.min.js"
        integrity="sha512-xCMh+IX6X2jqIgak2DBvsP6DNPne/t52lMbAUJSjr3+trFn14zlaryZlBcXbHKw8SbrpS0n3zlqSVmZPITRDSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/overview.css">
    <link rel="stylesheet" href="/css/template.css">
    <link rel="stylesheet" href="/css/footer.css">
    <link rel="stylesheet" href="/css/myprogram.css">
    <link rel="stylesheet" href="/css/myprogram.css">
    <link rel="stylesheet" href="/css/ticket.css">
    <link rel="stylesheet" href="/css/danceDetail.css">

    <link rel="stylesheet" href="/css/list-view-tickets.css">

</head>

<body>
    <main>
        <?php if (isset ($allPages) && is_array($allPages)): ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img src="/../img/logo.png" alt="Logo" height="70">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <?php foreach ($allPages as $page): ?>
                                <?php if ($page->getPageName() == "Home"): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/?pageid=<?php echo urlencode($page->getPageID()); ?>">
                                            <?php echo htmlspecialchars($page->getPageName()); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/my-program">My Program</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Festivals
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <?php foreach ($allPages as $page): ?>
                                        <?php if ($page->getPageName() != "Home"): ?>
                                            <li><a class="dropdown-item"
                                                    href="/?pageid=<?php echo urlencode($page->getPageID()); ?>">
                                                    <?php echo htmlspecialchars($page->getPageName()); ?>
                                                </a></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                        <?php
                        if (isset ($_SESSION['role'])) {
                            switch ($_SESSION['role']) {
                                case 'customer':
                                    echo '<button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/account\'">Account</button>';
                                    echo '<button class="btn btn-danger ms-2" type="button" onclick="confirmLogout()">Logout</button>';
                                    break;
                                default:
                                    echo '<button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/login\'">Login</button>';
                                    echo '<button class="btn btn-dark ms-2" type="button" onclick="location.href=\'/register\'">Register</button>';
                                    break;
                            }
                        } else {
                            echo '<button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/login\'">Login</button>';
                            echo '<button class="btn btn-dark ms-2" type="button" onclick="location.href=\'/register\'">Register</button>';
                        }
                        ?>
                    </div>
                </div>
            </nav>
        <?php endif; ?>
        <div class="container">
        </div>
    </main>

    <script type="text/javascript">
        function confirmLogout() {
            var logout = confirm("Are you sure you want to log out?");
            if (logout) {
                window.location.href = '/logout';
            }
        }
    </script>