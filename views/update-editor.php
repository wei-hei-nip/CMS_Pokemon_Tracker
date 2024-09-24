<header>
  <h1><?php echo $this->head['title']; ?></h1>
</header>

<?php date_default_timezone_set('Europe/London');?>
<form method="POST">
    <input type="hidden" name="update_id" value="<?php echo $update['update_id']; ?>" />
    
    <input type="hidden" name="created_at" value="<?php 
    if ($update['created_at']){
        
        echo $update['created_at'];
    }else{
        
        echo date('m/d/Y h:i:s a', time());
    }
    ?>" />

    <input type="hidden" name="updated_at" value="<?php echo date('m/d/Y h:i:s a', time()); ?>" />
    Version Number<br/>
    <input type="text" name="version_number" value="<?php echo $update['version_number']; ?>" /><br />
    Title<br />
    <input type="text" name="title" value="<?php echo $update['title']; ?>" /><br />
    URL<br />
    <input type="text" name="url" value="<?php echo $update['url']; ?>" /><br />
    <textarea name="content"><?php echo $update['content']; ?></textarea>
    <input type="submit" value="Save Update" />
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