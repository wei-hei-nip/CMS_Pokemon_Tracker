<header>
  <h1><?php echo $this->head['title']; ?></h1>
</header>

<form method="post">
    Name<br />
    <input type="text" name="name" /><br />
    Password<br />
    <input type="password" name="password" /><br />
    Password repeat<br />
    <input type="password" name="password_repeat" /><br />
    Enter current year (antispam)<br />
    <input type="text" name="antispam" /><br />

    <br>Profile Visibility (This affects your pokedex being visible by public or only yourself):<br>
    <select name="visibility" class='type-select'>
        <option value="public">Public</option>
        <option value="private">Private</option>
    </select>
    <br />

    <br><input type="submit" value="Register" />
</form>