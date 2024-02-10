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
    <h1>Manage Users</h1>
    <br>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Ticket ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allUsers as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['user_id'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user['ticket_id'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user['username'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user['role'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user['e_mail'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($user['registration_date'] ?? 'N/A') ?></td>
                        <td>
                            <a href="/admin/edit-user/<?= $user['user_id'] ?? '' ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="/admin/delete-user/<?= $user['user_id'] ?? '' ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <br>
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-secondary" title="Create New User">Create New User</button>
    </div>
</div>

<?php include __DIR__ . '/../general_views/footer.php'; ?>