<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jazz Festival</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/color-calendar@1.0.5/dist/bundle.js"></script>
    <link rel="stylesheet" href="/css/theme-basic.min.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <style>
        body {
            background: url('/img/Music_img/Jazz.jpeg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        #image-section {
            position: relative;
            min-height: 500px;
            overflow: hidden;
            background: url('/img/Music_img/image 100.png') no-repeat center center fixed;
            background-size: cover;
        }

        #slogan {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 36px;
            color: white;
            text-align: center;
            width: 100%;
        }

        #top-artist-section {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .top-artist-heading {
            font-size: 36px;
            font-weight: bold;
            color: white;
            margin-bottom: 20px;
        }

        .artist-images {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .artist-images img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .artist-images img:hover {
            transform: scale(1.1);
        }

        #events-section {
            text-align: center;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        #events-section h2 {
            color: white;
        }

        .image-container {
            position: relative;
            overflow: hidden;
        }

        .hover-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .hover-text {
            background-color: rgba(85, 112, 89, 1);
            color: white;
            padding: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-container:hover .hover-text {
            opacity: 1;
        }
    </style>
</head>

<body>

    <div id="image-section">
        <div id="slogan">JAZZ ECLECTICA Haarlem's Melodic Tapestry Unveiled</div>
    </div>

    <div id="top-artist-section">
        <div class="top-artist-heading">TOP JAZZ ARTISTS</div>
        <div class="artist-images">
            <?php foreach ($artists as $artist) : ?>
                <a class="text-decoration-none" href="/artist/details?id=<?php echo htmlspecialchars($artist->getArtistId()); ?>">
                    <img src="<?php echo htmlspecialchars($artist->getProfile()); ?>" alt="<?php echo htmlspecialchars($artist->getName()); ?>">
                    <p class="m-2 text-white"><?php echo htmlspecialchars($artist->getName()); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="events-section">
        <h2>Upcoming Events</h2>
        <div id="calendar-view">
            <section class="container calender-bg">
                <div class="d-flex gap-5 align-items-start">
                    <div>
                        <h4>Jazz festival overview</h4>
                        <div id="calendar-a"></div>
                    </div>
                    <div class="mt-5" style="background: whitesmoke; width: 800px; padding: 10px; border-radius: 10px;">
                        <h4 id="selected-date"></h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Event Date Time</th>
                                    <th>Venue</th>
                                    <th>One day price</th>
                                    <th>All day price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($event->getDate()); ?></td>
                                        <td><?php echo htmlspecialchars($event->getVenueName()); ?></td>
                                        <td>$<?php echo htmlspecialchars($event->getOnedayprice()); ?></td>
                                        <td>$<?php echo htmlspecialchars($event->getAlldayprice()); ?></td>
                                        <td><a href="/events/jazz-details?id=<?php echo htmlspecialchars($event->getEventId()); ?>">Details</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

     <div style="text-align: center; margin-top: 50px;">
        <h3 style="color: white;">Jazz Up Your Rhythm: Swing Into Dance Now!</h3>
        <div style="width: 1500px; height: 626px; display: flex; justify-content: space-around; align-items: center;">
            <div class="image-container" style="width: 520px; height: 500px; position: relative; overflow: hidden; cursor: pointer;">
                <img src="/img/Music_img/image 119.png" alt="Image 1" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="image-container" style="width: 520px; height: 500px; position: relative; overflow: hidden; cursor: pointer;">
                <img src="/img/Music_img/Tiesto.png" alt="Image 2" style="width: 100%; height: 100%; object-fit: cover;">
                <div class="hover-container">
                    <div class="hover-text">Find your favourite artist</div>
                </div>
            </div>
            <div class="image-container" style="width: 520px; height: 500px; position: relative; overflow: hidden; cursor: pointer;">
                <img src="/img/Music_img/Martin Garrix.png" alt="Image 3" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    </div> 

    <?php include __DIR__ . '/../general_views/footer.php'; ?>
    <script src="/js/calender.js"></script>
</body>

</html>