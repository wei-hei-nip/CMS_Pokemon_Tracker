<header>
    <h1><?php echo $this->head['title']; ?></h1>
</header>

<p>Welcome! you are logged in as <?php echo $name; ?></p>

<?php if (!$admin): ?>
    <p>You don't have administrator privileges. Ask an admin to assign them for you.</p>
<?php else: ?>
<p>You are an administrator!</p>
<h2><a href="update">Edit / Add Update Announcement</a></h2>
<h2><a href="pokedex">Manage Pokedex</a></h2>
<h2><a href="users">Manage Users</a></h2>


<?php endif; ?>