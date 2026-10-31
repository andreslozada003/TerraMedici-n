@php
    $flashAlerts = collect([
        ['icon' => 'success', 'message' => session('success')],
        ['icon' => 'error', 'message' => session('error')],
        ['icon' => 'warning', 'message' => session('warning')],
        ['icon' => 'info', 'message' => session('info') ?? session('status')],
    ])->filter(fn ($alert) => filled($alert['message']))->values();
@endphp

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .notice { display: none !important; }
    .swal2-popup { border-radius: 16px !important; padding: 1.7rem !important; font-family: Inter, Segoe UI, Arial, sans-serif !important; }
    .swal2-title { color: #102a3b !important; font-size: 1.35rem !important; }
    .swal2-html-container { color: #63777f !important; }
    .swal2-confirm, .swal2-cancel { border-radius: 8px !important; font-weight: 700 !important; padding: .7rem 1.1rem !important; }
    .swal2-toast { box-shadow: 0 12px 32px rgba(16, 42, 59, .16) !important; }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const flashAlerts = @json($flashAlerts);
        const validationMessage = @json($errors->any() ? $errors->first() : null);
        document.querySelectorAll('form[action$="/logout"]').forEach((form) => {
            form.dataset.confirm = 'Tu sesión se cerrará de forma segura.';
            form.dataset.confirmTitle = '¿Cerrar sesión?';
            form.dataset.confirmButton = 'Sí, cerrar sesión';
            form.dataset.confirmIcon = 'question';
        });
        const toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 4200, timerProgressBar: true,
            didOpen: (element) => { element.addEventListener('mouseenter', Swal.stopTimer); element.addEventListener('mouseleave', Swal.resumeTimer); }
        });

        flashAlerts.forEach((alert, index) => window.setTimeout(() => toast.fire({ icon: alert.icon, title: alert.message }), index * 250));

        if (validationMessage) {
            Swal.fire({ icon: 'error', title: 'Revisa la información', text: validationMessage, confirmButtonText: 'Entendido', confirmButtonColor: '#159670' });
        }

        document.addEventListener('submit', (event) => {
            const form = event.target.closest('form[data-confirm]');
            if (!form || form.dataset.confirmed === 'true') return;
            event.preventDefault();
            Swal.fire({
                icon: form.dataset.confirmIcon || 'warning', title: form.dataset.confirmTitle || '¿Confirmar esta acción?', text: form.dataset.confirm,
                showCancelButton: true, confirmButtonText: form.dataset.confirmButton || 'Sí, continuar', cancelButtonText: 'Cancelar',
                confirmButtonColor: form.dataset.confirmColor || '#159670', cancelButtonColor: '#6f8188', reverseButtons: true, focusCancel: true
            }).then((result) => { if (result.isConfirmed) { form.dataset.confirmed = 'true'; form.submit(); } });
        });
    });
</script>
