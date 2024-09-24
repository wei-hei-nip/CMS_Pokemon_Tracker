<header>
    <h1><?php echo $this->head['title']; ?></h1>
</header>

<section>

    <div> Welcome<?php if ($name) : ?> <?php echo $name; ?> <?php endif ?>! This is a website pokedex where you can track and browse information of Pokemons.</div>

    <!--  Only visible to users -->    
    <?php 
    if ($name){
        if ($admin){
            echo '<br>'. '<div>You have admin access to edit <a href="update">Update Announcement</a>.</div>';
            echo '<br>'. '<div>You have admin access to edit <a href="pokedex">Pokedex</a>.</div>';
            echo '<br>'. '<div>You have admin access to manage <a href="users">Users</a>.</div>';
        } else{
            echo '<br>'. '<div>Track your pokedex progress at <a href="pokedex">Pokedex</a>. </div>';
            echo '<br>'. '<div>Access the user community at <a href="user-community">Community</a>. </div>';
            echo '<br>'. "<div>You don't have administrator privileges. Ask an admin to assign them for you.</div>";
        }
    } else{
        echo '<br>'. '<div>You are not logged in. <a href="login">Login</a> to access personal pokedex features. <a href="register">Register</a> if you don\'t have an account.</div>';
    }
    ?>

</section>
