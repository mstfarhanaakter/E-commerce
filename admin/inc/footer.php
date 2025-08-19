 <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Sidebar toggle for desktop
    const desktopToggleBtn = document.getElementById('desktopToggle');
    const sidebar = document.getElementById('sidebarDesktop');
    const contentWrapper = document.querySelector('.content-wrapper');

    desktopToggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      contentWrapper.classList.toggle('shifted');
    });
  </script>

</body>

</html>
