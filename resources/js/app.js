const sidebar = document.querySelector('#app-sidebar');
const sidebarOverlay = document.querySelector('[data-sidebar-overlay]');
const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
const sidebarClose = document.querySelector('[data-sidebar-close]');

function closeSidebar() {
    sidebar?.classList.add('-translate-x-full');
    sidebarOverlay?.classList.add('hidden');
    sidebarToggle?.setAttribute('aria-expanded', 'false');
    sidebarToggle?.focus({ preventScroll: true });
}

sidebarToggle?.addEventListener('click', () => {
    const isOpen = sidebarToggle.getAttribute('aria-expanded') === 'true';

    if (isOpen) {
        closeSidebar();
        return;
    }

    sidebar?.classList.remove('-translate-x-full');
    sidebarOverlay?.classList.remove('hidden');
    sidebarToggle.setAttribute('aria-expanded', 'true');
});

sidebarClose?.addEventListener('click', closeSidebar);
sidebarOverlay?.addEventListener('click', closeSidebar);

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeSidebar();
    }
});

const analysisForm = document.querySelector('[data-analysis-form]');

if (analysisForm) {
    const textareas = analysisForm.querySelectorAll('[data-counted-textarea]');
    const submitButton = analysisForm.querySelector('[data-analysis-submit]');
    const submitIcon = analysisForm.querySelector('[data-submit-icon]');
    const submitSpinner = analysisForm.querySelector('[data-submit-spinner]');
    const submitLabel = analysisForm.querySelector('[data-submit-label]');
    const formStatus = analysisForm.querySelector('[data-form-status]');
    let isSubmitting = false;

    function updateCounter(textarea) {
        const counter = analysisForm.querySelector(`[data-character-counter="${textarea.id}"]`);
        const currentLength = textarea.value.length;
        const maxLength = Number(textarea.dataset.maxLength);
        const minLength = Number(textarea.dataset.minLength);

        if (counter) {
            counter.textContent = `${currentLength.toLocaleString()} / ${maxLength.toLocaleString()}`;
            counter.classList.toggle('text-red-600', currentLength > 0 && currentLength < minLength);
            counter.classList.toggle('text-amber-600', currentLength >= maxLength * 0.9);
            counter.classList.toggle('text-gray-400', currentLength >= minLength && currentLength < maxLength * 0.9);
        }

        textarea.setCustomValidity(
            textarea.value.trim().length < minLength
                ? `Please enter at least ${minLength} non-whitespace characters.`
                : '',
        );
    }

    textareas.forEach((textarea) => {
        updateCounter(textarea);
        textarea.addEventListener('input', () => updateCounter(textarea));
    });

    analysisForm.querySelectorAll('[data-clear-textarea]').forEach((button) => {
        button.addEventListener('click', () => {
            const textarea = analysisForm.querySelector(`#${CSS.escape(button.dataset.clearTextarea)}`);

            if (textarea) {
                textarea.value = '';
                updateCounter(textarea);
                textarea.focus();
            }
        });
    });

    analysisForm.addEventListener('submit', (event) => {
        if (isSubmitting) {
            event.preventDefault();
            return;
        }

        textareas.forEach(updateCounter);

        const candidateName = analysisForm.querySelector('#candidate_name');
        if (candidateName) {
            candidateName.setCustomValidity(
                candidateName.value.trim() ? '' : 'Please enter the candidate’s name.',
            );
        }

        if (!analysisForm.checkValidity()) {
            event.preventDefault();
            analysisForm.reportValidity();
            formStatus.textContent = 'Please complete all required fields before continuing.';
            return;
        }

        isSubmitting = true;
        submitButton.disabled = true;
        submitIcon.classList.add('hidden');
        submitSpinner.classList.remove('hidden');
        submitLabel.textContent = 'Analyzing resume…';
        formStatus.textContent = 'Submitting resume for analysis. Please wait.';
    });
}
