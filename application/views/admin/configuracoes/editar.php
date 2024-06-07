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
        foreach ($data

                 as $key => $value) {
            ?>
            <tr>
                <td><?= $key ?></td>
                <? if (!(strpos($value, '{') === 0 && substr($value, -1) === '}')) { ?>
                    <td><input id="<?= $key; ?>" name="<?= $key; ?>" type="text" value="<?= $value ?>"></td>
                    <?
                } else {
                    $value = substr($value, 1, -1);
                    $values = explode(',', $value);
                    //Fazer trim às strings
                    $values = array_map('trim', $values);
                    flush();
                    ?>
                    <td>
                        <select id="<?= $key; ?>" name="<?= $key; ?>">
                            <?php
                            foreach ($values as $option) {
                                $values_temp = $values;

                                $key = array_search($option, $values_temp);
                                if ($key !== false) {
                                    unset($values_temp[$key]);
                                }
                                // Reindexar o array
                                $values_tempss = array_values($values_temp);
                                ?>
                                <option value="<?= "{" . trim($option) . ',' . implode(',', $values_temp) . "}" ?>"><?= $option ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                <? } ?>
            </tr>
            <?php
        }
        ?>
    </table>
    <button class="bottom btn-style" type="submit">Gravar</button>
</form>
