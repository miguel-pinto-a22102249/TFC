<div class="popup-erro">
    <h2><?= isset($menssagem) ? $menssagem : "" ?></h2>
</div>

<style>
    .popup-erro{
        display: flex;
        align-items: center;
        background-color:rgba(255, 0, 0, 0.2);
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
        $('.popup-erro').click(function () {
            $('.popup-erro').css({'opacity': "0"});
        });
        setTimeout(function () {
            $('.popup-erro').css({'opacity': "0"});
        }, 3000);
        setTimeout(function () {
            $('.popup-erro').css({'display': "none"});
        }, 3500);
    });
</script>