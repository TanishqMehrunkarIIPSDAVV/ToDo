</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const drawerToggle = document.querySelector('[data-drawer-toggle]');
        const drawer = document.getElementById(drawerToggle.getAttribute('data-drawer-target'));

        drawerToggle.addEventListener('click', function() {
            drawer.classList.toggle('-translate-x-full');

            // Ensure button stays visible
            this.classList.toggle('z-50');
        });
    });
</script>

</html>