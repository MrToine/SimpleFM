<h2>Admin <?php echo $data['model']; ?>s</h2>
<p>Il y a actuellement <strong><?php echo $data['total'] ?></strong> <?php echo strtolower($data['model']); ?>s.</p>
<a href="<?php echo Router::url('admin/'.strtolower($data['model']).'s/edit') ?>">Créer une entrée</a>
<table class="table">
    <thead>
        <tr>
            <th style="width:5%;">ID</th>
            <th style="width:20%;">Date de création</th>
            <th style="width:40%;">Nom</th>
            <th style="width:10%;">Status</th>
            <th style="width:25%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data['data'] as $key => $value): ?>
        <tr>
            <td><?php echo $value->id; ?></td>
            <td><?php echo $value->created; ?></td>
            <td><?php echo ($data['model'] == "User")?$value->username:$value->name; ?></td>
            <td>
                <?php
                if($data['model'] == "User") {
                    echo $value->role;
                }else{
                    "<span class=\"tag--".($value->online==1)?'success':'warning'."\">".($value->online==1)?'En ligne':'Hors ligne'."</span></td>";
                }
                ?>
            <td>
                <a href="<?php echo Router::url('admin/'.strtolower($data['model']).'s/edit/'.$value->id); ?>">Editer</a> <a href="<?php echo Router::url('admin/news/delete/'.$value->id); ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
