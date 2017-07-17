
<section class="account ad-section">
    <div class="wrapper">
        <div class="ad-row">
            <div class="ad-col-12">
              <div class="ad-card whiteBG ad-user-dashboard" style="background-image:url('<?=BaseUrl;?>media/images/pcs.jpg');">



                    <ad-user class="darkBG ad-sm" style="">
                      <img src="<?=BaseUrl;?>media/images/user/8.jpg" alt="">
                    </ad-user>
                    <a adRouter="<?=BaseUrl;?>account/logout" class="ad-btn ad-round btn-tgreen ad-md outline">Logout</a>
              </div>

            </div>
        </div>
    </div>
</section>


<ad-section>
  <ad-wrapper>
    <ad-row>
      <div class="ad-cols-12">
        <ad-card>
          <h2 class="title">This is the Account Page</h2>
            <p>
              <?=$data;?>
            </p>
        </ad-card>
      </div>
    </ad-row>
  </ad-wrapper>
</ad-section>
