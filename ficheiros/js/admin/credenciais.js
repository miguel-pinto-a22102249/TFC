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

        function getTouchPos(canvas, touchEvent) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            };
        }

        $canvas.on('mousedown touchstart', function(event) {
            isDrawing = true;
            ctx.beginPath();
            const pos = event.type === 'touchstart' ? getTouchPos($canvas[0], event) : {x: event.clientX - $canvas[0].getBoundingClientRect().left, y: event.clientY - $canvas[0].getBoundingClientRect().top};
            ctx.moveTo(pos.x, pos.y);
            event.preventDefault();
        });

        $canvas.on('mousemove touchmove', function(event) {
            if (isDrawing) {
                const pos = event.type === 'touchmove' ? getTouchPos($canvas[0], event) : {x: event.clientX - $canvas[0].getBoundingClientRect().left, y: event.clientY - $canvas[0].getBoundingClientRect().top};
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }
            event.preventDefault();
        });

        $canvas.on('mouseup touchend touchcancel', function(event) {
            isDrawing = false;
            event.preventDefault();
        });

        function clearCanvas() {
            ctx.clearRect(0, 0, $canvas[0].width, $canvas[0].height);
        }
    });

    document.addEventListener("touchstart", function(event) {
        if (event.target === document.querySelector('.signatureCanvas')) {
            event.preventDefault();
        }
    }, {passive: false});

    document.addEventListener("touchmove", function(event) {
        if (event.target === document.querySelector('.signatureCanvas')) {
            event.preventDefault();
        }
    }, {passive: false});


    $('#btn-gerar-credencial').on('click', function() {

        let htmlContent = $('.html-credencial').clone();
        htmlContent.find('.remover').remove();

        var url = $(this).data('url');

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

        var signatureCanvases = document.getElementsByClassName('signatureCanvas');
        var signatures = [];
        var isValid = true;
        var currentUrl = window.location.href;
        // var baseUrl = currentUrl.substring(0, currentUrl.lastIndexOf('/'));

        //Validar as assinaturas
        for (var i = 0; i < signatureCanvases.length; i++) {
            var canvas = signatureCanvases[i];
            let img = canvas.parentElement.parentElement.querySelector('.signatureImage');

            if (img.src === currentUrl) {
                isValid = false;
                break;
            }

            // Verifica se a imagem é vazia
            if (isImageEmpty(img)) {
                isValid = false;
                break;
            } else {
                // Cria um canvas temporário para desenhar a imagem e obter a representação base64
                var tempCanvas = document.createElement('canvas');
                var ctx = tempCanvas.getContext('2d');
                tempCanvas.width = img.width;
                tempCanvas.height = img.height;
                ctx.drawImage(img, 0, 0, img.width, img.height);
                var dataURL = tempCanvas.toDataURL(); // Obtém a representação base64 da imagem
                signatures.push(dataURL);
            }
        }

        if (!isValid) {
            $('.signature-container').find('.label--error').remove();
            // alert('A assinatura é obrigatória e não pode estar vazia.');
            $('.signature-container').append('<div class="label--error remover" role="alert">A assinatura é obrigatória e não pode estar vazia.</div>');

        } else {
            // Proceed with form submission
            data.signatures = signatures;

            notie.confirm({
                text: "Tem certeza que deseja gerar esta credencial?<br><small>Esta ação é irreversível.</small>",
                submitText: 'Sim',
                cancelText: 'Não'
            }, function() {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            notie.alert({type: 1, text: response.message});
                        } else {
                            notie.alert({type: 3, text: response.message});
                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function() {
                        notie.alert({type: 3, text: "Erro", stay: true});
                    }
                });
            });
        }
    });

    // Função para verificar se a imagem é vazia
    function isImageEmpty(imgElement) {
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        canvas.width = imgElement.width;
        canvas.height = imgElement.height;
        ctx.drawImage(imgElement, 0, 0, imgElement.width, imgElement.height);
        var pixelBuffer = new Uint32Array(ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer);
        return !pixelBuffer.some(color => color !== 0);
    }

}, 2000);

