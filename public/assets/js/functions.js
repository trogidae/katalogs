
/*======= ADMIN PANEL ====================================================*/
/* Add featured image (items/edit and items/create) */
var addFeaturedImage = function(click, allClicks, input) {
    var newValue = click.attr('id');
    newValue = newValue.split("-");
    newValue = newValue[1];
    if (newValue==input.val()) {
        input.val("");
        click.text('Add as featured image');
        click.removeClass('btn-danger');
        click.addClass('btn-primary');
        //Remove previously added featured image preview
        $('.featured-image-info p').html("No image chosen")
    }
    else {
        input.val(newValue);
        allClicks.text('Add as featured image');
        allClicks.removeClass('btn-danger');
        allClicks.addClass('btn-primary');
        click.text('Remove as featured image');
        click.removeClass('btn-primary');
        click.addClass('btn-danger');
        //Add newly added image to featured image preview
        var imgsrc= $("#image-" + newValue).attr('src');
        $('.featured-image-info p').html('<img src="'+ imgsrc + '" alt=""> ');
    }
};

/* Select all (images/index) */
var selectAll = function (click, elements) {
    if (click.text()=='Select all') {
        click.text('Unselect all');
        elements.each(function(){
            $(this).prop("checked", true);
        })
    }
    else {
        click.text('Select all');
        elements.each(function(){
            $(this).prop("checked", false);
        })
    }
    return false;
};

/* Add checked gallery images to hidden input (items/edit and items/create) */
var addGalleryCheck = function (checkbox, hiddenInput) {
    var split;
    if (checkbox.prop('checked')) {
        hiddenInput.val(hiddenInput.val() + "," + checkbox.attr('id'));
        //Add newly added image to gallery image preview
        var imgsrc= $("#image-" + checkbox.attr('id')).attr('src');
        var galleryInfo = $('.gallery-info p');
        if (galleryInfo.text()=="No images chosen") galleryInfo.text('');
        var oldHtml = galleryInfo.html();
        galleryInfo.html(oldHtml + '<img src="'+ imgsrc + '" alt=""> ');
    }
    else {
        split = hiddenInput.val().split(",");
        var i=0;
        while (!(split[i]===undefined)) {
            if (split[i]==checkbox.attr('id')) split[i]=0;
            i++;
        }
        hiddenInput.val(split.join(","));
        //Remove image from gallery image preview
        var imgsrc= $("#image-" + checkbox.attr('id')).attr('src');
        $('.gallery-info p img[src$="'+ imgsrc +'"]').remove();
        if ($('.gallery-info p img').length == 0) $('.gallery-info p').text("No images chosen");
    }
};

/* Check already added images to gallery (items/edit) */
var fillGalleryCheck = function (hiddenInput) {
    var values = hiddenInput.val().split(",");
    var imgsrc = "";
    var oldHtml = "";
    var galleryInfo = $('.gallery-info p');
    var i=1;
    while (!(values[i]===undefined)) {
        $("input#" + values[i]).prop('checked', true);
        //Add newly added image to gallery image preview
        imgsrc= $("#image-" + values[i]).attr('src');
        if ($('.gallery-info p img[src$="'+ imgsrc +'"]').length==0) {
            if (galleryInfo.text()=="No images chosen") galleryInfo.text('');
            oldHtml = galleryInfo.html();
            galleryInfo.html(oldHtml + '<img src="'+ imgsrc + '" alt=""> ');
        }
        i++;
    }
};

/* Check/Add the added featured image to item (items/edit) */
var fillFeaturedImage = function (hiddenInput) {
    var img = hiddenInput.val();
    if (img!="1") {
        var button = $('#featured-' + img);
        button.text("Remove as featured image");
        button.removeClass('btn-primary');
        button.addClass('btn-danger');
        //Add saved featured image to featured image preview
        var imgsrc= $("#image-" + img).attr('src');
        $('.featured-image-info p').html('<img src="'+ imgsrc + '" alt=""> ');
    }

}


