<header>
    <h1><?php echo $this->head['title']; ?></h1>
</header>

<form method="post">
    Name<br />
    <input type="text" name="name" /><br />
    Password<br />
    <input type="password" name="password" /><br />
    <input type="submit" value="Login" />
</form>

<p>If you don't have an account, please <a href="register">register</a>.</p>