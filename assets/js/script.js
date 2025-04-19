  const navbar = document.getElementById('scrollNavbar');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.style.display = 'block';
      navbar.classList.add('fade-in');
    } else {
      navbar.style.display = 'none';
      navbar.classList.remove('fade-in');
    }
  });


  document.addEventListener("DOMContentLoaded", function () {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("appear");
            observer.unobserve(entry.target); // animasi hanya sekali
          }
        });
      },
      { threshold: 0.2 }
    );

    const animatedItems = document.querySelectorAll(".fade-in-down");
    animatedItems.forEach((el) => observer.observe(el));
  });

  Fancybox.bind("[data-fancybox]", {
    Thumbs: false,
    Toolbar: {
        display: [
            { id: "prev", position: "center" },
            { id: "counter", position: "center" },
            { id: "next", position: "center" },
            "close",
        ],
    },
});

// Aktifkan tooltip
const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));


document.addEventListener("DOMContentLoaded", function () {
  Fancybox.bind("[data-fancybox^='detail-gallery-']", {
    groupAll: false,
    Thumbs: {
      autoStart: true,
    },
    Toolbar: {
      items: {
        start: ["zoom", "fullscreen"],
        center: [],
        end: ["thumbs", "close"],
      },
    },
    Image: {
      zoom: true,
    },
  });
});


function updateQty(id, change) {
  const input = document.getElementById(id);
  let val = parseInt(input.value);
  const max = parseInt(input.max);
  val += change;
  if (val < 0) val = 0;
  if (val > max) val = max;
  input.value = val;
}
function openCart(id) {
  // Menampilkan SweetAlert2 sebelum membuka AJAX
  // Swal.fire({
  //     title: 'Loading...',
  //     text: 'Please wait while we process your request.',
  //     icon: 'info',
  //     showConfirmButton: false,
  //     allowOutsideClick: false
  // });

  // Menggunakan AJAX untuk mengambil konten dari popup.php
  $.ajax({
      url: 'popup.php', // URL halaman yang ingin dimuat
      type: 'GET',
      data: { menu: 'addcart', id: id }, // Mengirimkan ID produk sebagai parameter
      success: function(response) {
          // Menutup SweetAlert2
          Swal.close();

          // Menampilkan konten yang diambil di dalam modal atau elemen lain
          // Misalnya kita menampilkan dalam elemen dengan ID #modalContent
          $('#modalContent').html(response);

          // Tampilkan modal dengan konten yang baru dimuat
          $('#myModal').modal('show');
      },
      error: function() {
          // Menutup SweetAlert2 dan menampilkan pesan error jika AJAX gagal
          // Swal.close();
          Swal.fire('Oops!', 'Something went wrong. Please try again.', 'error');
      }
  });
}
function simpanCart() {
  $(document).ready(function () {
      var valid = false; // Menandakan apakah ada quantity yang diisi

      // Cek setiap input quantity
      $('input[name^="variants"]').each(function () {
        var quantity = $(this).val();
        if (quantity > 0) {
          valid = true; // Set valid menjadi true jika ada quantity yang lebih dari 0
        }
      });

      if (!valid) {
        // Jika tidak ada quantity yang diisi, tampilkan peringatan
        Swal.fire({
          title: 'No Quantity Selected',
          text: 'Please select a quantity for at least one product variant.',
          icon: 'warning',
          confirmButtonText: 'Close'
        });
        return; // Hentikan eksekusi fungsi lebih lanjut
      }

      // Jika ada quantity yang diinput, lanjutkan pengiriman data ke server
      var formData = $('#add-to-cart-form').serialize(); // Mengambil semua data dari form dalam format serialized
      $.ajax({
        url: 'action.php?menu=simpancart', // Halaman server untuk memproses data
        type: 'POST',
        data: formData, // Data yang akan dikirim
        success: function (response) {
          // Tampilkan pesan sukses menggunakan SweetAlert
          var result = JSON.parse(response); // Parsing JSON
          Swal.fire({
            title: 'Item Added!',
            text: result.message, // Menampilkan pesan dari server
            icon: 'success',
            confirmButtonText: 'Close'
          });
        },
        error: function () {
          Swal.fire({
            title: 'Error',
            text: 'There was an issue adding the item to the cart. Please try again.',
            icon: 'error',
            confirmButtonText: 'Close'
          });
        }
      });
    });
}

