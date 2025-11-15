// Navegação de abas
// Seleciona todos os botões de aba e adiciona um evento de clique em cada um
document.querySelectorAll('.tab-btn').forEach(btn => 
    btn.addEventListener('click', () => {

        // Remove a classe "active" de TODOS os botões
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

        // Adiciona a classe "active" SOMENTE ao botão clicado
        btn.classList.add('active');

        // Esconde TODAS as abas (sections)
        document.querySelectorAll('.tab').forEach(t => t.style.display = 'none');

        // Mostra APENAS a aba correspondente ao botão clicado
        // O botão contém data-target="idDaAba"
        document.getElementById(btn.dataset.target).style.display = 'block';

        // Faz a página rolar suavemente até o topo
        window.scrollTo({ top: 0, behavior: 'smooth' });
    })
);

// Função para simular filtro por categoria
function filterCategory(cat) { 
    alert('Filtro simulado: ' + cat); 
}

// Função para simular envio de reserva
// e.preventDefault() evita o envio real do formulário
function handleReserva(e) { 
    e.preventDefault(); 
    alert('Reserva enviada (simulada)'); 
}

// Função para simular login do administrador
// Também impede envio real do formulário
function handleAdmin(e) { 
    e.preventDefault(); 
    alert('Login simulado'); 
}
