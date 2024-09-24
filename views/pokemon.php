<h1>
<span>No. <?php echo $pokemon_id; ?></span>
<span><?php echo $name; ?></span>
</h1>



<?php if ($user) : ?>
    <?php if ($user_id) : ?>  <a class='catch-container-a' href="pokedex/<?php echo $pokemon_id; ?>/catch"><div class='catch-container caught'><?php echo $name; ?> is caught. Click to Reset <div class="catch-container-pokeball-overlay red-pokeball"></div></div></a>
    <?php else: ?>
        <a class='catch-container-a' href="pokedex/<?php echo $pokemon_id; ?>/catch"><div class='catch-container notcaught'><?php echo $name; ?> is not caught. Click to Catch</div></a>
    <?php endif; ?>
<?php endif; ?>


<div class="img-container">
    <img class="pokemon-image" src=<?php echo $img_url; ?> alt='<?php echo $name;?>'>
</div>

<div class="type-container">
    <span class='typebox type-<?php echo strtolower($type1); ?>'><?php echo strtoupper($type1); ?></span>
    <?php if ($type2) : ?>
        <span class='typebox type-<?php echo strtolower($type2); ?>'><?php echo strtoupper($type2); ?></span>
    <?php endif ?>
</div>

<h3>Description</h3>
<div class="description-container">
    <?php echo $content; ?>
</div>

<br>

<h3>Base Stats</h3>
<div class="base-stat-container">
    <table class="stats-table">
        <thead>
            <th></th>
            <th></th>
            <th></th>  
        </thead>
        <tbody>
            <tr>
            <td>HP</td>
            <td><?php echo $hp; ?></td>
            <td>
                <div class="stats-bar">
                <div class="stats-bar-fill" style="width: <?php echo round(($hp/180)*100); ?>%;"></div>
                </div>
            </td>
            </tr>

            <tr>
            <td>ATTACK</td>
            <td><?php echo $attack; ?></td>
            <td>
                <div class="stats-bar">
                <div class="stats-bar-fill" style="width: <?php echo round(($attack/180)*100); ?>%;"></div>
                </div>
            </td>
            </tr>

            <tr>
            <td>DEFENSE</td>
            <td><?php echo $defense; ?></td>
            <td>
                <div class="stats-bar">
                <div class="stats-bar-fill" style="width: <?php echo round(($defense/180)*100); ?>%;"></div>
                </div>
            </td>
            </tr>

            <tr>
            <td>SPECIAL ATTACK</td>
            <td><?php echo $sp_attack; ?></td>
            <td>
                <div class="stats-bar">
                <div class="stats-bar-fill" style="width: <?php echo round(($sp_attack/180)*100); ?>%;"></div>
                </div>
            </td>
            </tr>

            <tr>
            <td>SPECIAL DEFENSE</td>
            <td><?php echo $sp_defense; ?></td>
            <td>
                <div class="stats-bar">
                <div class="stats-bar-fill" style="width: <?php echo round(($sp_defense/180)*100); ?>%;"></div>
                </div>
            </td>
            </tr>

            <tr>
            <td>SPEED</td>
            <td><?php echo $speed; ?></td>
            <td>
                <div class="stats-bar">
                <div class="stats-bar-fill" style="width: <?php echo round(($speed/180)*100); ?>%;"></div>
                </div>
            </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td><?php echo $total; ?></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

<?php if($admin):?>
<a href="pokedex-editor/<?php echo $pokemon_id; ?>">Edit</a>
<a href="pokedex/<?php echo $pokemon_id; ?>/remove">Remove</a>
<?php endif ?>