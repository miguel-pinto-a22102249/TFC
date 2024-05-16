<?php

//var_dump($data);

?>
<form action="<?= base_url("/admin/configuracoes/gravar") ?>" method="POST" class="form-ajax no-reset" enctype="multipart/form-data">
    <table>
        <tr>
            <th>Código</th>
            <th>Valor</th>
        </tr>
        <?php
        foreach ($data as $key => $value) {
            ?>
            <tr>
                <td><?= $key ?></td>

                <td><input id="<?= $key; ?>" name="<?= $key; ?>" type="text" value="<?= $value ?>"></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <button class="bottom btn-style" type="submit">Gravar</button>
</form>
