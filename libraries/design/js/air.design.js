

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




    //User Component

    var userComp = $('.ad-user[ad-count]');
    userComp.append('<span>' + userComp.attr('ad-count') + '</span>');
    var userCount = $('.ad-user[ad-count] span');

    userCount.css('margin-left', userComp.width())


//ad-modal popUp

$('.ad-modal-trigger[ad-modal]').click(function(e){
   var $this = $(this);
//    $('.ad-modal#'+$this.attr('ad-modal')).css({'left': e.pageX},{'top': e.pageX});
  var $modal = $('.ad-modal#'+$this.attr('ad-modal'));

   var triggerPosition = {top: e.pageY - window.pageYOffset + 'px', left: e.pageX + 'px'} ;

   $modal.css('left',triggerPosition.left);
   $modal.css('top',triggerPosition.top);

   $modal.hasClass('ad-blur') ? $('.wrapper, .wrapper-fluid').css('filter','blur(3px)'):'';

   $modal.addClass('ad-show');

   $modal.removeAttr('style');

  //  $modal.animate({'top':window.innerHeight * .3} ,6000);
  //  $modal.animate({'left':window.innerWidth * .5 } ,6000);
  // //  $modal.css('top','20%');
    // console.log('e.pageX value is: '+ e.pageX + ' e.pageX value is: '+ e.pageY);

    console.log(triggerPosition.top);
});

$('.ad-close-modal').click(function(){
  var $modal = $('.ad-modal');
   $modal.removeClass('ad-show');
   $modal.removeAttr('style');
   $modal.hasClass('ad-blur') ? $('.wrapper, .wrapper-fluid').css('filter','blur(0)'):'';
});







//ad-accordian

$('.ad-accordian .ad-head').click(function(){
    var $this = $(this);
    $this.toggleClass('ad-show');
});







// ad-tab

$('.ad-tab .ad-head li').click(function(){
    var $this = $(this);
    $this.parents('.ad-tab').find('li[ad-tab]').removeClass('active');
    $this.addClass('active');
    $this.parents('.ad-tab').find('.ad-body div.ad-show').removeClass('ad-show')
    $this.parents('.ad-tab').find('.ad-body #'+$this.attr('ad-tab')+'').addClass('ad-show');
});


    //ad-cardView Toggle

    $('.ad-cardView .ad-data').click(function($e){
        $(this).find('.ad-front').toggleClass('ad-slideUp');
    });


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
