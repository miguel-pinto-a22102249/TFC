<div class="consultar-credencial">
    <div class="row">
        <div class="columns large-12">
            <div class="wrapper-print">
                <?= $credencial->getHtml(); ?>
                <style>
                    @media print,.wrapper-print {
                        p, div, a, td, th, li {
                            font-size: 12px;
                            font-family: 'Calibri', sans-serif;
                        }
                        img.credencial-b__logo-entidade {
                            max-width: 100px!important;
                        }
                    }

                    table {
                        border: 1px solid black;
                        border-spacing: 0px;
                    }

                    tr, td, th {
                        border: 1px solid black;
                    }


                    .credencial-b__logo-entidade {
                    }

                    .section-title {
                        font-size: 16px;
                        font-weight: 600;
                    }

                    .credencial-b__logo-entidade {
                        opacity: 0.7;
                        margin-bottom: 1rem;
                        display: block;
                    }



                    .observations {
                        margin-top: 20px;
                        border: 1px solid #000;
                        padding: 10px;
                    }


                    .credencial-b__header {
                        border-top: 2px solid black;
                        border-bottom: 2px solid black;
                        margin-bottom: 2rem;
                        padding-top: 1rem;
                        padding-bottom: 1rem;
                        width: 100%;

                    }

                    textarea, .observations {
                        width: 100%;
                    }

                    .signatureImage {
                        max-width: 214px;
                    }


                    .credencial-b__header p:last-child {
                        margin-bottom: 0;
                    }

                </style>
            </div>
            <!--            <button class="printButton no-print button button--add button--success"><i class="fas fa-print"></i>&nbsp;&nbsp;Imprimir</button>-->
        </div>
    </div>
</div>
<script>

$(document).ready(function() {
    $('textarea').each(function() {
        $(this).prop('readonly', true);
    });

    // Função para imprimir
    function performPrint() {
        let printContents = document.querySelector('.wrapper-print').innerHTML;
        let originalContents = document.body.innerHTML;

        let printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Imprimir</title>');

        // Copiar estilos externos
        let links = document.querySelectorAll('link[rel="stylesheet"]');
        for (let i = 0; i < links.length; i++) {
            printWindow.document.write(links[i].outerHTML);
        }

        // Copiar estilos internos
        let styles = document.querySelectorAll('style');
        for (let i = 0; i < styles.length; i++) {
            printWindow.document.write(styles[i].outerHTML);
        }

        printWindow.document.write('</head><body>');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');

        // Evento para fechar a janela de impressão após a impressão ser concluída
        printWindow.addEventListener('onafterprint', function() {
            printWindow.close();
        });

        printWindow.document.close();
        printWindow.print();
    }

    // Evento para capturar a impressão via navegador
    window.addEventListener('beforeprint', function(eve) {
        eve.stopImmediatePropagation();
        eve.stopPropagation();
        eve.preventDefault();
        performPrint();
    });

    // Botão para imprimir
    $('.printButton').on('click', function() {
        performPrint();
    });
});
    </script>

