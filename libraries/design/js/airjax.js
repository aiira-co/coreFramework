$(document).ready(function () {

  var ajaxURL = $('base').attr('url') + 'cqured.php';
  var wrapper = $('body');

  var url;
  // MOUSE EVENTS
  //Responsible for handling click Events

  wrapper.on('click', '[adClick]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('adClick'));
  });


  // on('hover') not working but $.hover works
  wrapper.on('mousedown', '[adMouseDown]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('adMouseDown'));
  });


  // on('hover') not working but $.hover works
  wrapper.on('mouseenter', '[adMouseEnter]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('adMouseEnter'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mouseleave', '[adMouseLeave]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('adMouseLeave'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mousemove', '[adMouseMove]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('adMouseMove'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mouseout', '[adMouseOut]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('adMouseOut'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mouseup', '[adMouseUp]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('adMouseUp'));
  });

  // on('hover') not working but $.hover works
  wrapper.on('mouseover', '[adMouseOver]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    processEvent($(this), $(this).attr('adMouseOver'));
  });


  // INPUT EVENTS
  wrapper.on('blur', 'input[adBlur]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    var inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('adBlur'), inputValue);
  });


  // KEY BOARDING EVENTS

  // for keypress, to search, that is auto-complete
  wrapper.on('keypress', 'input[adKeyPress]', function () {
    // e.preventDefault();
    wrapper.append('<ad-loading/>');
    var inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('adKeyPress'), inputValue);

  });

  // for keydown, to search, that is auto-complete
  wrapper.on('keydown', 'input[adKeyDown]', function () {
    // e.preventDefault();
    wrapper.append('<ad-loading/>');
    var inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('adKeyDown'), inputValue);

  });

  // for keydown, to search, that is auto-complete
  wrapper.on('keyup', 'input[adKeyUp]', function () {
    // e.preventDefault();
    wrapper.append('<ad-loading/>');
    var inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('adKeyUp'), inputValue);

  });


  // for keypress, to search, that is auto-complete
  wrapper.on('change', 'input[adChange]', function (e) {
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    var inputValue = $(this).serialize();
    processEvent($(this), $(this).attr('adChange'), inputValue);

    // console.log('change event triggered');
  });

  //on submit for forms
  wrapper.on('submit', 'form[adSubmit]', function (e) {
    // stop post to refresh page
    e.preventDefault();
    wrapper.append('<ad-loading/>');
    var formData = $(this).serialize();
    processEvent($(this), $(this).attr('adSubmit'), formData);

  });


  //responsible for getting data to be airJax-ed
  function processEvent(trigger, eventData, triggerData = "") {
    // console.log(trigger);
    var airData = $.param(airThod(eventData));
    var data = airData + '&' + triggerData;
    var outlet = trigger[0].hasAttribute('router-outlet') ? $('' + trigger.attr('router-outlet') + '') : 'ad-notify';
    var dataType = trigger[0].hasAttribute('ad-data-type') ? trigger.attr('ad-data-type') : 'json';
    requestAirJax(ajaxURL, data, 'POST', dataType, { 'outlet': outlet, 'animate': true });
  }

  // This function takes the attrubute value and convert them
  // to method and parameters fo the php file
  function airThod(airValue) {
    //slipt string into mehtod and parameters
    split = airValue.split('(');

    method = split[0];
    params = split[1].trim().replace(')', ''); //trim the side ) off
    url = window.location.href.split($('base').attr('url'))[1];
    // console.log(params.length);
    if (params.length != 0) {

      params = params.split(','); //make it object for multiple parameters for the method

      count = params.length;

      // console.log(count);
      for (i = 0; i < count; i++) {
        // console.log(params[i]);
        if (params[i][0] == '$') {
          // console.log('yes');
          params[i] = $('#' + params[i].trim().replace('$', '')).val();
        }
      }


      return { 'airJaxPath': url, 'method': method, 'params': params };
    }

    // var airthod =
    // console.log(airthod);\

    // console.log(url);
    return { 'airJaxPath': url, 'method': method };

  }


  //Responsible for loading modals

  wrapper.on('click', '[adModal]', function (e) {
    e.preventDefault();
    $('ad-modal').addClass('ad-show');
    $('ad-modal').load($(this).attr('adModal'));

  });



  // ad>Router click event

  wrapper.on('click', '[routerLink]', function () {

    var nextPage;
    var routerOutlet = $('ad-router');
    var currentPageRouter = window.location.href;
    var nextPageRouter = $(this).attr('routerLink');
    var animate = $('ad-router').attr('animate');

    // console.log(currentPageRouter);
    if (currentPageRouter == nextPageRouter) {
      animate = false;
    }

    if (animate) {
      wrapper.append('<ad-loading/>');
    }

    requestAirJax(nextPageRouter, { "api": 'airJax' }, 'GET', 'html', { 'outlet': routerOutlet, 'animate': animate });
    history.pushState(null, null, nextPageRouter);

    // check any routerLinkActive to apply class
    routerLinkActive(nextPageRouter);

  });



  // Apply class of the routerLinkActive to the element if the routerLink value matches the url
  function routerLinkActive(url) {
    var lActive = $('[routerLinkActive]');
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
      else if ($(this).find('[routerLink]') != null) {
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
    var params = autoLoad.attr('adSync').split(',');

    var html = params[0];
    var count = params[1]; //trim the side ) off

    // check if count is available
    if (count) {
      var data = $.param(airThod(count));
      // console.log(data);

      //ajaxMethod to get the number
      $.post(ajaxURL, data, function (result) {

        if (autoLoad[0].hasAttribute('adCount')) {

          oldCount = autoLoad.attr('adCount');
        } else {
          oldCount = 0;
          autoLoad.attr('adCount', 0);
        }

        newCount = result.result;
        if (oldCount != newCount) {
          // loadPage
          autoLoad.attr('adCount', newCount);
          requestAirJax(html, { "api": 'airJax' }, 'GET', 'html', { 'outlet': autoLoad, 'animate': true });
        }

        // console.log('result is : '+newCount);
      }, 'json');

      // ajax Post Ends

    } else {


      // console.log('load page every 30 seconds');
      requestAirJax(html, { "api": 'airJax' }, 'GET', 'html', { 'outlet': autoLoad, 'animate': true });

    }

  }

  function checkSync() {
    // console.log('checkSync is running to find sync.');
    if ($('[adSync]').length != 0) {
      // console.log('sync found!')
      $('[adSync]').each(function () {
        adSync($(this));
      });

    }

  }

  // Find a way to initialize this if a person wants to use it
  setInterval(function () {
    checkSync()// this will run after every 5 seconds
  }, 10000);





  //Call script of component




  function requestAirJax($url, $data, $type = 'POST', $dataType = 'json', $params = null) {


    $.ajax({

      type: $type,
      global: false,
      dataType: $dataType,
      url: $url,
      data: $data

    }).done(function (data) {
      loadData(data, $params.outlet, $params.animate, $dataType);

    }).fail(function (jqXHR, textStatus) {
      //do fail stuff
      console.log(textStatus);
    });



  }


  // Load the ajax result to position
  function loadData(page, outlet, aimate = false, type = 'html') {
    // var routerOutlet = $('ad-router');

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
        $('ad-loading').fadeOut().remove();
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

    //scroll back to top
    $(outlet).parent().animate({
      scrollTop: 0
    }, 1000);


    //update the browser tab title to page title if ajax call is the page


    // check if script exits, then include else remove

    if ($('script#airScript').length == 0) {
      var script = $('<script type="text/javascript" id="airScript"></script>');
      wrapper.append(script);
    }

    console.log($('script#airScript').length);
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


    console.log(url);

    // check to see if component has script





  }



  // END OF DOM.READY
});
