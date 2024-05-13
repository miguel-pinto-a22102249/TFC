// Referências aos elementos HTML
const canvas = document.getElementById('signatureCanvas');
const saveButton = document.getElementById('saveButton');
const clearButton = document.getElementById('clearCanvasButton');
const signatureImage = document.getElementById('signatureImage');
const ctx = canvas.getContext('2d');

// Variável para controlar se está desenhando
let isDrawing = false;
// Variável para controlar se a rolagem está bloqueada durante a assinatura
let isScrollBlocked = false;

// Evento de toque no canvas para dispositivos móveis
canvas.addEventListener('touchstart', (event) => {
    // Bloquear a rolagem durante a assinatura
    document.body.style.overflow = 'hidden';
    isScrollBlocked = true;

    // Lógica de desenho
    isDrawing = true;
    ctx.beginPath();
    ctx.moveTo(event.touches[0].clientX - canvas.getBoundingClientRect().left, event.touches[0].clientY - canvas.getBoundingClientRect().top);
});

canvas.addEventListener('touchmove', (event) => {
    // Impedir a rolagem durante o desenho
    if (isScrollBlocked) {
        event.preventDefault();
    }

    // Lógica de desenho
    if (isDrawing) {
        ctx.lineTo(event.touches[0].clientX - canvas.getBoundingClientRect().left, event.touches[0].clientY - canvas.getBoundingClientRect().top);
        ctx.stroke();
    }
});

canvas.addEventListener('touchend', () => {
    // Desbloquear a rolagem após o término da assinatura
    document.body.style.overflow = 'auto';
    isScrollBlocked = false;

    // Lógica de desenho
    isDrawing = false;
});

// Eventos de mouse para desktop
canvas.addEventListener('mousedown', (event) => {
    isDrawing = true;
    ctx.beginPath();
    ctx.moveTo(event.clientX - canvas.getBoundingClientRect().left, event.clientY - canvas.getBoundingClientRect().top);
});

canvas.addEventListener('mousemove', (event) => {
    if (isDrawing) {
        ctx.lineTo(event.clientX - canvas.getBoundingClientRect().left, event.clientY - canvas.getBoundingClientRect().top);
        ctx.stroke();
    }
});

canvas.addEventListener('mouseup', () => {
    isDrawing = false;
});

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

// Função para limpar o canvas
function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

// Evento de clique no botão de limpar
clearButton.addEventListener('click', clearCanvas);
