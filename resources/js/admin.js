/* Confirmation dialog for any <form data-confirm="..."> (logout, delete, ...). */
const dialog = document.getElementById('confirm-dialog');

if (dialog) {
    const title = document.getElementById('confirm-title');
    const message = document.getElementById('confirm-message');
    const okButton = document.getElementById('confirm-ok');
    let pending = null;

    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement) || !form.dataset.confirm || form.dataset.confirmed) return;

        event.preventDefault();
        pending = form;
        title.textContent = form.dataset.confirmTitle || 'Please confirm';
        message.textContent = form.dataset.confirm;
        okButton.textContent = form.dataset.confirmLabel || 'Confirm';
        dialog.returnValue = '';
        dialog.showModal();
    });

    dialog.addEventListener('close', () => {
        if (dialog.returnValue === 'confirm' && pending) {
            pending.dataset.confirmed = '1';
            pending.requestSubmit();
        }
        pending = null;
    });
}

/* Auto-dismiss toasts. */
document.querySelectorAll('[data-toast]').forEach((toast) => {
    const remove = () => toast.remove();
    toast.querySelector('button')?.addEventListener('click', remove);
    setTimeout(remove, 5000);
});