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

const report = document.querySelector('[data-analysis-report]');

if (report) {
    async function copyText(text) {
        if (navigator.clipboard?.writeText) {
            try {
                await navigator.clipboard.writeText(text);
                return true;
            } catch {
                // Fall through to the legacy clipboard method when permission is unavailable.
            }
        }

        const temporaryInput = document.createElement('textarea');
        temporaryInput.value = text;
        temporaryInput.setAttribute('readonly', '');
        temporaryInput.style.position = 'fixed';
        temporaryInput.style.opacity = '0';
        document.body.append(temporaryInput);
        temporaryInput.select();

        let copied = false;
        try {
            copied = document.execCommand('copy');
        } finally {
            temporaryInput.remove();
        }

        return copied;
    }

    report.querySelectorAll('[data-copy-question]').forEach((button) => {
        button.addEventListener('click', async () => {
            const status = button.closest('li')?.querySelector('[data-copy-status]');

            try {
                const copied = await copyText(button.dataset.questionText ?? '');
                if (status) {
                    status.textContent = copied ? 'Copied' : 'Copy unavailable';
                    status.classList.toggle('text-red-600', !copied);
                }
            } catch {
                if (status) {
                    status.textContent = 'Copy unavailable';
                    status.classList.add('text-red-600');
                }
            }
        });
    });

    report.querySelector('[data-copy-all]')?.addEventListener('click', async () => {
        const status = report.querySelector('[data-copy-all-status]');
        const questions = [...report.querySelectorAll('[data-copy-question]')]
            .map((button, index) => `${index + 1}. ${button.dataset.questionText ?? ''}`)
            .join('\n');

        try {
            const copied = await copyText(questions);
            if (status) {
                status.textContent = copied ? 'All interview questions copied.' : 'Copy unavailable. Select and copy the questions manually.';
            }
        } catch {
            if (status) {
                status.textContent = 'Copy unavailable. Select and copy the questions manually.';
            }
        }
    });
}

const historyFilterForm = document.querySelector('[data-history-filter-form]');

if (historyFilterForm) {
    const minScore = historyFilterForm.querySelector('[data-min-score]');
    const maxScore = historyFilterForm.querySelector('[data-max-score]');
    const filterError = historyFilterForm.querySelector('[data-score-filter-error]');
    const filterStatus = document.querySelector('[data-history-filter-status]');
    const searchInput = historyFilterForm.querySelector('[name="search"]');
    const clearSearchButton = historyFilterForm.querySelector('[data-clear-history-search]');

    function validateScoreRange() {
        const min = minScore.value === '' ? null : Number(minScore.value);
        const max = maxScore.value === '' ? null : Number(maxScore.value);
        const invalidRange = min !== null && max !== null && min > max;
        const message = invalidRange ? 'Minimum Score cannot be greater than Maximum Score.' : '';

        minScore.setCustomValidity(message);
        maxScore.setCustomValidity(message);
        filterError.textContent = message;
        filterError.classList.toggle('hidden', !invalidRange);

        return !invalidRange;
    }

    minScore.addEventListener('input', validateScoreRange);
    maxScore.addEventListener('input', validateScoreRange);
    searchInput.addEventListener('input', () => {
        clearSearchButton.disabled = searchInput.value.length === 0;
    });

    historyFilterForm.addEventListener('submit', (event) => {
        if (!validateScoreRange()) {
            event.preventDefault();
            filterStatus.textContent = filterError.textContent;
            (Number(minScore.value) > Number(maxScore.value) ? minScore : maxScore).reportValidity();
        }
    });

    clearSearchButton?.addEventListener('click', () => {
        searchInput.value = '';
        clearSearchButton.disabled = true;
        historyFilterForm.requestSubmit();
    });
}
