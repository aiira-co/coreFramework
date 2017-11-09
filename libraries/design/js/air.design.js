$(document).ready(function () {


    var wrapper = $('body');

    // Button to hide and show the sideMenu
    $('#ad-menu-toggle').click(function () {
        $('ad-left').toggleClass('ad-hide');
    });

    //Header Fixed
    $(window).scroll(function () {
        var header = $('.scrollFixed'),
            scroll = $(window).scrollTop();

        if (scroll >= 58) {
            header.addClass('ad-fixed');
            $('.logo1').css('display', 'none');
            $('.logo2').css('display', 'block');
        } else {
            header.removeClass('ad-fixed');
            $('.logo1').css('display', 'block');
            $('.logo2').css('display', 'none');
        }
    });



    function ScanDOM4Constructive() {
        // tab

        if (wrapper.find('.ad-tab-group, ad-tab-group').not('[ad_constructed]').length !== 0) {

            constructTab();
        }
    }


    // ScanDOM4Constructive
    ScanDOM4Constructive();
    setInterval(function () {
        ScanDOM4Constructive();
    }, 3000);

    // Nav

    function checkNav() {
        if ($('.ad-nav #menuTrigger').length != 0) {
            // console.log('nav found menuTrigger found');
            var adLogo = $('.ad-nav .ad-logo').html();
            var adMenu = $('.ad-nav .ad-menu').html();
            wrapper.prepend('<div class="menuTriggered"><div class="ad-logo">' + adLogo + '</div>' + adMenu + '</div>');
        }
    }


    checkNav();


    $('#menuTrigger').click(function () {
        $('.menuTriggered').toggleClass('ad-show');
    });


    // smoothScrolling

    $('a[href*="#"]:not([href="#"])').click(function () {

        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });



    //ad-modal popUp

    $('.ad-modal-trigger[ad-modal]').click(function (e) {
        var $this = $(this);
        //    $('.ad-modal#'+$this.attr('ad-modal')).css({'left': e.pageX},{'top': e.pageX});
        var $modal = $('.ad-modal#' + $this.attr('ad-modal'));

        var triggerPosition = {
            top: e.pageY - window.pageYOffset + 'px',
            left: e.pageX + 'px'
        };

        $modal.css('left', triggerPosition.left);
        $modal.css('top', triggerPosition.top);

        $modal.hasClass('ad-blur') ? $('.wrapper, .wrapper-fluid').css('filter', 'blur(3px)') : '';

        $modal.addClass('ad-show');

        $modal.removeAttr('style');

        //  $modal.animate({'top':window.innerHeight * .3} ,6000);
        //  $modal.animate({'left':window.innerWidth * .5 } ,6000);
        // //  $modal.css('top','20%');
        // console.log('e.pageX value is: '+ e.pageX + ' e.pageX value is: '+ e.pageY);

        // console.log(triggerPosition.top);
    });

    wrapper.on('click', '.ad-close-modal', function () {
        // console.log('clicked');
        var $modal = $('.ad-modal, ad-modal');
        $modal.removeClass('ad-show');
        $modal.removeAttr('style');
        $modal.hasClass('ad-blur') ? $('.wrapper, .wrapper-fluid').css('filter', 'blur(0)') : '';
    });







    //ad-accordian

    wrapper.on('click', '.ad-accordian .ad-head', function () {
        var $this = $(this);
        $this.toggleClass('ad-show');
    });

    wrapper.on('click', 'ad-accordian ad-head', function () {
        var $this = $(this);
        $this.toggleClass('ad-show');
    });


    // ad-tab-group

    // Scan DOM for ad-tab-group and construct the ad-head
    function constructTab() {

        $('.ad-tab-group, ad-tab-group').not('[ad_constructed]').each(function () {

            // Check is the .ad-head is not already generated
            if ($(this).find('.ad-head').length == 0) {

                let adTab = $(this).find('.ad-tab[label], ad-tab[label]');

                let list = '';
                adTab.each(function () {
                    // console.log($(this).attr('label'));
                    if ($(this).hasClass('ad-show')) {
                        list += '<li class="active">' + $(this).attr('label') + '</li>';
                    } else {

                        list += '<li>' + $(this).attr('label') + '</li>';
                    }

                });

                let head = '<div class="ad-head"><ul>' + list + '</ul></div>';
                $(this).prepend(head);
            }


            // Mark as Constructed
            $(this).attr('ad_constructed', true);

        });
    }



    wrapper.on('click', '.ad-tab-group .ad-head li, ad-tab-group .ad-head li', function () {
        var $this = $(this);
        $this.parents('.ad-tab-group, ad-tab-group').find('.ad-head li').removeClass('active');
        $this.addClass('active');
        $this.parents('.ad-tab-group, ad-tab-group').find('.ad-tab.ad-show, ad-tab.ad-show').removeClass('ad-show');

        // check Matching ad-tab label

        $this.parents('.ad-tab-group, ad-tab-group')
            .find('.ad-tab, ad-tab').each(function () {
                if ($(this).attr('label') == $this.text()) {
                    $(this).addClass('ad-show');
                }
            })


    });




    //ad-cardView Toggle

    wrapper.on('click', '.ad-cardView .ad-data', function (e) {
        $(this).find('.ad-front').toggleClass('ad-slideUp');
    });


    //Dropdown
    wrapper.on('click', '.ad-dropdown .ad-trigger, ad-dropdown .ad-trigger', function (e) {
        e.stopPropagation();
        $('.ad-dropdown .ad-content, ad-dropdown ad-content').removeClass('ad-show');
        $(this).parent('.ad-dropdown, ad-dropdown').find('.ad-content, ad-content').addClass('ad-show');

    });

    wrapper.on('click', '.ad-dropdown .ad-content, ad-dropdown ad-content', function (e) {
        e.stopPropagation();
    });


    // disable dropdown at body's click
    wrapper.click(function () {
        $('.ad-dropdown .ad-content, ad-dropdown ad-content').removeClass('ad-show');
    });



});