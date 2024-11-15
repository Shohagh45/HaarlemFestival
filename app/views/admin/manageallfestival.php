<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Darumadrop+One&display=swap" rel="stylesheet">
    <title>HAARLEM FESTIVALS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.min.js" integrity="sha512-xCMh+IX6X2jqIgak2DBvsP6DNPne/t52lMbAUJSjr3+trFn14zlaryZlBcXbHKw8SbrpS0n3zlqSVmZPITRDSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/overview.css">
    <link rel="stylesheet" href="/css/template.css">
    <link rel="stylesheet" href="/css/footer.css">

</head>

<body>
    <main>
        <?php if (isset($allPages) && is_array($allPages)) : ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img src="/../img/logo.png" alt="Logo" height="70">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <?php foreach ($allPages as $page) : ?>
                                <?php if ($page->getName() == "Home") : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/?pageid=<?php echo urlencode($page->getId()); ?>">
                                            <?php echo htmlspecialchars($page->getName()); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/my-program">My Program</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Festivals
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <?php foreach ($allPages as $page) : ?>
                                        <?php if ($page->getName() != "Home") : ?>
                                            <li><a class="dropdown-item" href="/?pageid=<?php echo urlencode($page->getId()); ?>">
                                                    <?php echo htmlspecialchars($page->getName()); ?>
                                                </a></li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                        <?php
                        if (isset($_SESSION['role'])) {
                            switch ($_SESSION['role']) {
                                case 'customer':
                                    echo '<button class="btn btn-outline-success ms-2" type="button" onclick="location.href=\'/account\'">Account</button>';
                                    echo '<button class="btn btn-danger ms-2" type="button" onclick="confirmLogout()">Logout</button>';
                                    break;
                                case 'admin':
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

        <div class="container mt-5">
            <h1 class="mb-4">Admin Management</h1>
            <p class="lead">Manage Jazz Artists, Venues, and Events</p>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="artists-tab" data-bs-toggle="tab" data-bs-target="#artists" type="button" role="tab" aria-controls="artists" aria-selected="true">Artists</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="venues-tab" data-bs-toggle="tab" data-bs-target="#venues" type="button" role="tab" aria-controls="venues" aria-selected="false">Venues</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab" aria-controls="events" aria-selected="false">Events</button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content mt-4">
                <!-- Artists Tab -->
                <div class="tab-pane fade show active" id="artists" role="tabpanel" aria-labelledby="artists-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Manage Artists</h2>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createArtistModal">Add New Artist</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($artists)) : ?>
                                    <tr>
                                        <td colspan="2" class="text-center">No artists found</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($artists as $artist) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($artist->getName()); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editArtistModal" data-id="<?php echo htmlspecialchars($artist->getArtistId()); ?>" data-name="<?php echo htmlspecialchars($artist->getName()); ?>" data-description="<?php echo htmlspecialchars($artist->getDescription()); ?>" data-profile="<?php echo htmlspecialchars($artist->getProfile()); ?>" data-image1="<?php echo htmlspecialchars($artist->getImage1()); ?>" data-image2="<?php echo htmlspecialchars($artist->getImage2()); ?>" data-image3="<?php echo htmlspecialchars($artist->getImage3()); ?>" data-video="<?php echo htmlspecialchars($artist->getVideo()); ?>" data-album="<?php echo htmlspecialchars($artist->getAlbum()); ?>">Edit</button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteArtistModal" data-id="<?php echo htmlspecialchars($artist->getArtistId()); ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Venues Tab -->
                <div class="tab-pane fade" id="venues" role="tabpanel" aria-labelledby="venues-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Manage Venues</h2>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createVenueModal">Add New Venue</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($venues)) : ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No venues found</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($venues as $venue) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($venue->getName()); ?></td>
                                            <td><?php echo htmlspecialchars($venue->getLocation()); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editVenueModal" data-id="<?php echo htmlspecialchars($venue->getVenueId()); ?>" data-name="<?php echo htmlspecialchars($venue->getName()); ?>" data-location="<?php echo htmlspecialchars($venue->getLocation()); ?>" data-picture="<?php echo htmlspecialchars($venue->getPicture()); ?>">Edit</button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteVenueModal" data-id="<?php echo htmlspecialchars($venue->getVenueId()); ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Events Tab -->
                <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Manage Events</h2>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">Add New Event</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Venue</th>
                                    <th>One Day Price</th>
                                    <th>All Day Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($events)) : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No events found</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($events as $event) : ?>
                                        <?php
                                        $artistIds = $event->getArtistIds(); // Assuming you have a method to get artist IDs for the event
                                        $artistIdsJson = json_encode($artistIds); // Convert artist IDs array to JSON format
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($event->getDate()); ?></td>
                                            <td><?php echo htmlspecialchars($event->getVenueId()); ?></td>
                                            <td><?php echo htmlspecialchars($event->getOnedayprice()); ?></td>
                                            <td><?php echo htmlspecialchars($event->getAlldayprice()); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editEventModal" data-id="<?php echo htmlspecialchars($event->getEventId()); ?>" data-date="<?php echo htmlspecialchars($event->getDate()); ?>" data-venue-id="<?php echo htmlspecialchars($event->getVenueId()); ?>" data-onedayprice="<?php echo htmlspecialchars($event->getOnedayprice()); ?>" data-alldayprice="<?php echo htmlspecialchars($event->getAlldayprice()); ?>" data-Event-image="<?php echo htmlspecialchars($event->getImage()); ?>" data-artist-ids="<?php echo htmlspecialchars($artistIdsJson); ?>">Edit</button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEventModal" data-id="<?php echo htmlspecialchars($event->getEventId()); ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Modals -->

    <!-- Create Artist Modal -->
    <div class="modal fade" id="createArtistModal" tabindex="-1" aria-labelledby="createArtistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/artists/create" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createArtistModalLabel">Add New Artist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="mb-3">
                            <label for="artist-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="artist-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="artist-description" class="form-label">Description</label>
                            <textarea class="form-control" id="artist-description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="artist-profile" class="form-label">Profile</label>
                            <input type="file" class="form-control" id="artist-profile" name="profile">
                        </div>
                        <div class="mb-3">
                            <label for="artist-image1" class="form-label">Image 1</label>
                            <input type="file" class="form-control" id="artist-image1" name="image1">
                        </div>
                        <div class="mb-3">
                            <label for="artist-image2" class="form-label">Image 2</label>
                            <input type="file" class="form-control" id="artist-image2" name="image2">
                        </div>
                        <div class="mb-3">
                            <label for="artist-image3" class="form-label">Image 3</label>
                            <input type="file" class="form-control" id="artist-image3" name="image3">
                        </div>
                        <div class="mb-3">
                            <label for="artist-video" class="form-label">Video</label>
                            <input type="text" class="form-control" id="artist-video" name="video">
                        </div>
                        <div class="mb-3">
                            <label for="artist-album" class="form-label">Album</label>
                            <input type="text" class="form-control" id="artist-album" name="album">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Artist Modal -->
    <div class="modal fade" id="editArtistModal" tabindex="-1" aria-labelledby="editArtistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/artists/edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="edit-artist-id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editArtistModalLabel">Edit Artist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="mb-3">
                            <label for="edit-artist-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-artist-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-artist-description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit-artist-description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-artist-profile" class="form-label">Profile</label>
                            <input type="file" class="form-control" id="edit-artist-profile" name="profile">
                            <img id="edit-artist-profile-preview" src="" alt="Profile Image" class="img-fluid mt-2">
                        </div>
                        <div class="mb-3">
                            <label for="edit-artist-image1" class="form-label">Image 1</label>
                            <input type="file" class="form-control" id="edit-artist-image1" name="image1">
                            <img id="edit-artist-image1-preview" src="" alt="Image 1" class="img-fluid mt-2">
                        </div>
                        <div class="mb-3">
                            <label for="edit-artist-image2" class="form-label">Image 2</label>
                            <input type="file" class="form-control" id="edit-artist-image2" name="image2">
                            <img id="edit-artist-image2-preview" src="" alt="Image 2" class="img-fluid mt-2">
                        </div>
                        <div class="mb-3">
                            <label for="edit-artist-image3" class="form-label">Image 3</label>
                            <input type="file" class="form-control" id="edit-artist-image3" name="image3">
                            <img id="edit-artist-image3-preview" src="" alt="Image 3" class="img-fluid mt-2">
                        </div>
                        <div class="mb-3">
                            <label for="edit-artist-video" class="form-label">Video</label>
                            <input type="text" class="form-control" id="edit-artist-video" name="video">
                        </div>
                        <div class="mb-3">
                            <label for="edit-artist-album" class="form-label">Album</label>
                            <input type="text" class="form-control" id="edit-artist-album" name="album">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Artist Modal -->
    <div class="modal fade" id="deleteArtistModal" tabindex="-1" aria-labelledby="deleteArtistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/artists/delete" method="post">
                    <input type="hidden" id="delete-artist-id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteArtistModalLabel">Delete Artist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this artist?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Venue Modal -->
    <div class="modal fade" id="createVenueModal" tabindex="-1" aria-labelledby="createVenueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/venues/create" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createVenueModalLabel">Add New Venue</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="mb-3">
                            <label for="venue-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="venue-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="venue-location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="venue-location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="venue-picture" class="form-label">Picture</label>
                            <input type="file" class="form-control" id="venue-picture" name="picture" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Venue Modal -->
    <div class="modal fade" id="editVenueModal" tabindex="-1" aria-labelledby="editVenueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/venues/edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="edit-venue-id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editVenueModalLabel">Edit Venue</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="mb-3">
                            <label for="edit-venue-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-venue-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-venue-location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="edit-venue-location" name="location" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-venue-picture" class="form-label">Picture</label>
                            <input type="file" class="form-control" id="edit-venue-picture" name="picture" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <img id="edit-venue-current-picture" src="" alt="Current Picture" style="max-width: 100%; height: auto;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Venue Modal -->
    <div class="modal fade" id="deleteVenueModal" tabindex="-1" aria-labelledby="deleteVenueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/venues/delete" method="post">
                    <input type="hidden" id="delete-venue-id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteVenueModalLabel">Delete Venue</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this venue?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Event Modal -->
    <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/events/create" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createEventModalLabel">Add New Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="mb-3">
                            <label for="event-date" class="form-label">Date/Time</label>
                            <input type="datetime-local" class="form-control" id="event-date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="event-venue" class="form-label">Venue</label>
                            <select class="form-select" id="event-venue" name="venue_id" required>
                                <?php foreach ($venues as $venue) : ?>
                                    <option value="<?php echo htmlspecialchars($venue->getVenueId()); ?>"><?php echo htmlspecialchars($venue->getName()); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="event-image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="event-image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="event-onedayprice" class="form-label">One Day Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="event-onedayprice" name="onedayprice" required>
                        </div>
                        <div class="mb-3">
                            <label for="event-alldayprice" class="form-label">All Day Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="event-alldayprice" name="alldayprice" required>
                        </div>
                        <div class="mb-3">
                            <label for="event-artists" class="form-label">Artists</label>
                            <select class="form-select" id="event-artists" name="artist_ids[]" multiple required>
                                <?php foreach ($artists as $artist) : ?>
                                    <option value="<?php echo htmlspecialchars($artist->getArtistId()); ?>"><?php echo htmlspecialchars($artist->getName()); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/events/edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="edit-event-id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="mb-3">
                            <label for="edit-event-date" class="form-label">Date/Time</label>
                            <input type="datetime-local" class="form-control" id="edit-event-date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-event-venue" class="form-label">Venue</label>
                            <select class="form-select" id="edit-event-venue" name="venue_id" required>
                                <?php foreach ($venues as $venue) : ?>
                                    <option value="<?php echo htmlspecialchars($venue->getVenueId()); ?>"><?php echo htmlspecialchars($venue->getName()); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-event-image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="edit-event-image" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <img id="edit-event-current-image" src="" alt="Current Image" style="max-width: 100%; height: auto;">
                        </div>
                        <div class="mb-3">
                            <label for="edit-event-onedayprice" class="form-label">One Day Price</label>
                            <input type="number" step="0.01" min ="0" class="form-control" id="edit-event-onedayprice" name="onedayprice" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-event-alldayprice" class="form-label">All Day Price</label>
                            <input type="number" step="0.01" min ="0" class="form-control" id="edit-event-alldayprice" name="alldayprice" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-event-artists" class="form-label">Artists</label>
                            <select class="form-select" id="edit-event-artists" name="artist_ids[]" multiple required>
                                <?php foreach ($artists as $artist) : ?>
                                    <option value="<?php echo htmlspecialchars($artist->getArtistId()); ?>"><?php echo htmlspecialchars($artist->getName()); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Event Modal -->
    <div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/events/delete" method="post">
                    <input type="hidden" id="delete-event-id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteEventModalLabel">Delete Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this event?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../general_views/footer.php'; ?>
    <script>
        // Populate the edit modals with existing data for artists
        var editArtistModal = document.getElementById('editArtistModal');
        editArtistModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var description = button.getAttribute('data-description');
            var profile = button.getAttribute('data-profile');
            var image1 = button.getAttribute('data-image1');
            var image2 = button.getAttribute('data-image2');
            var image3 = button.getAttribute('data-image3');
            var video = button.getAttribute('data-video');
            var album = button.getAttribute('data-album');

            var modal = this;
            modal.querySelector('#edit-artist-id').value = id;
            modal.querySelector('#edit-artist-name').value = name;
            modal.querySelector('#edit-artist-description').value = description;

            // Set file input values and image previews
            var profileInput = modal.querySelector('#edit-artist-profile');
            var image1Input = modal.querySelector('#edit-artist-image1');
            var image2Input = modal.querySelector('#edit-artist-image2');
            var image3Input = modal.querySelector('#edit-artist-image3');

            if (profile) {
                profileInput.value = '';
                modal.querySelector('#edit-artist-profile-preview').src = profile;
            }
            if (image1) {
                image1Input.value = '';
                modal.querySelector('#edit-artist-image1-preview').src = image1;
            }
            if (image2) {
                image2Input.value = '';
                modal.querySelector('#edit-artist-image2-preview').src = image2;
            }
            if (image3) {
                image3Input.value = '';
                modal.querySelector('#edit-artist-image3-preview').src = image3;
            }

            modal.querySelector('#edit-artist-video').value = video;
            modal.querySelector('#edit-artist-album').value = album;
        });

        // Populate the delete modal with existing data for artists
        var deleteArtistModal = document.getElementById('deleteArtistModal');
        deleteArtistModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');

            var modal = this;
            modal.querySelector('#delete-artist-id').value = id;
        });

        // Populate the edit modals with existing data for venues
        var editVenueModal = document.getElementById('editVenueModal');
        editVenueModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var location = button.getAttribute('data-location');
            var picture = button.getAttribute('data-picture');

            var modal = this;
            modal.querySelector('#edit-venue-id').value = id;
            modal.querySelector('#edit-venue-name').value = name;
            modal.querySelector('#edit-venue-location').value = location;

            var pictureInput = modal.querySelector('#edit-venue-picture');
            var currentPicture = modal.querySelector('#edit-venue-current-picture');
            if (picture) {
                pictureInput.value = '';
                currentPicture.src = picture.startsWith('/') ? picture : '/img/' + picture;
            } else {
                currentPicture.src = '';
            }
        });

        // Populate the delete modal with existing data for venues
        var deleteVenueModal = document.getElementById('deleteVenueModal');
        deleteVenueModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');

            var modal = this;
            modal.querySelector('#delete-venue-id').value = id;
        });

        // Populate the edit modals with existing data for events
        document.addEventListener('DOMContentLoaded', function() {
            var editEventModal = document.getElementById('editEventModal');
            editEventModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var date = button.getAttribute('data-date');
                var venueId = button.getAttribute('data-venue-id');
                var image = button.getAttribute('data-event-image');
                var onedayprice = button.getAttribute('data-onedayprice');
                var alldayprice = button.getAttribute('data-alldayprice');
                var artistIdsData = button.getAttribute('data-artist-ids');
                var artistIds = artistIdsData ? JSON.parse(artistIdsData) : [];

                
                var modal = this;
                modal.querySelector('#edit-event-id').value = id;
                modal.querySelector('#edit-event-date').value = date;
                modal.querySelector('#edit-event-venue').value = venueId;
                modal.querySelector('#edit-event-image').value = '';
                modal.querySelector('#edit-event-onedayprice').value = onedayprice;
                modal.querySelector('#edit-event-alldayprice').value = alldayprice;
                
                if (image) {
                    modal.querySelector('#edit-event-current-image').src = image.startsWith('/') ? image : '/img/' + image;
                } else {
                    modal.querySelector('#edit-event-current-image').src = '';
                }
                
                var artistSelect = modal.querySelector('#edit-event-artists');
                for (var i = 0; i < artistSelect.options.length; i++) {
                    console.log("trd",artistSelect.options[i].value);
                    artistSelect.options[i].selected = artistIds.includes(parseInt(artistSelect.options[i].value));
                }
            });
        });


        // Populate the delete modal with existing data for events
        var deleteEventModal = document.getElementById('deleteEventModal');
        deleteEventModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');

            var modal = this;
            modal.querySelector('#delete-event-id').value = id;
        });
    </script>

    <script type="text/javascript">
        function confirmLogout() {
            var logout = confirm("Are you sure you want to log out?");
            if (logout) {
                window.location.href = '/logout';
            }
        }
    </script>
</body>

</html>