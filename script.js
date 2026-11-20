const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('buttonSearch');
const confModal = document.getElementById('confModal');
const deleteProductIdInput = document.getElementById('deleteProductId');
const deleteProductName = document.getElementById('deleteProductName');
const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
const buttonReset = document.getElementById('buttonReset');
const messModal = document.getElementById('messModal');
const okModalBtn = document.getElementById('okModalBtn');
const productModal = document.getElementById('productModal');
const modalTitle = document.getElementById('modalTitle');
const productForm = document.getElementById('productForm');
const addBtn = document.getElementById('buttonAdd');
const closeModalBtn = document.getElementById('closeModalBtn');
const deletePermBtn = document.getElementById('deletePerm');

if (productForm) {
    productForm.action = 'index.php' + window.location.search;
}

function searchProducts() {
    const text = searchInput.value.trim();
    window.location.href = '?page=1&toFind=' + encodeURIComponent(text);
}

let pendingOld = null;

function showMessageModal(text, old = null) {
    const p = document.getElementById('modalMessage');
    p.textContent = text;
    p.style.whiteSpace = 'pre-line';
    pendingOld = old;
    messModal.style.display = 'flex';
}

function reopenProductForm(old) {
    modalTitle.textContent = old.id ? 'Edit Product' : 'Add Product';
    document.getElementById('productId').value = old.id || '';
    document.getElementById('name').value = old.name || '';
    document.getElementById('description').value = old.description || '';
    document.getElementById('price').value = old.price || '';
    document.getElementById('availability_date').value = old.availability_date || '';
    document.getElementById('stock_status').checked = (old.stock_status === '1');
    productModal.style.display = 'flex';
}


if (searchInput) {
    searchInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchProducts();
        }
    });
}

if (searchBtn) {
    searchBtn.addEventListener('click', function (event) {
        event.preventDefault();
        searchProducts();
    });
}

if (buttonReset) {
    buttonReset.addEventListener('click', function () {
        window.location.href = window.location.pathname;
    });
}



if (okModalBtn) {
    okModalBtn.addEventListener('click', () => {
        messModal.style.display = 'none';
        if (pendingOld) {
            reopenProductForm(pendingOld);
            pendingOld = null;
        }
    });
}




if (addBtn) {
    addBtn.addEventListener('click', () => {
        modalTitle.textContent = 'Add Product';
        productForm.reset();
        document.getElementById('productId').value = '';
        productModal.style.display = 'flex';
    });
}

document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', () => {
        modalTitle.textContent = 'Edit Product';
        document.getElementById('productId').value = btn.dataset.id;
        document.getElementById('name').value = btn.dataset.name;
        document.getElementById('description').value = btn.dataset.description;
        document.getElementById('price').value = btn.dataset.price;
        document.getElementById('availability_date').value = btn.dataset.date;
        document.getElementById('stock_status').checked = (btn.dataset.stock === '1');
        productModal.style.display = 'flex';
    });
});

document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', () => {
        deleteProductIdInput.value = btn.dataset.id;
        deleteProductName.textContent = btn.dataset.name;
        confModal.style.display = 'flex';
    });
});

if (closeModalBtn) {
    closeModalBtn.addEventListener('click', () => {
        productModal.style.display = 'none';
    });
}


window.addEventListener('click', (event) => {
    if (event.target === productModal) {
        productModal.style.display = 'none';
    }
});

if (cancelDeleteBtn) {
    cancelDeleteBtn.addEventListener('click', () => {
        confModal.style.display = 'none';
    });
}



window.addEventListener('click', (event) => {
    if (event.target === confModal) {
        confModal.style.display = 'none';
    }
});

if (deletePermBtn) {
    deletePermBtn.addEventListener('click', function (event) {
        event.preventDefault();

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php' + window.location.search;

        const fields = { action: 'delete', id: deleteProductIdInput.value };
        for (const name in fields) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = fields[name];
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
    });
}