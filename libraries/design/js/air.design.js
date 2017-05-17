

$(document).ready(function () {

       //Header Fixed
    $(window).scroll(function(){
       var header = $('.scrollFixed'),
       scroll = $(window).scrollTop();

       if(scroll >= 40){
        header.addClass('ad-fixed');
        $('.logo1').css('display','none');
        $('.logo2').css('display','block');
       }
        else {
            header.removeClass('ad-fixed');
            $('.logo1').css('display','block');
        $('.logo2').css('display','none');
        }
    });

    // smoothScrolling

    $('a[href*="#"]:not([href="#"])').click(function(){

       if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname){
           var target = $(this.hash);
           target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

           if(target.length){
               $('html,body').animate({
                   scrollTop: target.offset().top
               }, 1000);
               return false;
           }
       }
    });


    // //Select * .ad-input and append <hr> to it

    // var adInput = $('.ad-input');
    // adInput.append('<u></u>');

    // var line = $('.ad-input u');
    // var input = $(".ad-input input");



    //User Component

    var userComp = $('.ad-user[ad-count]');
    userComp.append('<span>' + userComp.attr('ad-count') + '</span>');
    var userCount = $('.ad-user[ad-count] span');

    userCount.css('margin-left', userComp.width())


//ad-modal popUp

$('.ad-modal-trigger[ad-modal]').click(function(e){
   var $this = $(this);
//    $('.ad-modal#'+$this.attr('ad-modal')).css({'left': e.pageX},{'top': e.pageX});
   $('.ad-modal#'+$this.attr('ad-modal')).addClass('ad-show');
    console.log('x value is: '+ e.pageX + '; Y value is: '+ e.pageY);
});

$('.close-modal').click(function(){
   $('.ad-modal').removeClass('ad-show');
});


//ad-accordian

$('.ad-accordian .ad-head').click(function(){
    var $this = $(this);
    $this.toggleClass('ad-show');
})


// ad-tab

$('.ad-tab .ad-head li').click(function(){
    var $this = $(this);
    $('.ad-tab .ad-head li.active').removeClass('active');
    $this.addClass('active');
    $this.parents('.ad-tab').find('.ad-body div.ad-show').removeClass('ad-show')
    $this.parents('.ad-tab').find('.ad-body #'+$this.attr('ad-tab')+'').addClass('ad-show');
})




    //SideMenu Menu-Bar trigger
    ////Responsive
    // Optimalisation: Store the references outside the event handler:
    var $window = $(window);



    //Toggle List View


    //ad-cardView Toggle

    $('.ad-cardView .ad-data').click(function($e){

        $(this).find('.ad-front').toggleClass('ad-slideUp');

    })


    //Dropdown
    $('.ad-dropdown .ad-trigger').click(function(event){
      event.stopPropagation();
      $('.ad-dropdown .ad-content').removeClass('visible');
      $(this).parent('.ad-dropdown').find('.ad-content').addClass('visible');

    });


    // disable dropdown at body's click
    $('body').click(function(){
      $('.ad-dropdown .ad-content').removeClass('visible');
    });



});
