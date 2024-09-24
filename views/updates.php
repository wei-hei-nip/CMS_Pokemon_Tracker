<header>
    <h1><?php echo $this->head['title']; ?></h1>
</header>

<?php if ($admin) : ?>
<h2><a href="update-editor">+ Add Update Announcement</a></h2>
<?php endif ?>

<table class = 'update-table'>
    <?php foreach ($updates as $update) : ?>
        <tr>
            <td class = 'update-box'>
                <h2><a href="update/<?php echo $update['url'] ?>"><?php echo 'Update '.number_format($update['version_number'], 2).' : '. $update['title']?></a></h2>
                <?php echo $update['content']; ?>
                <?php if ($admin) : ?>
                    <br />
                    <a href="update-editor/<?php echo $update['url']; ?>">Edit</a>
                    <a href="update/<?php echo $update['url']; ?>/remove">Remove</a>
                <?php endif ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>