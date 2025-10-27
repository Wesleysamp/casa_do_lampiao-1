// Navegação de abas
document.querySelectorAll('.tab-btn').forEach(btn => btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.tab').forEach(t => t.style.display = 'none');
    document.getElementById(btn.dataset.target).style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}))
function filterCategory(cat) { alert('Filtro simulado: ' + cat); }
function handleReserva(e) { e.preventDefault(); alert('Reserva enviada (simulada)'); }
function handleAdmin(e) { e.preventDefault(); alert('Login simulado'); }