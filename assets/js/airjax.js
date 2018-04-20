$(document).ready(function () {

  var ajaxURL = $('base').attr('url') + 'core/cqured.php';
  var wrapper = $('body');

  //to clear input forms after submission
  var clearFormInputs = null;
  // navigate to url onn success submission
  var inputRouterLink = null;

  var url;
  // MOUSE EVENTS
  //Responsible for handling click Events

  wrapper.on('click', '[\\(click\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    // console.log($(this).attr('(click)'));
    processEvent($(this), $(this).attr('(click)'));
  });


  // on('hover') not working but $.hover works
  wrapper.on('mousedown', '[\\(mousedown\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('(mousedown)'));
  });


  // on('hover') not working but $.hover works
  wrapper.on('mouseenter', '[\\(mouseenter\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('(mouseenter)'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mouseleave', '[\\(mouseleave\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('(mouseleave)'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mousemove', '[\\(mousemove\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('(mousemove)'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mouseout', '[\\(mouseout\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('(mouseout)'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mouseup', '[\\(mouseup\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('(mouseup)'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mouseover', '[\\(mouseover\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('(mouseover)'));
  });


  // INPUT EVENTS
  wrapper.on('blur', 'input[\\(blur\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    let inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('(blur)'), inputValue);
  });


  // KEY BOARDING EVENTS

  // for keypress, to search, that is auto-complete
  wrapper.on('keypress', 'input[\\(keypress\\)]', function () {
    // e.preventDefault();
    wrapper.append('<ad-loading/>');
    let inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('(keypress)'), inputValue);

  });

  // for keydown, to search, that is auto-complete
  wrapper.on('keydown', 'input[\\(keydown\\)]', function () {
    // e.preventDefault();
    wrapper.append('<ad-loading/>');
    let inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('(keydown)'), inputValue);

  });

  // for keydown, to search, that is auto-complete
  wrapper.on('keyup', 'input[\\(keyup\\)]', function () {
    // e.preventDefault();
    wrapper.append('<ad-loading/>');
    let inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('(keyup)'), inputValue);

  });


  // for keypress, to search, that is auto-complete
  wrapper.on('change', 'input[\\(change\\)], select[\\(change\\)]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    let inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('(change)'), inputValue);

    // console.log('change event triggered');
  });

  //on submit for forms
  wrapper.on('submit', 'form[\\(submit\\)]', function (e) {
    // stop post to refresh page
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    let formData = $(this).serialize();

    //Check to clear data after submit or to navigate
    if ($(this)[0].hasAttribute('ad-form')) {
      // check for inputs with ad-clear to clear them on success
      clearFormInputs = $(this);
    } else {
      clearFormInputs = null;

    }

    if ($(this)[0].hasAttribute('action')) {
      //router to action on save
      inputRouterLink = $(this).attr('action');
    } else {
      inputRouterLink = null;
    }


    processEvent($(this), $(this).attr('(submit)'), formData);

  });



  function clearForm(form) {
    // after submission, empty the inputs
    form.find('[ad-clear]').each(function () {
      $(this)[0].value='';
      // console.log($(this));

    });
  }


  //responsible for getting data to be airJax-ed
  function processEvent(trigger, eventData, triggerData = "") {
    // console.log(trigger);
    let airData = $.param(airThod(eventData));
    let data = airData + '&' + triggerData;
      let outlet='';
      let dataType ='';

    if(trigger[0].hasAttribute('[outlet]')){
          // console.log('outlet found');
         outlet = $('#' + trigger.attr('[outlet]') + '');
         dataType = trigger[0].hasAttribute('[data-type]') ? trigger.attr('[data-type]') : 'html';
    }else{
        // console.log('no outlet was found');
         outlet = 'ad-notify';
         dataType = trigger[0].hasAttribute('[data-type]') ? trigger.attr('[data-type]') : 'json';
    }


    // var outlet = trigger[0].hasAttribute('[outlet]') ? $('#' + trigger.attr('[outlet]') + '') : 'ad-notify';
    // if outlet is set, then automatically the dataType should be html ubless specified

    requestAirJax(ajaxURL, data, 'POST', dataType, {
      'outlet': outlet,
      'animate': true
    });
  }

  // This function takes the attrubute value and convert them
  // to method and parameters fo the php file
  function airThod(airValue) {
    //slipt string into mehtod and parameters
    split = airValue.split('(');

    method = split[0];
    airParams = split[1].trim().replace(')', ''); //trim the side ) off
    url = window.location.href.split($('base').attr('url'))[1];
    // console.log(airParams.length);
    if (airParams.length != 0) {

      airParams = airParams.split(','); //make it object for multiple parameters for the method

      count = airParams.length;

      // console.log(count);
      for (i = 0; i < count; i++) {
        // console.log(airParams[i]);
        if (airParams[i][0] == '$') {
          // console.log('yes');
          airParams[i] = $('#' + airParams[i].trim().replace('$', '')).val();
        }
      }


      return {
        'airJaxPath': url,
        'method': method,
        'airParams': airParams
      };
    }

    // var airthod =
    // console.log(airthod);\

    // console.log(url);
    return {
      'airJaxPath': url,
      'method': method
    };

  }


  //Responsible for loading modals

  wrapper.on('click', '[\\(modal\\)]', function (e) {
    e.preventDefault();
    if($('ad-modal').length != 0){

      $('ad-modal').addClass('ad-show');
      $('ad-modal').load($(this).attr('(modal)'));
    }else{
      let = modalHTML = `<div class="ad-modal ad-show">

                          <div class="modal-content">
                            <div class="ad-card ad-round ad-shadow bg-white text-center is-loading">
                              <p>LOADING...</p>
                            </div>
                          </div>

                          <button id='closeModal' class="ad-btn ad-icon ad-md ad-round btn-dark" style="position:absolute; top:-16px; right:-16px;">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                        <div class="ad-overlay"></div>`;
      wrapper.append(modalHTML);
      let outlet = $('.ad-modal>div.modal-content');

      ajaxURL = $(this).attr('(modal)');

      requestAirJax(ajaxURL, {
        "api": 'airJax'
      }, 'GET', 'html', {
        'outlet': outlet,
        'animate': true
      });
    }

  });

  // Close Modal

  wrapper.on('click','#closeModal',function(){

    $('div.ad-modal').addClass('ad-closemodal');

    setTimeout(()=>{
      $('div.ad-modal').remove();
      $('div.ad-overlay').remove();
    },1000);
  });


  // adRouter now routerLink click event

  wrapper.on('click', '[routerLink]', function () {
    routerLinkFx($(this).attr('routerLink'));
  });



  function routerLinkFx(url) {
    let nextPage;
    let routerOutlet = $('router-outlet');
    let currentPageRouter = window.location.href;
    let nextPageRouter = url;
    let animate = $('router-outlet').attr('animate');

    // console.log(nextPageRouter);
    // console.log(currentPageRouter);
    if (currentPageRouter == nextPageRouter) {
      animate = false;
    }

    // if (animate) {
    // Just add loader for 2G networks
    wrapper.append('<ad-loading/>');
    // }

    requestAirJax(nextPageRouter, {
      "api": 'airJax'
    }, 'GET', 'html', {
      'outlet': routerOutlet,
      'animate': animate,
      'routerLink':true
    });
    history.pushState(null, null, nextPageRouter);

    // check any routerLinkActive to apply class
    routerLinkActive(nextPageRouter);
  }



  // Apply class of the routerLinkActive to the element if the routerLink value matches the url
  function routerLinkActive(url) {
    let lActive = $('[routerLinkActive]');
    lActive.each(function () {

      if ($(this)[0].hasAttribute('routerLink')) {

        if ($(this).attr('routerLink') == url) {
          $(this).addClass($(this).attr('routerLinkActive'));
          // return true;
        } else {
          if ($(this).hasClass($(this).attr('routerLinkActive'))) {
            $(this).removeClass($(this).attr('routerLinkActive'));
          }
        }

      }
      // Search within
      else if ($(this).find('[routerLink]').length != 0) {
        // $(this).find('[routerLink]').attr('routerLink');
        if ($(this).find('[routerLink]').attr('routerLink') == url) {
          $(this).addClass($(this).attr('routerLinkActive'));
          // return true;
        } else {
          if ($(this).hasClass($(this).attr('routerLinkActive'))) {
            $(this).removeClass($(this).attr('routerLinkActive'));
          }

        }

      }


    });

  }

  // search routerLinkActive on Load
  routerLinkActive(window.location.href);



  // AUTOREFRESH DATA

  // expecting html


  function adSync(autoLoad) {

    // var autoLoad = $('[adSync]');
    var airParams = autoLoad.attr('(adSync)').split(',');

    var html = airParams[0];
    var count = airParams[1]; //trim the side ) off

    // check if count is available
    if (count) {
      var data = $.param(airThod(count));
      // console.log(data);

      //ajaxMethod to get the number
      $.post(ajaxURL, data, function (result) {

        if (autoLoad[0].hasAttribute('ad_count')) {

          oldCount = autoLoad.attr('ad_count');
        } else {
          oldCount = 0;
          autoLoad.attr('ad_count', 0);
        }

        newCount = result.result;
        if (oldCount != newCount) {
          // loadPage
          autoLoad.attr('ad_count', newCount);
          requestAirJax(html, {
            "api": 'airJax'
          }, 'GET', 'html', {
            'outlet': autoLoad,
            'animate': true
          });
        }

        // console.log('result is : '+newCount);
      }, 'json');

      // ajax Post Ends

    } else {


      // console.log('load page every 30 seconds');
      requestAirJax(html, {
        "api": 'airJax'
      }, 'GET', 'html', {
        'outlet': autoLoad,
        'animate': true
      });

    }

  }

  function checkSync() {
    // console.log('checkSync is running to find sync.');
    if ($('[\\(adSync\\)]').length != 0) {
      // console.log('sync found!')
      $('[\\(adSync\\)]').each(function () {
        adSync($(this));
      });

    }

  }

  // Find a way to initialize this if a person wants to use it
  setInterval(function () {
    checkSync() // this will run after every 5 seconds
  }, 10000);





  //Call script of component




  function requestAirJax($url, $data, $type = 'POST', $dataType = 'json', $airParams = null) {


    $.ajax({

      type: $type,
      global: false,
      dataType: $dataType,
      url: $url,
      data: $data

    }).done(function (data) {
      loadData(data, $airParams.outlet, $airParams.animate, $dataType, $airParams.routerLink ? $airParams.routerLink : false);

    }).fail(function (jqXHR, textStatus) {
      //do fail stuff
      console.error(textStatus, jqXHR.responseText);


      if ($('ad-notify > p').length == 0) {
        wrapper.append('<ad-notify><p></p></ad-notify>');
        outlet = $('ad-notify > p');
      } else {
        outlet = $('ad-notify > p');
      }
      $('ad-loading').remove();
      outlet.html('An Error Occured <span class="color-yellow">[Check Browser Console]</span>');
    });



  }


  // Load the ajax result to position
  function loadData(page, outlet, aimate = false, type = 'html', routerLink = false) {
    // var routerOutlet = $('ad-router');

    // console.log(outlet);
    // create notify if doesnt exist
    if (outlet == 'ad-notify') {
      if ($('ad-notify > p').length == 0) {
        wrapper.append('<ad-notify><p></p></ad-notify>');
        outlet = $('ad-notify > p');
      } else {
        outlet = $('ad-notify > p');
      }

    }

    if (aimate) {

      outlet.addClass('ad-disappear');

      setTimeout(function () {
        outlet.html(type == 'html' ? page : page.result);
      }, 1000);

      setTimeout(function () {
        outlet.removeClass('ad-disappear');
        // $('ad-loading').fadeOut().remove();
      }, 1500);


      // Remove ad-notify if it exist
      if ($('ad-notify').length != 0) {
        setTimeout(function () {
          $('ad-notify').fadeOut().remove();
        }, 6000);
      }

    } else {
      outlet.html(type == 'html' ? page : page.result);
    }

    setTimeout(function () {
      // outlet.removeClass('ad-disappear');
      $('ad-loading').fadeOut().remove();
    }, 1500);

    //scroll back to top
    $(outlet).parent().animate({
      scrollTop: 0
    }, 1000);



    //check if its a submission
    if (clearFormInputs !== null) {
      clearForm(clearFormInputs);
    }

     // For form action attr
    if (inputRouterLink !== null) {
        routerLinkFx(inputRouterLink);

        // reset to null to prevent infinite loop
        inputRouterLink = null
    }


    //update the browser tab title to page title if ajax call is the page
    // console.log(wrapper.find(pageTitle));
    if(routerLink){
      setTimeout(function () {

        document.title = wrapper.find('pageTitle').attr('label');
      }, 1000);
    }

    // check if script exits, then include else remove

    if ($('script#airScript').length == 0) {
      var script = $('<script type="text/javascript" id="airScript"></script>');
      wrapper.append(script);
    }

    // console.log($('script#airScript').length);
    var script = $('script#airScript');
    script.text(''); //empty script



    setTimeout(function () {
      $('ad-notify').fadeOut().remove();
    }, 6000);



    if ($('airScript').length != 0) {
      $('airScript').each(function () {
        script.text($('airScript').attr('path'));

      })
    } else {
      // console.log('no script');

    }


    // console.log(url);

    // check to see if component has script





  }



  // END OF DOM.READY
});
