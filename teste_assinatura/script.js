// Referências aos elementos HTML
const canvas = document.getElementById('signatureCanvas');
const saveButton = document.getElementById('saveButton');
const signatureImage = document.getElementById('signatureImage');
const ctx = canvas.getContext('2d');

// Variável para controlar se está desenhando
let isDrawing = false;

// Evento de clique no botão de salvar
saveButton.addEventListener('click', () => {
    const signatureDataURL = canvas.toDataURL(); // Obtém a imagem da assinatura como uma URL base64
    signatureImage.src = signatureDataURL; // Define a imagem da assinatura na tag img

    // Envie a assinatura para o servidor (por exemplo, via AJAX) e salve no banco de dados
    // Aqui você deve implementar a lógica para enviar a imagem para o servidor e armazená-la no banco de dados.
    // Isso pode envolver o uso de PHP para processar a imagem e salvá-la.

    // Reinicie o canvas para permitir uma nova assinatura
    clearCanvas();
});

// Eventos de desenho no canvas
canvas.addEventListener('mousedown', () => {
    isDrawing = true;
    ctx.beginPath();
    ctx.moveTo(event.clientX - canvas.getBoundingClientRect().left, event.clientY - canvas.getBoundingClientRect().top);
});

canvas.addEventListener('mousemove', () => {
    if (isDrawing) {
        ctx.lineTo(event.clientX - canvas.getBoundingClientRect().left, event.clientY - canvas.getBoundingClientRect().top);
        ctx.stroke();
    }
});

canvas.addEventListener('mouseup', () => {
    isDrawing = false;
});

// Função para limpar o canvas
function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}
