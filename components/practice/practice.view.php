


<section class="ad-section whiteBG">

<div class="wrapper">
    <div class="ad-row">
        <div class="ad-cols-12">
          <h2><?=$title?></h2>


          <?php

          if(isset($noti)){
              echo '<div class="ad-card ad-flat ad-round tqBG"><p>'.$alert.'</p></div>';
          }

          // phpinfo();
          // print_r($personData);

          ?>

            <form action="" method="POST">

                <div class="ad-card ad-flat">
                    <div class="ad-input ad-block ad-label">
                        <label for="">Name:</label>
                        <input type="text" name="name" value="<?=isset($personData)? $personData->name :null;?>">
                    </div>
                    <div class="ad-input ad-block ad-label">
                        <label for="">Gender:</label>
                        <select name="gender" id="">
                            <option value="1" <?=isset($personData) && ($personData->gender == 1 )? 'selected' :null;?>>Male</option>
                            <option value="0" <?=isset($personData) && ($personData->gender == 0 )? 'selected' :null;?>>Female</option>
                        </select>
                    </div>
                    <div class="ad-input ad-block ad-label">
                        <label for="">Email:</label>
                        <input type="email" name="email"  value="<?=isset($personData)? $personData->email :null;?>">
                    </div>

                <button class="ad-btn btn-dark ad-round ad-md" type="submite" name="<?=isset($personData)? 'update' :'submite';?>">Submite</button>
                <?php if($clear){?>
                <a class="ad-btn ad-round ad-md" href="<?=BaseUrl;?>practice">Clear</a>
                <?php }?>
                </div>

            </form>

        </div>
        <div class="ad-clearfix">

        </div>

    </div>
</div>





</section>
<div class="clearfix">

</div>
<section class="ad-section">
  <div class="wrapper">
    <div class="ad-row">
      <div class="ad-cols-12">
          <?php
              if(isset($data)){



          ?>

          <form action="" method="POST">
              <div class="ad-table ad-card whiteBG">
                  <div class="ad-header">
                      <h2 class="title">Data Of Persons</h2>
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
                      <tbody>
                          <tr <?php foreach($data as $row){ ?>>
                              <td> <div class="ad-icon-letter"><?=$row->name[0];?></div>
                              <?=$row->name;?> </td>
                              <td><?=$row->gender ? 'Male':'Female';?> </td>
                              <td><?=$row->email;?> </td>
                              <td class="action">
                                  <a class="ad-btn btn-prim ad-flat ad-block" href="<?=BaseUrl.'practice/?edit='.$row->id;?>">Edit</a>
                                  <button class="ad-btn btn-red ad-flat ad-block" type="submite" name="deletePerson" value="<?=$row->id;?>">Delete</button>
                              </td>
                          </tr <?php }?>>

                      </tbody>
                  </table>

                  <div class="ad-footer">

                  </div>
              </div>

              </form>

          <?php
              }
          ?>
      </div>
    </div>
  </div>
</section>
