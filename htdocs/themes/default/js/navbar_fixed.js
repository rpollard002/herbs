
$(document).ready(function()
{
    //Calculate the height of <header>
    //Use outerHeight() instead of height() if have padding
    var aboveHeight = $('nav').outerHeight() - 30;
    var aboveButtonBarHeight = ($('.button_bar').outerHeight()) + aboveHeight;
    console.log("Above height: " + aboveHeight + " button bar height: " + aboveButtonBarHeight);
    //when scroll
    $(window).scroll(function(){

        //if scrolled down more than the header’s height
        if ($(window).scrollTop() > aboveHeight){

            // if yes, add “fixed” class to the <nav>
            // add padding top to the #content
            // (value is same as the height of the nav)
            $('nav').addClass('fixed').css('top','0').next()
                .css('padding-top','60px');

        } else {

            // when scroll up or less than aboveHeight,
            // remove the “fixed” class, and the padding-top
            $('nav').removeClass('fixed').next()
                .css('padding-top','0');
        }
        //if scrolled down more than the header’s height
        if ($(window).scrollTop() > aboveButtonBarHeight){

            // if yes, add “fixed” class to the <nav>
            // add padding top to the #content
            // (value is same as the height of the nav)
            $('div#button_bar_id').addClass('fixed').css('top','71px').next()
                .css('padding-top','0px');

        } else {

            // when scroll up or less than aboveHeight,
            // remove the “fixed” class, and the padding-top
            $('div#button_bar_id').removeClass('fixed').next()
                .css('padding-top','0');
        }
    });
});