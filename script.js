const searchInput = document.getElementById('search-input');
const filterButtons = document.querySelectorAll('.filter-btn');
const productCards = document.querySelectorAll('.product-card');

function updateFilter(filter) {
    if (!searchInput) return;
    productCards.forEach(card => {
        const category = card.dataset.category.toLowerCase();
        const query = searchInput.value.trim().toLowerCase();
        const title = card.querySelector('h2').textContent.toLowerCase();
        const description = card.querySelector('p').textContent.toLowerCase();
        const matchCategory = filter === 'all' || category === filter.toLowerCase();
        const matchQuery = title.includes(query) || description.includes(query) || category.includes(query);

        if (matchCategory && matchQuery) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

if (searchInput) {
    searchInput.addEventListener('input', () => {
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
        updateFilter(activeFilter);
    });
}

if (filterButtons.length) {
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            updateFilter(button.dataset.filter);
        });
    });
}

const paymentMethodSelect = document.getElementById('payment-method');
const cardDetails = document.getElementById('card-details');
const openModalBtn = document.getElementById('open-modal');
const closeModalBtn = document.getElementById('close-modal');
const confirmModalBtn = document.getElementById('confirm-modal');
const modal = document.getElementById('notification-modal');

function updatePaymentFields() {
    if (!paymentMethodSelect || !cardDetails) return;
    cardDetails.style.display = paymentMethodSelect.value === 'card' ? 'grid' : 'none';
}

if (paymentMethodSelect) {
    paymentMethodSelect.addEventListener('change', updatePaymentFields);
}

function openModal() {
    if (modal) {
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
    }
}

function closeModal() {
    if (modal) {
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
    }
}

if (openModalBtn) {
    openModalBtn.addEventListener('click', openModal);
}

if (closeModalBtn) {
    closeModalBtn.addEventListener('click', closeModal);
}

if (confirmModalBtn) {
    confirmModalBtn.addEventListener('click', closeModal);
}

if (modal) {
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });
}

window.addEventListener('DOMContentLoaded', () => {
    updateFilter('all');
    updatePaymentFields();
});
