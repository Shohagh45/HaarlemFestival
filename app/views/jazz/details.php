<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <?php include __DIR__ . '../../general_views/header.php'; ?>
    <style>
        .custom-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }

        .upcoming-shows {
            background-image: url('./img/Music_img/upcoming show.png');
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 250px;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            color: white;
            padding: 0 20px;
            margin-bottom: 50px;
        }

        .event-details-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
        }

        .event-details {
            text-align: center;
            font-size: 14px;
            line-height: 1.5;
            max-width: 100%;
            margin: 0;
        }

        .ticket-button {
            width: 150px;
            height: 40px;
            padding: 10px 22px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .music-card {
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .music-card img {
            border-radius: 10px;
        }

        .audio-wrapper {
            width: 100%;
            margin-top: 10px;
        }

        audio {
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>

<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1 class="display-4"><?php echo htmlspecialchars($venue->getName()); ?></h1>
        <div class="row mt-4">
            <div class="col-12">
                <img src="<?php echo htmlspecialchars($venue->getPicture()); ?>" alt="<?php echo htmlspecialchars($venue->getName()); ?>" class="custom-image">
            </div>
        </div>

        <hr class="my-5">

        <div class="text-center">
            <h2 class="mb-4">About the Event</h2>
            <p>
                Venue: <?php echo htmlspecialchars($event->getVenueName()); ?><br>
                Location: <?php echo htmlspecialchars($event->getLocation()); ?><br>
                Date: <?php echo htmlspecialchars($event->getDate()); ?><br>
                One Day Price: $<?php echo htmlspecialchars($event->getOnedayprice()); ?><br>
                All Day Price: $<?php echo htmlspecialchars($event->getAlldayprice()); ?><br>
            </p>
        </div>

        <h2 class="text-center mt-5">Artists Coming</h2>
        <div class="row mt-4">
            <?php foreach ($event->getArtistIds() as $artistId) :
                $artist = $this->artistService->getArtistById($artistId); ?>
                <div class="col-md-3 mb-4">
                    <div class="card music-card">
                        <img class="card-img-top" src="https://static.vecteezy.com/system/resources/previews/006/259/995/original/music-logo-icon-initial-letter-t-music-logo-design-template-element-vector.jpg" alt="Album">
                        <div class="card-body">
                            <h4 class="card-title text-center"><?php echo htmlspecialchars($artist->getName()); ?></h4>
                        </div>
                        <div class="audio-wrapper">
                            <audio controls>
                                <source src="<?= $artist->getAlbum() ?>" type="audio/mp3">
                                Your browser does not support the audio tag.
                            </audio>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include __DIR__ . '../../general_views/footer.php'; ?>
</body>

</html>