  const navbar = document.getElementById('scrollNavbar');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.style.display = 'block';
      navbar.classList.add('fade-in');
    } else {
      navbar.style.display = 'none';
      navbar.classList.remove('fade-in');
    }
  });
