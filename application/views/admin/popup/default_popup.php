<?
$titulo = isset($titulo) ? $titulo : "Titulo";
$html = isset($html) ? $html : "HTML";
$URLNewWindow = isset($URLNewWindow) ? $URLNewWindow : false;
$soConsulta = isset($soConsulta) ? $soConsulta : false;
?>
<div class="default-dialog <?= $soConsulta == 1 ? 'dialog-consulta' : '' ?>">
    <? if ($URLNewWindow) {
        echo "<a title='Maximizar Janela' href='$URLNewWindow' target='_blank' 
class='default-dialog__button-maximize'><i class='fas fa-window-restore'></i></a>";
    } ?>

    <? if ($soConsulta == 1) {
        echo "<a title='Ativar Edição' href='javascript:;' target='_blank' 
class='default-dialog__button-edit'><i class='fas fa-edit'></i></a>";
    } ?>
    <div class="default-dialog__inner-wrapper">
        <div class="row">
            <div class="columns large-12">
                <div class="default-dialog__inner-wrapper__wrapper-titulo">
                    <h2><?= $titulo ?></h2>
                </div>
            </div>
        </div>
        <div class="default-dialog__inner-wrapper__content">
            <?= $html ?>
        </div>
    </div>
</div>
