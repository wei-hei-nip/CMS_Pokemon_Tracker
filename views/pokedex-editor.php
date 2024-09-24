<style>
    .type-select {
        width: 150px;
    }

</style>

<header>
    <h1><?php echo $this->head['title']; ?></h1>
</header>

<form method="POST">
    <h3>Basic Info</h3>
    Pokemon ID:<br>
    <!-- pokemon id read only if editing existing pokemon-->
    <input type="number" name="pokemon_id" value="<?php echo $pokemon['pokemon_id']; ?>" <?php if ($pokemon['pokemon_id']): ?> readonly <?php endif; ?>>

    <br>Name:<br>
    <input type="text" name="name" value="<?php echo $pokemon['name']; ?>" >
    
    <br>Primary Type:<br>
    <?php $typeOptions = array('bug', 'dark', 'dragon', 'electric', 'fairy', 'fighting', 'fire', 'flying', 'ghost', 'grass', 'ground', 'ice', 'normal', 'poison', 'psychic', 'rock', 'steel', 'water');?>
    <select name="type1" class='type-select'>
        <option <?php echo $pokemon['type1']; ?>><?php echo ucfirst($pokemon['type1']); ?></option>
        <?php foreach ($typeOptions as $type): ?>
            <?php if ($pokemon['type1'] != $type): ?>
                <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>

    <br>Secondary Type:<br>
    <select name="type2" class='type-select'>
        <?php if ($pokemon['type2']):?><option <?php echo $pokemon['type2']; ?>><?php echo ucfirst($pokemon['type2']); ?></option><?php endif ?>
        <option value="">No Secondary Type</option>
        <?php foreach ($typeOptions as $type): ?>
            <?php if ($pokemon['type1'] != $type): ?>
                <option value="<?php echo $type; ?>"><?php echo ucfirst($type); ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>

    
    <h3>Basic Stats</h3>
    Total:<br>
    <input type="number" name="total" value="<?php echo $pokemon['total']; ?>" />
    <br>HP:<br>
    <input type="number" name="hp" value="<?php echo $pokemon['hp']; ?>" />
    <br>Attack:<br>
    <input type="number" name="attack" value="<?php echo $pokemon['attack']; ?>" />
    <br>Defense:<br>
    <input type="number" name="defense" value="<?php echo $pokemon['defense']; ?>" />
    <br>Special Attack:<br>
    <input type="number" name="sp_attack" value="<?php echo $pokemon['sp_attack']; ?>" />
    <br>Special Defense:<br>
    <input type="number" name="sp_defense" value="<?php echo $pokemon['sp_defense']; ?>" />
    <br>Speed:<br>
    <input type="number" name="speed" value="<?php echo $pokemon['speed']; ?>" />

    <h3>Image</h3>
    Image Link:<br>
    <input type="text" name="img_url" value="<?php echo $pokemon['img_url']; ?>" />
    
    <br>Thumbnail (Sprite) Link:<br>
    <input type="text" name="sprit_url" value='<?php echo $pokemon['sprit_url']; ?>' />

    <textarea name="content"><?php echo $pokemon['content']; ?></textarea>

    <input type="submit" value="Save Pokemon" />
</form>

<script type="text/javascript" src="views/assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea[name=content]",
        plugins: [
            "advlist", "autolink", "lists", "link", "image", "code", "charmap", "anchor",
            "searchreplace", "visualblocks", "code", "fullscreen",
            "insertdatetime", "media", "table", "wordcount"
        ],
        toolbar: "insertfile inserttable undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | source code | fullscreen"
    });
</script>