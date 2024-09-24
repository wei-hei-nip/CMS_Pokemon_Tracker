<header>
    <h1><?php echo 'Update '.number_format($version_number, 2).' : '. $title?></h1>
</header>

<section>
    <?php echo $content. '<br>'; ?>
    <?php echo '<br> <div>'. 'Created at: '.$created_at. '</div>'.'<div>'. 'Updated at: '. $updated_at. '</div>'; ?>
    <?php if ($admin) : ?>
        <br />
        <a href="update-editor/<?php echo $url; ?>">Edit</a>
        <a href="update/<?php echo $url; ?>/remove">Remove</a>
    <?php endif ?>
</section>