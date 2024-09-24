<header>
  <h1><?php echo $this->head['title']; ?></h1>
</header>

<div id="pokedex-grid">
    <div class="pokedex-container">
        <?php foreach ($pokemons as $pokemon) : ?>
            
            <div class="pokedex-box">
            <?php if ($my_pokedex) : ?>
              <a href='pokedex/<?php echo $pokemon['pokemon_id'];?>'> <img class="pokemon-sprit" src='<?php echo $pokemon['sprit_url'];?>' alt='<?php echo $pokemon['name'];?>'> </a>
              <?php if ($pokemon['user_id']) : ?>  <div class="pokedex-pokeball-overlay <?php echo $pokeball_icon;?>-pokeball"></div> <?php endif; ?>
              <a class="pokemon-info" href='pokedex/<?php echo $pokemon['pokemon_id'];?>'>
                <span class="pokemon-number">No. <?php echo $pokemon['pokemon_id'];?></span>    
                <span class="pokemon-name"><?php echo $pokemon['name'];?></span>
              </a>
            <?php else: ?>
              <img class="pokemon-sprit" src='<?php echo $pokemon['sprit_url'];?>' alt='<?php echo $pokemon['name'];?>'>
              <?php if ($pokemon['user_id']) : ?>  <div class="pokedex-pokeball-overlay <?php echo $pokeball_icon;?>-pokeball"></div> <?php endif; ?>
              <a>  
                <span class="pokemon-number">No. <?php echo $pokemon['pokemon_id'];?></span>    
                <span class="pokemon-name"><?php echo $pokemon['name'];?></span>
              </a>
            <?php endif; ?>
              

                
            </div>
        <?php endforeach ?>
        
        <?php if ($admin) : ?>
            <div class="pokedex-box">
                  <a href='pokedex-editor'><h2>Add Pokemon</h2></a>
    
            </div>
        <?php endif ?>

    </div>
</div>