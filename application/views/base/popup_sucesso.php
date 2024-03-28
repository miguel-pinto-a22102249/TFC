<div class="popup-sucesso">
    <h2><?= isset($menssagem) ? $menssagem : "" ?></h2>
</div>

<style>
    .popup-sucesso{
        display: flex;
        align-items: center;
        background-color:#2DCC70;
        color: white;
        height: 100px;
        position: absolute;
        width: 100%;
        top: 0;
        justify-content: center;
        -webkit-transition: opacity 0.8s ease-in-out;
        -moz-transition: opacity 0.8s ease-in-out;
        -ms-transition: opacity 0.8s ease-in-out;
        -o-transition: opacity 0.8s ease-in-out;
        transition: opacity 0.8s ease-in-out;
    }
</style>

<script>
    $(document).ready(function () {
        $('.popup-sucesso').click(function () {
            $('.popup-sucesso').css({'opacity': "0"});
        });
        setTimeout(function () {
            $('.popup-sucesso').css({'opacity': "0"});
        }, 3000);
        setTimeout(function () {
            $('.popup-sucesso').css({'display': "none"});
        }, 3500);
    });
</script>