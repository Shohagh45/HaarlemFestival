<?php include __DIR__ . '/../general_views/header.php'; ?>

<style>
    .navbar-secondary {
        background-color: #000000;
    }
    .navbar-secondary .navbar-nav .nav-link {
        color: white; 
    }
    .content {
        text-align: center;
        padding: 2rem;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-secondary justify-content-center">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="/admin/manage-users">Manage Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Manage Festival</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Edit Festival</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Orders</a>
        </li>
    </ul>
</nav>

<div class="content">
    <h1>Admin Dashboard</h1>

    <?php if (isset($userDetails)): ?>
        <section>
            <br>
            <h2>Currently Logged In User</h2>
            <br>
            <p>Username: <?php echo htmlspecialchars($userDetails['username']); ?></p>
            <p>Email: <?php echo htmlspecialchars($userDetails['email']); ?></p>
            <p>Role: <?php echo htmlspecialchars($userDetails['role']); ?></p>
        </section>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../general_views/footer.php'; ?>
