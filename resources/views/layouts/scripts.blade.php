<script src="{{ asset('admin/static/js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Script Tahun Otomatis -->
<script>
document.getElementById("year").textContent = new Date().getFullYear();
</script>

<!-- Dark Mode Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const html = document.documentElement;
    const toggles = document.querySelectorAll('.theme-toggle');
    const themeIcon = document.getElementById('themeDropdown')?.querySelector('i');

    function setTheme(theme) {
        if (theme === 'auto') {
            const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            html.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
        } else {
            html.setAttribute('data-bs-theme', theme);
        }
        localStorage.setItem('theme', theme);

        if (themeIcon) {
            themeIcon.setAttribute('data-feather',
                (theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)')
                    .matches)) ?
                'moon' : 'sun'
            );
            feather.replace();
        }
    }

    const savedTheme = localStorage.getItem('theme') || 'dark';
    setTheme(savedTheme);

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            setTheme(this.dataset.theme);
        });
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (localStorage.getItem('theme') === 'auto') setTheme('auto');
    });
});
</script>
<script>
$(document).on('click', '.pagination a', function(e) {
    e.preventDefault();

    let url = $(this).attr('href');

    $.ajax({
        url: url,
        success: function(data) {
            $('#ajax-table').html(data);
        }
    });
});
</script>
