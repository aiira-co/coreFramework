<h2 class="title"><?=$title?></h2>
<form (submit)="<?=$method;?>">
    <div class="ad-input ad-block ad-label">
      <label for="">Name:</label>
      <input type="text" name="name"  value="<?=$item->name ??null;?>" required>
    </div>
    <div class="ad-input ad-block ad-label">
      <label for="">Gender:</label>
      <select name="gender" id="">
        <option value="1" <?=isset($personData) && ($personData->gender == 1)? 'selected' :null;?>>Male</option>
        <option value="0" <?=isset($personData) && ($personData->gender == 0)? 'selected' :null;?>>Female</option>
      </select>
    </div>
    <div class="ad-input ad-block ad-label" >
      <label for="">Email:</label>
      <input type="email" name="email"  value="<?=$item->email ?? null;?>" required>
    </div>
    <input type="hidden" name="id" value="<?=$item->id??null;?>">
    <p>
      <button class="ad-btn btn-dark ad-full ad-block ad-md text-upper ad-spread" type="submit"  name="<?=isset($personData)? 'update' :'submite';?>">Add to cart</button>
      <?php if (isset($item->id)) {
    ?>
        <button type="button" class="ad-btn ad-block ad-full ad-md" routerLink="<?=BaseUrl; ?>practice">Clear</button>
        <?php
}?>
    </p>



  </form>
