document.addEventListener('DOMContentLoaded', () => {
  const sections = document.querySelectorAll('.section');
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      entry.target.classList.toggle('fade-in', entry.isIntersecting);
    });
  }, { threshold: 0.1 });

  sections.forEach(section => {
    section.classList.add('fade-section');
    observer.observe(section);
  });
});