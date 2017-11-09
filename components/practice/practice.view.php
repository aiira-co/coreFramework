


<section class="ad-section ">

<div class="wrapper">
    <div class="ad-row">
      <div class="ad-cols-8">
          <form (submit)="searchItem()" [data-type]='html' [outlet]="tbody" method="POST">
              <ad-table class="ad-block ad-flat whiteBG">
                  <ad-header class="ad-flat">
                      <h2 class="title"><i class="fa fa-user-circle"></i> &nbsp; List of Clients</h2>
                      <span class="rFloat">
                        <input type="search"  (keypress)="searchItem()" [data-type]='html' [outlet]="tbody" name="key" value="">
                        <button type="submit" name="button" class="ad-btn ad-flat"><i class="fa fa-search"></i></button>
                        <button type="button" name="button" class="ad-btn ad-flat ad-tip" ad-tip="Add Item" (click)="createNew()" [data-type]='html' [outlet]="#summaryView"><i class="fa fa-plus"></i></button>
                      </span>
                  </ad-header>

                  <table>
                      <thead>
                          <tr >
                              <th>Name</th>
                              <th>Gender</th>
                              <th>Email</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody (adSync) ="<?=BaseUrl;?>persondata, countData()" >
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

            <h1 class="title">Client Detail</h1>

            <p class="text-center" style="opacity:.5;">
              <i class="fa fa-id-card fa-5x"></i>
              <br>
              <br>
              Select a client to view detail
            </p>

          </ad-card>

        </div>


    </div>
</div>





</section>
