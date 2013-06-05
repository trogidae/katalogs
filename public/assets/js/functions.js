
/*======= ADMIN PANEL ====================================================*/
/* Add featured image (items/edit and items/create) */
var addFeaturedImage = function(click, allClicks, input, textNoImg, textAdd, textRemove) {
    var newValue = click.attr('id');
    newValue = newValue.split("-");
    newValue = newValue[1];
    if (newValue==input.val()) {
        input.val("");
        click.text(textAdd);
        click.removeClass('btn-danger');
        click.addClass('btn-primary');
        //Remove previously added featured image preview
        $('.featured-image-info p').html(textNoImg);
    }
    else {
        input.val(newValue);
        allClicks.text(textAdd);
        allClicks.removeClass('btn-danger');
        allClicks.addClass('btn-primary');
        click.text(textRemove);
        click.removeClass('btn-primary');
        click.addClass('btn-danger');
        //Add newly added image to featured image preview
        var imgsrc= $("#image-" + newValue).attr('src');
        $('.featured-image-info p').html('<img src="'+ imgsrc + '" alt=""> ');
    }
    return false;
};

/* Select all (images/index) */
var selectAll = function (click, elements, selectall, unselectall) {
    if (click.text()==selectall) {
        click.text(unselectall);
        elements.each(function(){
            $(this).prop("checked", true);
        })
    }
    else {
        click.text(selectall);
        elements.each(function(){
            $(this).prop("checked", false);
        })
    }
    return false;
};

/* Add checked gallery images to hidden input (items/edit and items/create) */
var addGalleryCheck = function (checkbox, hiddenInput, text) {
    var split;
    if (checkbox.prop('checked')) {
        hiddenInput.val(hiddenInput.val() + "," + checkbox.attr('id'));
        //Add newly added image to gallery image preview
        var imgsrc= $("#image-" + checkbox.attr('id')).attr('src');
        var galleryInfo = $('.gallery-info p');
        if (galleryInfo.text()==text) galleryInfo.text('');
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
        if ($('.gallery-info p img').length == 0) $('.gallery-info p').text(text);
    }
};

/* Check already added images to gallery (items/edit) */
var fillGalleryCheck = function (hiddenInput, text) {
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
            if (galleryInfo.text()==text) galleryInfo.text('');
            oldHtml = galleryInfo.html();
            galleryInfo.html(oldHtml + '<img src="'+ imgsrc + '" alt=""> ');
        }
        i++;
    }
};

/* Check/Add the added featured image to item (items/edit) */
var fillFeaturedImage = function (hiddenInput, textRemove) {
    var img = hiddenInput.val();
    if (img!="1") {
        var button = $('#featured-' + img);
        button.text(textRemove);
        button.removeClass('btn-primary');
        button.addClass('btn-danger');
        //Add saved featured image to featured image preview
        var imgsrc= $("#image-" + img).attr('src');
        $('.featured-image-info p').html('<img src="'+ imgsrc + '" alt=""> ');
    }

}

/* Change main image to thumb image on click */
var changeMainImage = function (newImage, mainImage) {
    mainImage.attr('href', newImage.attr('href'));
    mainImage.find('img').attr('src', newImage.attr('href'));
}

/* Set equal height to columns */
var equalHeights = function(mainCol, sideCol) {
    var maxHeight = 0;
    if (mainCol.height()>sideCol.height()) {
        maxHeight = mainCol.height();
    }
    else {
        maxHeight = sideCol.height()
    }
    mainCol.height(maxHeight);
    sideCol.height(maxHeight);
};

var sameHeight = function (row, item) {
    row.each(function() {
        var maxHeight = 0;
        $(this).find(item).each(function() {
            if ($(this).height()>maxHeight) maxHeight = $(this).height();
        });
        $(this).find(item).each(function() {
            $(this).height(maxHeight);
        });
    });
};
