
<section class="account ad-section">
    <div class="wrapper">
        <div class="ad-row">
            <div class="ad-col-12">
              <div class="ad-card whiteBG">
                <h2 class="title">This is the Account Page</h2>
                  <p>
                    <?=$data;?>
                  </p>

                    <br>
                    <a adRouter="<?=BaseUrl;?>account/logout" class="ad-btn ad-flat ad-round btn-dark ad-md">Logout</a>

              </div>

            </div>
        </div>
    </div>
</section>



<section class="ad-section">
  <div class="wrapper">
    <div class="ad-row">
      <div class="ad-cols-12">
        <div class="ad-tab">
          <ul class="ad-head">
            <li class="active" ad-tab="About">About Me</li>
            <li ad-tab="Photos">Photos</li>
            <li ad-tab="Friends">Friends</li>
            <li ad-tab="Settings">Settings</li>
          </ul>

          <div class="ad-body">
            <div class="ad-content ad-show" id="About">
              .
              <h2>This is the About Tab</h2>
              <?php
                CORE::component('practice');
               ?>
            </div>

            <div class="ad-content" id="Photos">
              .
              <h2>This is the Photos Tab</h2>
            </div>

            <div class="ad-content" id="Friends">
              .
              <h2>This is the Friends Tab</h2>
            </div>

            <div class="ad-content" id="Settings">
              .
              <h2>This is the Settings Tab</h2>
            </div>


          </div>
        </div>


      </div>
    </div>
  </div>
</section>




<section class="ad-section">
  <div class="wrapper">
    <div class="ad-row">
      <div class="ad-cols-6">
        <div class="ad-accordian">
          <div class="ad-head">
            <i class="fa fa-angle-up"></i> Hello
          </div>
          <div class="ad-body">
            <div class="ad-card ad-flat">
              <p>
                <?php CORE::component('contact'); ?>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
            </div>
          </div>

          <div class="ad-head">
            <i class="fa fa-angle-up"></i> Second
          </div>
          <div class="ad-body">
            <div class="ad-card ad-flat">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
            </div>
          </div>
          <div class="ad-head">
            <i class="fa fa-angle-up"></i> Third
          </div>
          <div class="ad-body">
            <div class="ad-card ad-flat">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
            </div>
          </div>
          <div class="ad-head">
            <i class="fa fa-angle-up"></i> Forth
          </div>
          <div class="ad-body">
            <div class="ad-card ad-flat">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
