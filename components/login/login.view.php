<section class="login ad-section">
    <div class="wrapper">
        <div class="ad-row">
            <div class="ad-cols-8">
                <div class="ad-card ad-img">
                  <img src="<?=BaseUrl;?>media/images/banner.jpg" class="img-responsive" alt="">
                </div>
            </div>
            <div class="ad-cols-4">
                <form action="<?=BaseUrl;?>account/login?redirect=<?=$redirect?>" method="POST">
                <?=$message;?>
                    <div class="ad-card ad-flat whiteBG">
                        <div class="ad-input ad-block  ad-label">
                            <label for="">Email:</label>
                            <input type="text" placeholder="Enter Email or Username" name="uname">
                        </div>

                         <div class="ad-input ad-block ad-label">
                            <label for="">Password:</label>
                            <input type="password" placeholder="****" name="upass">
                        </div>
                        <button class="ad-btn ad-md ad-flat ad-round btn-prim" type="submite" name="login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
