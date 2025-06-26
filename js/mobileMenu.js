document.addEventListener('DOMContentLoaded', function() {
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const nav = document.querySelector('nav'); // Seleciona a tag <nav> que contém os links e o botão/div de login
    const navLinks = document.querySelector('.nav-links');
    const btnLogin = document.querySelector('.btnlogin'); // Pode ser null se o usuário estiver logado
    const logadoDiv = document.querySelector('.logado'); // Pode ser null se o usuário não estiver logado

    if (hamburgerMenu && nav) {
        hamburgerMenu.addEventListener('click', function() {
            nav.classList.toggle('active');
            hamburgerMenu.classList.toggle('active'); // Anima o ícone hambúrguer

            // Opcional: Se quiser controlar o overflow do body para evitar rolagem quando o menu estiver aberto
            if (nav.classList.contains('active')) {
                document.body.style.overflow = 'hidden'; // Evita rolagem da página
            } else {
                document.body.style.overflow = ''; // Restaura a rolagem
            }
        });

        // Opcional: Fechar o menu ao clicar em um link (se for um SPA ou para rolar a página)
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (nav.classList.contains('active')) {
                    nav.classList.remove('active');
                    hamburgerMenu.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
    }
});