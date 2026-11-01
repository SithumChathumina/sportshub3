// SportsHub shared browser behaviour.
document.addEventListener('DOMContentLoaded', () => {
    // Bootstrap client-side validation. Server-side checks still run on every form.
    document.querySelectorAll('.needs-validation').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Ask before destructive or irreversible actions.
    document.querySelectorAll('[data-confirm]').forEach((element) => {
        element.addEventListener('click', (event) => {
            if (!window.confirm(element.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    // Set booking date minimums without relying only on HTML validation.
    const today = new Date();
    const localToday = new Date(today.getTime() - today.getTimezoneOffset() * 60000)
        .toISOString().split('T')[0];
    document.querySelectorAll('input[data-future-date]').forEach((input) => {
        input.min = localToday;
    });
});
