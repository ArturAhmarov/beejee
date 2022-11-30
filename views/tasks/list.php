<a class="btn btn-primary" href="/add/" style="margin-bottom: 10px;">Add</a>
<table class="table table-bordered table-striped table-hover">
    <tr>
        <td>Статус</td>
        <td><a class="btn btn-primary" href="/user_name/<?=$by;?>">Имя пользователя</a></td>
        <td class="th-sm"><a class="btn btn-primary"  href="/email/<?=$by;?>">e-mail</a></td>
        <td class="th-sm"><a class="btn btn-primary"  href="/text/<?=$by;?>">Текст</a></td><?
            if( $access ) {
                ?>
                <td>Update</td>
                <?
            }
        ?>
    </tr>
    <?
    foreach ( $rows as $row ) {
        $textChange = ($row['text_change'] == true) ? 'отредактировано администратором' : '';
        ?>
        <tr>
            <td><?=($row['status']) ? 'Выполнено' : 'Не выполнено'?></td>
            <td><?=$row['user_name'];?></td>
            <td><?=$row['email'];?></td>
            <td><?=$row['text'] . '<br><i>' . $textChange . '</i>';?></td>
            <?
            if( $access ) {
                ?>
                <td>
                    <a class="btn btn-primary" href="/update/<?=$row['id'];?>" style="margin-bottom: 10px;">Update</a>
                </td>
                <?
            }
            ?>
        </tr>
        <?
    }
    ?>
</table>
<?php
echo yidas\widgets\Pagination::widget([
    'pagination' => $pagination
]);