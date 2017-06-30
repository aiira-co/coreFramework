


<section class="ad-section ">

<div class="wrapper">
    <div class="ad-row">
      <div class="ad-cols-8">
          <form adSubmit="searchPerson()" ad-data-type='html' ad-outlet="tbody" method="POST">
              <div class="ad-table ad-card ad-block whiteBG">
                  <div class="ad-header">
                      <h2 class="title">Data Of Persons</h2>
                      <span class="rFloat">
                        <input type="search"  adKeyPress="searchPerson()" ad-data-type='html' ad-outlet="tbody" name="key" value="">
                        <button type="submit" name="button" class="ad-btn ad-flat"><i class="fa fa-search"></i></button>
                      </span>
                  </div>

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
              </div>

              </form>


      </div>
        <div class="ad-cols-4">
          <div class="ad-card ad-block whiteBG">

            <h2 class="title"><?=$title?></h2>


            <?php

            if(isset($noti)){
              echo '<div class="ad-card ad-flat ad-round tqBG"><p>'.$alert.'</p></div>';
            }

            // phpinfo();
            // print_r($personData);

            ?>

            <form adSubmit="savePerson()">


                <div class="ad-input ad-round ad-label">
                  <label for="">Name:</label>
                  <input type="text" name="name"  value="<?=isset($personData)? $personData->name :null;?>" required>
                </div>
                <div class="ad-input ad-round ad-label">
                  <label for="">Gender:</label>
                  <select name="gender" id="">
                    <option value="1" <?=isset($personData) && ($personData->gender == 1 )? 'selected' :null;?>>Male</option>
                    <option value="0" <?=isset($personData) && ($personData->gender == 0 )? 'selected' :null;?>>Female</option>
                  </select>
                </div>
                <div class="ad-input ad-round ad-label" >
                  <label for="">Email:</label>
                  <input type="email" name="email" adBlur="blurMe()"  value="<?=isset($personData)? $personData->email :null;?>" required>
                </div>
                <div id="showMe">

                </div>
                <p>
                  <button class="ad-btn btn-tgreen ad-full ad-round ad-md" type="submit" adHover="blurMe()"  name="<?=isset($personData)? 'update' :'submite';?>">Save</button>
                  <?php if($clear){?>
                    <a class="ad-btn ad-round ad-full ad-md" href="<?=BaseUrl;?>practice">Clear</a>
                    <?php }?>
                </p>



              </form>
          </div>

        </div>


    </div>
</div>





</section>
