<form action="/update/" method="post">
    <label>Текст</label>
    <div class="input-group mb-3">
        <div class="col-lg-3">
            <input type="text" class="form-control" name="text" value="<?=$item['text'];?>">
        </div>
    </div>
    <label>Статус</label>
    <div class="input-group mb-3">
        <div class="col-lg-3">
            <input type="checkbox" class="form-check-input" name="status" <?=(boolval($item['status']) == 'true') ? 'checked' : ''?>>
        </div>
    </div>
    <div class="input-group mb-3">
        <div class="col-lg-1">
            <input type="submit" class="form-control btn btn-primary" value="Изменить">
        </div>
    </div>
    <input type="hidden" name="id" value="<?=$item['id'];?>">
    <input type="hidden" name="textPred" value="<?=$item['text'];?>">
    <input type="hidden" name="text_change" value="<?=$item['text_change'];?>">
</form>