function getCart(){
    // Mengambil data keranjang menggunakan AJAX
    fetch('action.php?menu=data-cart') // Gantilah dengan URL endpoint PHP Anda
        .then(response => response.json())
        .then(data => {
            const cartContent = document.getElementById('cartContent');
            if (data.length === 0) {
                cartContent.innerHTML = '<p class="text-muted">Your cart is empty.</p>';
            } else {
                let cartHTML = '';
                data.forEach(item => {
                    cartHTML += `
                        <div class="cart-item d-flex mb-4 align-items-center">
                            <img src="assets/img/product/${item.image}" height='40px' alt="${item.name}" class="cart-item-image" />
                            <div class="cart-item-details ms-3">
                                <h6 class="cart-item-name">${item.name}</h6>
                                <p class="cart-item-size"><strong>Size:</strong> ${item.size}</p>
                                <p class="cart-item-quantity"><strong>Quantity:</strong> 
                                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.id}, -1)">-</button>
                                    <span id="quantity_${item.id}">${item.quantity}</span>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.id}, 1)">+</button>
                                </p>
                                <p class="cart-item-price"><strong>Price:</strong> €${item.price}</p>
                                <p class="cart-item-total"><strong>Total Price:</strong> €${(item.quantity * item.price).toFixed(2)}</p>
                            </div>
                            <div class="cart-item-remove ms-auto">
                                <button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Remove</button>
                            </div>
                        </div>
                        <hr>
                    `;
                });
                cartContent.innerHTML = cartHTML;
            }
        })
        .catch(error => {
            console.error('Error fetching cart data:', error);
        });
}


// Fungsi untuk menambah atau mengurangi jumlah item dalam keranjang
function updateQuantity(itemId, change) {
  const quantityElement = document.getElementById(`quantity_${itemId}`);
  let currentQuantity = parseInt(quantityElement.innerText);

  currentQuantity += change;

  if (currentQuantity < 1) {
      currentQuantity = 0;  // Jika jumlah menjadi kurang dari 1, set ke 0
  }

  // Update tampilan jumlah item
  quantityElement.innerText = currentQuantity;

  // Kirim perubahan jumlah item ke server
  fetch(`action.php?menu=update-cart&id=${itemId}&quantity=${currentQuantity}`, { method: 'GET' })
      .then(response => response.json())
      .then(data => {
          if (currentQuantity === 0) {
              // Jika jumlah item 0, hapus item dari keranjang
              removeFromCart(itemId);
          }
          getCart();
      })
      .catch(error => {
          console.error('Error updating cart quantity:', error);
      });
}

// Fungsi untuk menghapus item dari keranjang
function removeFromCart(itemId) {
  fetch(`action.php?menu=remove-item&id=${itemId}`, { method: 'GET' })
      .then(response => response.json())
      .then(data => {
        getCart();
          // Mengupdate UI atau mereload data keranjang
          Swal.fire({
            icon: 'success',
            title: 'Item removed',
            text: 'The item has been removed from your cart.',
            timer: 1500,
            showConfirmButton: false
        });
                  // Setelah item dihapus, refresh data keranjang
      })
      .catch(error => {
          console.error('Error removing item from cart:', error);
      });
}


document.addEventListener('DOMContentLoaded', function () {
  fetch('action.php?menu=data-cart') // ambil cart item
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('orderSummary');
      if (!data.length) {
        container.innerHTML = '<p class="text-danger">Your cart is empty!</p>';
        return;
      }

      let total = 0;
      let html = '';
      data.forEach(item => {
        const subtotal = item.price * item.quantity;
        total += subtotal;
        html += `
          <div class="d-flex justify-content-between mb-2">
            <div>${item.name} (${item.size}) × ${item.quantity}</div>
            <div>€${subtotal.toFixed(2)}</div>
          </div>
        `;
      });
      html += `<hr><div class="d-flex justify-content-between fw-bold">
                <div>Total</div><div>€${total.toFixed(2)}</div>
              </div>`;
      container.innerHTML = html;
    });
});
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
  e.preventDefault(); // Cegah submit langsung

  const form = e.target;
  const name = form.querySelector('[name="name"]').value.trim();
  const address = form.querySelector('[name="address"]').value.trim();
  const phone = form.querySelector('[name="phone"]').value.trim();
  const paymentMethod = form.querySelector('[name="payment_method"]').value;

  // Validasi manual
  if (!name || !address || !phone || !paymentMethod) {
    Swal.fire({
      icon: 'warning',
      title: 'Incomplete Form',
      text: 'Please fill in all required fields.',
    });
    return;
  }

  // Konfirmasi order
  Swal.fire({
    title: 'Confirm Order',
    text: "Are you sure you want to place this order?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, place order',
    cancelButtonText: 'Cancel',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData(form);

      fetch('action.php?menu=checkout', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          Swal.fire({
            title: 'Success!',
            text: 'Your order has been placed.',
            icon: 'success',
            confirmButtonText: 'OK'
          }).then(() => {
            window.location.href = 'invoice.php?id=' + data.order_number;
          });
        } else {
          Swal.fire('Error', data.message || 'Something went wrong.', 'error');
        }
      })
      .catch(error => {
        console.error(error);
        Swal.fire('Error', 'Could not process order.', 'error');
      });
    }
  });
});
