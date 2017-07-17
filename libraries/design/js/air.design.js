$(document).ready(function () {


  var wrapper = $('body');
  // var airlement = { "1":"ad-router",
  //                   "2":"ad-loading",
  //                   "3":"ad-header",
  //                   "4":"ad-subheader",
  //                   "5":"ad-nav",
  //                   "6":"ad-footer",
  //                   "7":"ad-section",
  //                   "8":"ad-card",
  //                   "9":"ad-modal",
  //                   "10":"ad-table",
  //                   "11":"ad-list",
  //                   "12":"ad-item",
  //                   "13":"ad-avatar",
  //                   "14":"ad-thumbnail",
  //                   "15":"ad-input",
  //                   "16":"ad-tab",
  //                   "17":"ad-accordian",
  //                   "18":"ad-head",
  //                   "19":"ad-body",
  //                   "20":"ad-content"
  //                 };
  //
  //

  // Button to hide and show the sideMenu
  $('#ad-menu-toggle').click(function() {
    $('ad-left').toggleClass('ad-hide');
  });
  
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

    // console.log(triggerPosition.top);
});

wrapper.on('click','.ad-close-modal',function(){
  console.log('clicked');
  var $modal = $('.ad-modal, ad-modal');
   $modal.removeClass('ad-show');
   $modal.removeAttr('style');
   $modal.hasClass('ad-blur') ? $('.wrapper, .wrapper-fluid').css('filter','blur(0)'):'';
});







//ad-accordian

wrapper.on('click','.ad-accordian .ad-head, ad-accordian ad-head',function(){
    var $this = $(this);
    $this.toggleClass('ad-show');
});


// ad-tab

wrapper.on('click','.ad-tab .ad-head li, ad-tab ad-head li',function(){
    var $this = $(this);
    $this.parents('.ad-tab, ad-tab').find('li').removeClass('active');
    $this.addClass('active');
    $this.parents('.ad-tab, ad-tab').find('.ad-body div.ad-show, ad-body ad-content.ad-show').removeClass('ad-show')
    $this.parents('.ad-tab, ad-tab').find('.ad-body #'+$this.attr('ad-tab')+','+'ad-body ad-content#'+$this.attr('ad-tab')+'').addClass('ad-show');
});


    //ad-cardView Toggle

    wrapper.on('click','.ad-cardView .ad-data',function(e){
        $(this).find('.ad-front').toggleClass('ad-slideUp');
    });


    //Dropdown
    wrapper.on('click','.ad-dropdown .ad-trigger, ad-dropdown .ad-trigger',function(e){
      e.stopPropagation();
      $('.ad-dropdown .ad-content, ad-dropdown ad-content').removeClass('ad-show');
      $(this).parent('.ad-dropdown, ad-dropdown').find('.ad-content, ad-content').addClass('ad-show');

    });

    wrapper.on('click','.ad-dropdown .ad-content, ad-dropdown ad-content', function(e){
      e.stopPropagation();
    });


    // disable dropdown at body's click
    wrapper.click(function(){
      $('.ad-dropdown .ad-content, ad-dropdown ad-content').removeClass('ad-show');
    });



});
