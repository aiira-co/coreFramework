

    <tr <?php foreach($data as $row){ ?>>
        <td> <div class="ad-icon-letter"><?=$row->name[0];?></div>
        <?=$row->name;?> </td>
        <td><?=$row->gender ? 'Male':'Female';?> </td>
        <td><?=$row->email;?> </td>
        <td class="action">
            <a class="ad-btn btn-prim ad-flat ad-round" adClick="createNew(<?=$row->id;?>)" ad-data-type="html" ad-outlet="#summaryView"><i class="fa fa-edit"></i></a>
            <button class="ad-btn btn-red ad-flat ad-round" adClick="deletePerson(<?=$row->id;?>)" name="deletePerson" value="<?=$row->id;?>"><i class="fa fa-trash"></i></button>
        </td>
    </tr <?php }?>>
