

    <tr <?php foreach($data as $row){ ?>>
        <td> <div class="ad-icon-letter"><?=$row->name[0];?></div>
        <?=$row->name;?> </td>
        <td><?=$row->gender ? 'Male':'Female';?> </td>
        <td><?=$row->email;?> </td>
        <td class="action">
            <a class="ad-btn btn-blue ad-flat ad-icon ad-round outline" (click)="createNew(<?=$row->id;?>)" [data-type]="html" [outlet]="#summaryView"><i class="fa fa-edit"></i></a>
            <button class="ad-btn btn-pink ad-flat ad-icon  ad-round outline" (click)="deleteItem(<?=$row->id;?>)" name="deletePerson" value="<?=$row->id;?>"><i class="fa fa-trash"></i></button>
        </td>
    </tr <?php }?>>
