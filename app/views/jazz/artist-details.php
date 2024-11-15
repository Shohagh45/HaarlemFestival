<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Details - <?php echo htmlspecialchars($artist->getName()); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <?php include __DIR__ . '../../general_views/header.php'; ?>
    <style>
        .custom-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }

        .gallery-image {
            width: 300px;
            height: 300px;
            object-fit: cover;
            margin: 10px;
        }

        .upcoming-shows {
            background-image: url('./img/Music_img/upcoming show.png');
            background-size: cover;
            background-position: center;
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
        }

        .ticket-button {
            width: 150px;
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
            margin-bottom: 20px;
        }

        .audio-wrapper {
            width: 100%;
        }

        audio {
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo htmlspecialchars($artist->getName()); ?></h1>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo htmlspecialchars($artist->getProfile()); ?>" alt="Profile Image" class="custom-image mb-4">
            </div>
            <div class="col-md-8">
                <h2 class="text-white">About the Artist</h2>
                <p class="text-white"><?php echo htmlspecialchars($artist->getDescription()); ?></p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h2 class="text-center text-white">Gallery</h2>
                <div class="d-flex justify-content-center flex-wrap">
                    <?php if ($artist->getImage1()) : ?>
                        <img src="<?php echo htmlspecialchars($artist->getImage1()); ?>" alt="Image 1" class="gallery-image">
                    <?php endif; ?>
                    <?php if ($artist->getImage2()) : ?>
                        <img src="<?php echo htmlspecialchars($artist->getImage2()); ?>" alt="Image 2" class="gallery-image">
                    <?php endif; ?>
                    <?php if ($artist->getImage3()) : ?>
                        <img src="<?php echo htmlspecialchars($artist->getImage3()); ?>" alt="Image 3" class="gallery-image">
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h2 class="text-center text-white">Music</h2>
                <div class="row">
                    <div class="col-md-3">
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
                    <!-- Repeat similar blocks for other albums or tracks -->
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '../../general_views/footer.php'; ?>
</body>

</html>