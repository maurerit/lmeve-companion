<?php
echo form_open('/queue/delete/' . $queueItem->queueId);
echo form_submit('ok', 'Delete queue');
echo form_close();
?>
<table class="lmframework">
    <?php echo form_open('/queue/submit'); ?>
    <tr>
        <td width="150" class="tab">Item:</td>
        <td width="200" class="tab">
            <?php
            echo form_hidden('typeId', $queueItem->typeId);
            echo form_hidden('queueId', $queueItem->queueId);
            if ($queueItem) {
                echo $queueItem->typeName;
            } else {
                echo 'No item selected';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>Activity:</td>
        <td>
            <?php echo form_dropdown('activity', $activities, $selected); ?>
        </td>
    </tr>
    <tr>
        <td>Quantity:</td>
        <td><?php echo form_input('quantity', $quantity); ?></td>
    </tr>
    <tr>
        <td>One time queue:</td>
        <td><?php echo form_checkbox('onetime', 'onetime', $onetime) ?></td>
    </tr>
</table>
<div class = "tleft">
    <table>
        <tr>
            <td width = "60" valign = ""top">
            <?php
            echo form_submit('editQueue', 'Ok');
            echo form_close();
            ?>
        </td>
        <td width=" 75" valign="top ">
            <?php
            echo form_open('/queue');
            echo form_submit('cancelEdit', 'Cancel');
            echo form_close();
            ?>
        </td>
    </tr>
</table>
</div>