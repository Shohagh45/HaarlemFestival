<?php include __DIR__ . '/../general_views/adminheader.php'; ?>

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
                <a href="/artists/create" class="btn btn-primary">Add New Artist</a>
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
                        <?php foreach ($artists as $artist) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($artist->getName()); ?></td>
                                <td>
                                    <a href="/artists/edit?id=<?php echo htmlspecialchars($artist->getArtistId()); ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="/artists/delete?id=<?php echo htmlspecialchars($artist->getArtistId()); ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Venues Tab -->
        <div class="tab-pane fade" id="venues" role="tabpanel" aria-labelledby="venues-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Manage Venues</h2>
                <a href="/venues/create" class="btn btn-primary">Add New Venue</a>
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
                        <?php foreach ($venues as $venue) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($venue->getName()); ?></td>
                                <td><?php echo htmlspecialchars($venue->getLocation()); ?></td>
                                <td>
                                    <a href="/venues/edit?id=<?php echo htmlspecialchars($venue->getVenueId()); ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="/venues/delete?id=<?php echo htmlspecialchars($venue->getVenueId()); ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Events Tab -->
        <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Manage Events</h2>
                <a href="/events/create" class="btn btn-primary">Add New Event</a>
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
                        <?php foreach ($events as $event) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event->getDate()); ?></td>
                                <td><?php echo htmlspecialchars($event->getVenueId()); ?></td>
                                <td><?php echo htmlspecialchars($event->getOnedayprice()); ?></td>
                                <td><?php echo htmlspecialchars($event->getAlldayprice()); ?></td>
                                <td>
                                    <a href="/events/edit?id=<?php echo htmlspecialchars($event->getEventId()); ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="/events/delete?id=<?php echo htmlspecialchars($event->getEventId()); ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../general_views/footer.php'; ?>