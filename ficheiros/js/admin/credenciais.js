setTimeout(function() {
    // console.log('Script de assinatura carregado');
    $('.signature-container').each(function() {
        const $container = $(this);
        const $canvas = $container.find('.signatureCanvas');
        const $saveButton = $container.find('.saveButton');
        const $clearCanvasButton = $container.find('.clearCanvasButton');
        const $signatureImage = $container.find('.signatureImage');
        const ctx = $canvas[0].getContext('2d');
        let isDrawing = false;

        $saveButton.on('click', function() {
            const signatureDataURL = $canvas[0].toDataURL();
            $signatureImage.attr('src', signatureDataURL);
            $signatureImage.show();
            clearCanvas();
        });

        $clearCanvasButton.on('click', function() {
            clearCanvas();
        });

        $canvas.on('mousedown', function(event) {
            isDrawing = true;
            ctx.beginPath();
            ctx.moveTo(event.clientX - $canvas[0].getBoundingClientRect().left, event.clientY - $canvas[0].getBoundingClientRect().top);
        });

        $canvas.on('mousemove', function(event) {
            if (isDrawing) {
                ctx.lineTo(event.clientX - $canvas[0].getBoundingClientRect().left, event.clientY - $canvas[0].getBoundingClientRect().top);
                ctx.stroke();
            }
        });

        $canvas.on('mouseup', function() {
            isDrawing = false;
        });

        function clearCanvas() {
            ctx.clearRect(0, 0, $canvas[0].width, $canvas[0].height);
        }
    });


    $('#btn-gerar-credencial').on('click', function() {

        let htmlContent = $('.html-credencial').clone();
        htmlContent.find('.remover').remove();

        htmlContent.find('textarea').each(function() {
            let originalValue = $(this).val();
            $(this).text(originalValue);
        });


        let data = {
            'html': htmlContent.html()
        };
        data.IdDistribuicao = $('#IdDistribuicao').val();
        data.GrupoDistribuicao = $('#GrupoDistribuicao').val();
        data.TipoCredencial = $('#TipoCredencial').val();

        var canvas = document.getElementsByClassName('signatureCanvas');
        var signatureImages = document.getElementsByClassName('signatureImage');
        var signatures = [];
        for (var i = 0; i < canvas.length; i++) {
            var ctx = canvas[i].getContext('2d');
            var dataURL = canvas[i].toDataURL();
            signatures.push(dataURL);
        }
        data.signatures = signatures;

        $.ajax({
            url: $(this).data('url'),
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success == true || response.success == true) {
                    notie.alert({type: 1, text: response.message})
                } else {
                    notie.alert({type: 3, text: response.message})
                }
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function() {
                notie.alert({type: 3, text: "Erro", stay: true})
            }
        });
    });
}, 2000);

