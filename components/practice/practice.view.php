


<section class="ad-section ">

<div class="wrapper">
    <div class="ad-row">
      <div class="ad-cols-8">
          <form adSubmit="searchItem()" ad-data-type='html' ad-outlet="tbody" method="POST">
              <ad-table class="ad-block ad-flat whiteBG">
                  <ad-header class="ad-flat">
                      <h2 class="title"><i class="fa fa-shopping-cart"></i> &nbsp; Items in Cart</h2>
                      <span class="rFloat">
                        <input type="search"  adKeyPress="searchItem()" ad-data-type='html' ad-outlet="tbody" name="key" value="">
                        <button type="submit" name="button" class="ad-btn ad-flat"><i class="fa fa-search"></i></button>
                        <button type="button" name="button" class="ad-btn ad-flat ad-tip" ad-tip="Add Item" adClick="createNew()" ad-data-type='html' ad-outlet="#summaryView"><i class="fa fa-plus"></i></button>
                      </span>
                  </ad-header>

                  <table class="table">
                      <thead>
                          <tr>
                              <th>Name</th>
                              <th>Gender</th>
                              <th>Email</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody adSync ="<?=BaseUrl;?>persondata, countData()" >
                        <?php CORE::component('practicedata');?>

                      </tbody>
                  </table>

                  <div class="ad-footer">

                  </div>
              </ad-table>

              </form>


      </div>
        <div class="ad-cols-4">
          <ad-card class="ad-round ad-shadow" id="summaryView">

            <h1 class="title">Item Detail</h1>

            <p class="text-center" style="opacity:.5;">
              <i class="fa fa-shopping-basket fa-5x"></i>
              <br>
              <br>
              Select an item to view detail
            </p>

          </ad-card>

        </div>


    </div>
</div>





</section>
