<script src="{{ asset('admin/static/js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap 5 DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        paging: true,
        pageLength: 10
    });
});
</script>

<!-- Script Tahun Otomatis -->
<script>
document.getElementById("year").textContent = new Date().getFullYear();
</script>

<!-- Dark Mode Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const html = document.documentElement;
    const body = document.body;

    const toggles = document.querySelectorAll('.theme-toggle');
    const themeIcon = document.querySelector('#themeDropdown i');

    function applyTheme(theme) {

        let finalTheme = theme;

        // AUTO MODE
        if (theme === 'auto') {
            finalTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ?
                'dark' :
                'light';
        }

        // APPLY KE SELURUH PAGE
        html.setAttribute('data-bs-theme', finalTheme);
        body.setAttribute('data-bs-theme', finalTheme);

        // OPTIONAL CLASS
        body.classList.remove('theme-light', 'theme-dark');
        body.classList.add('theme-' + finalTheme);

        // SAVE
        localStorage.setItem('theme', theme);

        // ICON
        if (themeIcon) {
            themeIcon.setAttribute(
                'data-feather',
                finalTheme === 'dark' ? 'moon' : 'sun'
            );

            feather.replace();
        }
    }

    // LOAD THEME
    const savedTheme = localStorage.getItem('theme') || 'dark';
    applyTheme(savedTheme);

    // CLICK EVENT
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();

            const selectedTheme = this.dataset.theme;
            applyTheme(selectedTheme);
        });
    });

    // SYSTEM CHANGE
    window.matchMedia('(prefers-color-scheme: dark)')
        .addEventListener('change', function() {

            if (localStorage.getItem('theme') === 'auto') {
                applyTheme('auto');
            }
        });
});
</script>