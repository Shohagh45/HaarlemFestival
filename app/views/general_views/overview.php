<?php
include __DIR__ . '/header.php';
?>
<h1>Haarlem Festival</h1>


<div class="festival-banner">
    <a href="/?pageid=2">
        <div class="festival-promotion-header" style='background-image: url(/img/historyPromotion.png);'>
            <h2>Stroll Through History</h2>
        </div>
    </a>

    <div class="banner-content">
        <!-- for every event / artist make this-->
        <div class="individual-event">
            <img src="/img/bavoKerkBanner.jpg" alt="">
            <p>Church of st Bravo</p>
        </div>

        <div class="individual-event">
            <img src="/img/groteMarktBanner.png" alt="">
            <p>Grote Markt</p>
        </div>

        <div class="individual-event">
            <img src="/img/deHallenBanner.jpg" alt="">
            <p>De Hallen</p>
        </div>

        <div class="individual-event">
            <img src="/img/proveniershofBanner.png" alt="">
            <p>Proveniershof</p>
        </div>

        <div class="individual-event">
            <img src="/img/jopenkerkBanner.png" alt="">
            <p>Jopenkerk</p>
        </div>

        <div class="individual-event">
            <img src="/img/waalsekerkBanner.png" alt="">
            <p>Waalse Kerk Haarlem</p>
        </div>

        <div class="individual-event">
            <img src="/img/molenBanner.png" alt="">
            <p>Molen de Adriaan</p>
        </div>

        <div class="individual-event">
            <img src="/img/amsterdamseBanner.png" alt="">
            <p>Amsterdamse Poort</p>
        </div>

        <div class="individual-event">
            <img src="/img/hofBanner.png" alt="">
            <p>Hof van Bakenes</p>
        </div>
    </div>
</div>

<div class="festival-banner">
    <a href="/?pageid=3">
        <div class="festival-promotion-header" style="background-image: url(/img/dancePromotion.png);">
            <h2>Dance! the night away</h2>
        </div>
    </a>

    <div class="banner-content">
        <!-- for every event / artist make this-->
        <div class="individual-event">
            <img src="/img/nickiBanner.png" alt="">
            <p>Nicki Romero</p>
        </div>

        <div class="individual-event">
            <img src="/img/tiestoBanner.png" alt="">
            <p>Tiesto</p>
        </div>

        <div class="individual-event">
            <img src="/img/hardwellBanner.png" alt="">
            <p>Hardwell</p>
        </div>

        <div class="individual-event">
            <img src="/img/afrojackBanner.png" alt="">
            <p>Afrojack</p>
        </div>

        <div class="individual-event">
            <img src="/img/arminBanner.png" alt="">
            <p>Armin Van Buuren</p>
        </div>

        <div class="individual-event">
            <img src="/img/martinBanner.png" alt="">
            <p>Martin Garrix</p>
        </div>
    </div>
</div>

<div class="festival-banner">
    <a href="/?pageid=4">
        <div class="festival-promotion-header" style="background-image: url(/img/jazzPromotion.jpg);">
            <h2>Jazz! and chill</h2>
        </div>
    </a>
    <div class="banner-content">
        <?php if (!empty($artists)) : ?>
            <?php foreach ($artists as $artist) : ?>
                <a class="text-decoration-none" href="/artist/details?id=<?php echo htmlspecialchars($artist->getArtistId()); ?>">
                    <div class="individual-event">
                        <img src="<?php echo htmlspecialchars($artist->getProfile()); ?>" alt="<?php echo htmlspecialchars($artist->getName()); ?>">
                        <p class="text-black"><?php echo htmlspecialchars($artist->getName()); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No artists found.</p>
        <?php endif; ?>
    </div>
</div>

<div class="festival-banner">
    <a href="/?pageid=5">
        <div class="festival-promotion-header" style="background-image: url(/img/yummyPromotion.png);">
            <h2>Yummy! Foodies </h2>
        </div>
    </a>
    <div class="banner-content">
        <!-- for every event / artist make this-->
        <div class="individual-event">
            <img src="/img/bavoKerkBanner.jpg" alt="">
            <p>cafe de roemer</p>
        </div>

        <div class="individual-event">
            <img src="/img/bavoKerkBanner.jpg" alt="">
            <p>Ratatouille</p>
        </div>

        <div class="individual-event">
            <img src="/img/bavoKerkBanner.jpg" alt="">
            <p>ML Restaurant</p>
        </div>

        <div class="individual-event">
            <img src="/img/bavoKerkBanner.jpg" alt="">
            <p>Fris Restaurant</p>
        </div>

        <div class="individual-event">
            <img src="/img/bavoKerkBanner.jpg" alt="">
            <p>Specktacel</p>
        </div>

        <div class="individual-event">
            <img src="/img/bavoKerkBanner.jpg" alt="">
            <p>Grand cafe Brinkman</p>
        </div>

        <div class="individual-event">
            <img src="/img/bavoKerkBanner.jpg" alt="">
            <p>Urban Frenchy Bistro Toujours</p>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/footer.php';
?>