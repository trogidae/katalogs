
<?php echo render('admin\images/image-list', $images); ?>
<script>
    $(document).ready(function(){
        $('#image-list-link').on('click', function(){
            $('#image-list').load('<?php echo Finder::search('images', 'image-list/index'); ?> #image-list');
        })
    });
</script>