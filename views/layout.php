<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo BASE_PATH; ?>/"/>
    <meta charset="UTF-8"/>
    <title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $description ?>"/>
    <link rel="icon" type="image/ico" href="favicon.ico">
    <link rel="stylesheet" href="views/css/style.css" type="text/css"/>
</head>

<body>
<header>
    <h1>Pokedex Tracker</h1>
</header>

<section>
    <div id="user-bar">
        <?php if ($name): ?>
            You are logged in as <u><?php echo $name; ?></u>
            <?php if ($admin): ?>
                | <a href="admin">Administration</a>
            <?php endif; ?>
            | <a href="user-setting">Settings</a>
            | <a href="admin/logoff">Log out</a>
        <?php else: ?>
            You are not logged in | <a href="login">Login</a>
        <?php endif; ?>
    </div>
</section>

<nav>
    <ul>
    <li><a href="home">Home</a></li>
    <li><a href="update">Update</a></li>
    <li><a href="pokedex">Pokedex</a></li>
    <li><a href="user-community">Community</a></li>
    </ul>
</nav>
<br/>

<?php if (!empty($messages)) : ?>
    <section>
        <?php foreach ($messages as $message) : ?>
            <p class="message"><?php echo $message; ?><br/></p>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<article>
    <?php $this->subcontroller->renderView(); // renders the current view from the nested controller into the template ?>
</article>

<footer>
    <p>This is a CMS project for education purposes.</p>
</footer>

</body>
</html>
