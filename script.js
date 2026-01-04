let cart = []; 

// Fungsi format mata uang Rupiah
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
};

// Fungsi Tambah ke Keranjang
const addToCart = (productId, name, price) => {
    const existingItemIndex = cart.findIndex(item => item.id === productId);

    if (existingItemIndex > -1) {
        cart[existingItemIndex].quantity += 1;
        Swal.fire({
            icon: "success", 
            title: "Jumlah Bertambah", 
            text: `${name} sudah ada di keranjang, jumlah ditambahkan.`, 
            timer: 1500,
            showConfirmButton: false
        });
    } else {
        cart.push({ id: productId, name: name, price: price, quantity: 1 });
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: `${name} masuk ke keranjang!`,
            timer: 1500,
            showConfirmButton: false
        });
    }
    updateCartDisplay();
};

// Fungsi Hapus Item dari Keranjang
const removeItem = (productId) => {
    const itemIndex = cart.findIndex(item => item.id === productId);

    if (itemIndex > -1) {
        Swal.fire({
            title: `Hapus ${cart[itemIndex].name}?`, 
            text: "Item akan dikeluarkan dari keranjang belanja.",
            icon: "warning",
            showCancelButton: true, 
            confirmButtonColor: "#ff69b4",
            confirmButtonText: "Ya, Hapus", 
            cancelButtonText: 'Batal' 
        }).then((result) => {
            if (result.isConfirmed) {
                cart.splice(itemIndex, 1);
                updateCartDisplay(); 
            }
        });
    }
};

const calculateTotal = () => {
    return cart.reduce((total, item) => {
        return total + (item.price * item.quantity);
    }, 0);
};

// Fungsi Update Tampilan Keranjang (Sidebar Kanan)
const updateCartDisplay = () => {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');
    
    cartItemsContainer.innerHTML = '';
    
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<p class="text-muted text-center" id="empty-cart-message">Keranjang masih kosong.</p>';
    } else {
        cart.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item', 'd-flex', 'justify-content-between', 'align-items-center', 'py-2', 'border-bottom');
            itemElement.innerHTML = `
                <div style="font-size: 0.9rem;">
                    <span class="fw-bold">${item.name}</span><br>
                    <small>${item.quantity} x ${formatRupiah(item.price)}</small>
                </div>
                <div class="text-end">
                    <span class="fw-bold" style="font-size: 0.9rem;">${formatRupiah(item.price * item.quantity)}</span><br>
                    <button class="btn btn-sm btn-outline-danger border-0 btn-remove-small" data-id="${item.id}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;
            cartItemsContainer.appendChild(itemElement);
        });
    }
    
    cartTotalElement.textContent = formatRupiah(calculateTotal());

    // Event listener untuk tombol hapus kecil di dalam keranjang
    document.querySelectorAll('.btn-remove-small').forEach(button => {
        button.addEventListener('click', function() {
            removeItem(parseInt(this.getAttribute('data-id'))); 
        });
    });
};

// Integrasi Event Click Tombol Tambah Menu
document.querySelectorAll('.btn-add-cart').forEach(button => {
    button.addEventListener('click', function() {
        const id = parseInt(this.getAttribute('data-id'));
        const name = this.getAttribute('data-name');
        const price = parseInt(this.getAttribute('data-price')); 
        addToCart(id, name, price);
    });
});

// Fitur Checkout Berkurang Stok (Integrasi Database)
document.getElementById('checkout-button').addEventListener('click', function() {
    const total = calculateTotal();
    
    if (total === 0) {
        Swal.fire('Keranjang Kosong', 'Silakan pilih menu terlebih dahulu.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Pesanan',
        html: `Total belanja Anda: <strong>${formatRupiah(total)}</strong><br><small>Stok akan otomatis berkurang setelah klik Bayar.</small>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ff69b4',
        confirmButtonText: 'Bayar Sekarang',
        cancelButtonText: 'Cek Lagi'
    }).then((result) => {
        if (result.isConfirmed) {
            // KIRIM DATA KE PHP UNTUK UPDATE DATABASE
            fetch('checkout_aksi.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cart: cart })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    cart = []; 
                    updateCartDisplay();
                    Swal.fire('Pembayaran Berhasil!', 'Stok produk telah diperbarui di database.', 'success');
                } else {
                    Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error!', 'Koneksi ke server terputus.', 'error');
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', updateCartDisplay);