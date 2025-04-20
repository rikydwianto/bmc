$(document).ready(function () {
    $('.order-detail-link').on('click', function (e) {
        e.preventDefault();
        const orderId = $(this).data('order-id');

        $.ajax({
            url: 'action.php?menu=order-detail&id=' + orderId,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    const order = response.data;
                    const items = response.items;

                    let itemsHtml = '';
                    items.forEach(function (item, index) {
                        itemsHtml += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.product_name}</td>
                                <td>${item.size || '-'}</td>
                                <td>${item.quantity}</td>
                                <td>€${parseFloat(item.price).toFixed(2)}</td>
                            </tr>
                        `;
                    });

                    const htmlContent = `
                        <p><strong>Order Number:</strong> ${order.order_number}</p>
                        <p><strong>Name:</strong> ${order.name}</p>
                        <p><strong>Phone:</strong> ${order.phone}</p>
                        <p><strong>Email:</strong> ${order.email}</p>
                        <p><strong>Address:</strong><br>${order.address.replace(/\n/g, "<br>")}</p>
                        <p><strong>Total:</strong> €${parseFloat(order.total).toFixed(2)}</p>
                        <p><strong>Payment Method:</strong> ${order.payment_method}</p>
                        <p><strong>Status:</strong> ${order.paid_status} (${order.is_paid == 1 ? 'Paid' : 'Unpaid'})</p>
                        <p><strong>Payment Note:</strong><br>${order.payment_note || '-'}</p>
                        <hr>
                        <h5>Order Items</h5>
                        <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>${itemsHtml}</tbody>
                        </table>
                        </div>
                    `;

                    Swal.fire({
                        title: 'Order Detail',
                        html: htmlContent,
                        width: 800,
                        showCloseButton: true,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Oops', response.message || 'Something went wrong.', 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Failed to load order detail.', 'error');
            }
        });
    });
});


$(document).ready(function () {
    $('.payment-proof-btn').on('click', function (e) {
        e.preventDefault();

        const imageUrl = $(this).data('image');
        const orderId = $(this).data('id');

        Swal.fire({
            title: 'Payment Proof',
            imageUrl: imageUrl,
            imageAlt: 'Payment Proof',
            showCancelButton: true,
            confirmButtonText: 'Approve',
            cancelButtonText: 'Reject',
            reverseButtons: true,
            showDenyButton: true,
            denyButtonText: 'Close',
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(orderId, 'approved');
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                updateStatus(orderId, 'rejected');
            }
        });

        function updateStatus(orderId, status) {
            $.post('action.php?menu=update-payment', { id: orderId, status: status }, function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Status updated!',
                    text: 'Order has been ' + status + '.',
                }).then(() => location.reload());
            });
        }
    });
});

$(document).ready(function () {
    $('#productsTable').DataTable({
        responsive: true
    });
});
